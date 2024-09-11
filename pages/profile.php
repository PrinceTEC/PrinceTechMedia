<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include '../includes/header.php';
include '../includes/db.php'; 

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user profile
$stmt = $pdo->prepare('SELECT * FROM profiles WHERE user_id = ?');
$stmt->execute([$user_id]);
$profile = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $full_name = $_POST['full_name'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];

    if ($profile) {
        // Update existing profile
        $stmt = $pdo->prepare('UPDATE profiles SET full_name = ?, address = ?, phone = ? WHERE user_id = ?');
        $stmt->execute([$full_name, $address, $phone, $user_id]);
    } else {
        // Create new profile
        $stmt = $pdo->prepare('INSERT INTO profiles (user_id, full_name, address, phone) VALUES (?, ?, ?, ?)');
        $stmt->execute([$user_id, $full_name, $address, $phone]);
    }

    header('Location: profile.php');
    exit();
}
?>

<h1>User Profile</h1>
<form method="post" action="profile.php">
    <div class="form-group">
        <label for="full_name">Full Name</label>
        <input type="text" class="form-control" id="full_name" name="full_name" value="<?php echo htmlspecialchars($profile['full_name'] ?? '', ENT_QUOTES); ?>" required>
    </div>
    <div class="form-group">
        <label for="address">Address</label>
        <textarea class="form-control" id="address" name="address" required><?php echo htmlspecialchars($profile['address'] ?? '', ENT_QUOTES); ?></textarea>
    </div>
    <div class="form-group">
        <label for="phone">Phone</label>
        <input type="text" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($profile['phone'] ?? '', ENT_QUOTES); ?>" required>
    </div>
    <button type="submit" class="btn btn-primary">Save Profile</button>
</form>

<?php include '../includes/footer.php'; ?>
