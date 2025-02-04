<?php

class OrcaService
{
    private $httpClient;
    private $orcaVault;

    public function __construct(HttpClient $httpClient, string $orcaVault)
    {
        $this->httpClient = $httpClient;
        $this->orcaVault = $orcaVault;
    }

    public function getLockedTokens(): array
    {
        try {
            // Fetch Orca balance dynamically
            $balance = $this->getTokenAccountBalance($this->orcaVault);
            return [
                'account' => $this->orcaVault,
                'balance' => $balance,
            ];
        } catch (Exception $e) {
            return [
                'account' => $this->orcaVault,
                'balance' => 0,
                'error' => $e->getMessage(),
            ];
        }
    }

    private function getTokenAccountBalance(string $account): float
    {
        $result = $this->httpClient->post('getTokenAccountBalance', [$account]); // Ensure $account is inside an array
        if (!isset($result['value']['uiAmount'])) {
            throw new Exception("RPC Error: " . json_encode($result));
        }
        return $result['value']['uiAmount'];
    }
}
