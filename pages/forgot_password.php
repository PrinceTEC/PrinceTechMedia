<?php include '../includes/header.php';?>
<?php
ob_start();
session_start();
require_once 'sms_functions.php'; // Include the file with sendOtp and generateOtp functions

require_once '../includes/db.php'; // Database connection

$error = "";
$success = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $phone = $_POST['phone'];

    // Check if the phone number exists in the users table
    $stmt = $pdo->prepare('SELECT * FROM users WHERE phone = ?');
    $stmt->execute([$phone]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Generate OTP
        $otp = generateOtp();

        // Store OTP and expiry time in session or database
        $_SESSION['otp'] = $otp;
        $_SESSION['otp_expiry'] = time() + 300; // OTP valid for 5 minutes
        $_SESSION['reset_phone'] = $phone;

        // Send OTP via SMS
        try {
            sendOtp($phone, $otp);
            $success = "An OTP has been sent to your phone.";
            header('Location: verify_otp.php'); // Redirect to OTP verification page
            exit();
        } catch (Exception $e) {
            $error = "Failed to send OTP. Please try again later.";
        }
    } else {
        $error = "Phone number not found.";
    }
}
ob_end_flush();
?>
<div class="container mt-5">
    <h2>Forgot Password</h2>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?= $error; ?></div>
    <?php endif; ?>
    <?php if ($success): ?>
        <div class="alert alert-success"><?= $success; ?></div>
    <?php endif; ?>

    <form action="forgot_password.php" method="post">
        <div class="form-group">
            <label for="phone">Enter Your Phone Number</label>
            <input type="text" class="form-control" id="phone" name="phone" required>
        </div>
        <button type="submit" class="btn btn-primary">Request OTP</button>
    </form>
</div>


<?php include '../includes/footer.php'; ?>
