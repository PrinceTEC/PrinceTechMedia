<?php
include 'mpesa_config.php';
include 'mpesa_functions.php';

$data = file_get_contents('php://input');
$response = json_decode($data);

if ($response->Body->stkCallback->ResultCode == 0) {
    $transaction = $response->Body->stkCallback->CallbackMetadata->Item;
    $transactionId = $transaction[1]->Value;
    $amount = $transaction[0]->Value;
    $phone = $transaction[4]->Value;
    $orderId = $transaction[3]->Value;

    $pdo = getDbConnection();

    // Store the transaction details in the database
    $stmt = $pdo->prepare("INSERT INTO payments (transaction_id, amount, phone, order_id, status) VALUES (?, ?, ?, ?, 'Completed')");
    $stmt->execute([$transactionId, $amount, $phone, $orderId]);

    // Update the order status as paid
    $stmt = $pdo->prepare("UPDATE orders SET status = 'Paid' WHERE id = ?");
    $stmt->execute([$orderId]);

    // Send response back to M-Pesa
    header("Content-Type: application/json");
    echo json_encode(['ResultCode' => 0, 'ResultDesc' => 'Transaction successful']);
} else {
    // Handle failure scenario
    $transactionId = $response->Body->stkCallback->CallbackMetadata->Item[1]->Value;
    $orderId = $response->Body->stkCallback->CallbackMetadata->Item[3]->Value;

    $pdo = getDbConnection();

    // Update the payment status as failed
    $stmt = $pdo->prepare("UPDATE payments SET status = 'Failed' WHERE transaction_id = ?");
    $stmt->execute([$transactionId]);

    echo json_encode(['ResultCode' => 1, 'ResultDesc' => 'Transaction failed']);
}
?>
