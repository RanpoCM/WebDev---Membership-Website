<?php
include 'db.php'; // Ensure this connects to your database properly

$tier = isset($_GET['tier']) ? $_GET['tier'] : 'Free';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Register | Momoyo</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="styles.css" />
</head>
<body>

 
  <section class="container py-5">
    <div class="form-container mt-5">
      <h2 class="text-center mb-4">Create Your Momoyo Account</h2>

      <?php session_start(); ?>
<?php if (isset($_SESSION['error'])): ?>
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <?= $_SESSION['error']; unset($_SESSION['error']); ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php endif; ?>

<?php if (isset($_SESSION['success'])): ?>
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    <?= $_SESSION['success']; unset($_SESSION['success']); ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php endif; ?>

<form action="register_action.php" method="POST" enctype="multipart/form-data">
  <div class="mb-3">
    <label for="username" class="form-label">Username</label>
    <input type="text" class="form-control" id="username" name="username" required>
  </div>
  <div class="mb-3">
    <label for="email" class="form-label">Email</label>
    <input type="email" class="form-control" id="email" name="email" required>
  </div>
  <div class="mb-3">
    <label for="password" class="form-label">Password</label>
    <input type="password" class="form-control" id="password" name="password" required>
  </div>
  <div class="mb-3">
    <label for="confirm_password" class="form-label">Confirm Password</label>
    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
  </div>
  <div class="mb-3">
    <label for="profile_picture" class="form-label">Profile Picture</label>
    <input type="file" class="form-control" id="profile_picture" name="profile_picture" accept="image/*">
  </div>
  <button type="submit" class="btn btn-primary">Register</button>
</form>


    </div>
  </section>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
