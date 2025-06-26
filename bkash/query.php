<?php
// bkash/query.php
session_start();

$config = include 'config.php';

$paymentID = $_SESSION['paymentID'] ?? null;

if (!$paymentID) {
    die("Payment ID missing.");
}

$token = $_SESSION['bkash_token'];

$url = $config['base_url'] . "tokenized/checkout/payment/query/" . $paymentID;

$curl = curl_init($url);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_HTTPHEADER, [
    'Content-Type:application/json',
    'Authorization:' . $token,
    'X-App-Key:' . $config['app_key']
]);

$response = curl_exec($curl);
curl_close($curl);

$data = json_decode($response, true);

print_r($data);
