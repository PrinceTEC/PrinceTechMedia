<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}// Initialize cart count
$cartCount = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Electronics E-commerce</title>
    <link rel="stylesheet" href="/ecommerce/css/styles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="flex-wrapper">
<div class="container mt-4">
<nav class="navbar navbar-expand-lg">
  <a class="navbar-brand" href="/ecommerce/pages/index.php">PALTECH ELC</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item"><a class="nav-link" href="/ecommerce/pages/index.php">Home</a></li>
      <li class="nav-item"> <a class="nav-link" href="/ecommerce/pages/cart.php">
        Cart <span class="badge badge-pill badge-primary"><?php echo $cartCount; ?></span>
    </a></li>
      <li class="nav-item"><a class="nav-link" href="/ecommerce/pages/admin.php">Admin</a></li>
      <?php if (isset($_SESSION['user_id'])): ?>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img src="path_to_profile_image/<?php echo $_SESSION['user_id']; ?>.jpg" alt="Profile Image" class="rounded-circle" style="width: 30px; height: 30px;">
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="profileDropdown">
                <a class="dropdown-item" href="/ecommerce/pages/profile.php">Profile</a>
                <a class="dropdown-item" href="/ecommerce/pages/logout.php">Logout</a>
            </div>
        </li>
      <?php else: ?>
        <li class="nav-item">
            <a class="nav-link" href="#" data-toggle="modal" data-target="#loginModal">Login</a>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="/ecommerce/pages/signup.php">Signup</a>
        </li>
      <?php endif; ?>
    </ul>
  </div>
</nav>
<!-- Bootstrap Modal for login -->
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="loginModalLabel">Login</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="/ecommerce/pages/login.php">
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
          </div>
          <button type="submit" class="btn btn-primary">Login</button>
          <a href="/ecommerce/pages/forgot_password.php" class="btn btn-link">Forgot Password?</a>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap Modal for signup
<div class="modal fade" id="signupModal" tabindex="-1" role="dialog" aria-labelledby="signupModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="signupModalLabel">signup</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="/ecommerce/pages/signup.php">
          <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" id="username" name="username" required>
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
      </div>
    </div>
  </div>
</div>-->