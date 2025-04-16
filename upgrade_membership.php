<?php
session_start();
require_once 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['new_tier'])) {
    $new_tier = $_POST['new_tier'];
    $user_id = $_SESSION['user_id'];

    $sql = "SELECT membership_tier FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($current_tier);
    $stmt->fetch();
    $stmt->close();

    if ($current_tier == $new_tier) {
        $_SESSION['message'] = "You're already a $new_tier member!";
        header("Location: membership_tiers.php");
        exit();
    }


    $sql = "UPDATE users SET membership_tier = ? WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $new_tier, $user_id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Your membership has been upgraded to $new_tier!";
        header("Location: profile.php");
        exit();
    } else {
        $_SESSION['message'] = "Error upgrading your membership. Please try again.";
        header("Location: membership_tiers.php");
        exit();
    }

    $stmt->close();
} else {
    $_SESSION['message'] = "Invalid upgrade request.";
    header("Location: membership_tiers.php");
    exit();
}
?>
