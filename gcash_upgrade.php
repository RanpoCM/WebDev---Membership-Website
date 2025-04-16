<?php
session_start();
require_once 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['receipt'])) {
    if ($_FILES['receipt']['error'] == 0) {
        $target_dir = "uploads/gcash_receipts/";
        $file_name = basename($_FILES["receipt"]["name"]);
        $file_name = preg_replace("/[^a-zA-Z0-9.]/", "_", $file_name);  
        $target_file = $target_dir . $file_name;

        $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($file_type, $allowed_types)) {
            if (move_uploaded_file($_FILES["receipt"]["tmp_name"], $target_file)) {
                
                $sql = "UPDATE users SET membership_tier = ? WHERE user_id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("si", $_POST['new_tier'], $user_id);

                if ($stmt->execute()) {
                    $_SESSION['message'] = "Your membership has been upgraded!";
                    header("Location: profile.php");
                    exit();
                } else {
                    $_SESSION['message'] = "Error upgrading membership.";
                    header("Location: upgrade_membership.php");
                    exit();
                }

                $stmt->close();
            } else {
                $_SESSION['message'] = "Error uploading the receipt. Please try again.";
                header("Location: upgrade_membership.php");
                exit();
            }
        } else {
            $_SESSION['message'] = "Invalid file type. Only images are allowed.";
            header("Location: upgrade_membership.php");
            exit();
        }
    } else {
        $_SESSION['message'] = "Error uploading the receipt. Please try again.";
        header("Location: upgrade_membership.php");
        exit();
    }
} else {
    header("Location: profile.php");
    exit();
}
?>

