<?php
// bkash/token.php

$config = include 'config.php';

$url = $config['base_url'] . 'tokenized/checkout/token/grant';

$data = [
    "app_key" => $config['app_key'],
    "app_secret" => $config['app_secret'],
];

$curl = curl_init($url);

curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type:application/json']);

$response = curl_exec($curl);
curl_close($curl);

$responseData = json_decode($response, true);

if (isset($responseData['id_token'])) {
    // Save the token in session or file for further requests
    session_start();
    $_SESSION['bkash_token'] = $responseData['id_token'];
    echo "Access token acquired.";
} else {
    echo "Failed to get access token.";
    print_r($responseData);
}
