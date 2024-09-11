<?php include '../includes/header.php'; ?>
<?php include '../includes/db.php'; ?>

<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
    header('Location: login.php');
    exit();
}

$category_id = $_GET['id'];

$stmt = $pdo->prepare('SELECT * FROM categories WHERE id = ?');
$stmt->execute([$category_id]);
$category = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];

    $stmt = $pdo->prepare('UPDATE categories SET name = ? WHERE id = ?');
    $stmt->execute([$name, $category_id]);

    header('Location: admin.php');
    exit();
}
?>

<h1>Edit Category</h1>
<form method="post" action="edit_category.php?id=<?php echo $category_id; ?>">
    <div class="form-group">
        <label for="name">Category Name</label>
        <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($category['name'], ENT_QUOTES); ?>" required>
    </div>
    <button type="submit" class="btn btn-primary">Update Category</button>
</form>

<?php include '../includes/footer.php'; ?>
