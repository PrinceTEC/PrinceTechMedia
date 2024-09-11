<?php
require '../includes/header.php';

//session_start();
require_once 'mpesa_config.php';

// Check if otp_phone exists in POST or SESSION
if (isset($_POST['otp_phone'])) {
    $otp_phone = $_POST['otp_phone'];
} elseif (isset($_SESSION['otp_phone'])) {
    $otp_phone = $_SESSION['otp_phone'];
} else {
    // If otp_phone is not set, show an error or handle it accordingly
    echo "OTP phone number is not available.";
    exit();
}

if (!isset($_SESSION['otp'])) {
    header('Location: request_otp.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $newPassword = password_hash($_POST['new_password'], PASSWORD_BCRYPT);

    // Update the password in the database
    $phoneNumber = $_SESSION['otp_phone'];
    $pdo = getDbConnection();
    $stmt = $pdo->prepare('UPDATE users SET password = ? WHERE phone = ?');
    $stmt->execute([$newPassword, $phoneNumber]);

    // Clear the OTP session data
    unset($_SESSION['otp'], $_SESSION['otp_expiry'], $_SESSION['otp_phone']);

    echo "Password updated successfully. You can now <a href='login.php'>login</a>.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
</head>
<body>
    <form action="reset_password.php" method="post">
        <label for="new_password">Enter your new password:</label>
        <input type="password" id="new_password" name="new_password" required>
        <button type="submit">Reset Password</button>
    </form>
</body>
</html>


<?php include '../includes/footer.php'; ?>
