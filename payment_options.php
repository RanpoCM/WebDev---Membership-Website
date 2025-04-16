<?php
session_start();
require_once 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['new_tier'])) {
    $selected_tier = $_POST['new_tier'];
} else {
    $_SESSION['message'] = "No tier selected.";
    header("Location: membership_tiers.php");
    exit();
}

$user_id = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Choose Payment Option | Momoyo</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <script src="https://www.paypal.com/sdk/js?client-id=YOUR_PAYPAL_CLIENT_ID&currency=PHP"></script> 
  <style>
    body {
      background-color: #fff0f5;
      font-family: Arial, sans-serif;
    }
    .container {
      max-width: 800px;
      margin-top: 50px;
    }
    .section-title {
      color: #ff4d88;
      font-size: 2rem;
      font-weight: bold;
      margin-bottom: 20px;
    }
    .qr-img {
      max-width: 300px;
      margin-bottom: 15px;
    }
    .payment-box {
      padding: 30px;
      border-radius: 15px;
      background: white;
      box-shadow: 0 0 15px rgba(0,0,0,0.1);
      margin-bottom: 30px;
    }
    .btn-submit {
      background-color: #ff4d88;
      border: none;
      color: white;
      padding: 10px 25px;
      border-radius: 50px;
      font-weight: bold;
    }
  </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container">
  <h2 class="text-center section-title">Pay to Upgrade: <?php echo htmlspecialchars($selected_tier); ?></h2>

  <div class="payment-box">
    <h4> Pay with GCash</h4>
    <p>Scan the QR code below and upload a screenshot of your receipt.</p>
    <img src="assets/gcash_qr.png" alt="GCash QR Code" class="qr-img">

    <form action="gcash_upload.php" method="POST" enctype="multipart/form-data">
      <input type="hidden" name="new_tier" value="<?php echo htmlspecialchars($selected_tier); ?>">
      <div class="mb-3">
        <label for="receipt" class="form-label">Upload GCash Receipt (image only)</label>
        <input type="file" name="receipt" id="receipt" class="form-control" required accept="image/*">
      </div>
      <button type="submit" class="btn-submit">Submit Payment</button>
    </form>
  </div>

  <div class="payment-box">
    <h4> Pay with PayPal</h4>
    <p>Click below to pay via PayPal and instantly upgrade your membership.</p>
    
    <div id="paypal-button-container"></div>
  </div>
</div>

<?php include 'footer.php'; ?>

<script>
paypal.Buttons({
  createOrder: function(data, actions) {
    return actions.order.create({
      purchase_units: [{
        amount: {
          value: '<?php echo ($selected_tier === "Premium" ? "250.00" : "150.00"); ?>'
        }
      }]
    });
  },
  onApprove: function(data, actions) {
    return actions.order.capture().then(function(details) {
      
      fetch('paypal_process.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({
          orderID: data.orderID,
          userID: <?php echo json_encode($user_id); ?>,
          newTier: <?php echo json_encode($selected_tier); ?>
        })
      })
      .then(res => res.json())
      .then(data => {
        alert(data.message);
        window.location.href = "profile.php";
      });
    });
  }
}).render('#paypal-button-container');
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
