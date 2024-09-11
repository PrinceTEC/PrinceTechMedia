<?php
session_start();
// Destroy the session
session_unset();
session_destroy();

// Redirect to the homepage or login page
header("Location: /ecommerce/pages/index.php");
exit();
?>
