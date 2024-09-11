<?php
include '../includes/header.php';
include '../includes/db.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
    header('Location: login.php');
    exit();
}
?>

<h1>Admin Panel</h1>
<div class="row">
    <div class="col-md-6">
        <h2>Manage Products</h2>
        <a href="add_product.php" class="btn btn-primary mb-3">Add Product</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Category</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $stmt = $pdo->query('SELECT products.id, products.name, products.price, categories.name AS category_name FROM products LEFT JOIN categories ON products.category_id = categories.id');
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo '<tr>';
                    echo '<td>' . $row['id'] . '</td>';
                    echo '<td>' . $row['name'] . '</td>';
                    echo '<td>' . $row['price'] . '</td>';
                    echo '<td>' . $row['category_name'] . '</td>';
                    echo '<td><a href="edit_product.php?id=' . $row['id'] . '" class="btn btn-warning btn-sm">Edit</a> ';
                    echo '<a href="delete_product.php?id=' . $row['id'] . '" class="btn btn-danger btn-sm">Delete</a></td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
    <div class="col-md-6">
        <h2>Manage Categories</h2>
        <a href="add_category.php" class="btn btn-primary mb-3">Add Category</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $stmt = $pdo->query('SELECT * FROM categories');
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo '<tr>';
                    echo '<td>' . $row['id'] . '</td>';
                    echo '<td>' . $row['name'] . '</td>';
                    echo '<td><a href="edit_category.php?id=' . $row['id'] . '" class="btn btn-warning btn-sm">Edit</a> ';
                    echo '<a href="delete_category.php?id=' . $row['id'] . '" class="btn btn-danger btn-sm">Delete</a></td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
