<?php
session_start();
require_once 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT username, email, membership_tier, profile_picture FROM users WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($username, $email, $membership_tier, $profile_picture);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>My Profile | Momoyo</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      background-color: #f8f9fa;
      color: #212529;
      transition: background-color 0.3s, color 0.3s;
    }

    .profile-container {
        max-width: 800px;
        margin: auto;
        padding: 40px 20px;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        text-align: center;
    }
    .profile-picture img {
        width: 150px;
        height: 150px;
        object-fit: cover;
        border-radius: 50%;
        border: 4px solid #ffc0cb;
    }
    .profile-info h2 {
        margin-top: 15px;
    }
    .upgrade-section, .billing-section, .settings-section, .feedback-section {
        margin-top: 40px;
        text-align: left;
    }
    .card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    .btn-pink {
        background-color: #ff69b4;
        border: none;
        color: white;
    }
    .btn-pink:hover {
        background-color: #e0569c;
    }
  </style>
</head>
<body>

<?php if (isset($_SESSION['message'])): ?>
  <div class="alert alert-info mt-3"><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></div>
<?php endif; ?>

<?php include('navbar.php'); ?>


<div class="container my-5">
  <div class="profile-container">
    <div class="profile-picture">
      <img src="<?php echo $profile_picture ? 'uploads/' . htmlspecialchars($profile_picture) : 'images/default-profile.jpg'; ?>" alt="Profile Picture">
    </div>

    <div class="profile-info mt-3">
      <h2><?php echo htmlspecialchars($username); ?></h2>
      <p>Email: <?php echo htmlspecialchars($email); ?></p>
      <p>Membership Tier: <strong><?php echo htmlspecialchars($membership_tier); ?></strong></p>
    </div>

    <div class="customer-service-section mt-4">
      <h3>Customer Service</h3>
      <p>If you have any questions or need assistance, feel free to contact our support team!</p>
      <p>Email: <a href="mailto:support@momoyo.com">support@momoyo.com</a></p>
    </div>

    <div class="feedback-section mt-4">
      <h3>Feedback</h3>
      <p>We'd love to hear from you! Please share your feedback about your experience with Momoyo.</p>
      <form action="submit_feedback.php" method="POST">
        <div class="mb-3">
          <label for="feedback" class="form-label">Your Feedback</label>
          <textarea id="feedback" name="feedback" class="form-control" rows="4" required></textarea>
        </div>
        <button type="submit" class="btn btn-pink">Submit Feedback</button>
      </form>
    </div>

    <div class="settings-section mt-4">
      <h3>Settings</h3>
      <p>Manage your account settings below:</p>
      <a href="change_password.php" class="btn btn-secondary">Change Password</a>
      <a href="update_profile.php" class="btn btn-secondary">Update Profile</a>
    </div>
  </div>
</div>

<?php include('footer.php'); ?>

</body>
</html>

