<?php
session_start();
require_once 'db_connect.php';

$current_tier = 'Free'; 

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $query = "SELECT membership_tier FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($membership_tier);
    $stmt->fetch();
    $stmt->close();

    $current_tier = $membership_tier;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Membership Tiers | Momoyo</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: white;
      color: black;
      font-family: 'Arial', sans-serif;
    }
    header {
      background-color: black;
      color: pink;
      padding: 20px 0;
    }
    footer {
      background-color: pink;
      color: black;
      padding: 20px 0;
    }
    .tier-card {
      border: 2px solid #f8f9fa;
      border-radius: 10px;
      padding: 30px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .tier-card:hover {
      transform: translateY(-10px);
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    }
    .tier-title {
      font-size: 2rem;
      font-weight: bold;
      color: #ff4d88;
    }
    .tier-description {
      color: #666;
      font-size: 1rem;
      margin-bottom: 15px;
    }
    .btn-upgrade {
      background-color: #ff4d88;
      color: white;
      border-radius: 50px;
      padding: 10px 30px;
      font-size: 1rem;
      font-weight: bold;
      border: none;
      transition: background-color 0.3s;
    }
    .btn-upgrade:hover {
      background-color: #e60073;
    }
    .tier-benefits {
      margin-top: 15px;
      font-size: 1rem;
      color: #333;
    }
    .benefit-item {
      margin: 5px 0;
    }
  </style>
</head>
<body>

<?php include('navbar.php'); ?>

<?php if (isset($_SESSION['message'])): ?>
  <div class="alert alert-info mt-3"><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></div>
<?php endif; ?>

<section class="py-5">
  <div class="container">
    <h2 class="text-center mb-4" style="font-size: 2.5rem; font-weight: bold; color: #ff4d88;">Membership Tiers</h2>
    <p class="text-center mb-5" style="font-size: 1.2rem; color: #666;">Choose the membership that suits you and enjoy amazing benefits at Momoyo!</p>
    <div class="row text-center">

      <div class="col-md-4 mb-4">
        <div class="tier-card">
          <h3 class="tier-title">Free</h3>
          <p class="tier-description">Get started with our loyalty card and stamps!</p>
          <div class="tier-benefits">
            <ul>
              <li class="benefit-item">Loyalty Card</li>
              <li class="benefit-item">Stamp Rewards</li>
            </ul>
          </div>
          <?php if (!isset($_SESSION['user_id'])): ?>
            <a href="register.php" class="btn-upgrade">Join Now</a>
          <?php elseif ($current_tier === 'Free'): ?>
            <span class="badge bg-success">Current Tier</span>
          <?php else: ?>
            <span class="badge bg-secondary">Included</span>
          <?php endif; ?>
        </div>
      </div>

      <div class="col-md-4 mb-4">
        <div class="tier-card">
          <h3 class="tier-title">Classic</h3>
          <p class="tier-description">Enjoy discounts and exclusive scratch cards!</p>
          <div class="tier-benefits">
            <ul>
              <li class="benefit-item">₱5 Discount</li>
              <li class="benefit-item">Scratch Cards</li>
            </ul>
          </div>
          <?php if ($current_tier === 'Free'): ?>
            <form action="payment_options.php" method="POST">
              <input type="hidden" name="new_tier" value="Classic">
              <button type="submit" class="btn-upgrade">Upgrade to Classic</button>
            </form>
          <?php elseif ($current_tier === 'Classic'): ?>
            <span class="badge bg-success">Current Tier</span>
          <?php else: ?>
            <span class="badge bg-secondary">Included in Premium</span>
          <?php endif; ?>
        </div>
      </div>

  
      <div class="col-md-4 mb-4">
        <div class="tier-card">
          <h3 class="tier-title">Premium</h3>
          <p class="tier-description">Access exclusive discounts and special scratch cards!</p>
          <div class="tier-benefits">
            <ul>
              <li class="benefit-item">₱10 Discount</li>
              <li class="benefit-item">Exclusive Scratch Cards</li>
            </ul>
          </div>
          <?php if ($current_tier === 'Premium'): ?>
            <span class="badge bg-success">Current Tier</span>
          <?php else: ?>
            <form action="payment_options.php" method="POST">
              <input type="hidden" name="new_tier" value="Premium">
              <button type="submit" class="btn-upgrade">Upgrade to Premium</button>
            </form>
          <?php endif; ?>
        </div>
      </div>

    </div>
  </div>
</section>

<?php include('footer.php'); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
