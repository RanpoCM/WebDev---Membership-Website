<?php
session_start();
require_once 'db_connect.php';

$isLoggedIn = isset($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>About Us | Momoyo</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: white;
      color: black;
    }
    header {
      background-color: black;
      color: pink;
      padding: 20px;
      text-align: center;
    }
    footer {
      background-color: pink;
      color: black;
      text-align: center;
      padding: 10px;
    }
    .navbar {
      background-color: #f8f9fa;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    .nav-link {
      color: black !important;
      font-weight: 500;
      margin-left: 10px;
    }
    .nav-link:hover {
      color: pink !important;
    }
  </style>
</head>
<body>

  <nav class="navbar navbar-expand-lg navbar-light">
    <div class="container-fluid">
      <a class="navbar-brand" href="index.php">Momoyo</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="about.php">About Us</a></li>
          <li class="nav-item"><a class="nav-link" href="locations.php">Locations</a></li>
          
          <?php if ($isLoggedIn): ?>
            <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
            <li class="nav-item"><a class="nav-link" href="profile.php">Profile</a></li>
            <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
          <?php else: ?>
            <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
            <li class="nav-item"><a class="nav-link" href="register.php">Register</a></li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </nav>

  <section class="container py-5">
    <h2>About Us</h2>
    <p>Welcome to Momoyo, where we offer delicious ice cream and iced coffee with a twist. We believe in creating not just a product, but a memorable experience. Our mission is to bring joy to your taste buds with every scoop and sip!</p>
    <p>Join our membership for exclusive perks, loyalty rewards, and much more! Whether you're a casual fan or a dedicated enthusiast, we have something for everyone.</p>
    <p>Discover the magic of Momoyo today!</p>
  </section>

  <footer>
    <p>&copy; 2025 Momoyo. All rights reserved.</p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
