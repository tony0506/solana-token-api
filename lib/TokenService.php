<?php

class TokenService
{
    private $httpClient;
    private $raydiumVaults;
    private $orcaVault;

    public function __construct(HttpClient $httpClient, array $raydiumVaults)
    {
        $this->httpClient = $httpClient;
        $this->raydiumVaults = $raydiumVaults;
    }

    public function getLockedTokens(): array
    {
        $balances = [];
        foreach ($this->raydiumVaults as $account) {
            try {
                $balance = $this->getTokenAccountBalance($account);
                $balances[$account] = $balance;
            } catch (Exception $e) {
                $balances[$account] = 0; // Default to 0 if balance cannot be fetched
            }
        }

        return [
            'PSQR/SOL' => array_sum($balances),
            'Details' => $balances,
        ];
    }

    private function getTokenAccountBalance(string $account): float
    {
        $result = $this->httpClient->post('getTokenAccountBalance', [$account]);
        return $result['value']['uiAmount'];
    }
}
