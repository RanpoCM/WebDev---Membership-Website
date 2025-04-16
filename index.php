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
  <title>Home | Momoyo</title>
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
    .product-card {
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease;
      border-radius: 15px;
      overflow: hidden;
      background-color: white;
    }
    .product-card:hover {
      transform: translateY(-5px);
    }
    .product-card img {
      width: 100%;
      height: 200px;
      object-fit: cover;
    }
    .product-card-body {
      padding: 20px;
    }
    .product-title {
      font-size: 1.25rem;
      font-weight: bold;
    }
    .product-price {
      font-size: 1.1rem;
      color: #d63384;
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

  <header>
    <h1>Welcome to Momoyo!</h1>
    <p>Delicious Ice Cream and Iced Coffee with a Twist</p>
  </header>

  <section class="container py-5">
    <h2 class="text-center mb-4">Our Products</h2>
    <div class="row">
 
      <div class="col-md-4 mb-4">
        <div class="product-card">
          <img src="images/product1.jpg" alt="Product 1">
          <div class="product-card-body">
            <h5 class="product-title">Classic Ice Cream</h5>
            <p class="product-price">₱150</p>
            <p>Indulge in our classic creamy ice cream made with the finest ingredients.</p>
          </div>
        </div>
      </div>

      <div class="col-md-4 mb-4">
        <div class="product-card">
          <img src="images/product2.jpg" alt="Product 2">
          <div class="product-card-body">
            <h5 class="product-title">Iced Coffee</h5>
            <p class="product-price">₱120</p>
            <p>Refresh yourself with our smooth iced coffee, brewed to perfection.</p>
          </div>
        </div>
      </div>
     
      <div class="col-md-4 mb-4">
        <div class="product-card">
          <img src="images/product3.jpg" alt="Product 3">
          <div class="product-card-body">
            <h5 class="product-title">Signature Sundae</h5>
            <p class="product-price">₱180</p>
            <p>Our signature sundae, with a perfect blend of ice cream and toppings.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <footer>
    <p>&copy; 2025 Momoyo. All rights reserved.</p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
