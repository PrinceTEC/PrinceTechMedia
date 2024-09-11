<?php include '../includes/header.php'; ?>
<?php include '../includes/db.php'; ?>

<?php
if (isset($_GET['id'])) {
    $stmt = $pdo->prepare('SELECT * FROM products WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($product) {
        echo '<div class="card mb-4">';
        echo '<img src="/images/' . $product['image'] . '" class="card-img-top" alt="' . $product['name'] . '">';
        echo '<div class="card-body">';
        echo '<h5 class="card-title">' . $product['name'] . '</h5>';
        echo '<p class="card-text">' . $product['description'] . '</p>';
        echo '<p class="card-text">$' . $product['price'] . '</p>';
        echo '<a href="add_to_cart.php?action=add&id=' . $product['id'] . '" class="btn btn-primary">Add to Cart</a>';
        echo '</div>';
        echo '</div>';
    } else {
        echo '<p>Product not found.</p>';
    }
} else {
    echo '<p>No product ID provided.</p>';
}
?>

<?php include '../includes/footer.php'; ?>
