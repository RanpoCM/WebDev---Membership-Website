<?php
session_start();
require_once 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$message = $_SESSION['message'] ?? '';
unset($_SESSION['message']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Upgrade Membership | Momoyo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://www.paypal.com/sdk/js?client-id=YOUR_PAYPAL_CLIENT_ID"></script>
    <style>
        body {
            background: #fff5fa;
        }
        .upgrade-container {
            max-width: 700px;
            margin: auto;
            margin-top: 50px;
            padding: 30px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        .momoyo-logo {
            width: 80px;
        }
    </style>
</head>
<body>

<div class="container upgrade-container">
    <div class="text-center">
        <img src="images/momoyo.png" class="momoyo-logo mb-3" alt="Momoyo Logo">
        <h2 class="mb-3">Upgrade to <span class="text-danger">Premium</span></h2>
        <?php if ($message): ?>
            <div class="alert alert-info"><?= htmlspecialchars($message); ?></div>
        <?php endif; ?>
    </div>

    <hr>

    <h5>💳 Pay with GCash (Manual)</h5>
    <p>Scan the QR code below and upload your payment receipt.</p>
    <div class="text-center mb-3">
        <img src="images/gcash_qr.png" alt="GCash QR" width="200">
    </div>
    <form action="gcash_upload.php" method="POST" enctype="multipart/form-data" class="mb-5">
        <div class="mb-3">
            <label for="receipt" class="form-label">Upload GCash Receipt</label>
            <input type="file" class="form-control" name="receipt" accept="image/*" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Submit Receipt</button>
    </form>

    <hr>

    <h5>🌐 Pay with PayPal</h5>
    <div id="paypal-button-container"></div>
</div>

<script>
paypal.Buttons({
    createOrder: function(data, actions) {
        return actions.order.create({
            purchase_units: [{
                amount: {
                    value: '4.99' 
                }
            }]
        });
    },
    onApprove: function(data, actions) {
        return actions.order.capture().then(function(details) {
     
            fetch('paypal_upgrade.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    orderID: data.orderID,
                    userID: <?= json_encode($user_id) ?>
                })
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message); 
                window.location.href = 'profile.php'; 
            })
            .catch(error => {
                alert('Error: ' + error.message); 
            });
        });
    }
}).render('#paypal-button-container');
</script>

</body>
</html>
