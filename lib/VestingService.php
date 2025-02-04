<?php

class VestingService
{
    private $httpClient;
    private $vestingAccounts;

    public function __construct(HttpClient $httpClient, array $vestingAccounts)
    {
        $this->httpClient = $httpClient;
        $this->vestingAccounts = $vestingAccounts;
    }

    public function getVestingBalances(): array
    {
        $balances = [];
        $total = 0;

        foreach ($this->vestingAccounts as $account) {
            try {
                $balance = $this->getTokenAccountBalance($account);
                $balances[$account] = $balance;
                $total += $balance;
            } catch (Exception $e) {
                $balances[$account] = 0; // Default to 0 on error
            }
        }

        return [
            'VestingTotal' => $total,
            'Details' => $balances,
        ];
    }

    private function getTokenAccountBalance(string $account): float
    {
        $result = $this->httpClient->post('getTokenAccountBalance', [$account]);
        return isset($result['value']['uiAmount']) ? (float)$result['value']['uiAmount'] : 0;
    }
}
