<?php
session_start();
require_once 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['orderID']) && isset($data['userID']) && isset($data['newTier'])) {
        $orderID = $data['orderID'];
        $userID = $data['userID'];
        $newTier = $data['newTier'];

        
        $sql = "UPDATE users SET membership_tier = ? WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $newTier, $userID);

        if ($stmt->execute()) {
            $_SESSION['message'] = "Your membership has been upgraded to $newTier!";
            echo json_encode(['message' => 'Upgrade successful!']);
        } else {
            $_SESSION['message'] = "Error upgrading your membership.";
            echo json_encode(['message' => 'Upgrade failed.']);
        }

        $stmt->close();
    } else {
        echo json_encode(['message' => 'Invalid data received.']);
    }
} else {
    header("Location: profile.php");
    exit();
}
?>

