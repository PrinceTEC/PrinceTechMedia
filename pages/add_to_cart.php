<?php
session_start();
include '../includes/header.php';
include '../includes/db.php';

// Assuming product ID is passed via GET
$product_id = $_GET['id'];

// Retrieve product details from the database
$stmt = $pdo->prepare('SELECT * FROM products WHERE id = ?');
$stmt->execute([$product_id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    echo 'Product not found';
    exit();
}

// Add the product to the cart (using session)
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Check if product is already in the cart
if (isset($_SESSION['cart'][$product_id])) {
    $_SESSION['cart'][$product_id]['quantity']++;
} else {
    // Add new product to the cart
    $_SESSION['cart'][$product_id] = [
        'name' => $product['name'],
        'price' => $product['price'],
        'quantity' => 1
    ];
}

// After adding, show a success message with options
echo '
    <div class="alert alert-success">
        Product added to cart successfully!
        <a href="/ecommerce/pages/index.php" class="btn btn-primary">Continue Shopping</a>
        <a href="/ecommerce/pages/cart.php" class="btn btn-secondary">View Cart</a>
    </div>
';
