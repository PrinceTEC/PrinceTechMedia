<?php include '../includes/header.php'; ?>
<?php include '../includes/db.php'; ?>

<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
    header('Location: login.php');
    exit();
}

$category_id = $_GET['id'];

$stmt = $pdo->prepare('DELETE FROM categories WHERE id = ?');
$stmt->execute([$category_id]);

header('Location: admin.php');
exit();
?>
