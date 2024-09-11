<?php
require '../includes/header.php';
ob_start();
//session_start();
require_once '../includes/db.php'; // Database connection

$error = "";
$success = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $enteredOtp = $_POST['otp'];

    // Check if the OTP matches and is still valid
    if (isset($_SESSION['otp']) && isset($_SESSION['otp_expiry'])) {
        if ($enteredOtp == $_SESSION['otp'] && time() < $_SESSION['otp_expiry']) {
            // OTP is correct and not expired
            header('Location: reset_password.php'); // Redirect to password reset page
            exit();
        } else {
            $error = "Invalid or expired OTP.";
        }
    } else {
        $error = "OTP not found. Please request a new OTP.";
    }
}
ob_end_flush();
?>
<div class="container mt-5">
    <h2>Verify OTP</h2>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?= $error; ?></div>
    <?php endif; ?>
    <?php if ($success): ?>
        <div class="alert alert-success"><?= $success; ?></div>
    <?php endif; ?>

    <form action="verify_otp.php" method="post">
        <div class="form-group">
            <label for="otp">Enter OTP</label>
            <input type="text" class="form-control" id="otp" name="otp" required>
        </div>
        <button type="submit" class="btn btn-primary">Verify OTP</button>
    </form>
</div>
<?php include '../includes/footer.php'; ?>
