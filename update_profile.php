<?php
session_start();
require_once 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];


$sql = "SELECT username, email, profile_picture FROM users WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($username, $email, $profile_picture);
$stmt->fetch();
$stmt->close();


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_email = $_POST['email'];


    $new_profile_picture = $profile_picture;
    if ($_FILES['profile_picture']['error'] == 0) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["profile_picture"]["name"]);
        
        if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file)) {
            $new_profile_picture = basename($_FILES["profile_picture"]["name"]);
        } else {
            $_SESSION['message'] = "Error uploading file.";
            header("Location: update_profile.php");
            exit();
        }
    }

 
    $sql = "UPDATE users SET email = ?, profile_picture = ? WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $new_email, $new_profile_picture, $user_id);
    
    if ($stmt->execute()) {
        $_SESSION['message'] = "Profile updated successfully.";
        header("Location: profile.php");
    } else {
        $_SESSION['message'] = "Error updating profile.";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Update Profile | Momoyo</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>

<?php include('navbar.php'); ?>

<div class="container my-5">
  <h2>Update Profile</h2>
  
  <form action="update_profile.php" method="POST" enctype="multipart/form-data">
    <div class="mb-3">
      <label for="email" class="form-label">Email</label>
      <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
    </div>

    <div class="mb-3">
      <label for="profile_picture" class="form-label">Profile Picture</label>
      <input type="file" class="form-control" id="profile_picture" name="profile_picture" accept="image/*">
    </div>

    <button type="submit" class="btn btn-primary">Update Profile</button>
  </form>
</div>

<?php include('footer.php'); ?>

</body>
</html>
