<?php
session_start();
require_once 'db_connect.php';


function generate_hash($password) {
    return password_hash($password, PASSWORD_BCRYPT);
}

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];


    if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
        $_SESSION['message'] = "All fields are required.";
        header("Location: change_password.php");
        exit();
    }

    if ($new_password !== $confirm_password) {
        $_SESSION['message'] = "New password and confirm password do not match.";
        header("Location: change_password.php");
        exit();
    }


    $sql = "SELECT password FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($hashed_password);
    $stmt->fetch();
    $stmt->close();

    if (!password_verify($current_password, $hashed_password)) {
        $_SESSION['message'] = "Current password is incorrect.";
        header("Location: change_password.php");
        exit();
    }

    $new_hashed_password = generate_hash($new_password);


    $sql = "UPDATE users SET password = ? WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $new_hashed_password, $user_id);
    
    if ($stmt->execute()) {
        $_SESSION['message'] = "Password changed successfully.";
        header("Location: profile.php");
    } else {
        $_SESSION['message'] = "Error changing password.";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Change Password | Momoyo</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>

<?php include('navbar.php'); ?>

<div class="container my-5">
  <h2>Change Password</h2>
  
  <form action="change_password.php" method="POST">
    <div class="mb-3">
      <label for="current_password" class="form-label">Current Password</label>
      <input type="password" class="form-control" id="current_password" name="current_password" required>
    </div>

    <div class="mb-3">
      <label for="new_password" class="form-label">New Password</label>
      <input type="password" class="form-control" id="new_password" name="new_password" required>
    </div>

    <div class="mb-3">
      <label for="confirm_password" class="form-label">Confirm New Password</label>
      <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
    </div>

    <button type="submit" class="btn btn-primary">Change Password</button>
  </form>
</div>

<?php include('footer.php'); ?>

</body>
</html>
