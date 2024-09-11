<?php
include 'mpesa_config.php';
include 'mpesa_functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $phone = $_POST['phone'];
    $amount = $_POST['amount'];
    $orderId = $_POST['order_id'];

    // Ensure phone number is in the correct format (e.g., 2547XXXXXXXX)
    $phone = '254' . substr($phone, -9);

    $response = initiateMpesaStkPush($phone, $amount, $orderId);

    if ($response->ResponseCode == '0') {
        echo 'Please check your phone to complete the payment.';
    } else {
        echo 'Error initiating STK Push: ' . $response->errorMessage;
    }
}
?>
