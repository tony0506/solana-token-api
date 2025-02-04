Solana Token API - Pudgy Squirrels (PSQR)

The Solana Token API provides real-time supply data for the Pudgy Squirrels (PSQR) token on the Solana blockchain. This API aggregates locked, burned, and circulating supply details to facilitate token tracking by aggregators like CoinGecko, CoinMarketCap, and Live Coin Watch.

- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
Live API Endpoint
- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 

Base URL:
http://api.pudgysquirrels.com/index.php

- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
API Endpoints
- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 

Circulating Supply
Returns the current circulating supply of the PSQR token.

Endpoint:
GET https://api.pudgysquirrels.com/index.php?endpoint=circulating-supply

Response Example:
{ "circulatingSupply": 524246566.03042823 }

Total Supply
Returns the total supply of the PSQR token, including locked and burned tokens.

Endpoint:
GET https://api.pudgysquirrels.com/index.php?endpoint=total-supply

Response Example:
{ "totalSupply": 1000000000 }

Max Supply
Returns the maximum supply of the PSQR token.

Endpoint:
GET https://api.pudgysquirrels.com/index.php?endpoint=max-supply

Response Example:
{ "maxSupply": 1000000000 }

Locked Addresses
Returns a list of locked token vesting addresses with their balances.

Endpoint:
GET https://api.pudgysquirrels.com/index.php?endpoint=locked-addresses

Response Example:
{ "lockedAddresses": [ "DCxenpJwqkkGJBruJLqqFr4N8715BfidQjDnskTf9iHe", "Crzhe9YVrsDSh4xeE4qptMnfhXg7tUR6btgvdCgPB8zm", "3RsfdsMu44guL29ubWXdTaSjo8A7TJMGVEwLyHotgVZT", "7LRmmmg6GXd2AuNUWk1fMM7J79J6VfAgKHpenHgoiAiQ", "EtnDy2kSeWAgFGK8pZ3kt52gytNURYTWq3qdGHLoAvcs" ] }

Burned Tokens
Returns burned token transactions and the total burned supply.

Endpoint:
GET https://api.pudgysquirrels.com/index.php?endpoint=total-burned

Response Example:
{ "totalBurned": 38493647.027780525 }

- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
Setup Instructions
- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 

Requirements
PHP 8.2 or higher
Composer
Solana RPC URL (Mainnet)
.env file for API keys and configuration
Installation
Clone this repository:
git clone https://github.com/tony0506/solana-token-api.git
cd solana-token-api

Install dependencies using Composer:
composer install

Create a .env file in the root directory and add:
SOLANA_RPC_URL=https://api.mainnet-beta.solana.com

Run the PHP development server:
php -S localhost:8000

- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
Security and Private Data
- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 

Sensitive API keys and environment variables are not included in the repository.
The .gitignore file ensures .env files are never tracked.
CoinGecko or other services will not have access to any private keys.

- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
Developer Information
- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 

GitHub Repository: https://github.com/tony0506/solana-token-api
Solana Explorer: https://solscan.io/token/
Live API Endpoint: http://api.pudgysquirrels.com/index.php

- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
Next Steps
- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 

Submit this repository link to CoinGecko.
Ensure the API endpoints are up-to-date.
Verify that .env and config/env.php are not included in the repository.

- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
Contact and Support
- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 

If you have any questions, contact the Pudgy Squirrels team via:

Twitter: https://twitter.com/pudgysquirrels1

- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
License
- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 

MIT License 2025 Pudgy Squirrels Token API
