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

    $stmt = $pdo->prepare('INSERT INTO categories (name) VALUES (?)');
    $stmt->execute([$name]);

    header('Location: admin.php');
    exit();
}
?>

<h1>Add Category</h1>
<form method="post" action="add_category.php">
    <div class="form-group">
        <label for="name">Category Name</label>
        <input type="text" class="form-control" id="name" name="name" required>
    </div>
    <button type="submit" class="btn btn-primary">Add Category</button>
</form>

<?php include '../includes/footer.php'; ?>
