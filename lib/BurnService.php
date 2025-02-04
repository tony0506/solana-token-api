<?php

class BurnService
{
    private HttpClient $httpClient;
    private array $burnTransactions;

    public function __construct(HttpClient $httpClient, array $burnTransactions)
    {
        $this->httpClient = $httpClient;
        $this->burnTransactions = $burnTransactions;
    }

    public function getTotalBurnedTokens(): array
    {
        $totalBurned = 0;
        $transactionDetails = [];

        foreach ($this->burnTransactions as $txId) {
            try {
                // Fetch transaction with maxSupportedTransactionVersion
                $result = $this->httpClient->post('getTransaction', [$txId, [
                    "encoding" => "jsonParsed",
                    "maxSupportedTransactionVersion" => 0
                ]]);

                if (!isset($result['meta'])) {
                    throw new Exception("Invalid response from RPC");
                }

                // Look at both preTokenBalances and postTokenBalances
                $burnedAmount = $this->extractBurnAmount($result['meta']);

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

    private function extractBurnAmount(array $meta): float
    {
        $burnAmount = 0;

        if (isset($meta['preTokenBalances']) && is_array($meta['preTokenBalances'])) {
            foreach ($meta['preTokenBalances'] as $balance) {
                if ($balance['owner'] === "1nc1nerator11111111111111111111111111111111") {
                    $burnAmount += $balance['uiTokenAmount']['uiAmount'] ?? 0;
                }
            }
        }

        if (isset($meta['postTokenBalances']) && is_array($meta['postTokenBalances'])) {
            foreach ($meta['postTokenBalances'] as $balance) {
                if ($balance['owner'] === "1nc1nerator11111111111111111111111111111111") {
                    $burnAmount += $balance['uiTokenAmount']['uiAmount'] ?? 0;
                }
            }
        }

        return $burnAmount;
    }
}
