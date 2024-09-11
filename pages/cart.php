<?php include '../includes/header.php'; ?>
<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_GET['action']) && $_GET['action'] == 'add' && isset($_GET['id'])) {
    $product_id = $_GET['id'];
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]++;
    } else {
        $_SESSION['cart'][$product_id] = 1;
    }
    header('Location: cart.php');
}

if (isset($_GET['action']) && $_GET['action'] == 'remove' && isset($_GET['id'])) {
    $product_id = $_GET['id'];
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]--;
        if ($_SESSION['cart'][$product_id] == 0) {
            unset($_SESSION['cart'][$product_id]);
        }
    }
    header('Location: cart.php');
}

if (isset($_GET['action']) && $_GET['action'] == 'clear') {
    unset($_SESSION['cart']);
    header('Location: cart.php');
}
?>

<h1>Shopping Cart</h1>
<table class="table">
    <thead>
        <tr>
            <th>Product</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Subtotal</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        include '../includes/db.php';

        // Initialize the total to zero
        $total = 0;

foreach ($_SESSION['cart'] as $id => $quantity) {
    // Prepare the statement to fetch the product details by ID
    $stmt = $pdo->prepare('SELECT * FROM products WHERE id = ?');
    $stmt->execute([$id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Ensure $product is an array before accessing its elements
    if ($product && is_array($product)) {
        // Cast the product price and quantity to appropriate types and calculate subtotal
        $subtotal = (float)$product['price'] * (int)$quantity;
        $total += $subtotal;

        // Output the table rows for the cart items
        echo '<tr>';
        echo '<td>' . htmlspecialchars($product['name']) . '</td>'; // Using htmlspecialchars for safety
        echo '<td>' . (int)$quantity . '</td>';
        echo '<td>$' . number_format((float)$product['price'], 2) . '</td>'; // Formatting price to 2 decimal places
        echo '<td>$' . number_format($subtotal, 2) . '</td>';
        echo '<td><a href="cart.php?action=remove&id=' . (int)$id . '" class="btn btn-warning btn-sm">Remove</a></td>';
        echo '</tr>';
    } else {
        // Handle case where product data couldn't be fetched
        echo '<tr><td colspan="5">Product not found</td></tr>';
    }
}

        ?>
    </tbody>
</table>
<p><strong>Total: $<?php echo $total; ?></strong></p>
<a href="cart.php?action=clear" class="btn btn-danger">Clear Cart</a>
<a href="checkout.php" class="btn btn-success">Checkout</a>

<?php include '../includes/footer.php'; ?>
