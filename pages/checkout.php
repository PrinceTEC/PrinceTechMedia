<?php include '../includes/header.php'; ?>
<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

include '../includes/db.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $total = $_POST['total'];

    $stmt = $pdo->prepare('INSERT INTO orders (user_id, total) VALUES (?, ?)');
    $stmt->execute([$user_id, $total]);
    $order_id = $pdo->lastInsertId();

    foreach ($_SESSION['cart'] as $id => $quantity) {
        $stmt = $pdo->prepare('INSERT INTO order_items (order_id, product_id, quantity) VALUES (?, ?, ?)');
        $stmt->execute([$order_id, $id, $quantity]);
    }

    unset($_SESSION['cart']);
    echo '<p>Order placed successfully!</p>';
}
?>

<h1>Checkout</h1>
<form method="post" action="checkout.php">
    <input type="hidden" name="total" value="<?php echo $total; ?>">
    <button type="submit" class="btn btn-primary">Place Order</button>

</form>
<form action="process_payment.php" method="POST">
    <div class="form-group">
        <label for="phone">Phone Number:</label>
        <input type="text" class="form-control" id="phone" name="phone" required placeholder="07XXXXXXXX">
    </div>
    <div class="form-group">
        <label for="amount">Amount:</label>
        <input type="number" class="form-control" id="amount" name="amount" required>
    </div>
    <input type="hidden" name="order_id" value="ORDER_ID"> <!-- Replace ORDER_ID with the actual order ID -->
    <button type="submit" class="btn btn-primary">Pay with M-Pesa</button>
</form>


<?php include '../includes/footer.php'; ?>
