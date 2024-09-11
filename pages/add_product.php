<?php include '../includes/header.php'; ?>
<?php include '../includes/db.php'; ?>

<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category_id = $_POST['category_id'];
    $image = $_FILES['image']['name'];
    $target = "../images/" . basename($image);

    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        $stmt = $pdo->prepare('INSERT INTO products (name, description, price, category_id, image) VALUES (?, ?, ?, ?, ?)');
        $stmt->execute([$name, $description, $price, $category_id, $image]);
        header('Location: admin.php');
    } else {
        echo '<p>Failed to upload image.</p>';
    }
}
?>

<h1>Add Product</h1>
<form method="post" action="add_product.php" enctype="multipart/form-data">
    <div class="form-group">
        <label for="name">Product Name</label>
        <input type="text" class="form-control" id="name" name="name" required>
    </div>
    <div class="form-group">
        <label for="description">Description</label>
        <textarea class="form-control" id="description" name="description" required></textarea>
    </div>
    <div class="form-group">
        <label for="price">Price</label>
        <input type="number" class="form-control" id="price" name="price" required>
    </div>
    <div class="form-group">
        <label for="category_id">Category</label>
        <select class="form-control" id="category_id" name="category_id" required>
            <?php
            $stmt = $pdo->query('SELECT * FROM categories');
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
            }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label for="image">Image</label>
        <input type="file" class="form-control" id="image" name="image" required>
    </div>
    <button type="submit" class="btn btn-primary">Add Product</button>
</form>

<?php include '../includes/footer.php'; ?>
