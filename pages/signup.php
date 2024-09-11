<?php include '../includes/header.php'; ?>
<?php
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $phone = $_POST['phone'];

    $stmt = $pdo->prepare('INSERT INTO users (username, email, password, phone) VALUES (?, ?, ?, ?)');
    $stmt->execute([$username, $email, $password, $phone]);

    header('Location: login.php');
}
?>
<h1>Signup</h1>
<form method="post" action="signup.php">
    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" class="form-control" id="username" name="username" required>
    </div>
    <div class="form-group">
        <label for="phone">Phone</label>
        <input type="tel" class="form-control" id="phone" name="phone" required>
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" class="form-control" id="email" name="email" required>
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" id="password" name="password" required>
    </div>
    <button type="submit" class="btn btn-primary">Signup</button>
</form>

<?php include '../includes/footer.php'; ?>
