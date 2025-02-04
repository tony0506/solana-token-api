<?php

class BurnService2
{
    private string $tatumApiKey;
    private array $burnTransactions;
    private string $tatumRpcUrl = 'https://solana-mainnet.gateway.tatum.io/';

    public function __construct(string $tatumApiKey, array $burnTransactions)
    {
        $this->tatumApiKey = $tatumApiKey;
        $this->burnTransactions = $burnTransactions;
    }

    public function getTotalBurnedTokens(): array
    {
        $totalBurned = 0;
        $transactionDetails = [];

        foreach ($this->burnTransactions as $txId) {
            try {
                $burnedAmount = $this->fetchBurnAmount($txId);
                if ($burnedAmount === null) {
                    throw new Exception("Invalid response from Tatum RPC");
                }

                $transactionDetails[$txId] = $burnedAmount;
                $totalBurned += $burnedAmount;

            } catch (Exception $e) {
                $transactionDetails[$txId] = "Error: " . $e->getMessage();
            }
        }

        return [
            'burnTransactions' => $transactionDetails,
            'totalBurned' => $totalBurned
        ];
    }

    private function fetchBurnAmount(string $txId): ?float
    {
        $payload = [
            "jsonrpc" => "2.0",
            "method" => "getTransaction",
            "params" => [
                $txId,
                ["encoding" => "jsonParsed", "maxSupportedTransactionVersion" => 0]
            ],
            "id" => 1
        ];

        $response = $this->sendRequest($payload);

        if (!isset($response['result']['meta']['preTokenBalances'])) {
            return null; // Invalid or missing data
        }

        foreach ($response['result']['meta']['preTokenBalances'] as $balance) {
            if ($balance['owner'] === "fgqmxERhVp8MJ59Sv3L46DK1QF7DgjPffHVwKhdctGq") {
                return $balance['uiTokenAmount']['uiAmount'] ?? 0;
            }
        }

        return null; // No burn amount found
    }

    private function sendRequest(array $payload): ?array
    {
        $ch = curl_init($this->tatumRpcUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'accept: application/json',
            'content-type: application/json',
            'x-api-key: ' . $this->tatumApiKey
        ]);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));

        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response, true);
    }
}