<?php
session_start();
require_once 'db_connect.php';


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];


$sql = "SELECT username, membership_tier, profile_picture FROM users WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($username, $membership_tier, $profile_picture);
$stmt->fetch();
$stmt->close();

if (!$username || !$membership_tier) {
    echo "Error: User not found or incomplete data.";
    exit();
}

$sql_payment_status = "SELECT status, payment_date FROM payments WHERE user_id = ? ORDER BY payment_date DESC LIMIT 1";
$stmt_payment = $conn->prepare($sql_payment_status);
$stmt_payment->bind_param("i", $user_id);
$stmt_payment->execute();
$stmt_payment->bind_result($payment_status, $payment_date);
$stmt_payment->fetch();
$stmt_payment->close();


$sql_payment_history = "SELECT amount, status, payment_date FROM payments WHERE user_id = ? ORDER BY payment_date DESC";
$stmt_history = $conn->prepare($sql_payment_history);
$stmt_history->bind_param("i", $user_id);
$stmt_history->execute();
$stmt_history->store_result();
$stmt_history->bind_result($payment_amount, $payment_status_history, $payment_date_history);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard | Momoyo</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
  
  <?php include('navbar.php'); ?>

  <section class="container py-5">
    <h1>Welcome, <?php echo htmlspecialchars($username); ?>!</h1>
    <p>Your Membership Tier: <?php echo htmlspecialchars($membership_tier); ?></p>

    <div class="profile-picture">
        <img src="<?php echo $profile_picture ? 'uploads/' . htmlspecialchars($profile_picture) : 'images/default-profile.jpg'; ?>" alt="Profile Picture" class="rounded-circle" width="150" height="150">
    </div>

 
    <div class="mt-4">
        <h2>Payment Status</h2>
        <?php if ($payment_status): ?>
            <p>Last payment status: <strong><?php echo htmlspecialchars($payment_status); ?></strong></p>
            <p>Payment Date: <?php echo date('F j, Y, g:i a', strtotime($payment_date)); ?></p>
        <?php else: ?>
            <p>No payment made yet. Please complete your payment to access exclusive content.</p>
        <?php endif; ?>
    </div>

    
    <div class="mt-4">
        <h2>Notifications</h2>
        <?php if ($membership_tier == 'Premium'): ?>
            <div class="alert alert-success" role="alert">
                 You have exclusive access to Premium content!
            </div>
        <?php else: ?>
            <div class="alert alert-warning" role="alert">
                 Upgrade to <strong>Premium</strong> to unlock exclusive content and features!
            </div>
        <?php endif; ?>
    </div>

    
    <div class="mt-4">
        <h2>Subscribe Now</h2>
        <?php if ($membership_tier == 'Premium'): ?>
            <button class="btn btn-secondary" disabled>Already a Premium Member</button>
        <?php elseif ($membership_tier == 'Classic'): ?>
            <a href="payment_options.php?tier=Premium" class="btn btn-primary">Upgrade to Premium</a>
        <?php else: ?>
            <a href="payment_options.php?tier=Classic" class="btn btn-primary">Upgrade to Classic</a>
        <?php endif; ?>
    </div>

    
    <div class="mt-4">
        <h2>Payment History</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Payment Date</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($stmt_history->num_rows > 0): ?>
                    <?php while ($stmt_history->fetch()): ?>
                        <tr>
                            <td>₱<?php echo number_format($payment_amount, 2); ?></td>
                            <td><?php echo htmlspecialchars($payment_status_history); ?></td>
                            <td><?php echo date('F j, Y, g:i a', strtotime($payment_date_history)); ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3">No payment history found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

   
    <div class="content-section mt-4">
      <?php if ($membership_tier == 'Premium'): ?>
        <h2> Exclusive Premium Content</h2>
        <p>Enjoy your exclusive content as a Premium member!</p>
      <?php else: ?>
        <h2> Exclusive Content</h2>
        <p>Upgrade to <strong>Premium</strong> to access exclusive content!</p>
      <?php endif; ?>
    </div>
  </section>

  <?php include('footer.php'); ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$stmt_history->close();
?>
