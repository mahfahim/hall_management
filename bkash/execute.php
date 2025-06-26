<?php
// bkash/execute.php
session_start();

$config = include 'config.php';

if (!isset($_SESSION['bkash_token']) || !isset($_SESSION['paymentID'])) {
    die("Invalid session, please start over.");
}

$token = $_SESSION['bkash_token'];
$paymentID = $_SESSION['paymentID'];

$url = $config['base_url'] . "tokenized/checkout/payment/execute/" . $paymentID;

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

if (isset($data['paymentID']) && $data['transactionStatus'] == 'Completed') {
    // Payment success, save info in DB as needed
    echo "Payment Successful! Transaction ID: " . $data['trxID'];
} else {
    echo "Payment Failed or Pending.";
    print_r($data);
}
