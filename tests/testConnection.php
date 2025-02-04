<?php

require '../config/env.php';
require '../lib/HttpClient.php';

header('Content-Type: application/json');

try {
    $httpClient = new HttpClient();
    $response = $httpClient->post('getVersion', []);

    echo json_encode([
        "success" => true,
        "message" => "Connection successful!",
        "data" => $response
    ]);
} catch (Exception $e) {
    echo json_encode([
        "success" => false,
        "error" => $e->getMessage()
    ]);
}
