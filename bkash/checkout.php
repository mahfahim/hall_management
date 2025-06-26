<?php
// bkash/checkout.php
session_start();

$config = include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $amount = $_POST['amount'];
    $payment_type = $_POST['payment_type'];

    if (!isset($_SESSION['bkash_token'])) {
        // Call token.php internally or redirect to get token first
        header('Location: token.php');
        exit;
    }

    $token = $_SESSION['bkash_token'];

    $url = $config['base_url'] . 'tokenized/checkout/payment/create';

    $postData = [
        "mode" => "0011",               // Default mode, consult bKash docs
        "payerReference" => session_id(),  // Unique payer reference, use session or user ID
        "amount" => $amount,
        "currency" => "BDT",
        "intent" => "sale",
        "merchantInvoiceNumber" => uniqid(),  // Unique invoice number
    ];

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($postData));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, [
        'Content-Type:application/json',
        'Authorization:' . $token,
        'X-App-Key:' . $config['app_key']
    ]);

    $response = curl_exec($curl);
    curl_close($curl);

    $data = json_decode($response, true);

    if (isset($data['paymentID'])) {
        // Store paymentID for later execution
        $_SESSION['paymentID'] = $data['paymentID'];

        // Redirect or send paymentID to client to trigger bKash payment UI
        // For example, redirect to execute.php to confirm payment
        header("Location: execute.php");
        exit;
    } else {
        echo "Payment creation failed:";
        print_r($data);
    }
}
