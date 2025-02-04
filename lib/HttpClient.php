<?php

class HttpClient
{
    private $baseUri;

    public function __construct(string $baseUri)
    {
        if (empty($baseUri)) {
            throw new Exception("Base URI is not set.");
        }

        $this->baseUri = rtrim($baseUri, '/');
    }

    public function post(string $method, array $params): array
    {
        $client = new \GuzzleHttp\Client();

        try {
            $response = $client->post($this->baseUri, [
                'json' => [
                    'jsonrpc' => '2.0',
                    'id' => 1,
                    'method' => $method,
                    'params' => $params,
                ],
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
            ]);

            $body = json_decode($response->getBody(), true);

            if (!isset($body['result'])) {
                throw new Exception("RPC Error: " . json_encode($body));
            }

            return $body['result'];
        } catch (\Exception $e) {
            throw new Exception("HTTP Client Error: " . $e->getMessage());
        }
    }
}
