<?php

require_once __DIR__ . '/vendor/autoload.php'; // Load dependencies
require_once __DIR__ . '/config/env.php';
require_once __DIR__ . '/lib/HttpClient.php';
require_once __DIR__ . '/lib/TokenService.php';
require_once __DIR__ . '/lib/OrcaService.php';
require_once __DIR__ . '/lib/VestingService.php';
require_once __DIR__ . '/lib/BurnService.php';

try {
    // Load environment variables
    $rpcUrl = $_ENV['SOLANA_RPC_URL'];
    $maxSupply = 1000000000; // 1 Billion max supply

    $raydiumVaults = [
        $_ENV['RAYDIUM_VAULT_1'],
        $_ENV['RAYDIUM_VAULT_2'],
    ];

    $orcaVault = $_ENV['ORCA_VAULT'];

    $vestingAccounts = [
        $_ENV['VESTING_RESERVES'],
        $_ENV['VESTING_CEX'],
        $_ENV['VESTING_AIRDROP'],
        $_ENV['VESTING_NFT'],
        $_ENV['VESTING_RESERVES_2'],
        $_ENV['VESTING_BURN'],
        $_ENV['VESTING_STAKING'],
    ];

    // Burn Transactions - Add more transaction IDs when new burns happen
    $burnTransactions = [
        "5nY9njt8p6gAjLsohPtTM2J1Z2G4risntLAtoCMBQHwzp8HF8kyaycXbf9hVbBawpU9rkov9mkqBYrgYuc2iNuVe"
    ];

    // Initialize HTTP client
    $httpClient = new HttpClient($rpcUrl);

    // Initialize services
    $tokenService = new TokenService($httpClient, $raydiumVaults);
    $orcaService = new OrcaService($httpClient, $orcaVault);
    $vestingService = new VestingService($httpClient, $vestingAccounts);
    $burnService = new BurnService($httpClient, $burnTransactions);

    // Fetch locked tokens
    $raydiumLockedTokens = $tokenService->getLockedTokens();
    $orcaLockedTokens = $orcaService->getLockedTokens();
    $vestingBalances = $vestingService->getVestingBalances();
    $burnedTokens = $burnService->getTotalBurnedTokens();

    // Calculate total locked
    $totalLocked = ($raydiumLockedTokens['TotalLocked'] ?? 0)
                 + ($orcaLockedTokens['balance'] ?? 0)
                 + ($vestingBalances['VestingTotal'] ?? 0);

    // Calculate circulating supply
    $circulatingSupply = $maxSupply - $totalLocked - ($burnedTokens['totalBurned'] ?? 0);

    // Determine API endpoint
    $endpoint = $_GET['endpoint'] ?? null;

    // API Routing
    switch ($endpoint) {
        case 'circulating-supply':
            echo json_encode(['circulatingSupply' => $circulatingSupply], JSON_PRETTY_PRINT);
            break;

        case 'total-supply':
            echo json_encode(['totalSupply' => $totalLocked + $circulatingSupply], JSON_PRETTY_PRINT);
            break;

        case 'max-supply':
            echo json_encode(['maxSupply' => $maxSupply], JSON_PRETTY_PRINT);
            break;

        case 'locked-addresses':
            echo json_encode([
                'lockedAddresses' => array_merge($raydiumVaults, [$orcaVault], $vestingAccounts)
            ], JSON_PRETTY_PRINT);
            break;

        default:
            // Return all data if no specific endpoint is requested
            echo json_encode([
                'totalLockedTokens' => [
                    'TotalLocked' => $totalLocked,
                    'TotalBurned' => $burnedTokens['totalBurned'] ?? 0,
                    'CirculatingSupply' => $circulatingSupply,
                    'Details' => [
                        'Raydium Vaults' => $raydiumLockedTokens['Details'],
                        'Orca' => $orcaLockedTokens,
                        'Vesting' => $vestingBalances,
                        'Burn' => [
                            'burnTransactions' => $burnedTokens['burnTransactions'] ?? [],
                            'totalBurned' => $burnedTokens['totalBurned'] ?? 0
                        ]
                    ],
                ],
            ], JSON_PRETTY_PRINT);
            break;
    }
} catch (Exception $e) {
    header('Content-Type: application/json', true, 500);
    echo json_encode(['error' => $e->getMessage()], JSON_PRETTY_PRINT);
}
