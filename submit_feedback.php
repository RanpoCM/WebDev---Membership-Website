<?php
session_start();
require_once 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $feedback = $_POST['feedback'];
    
    if (!empty($feedback)) {
       
        $sql = "INSERT INTO feedback (user_id, feedback_text, submitted_at) VALUES (?, ?, NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $user_id, $feedback);
        
        if ($stmt->execute()) {
            $_SESSION['message'] = "Thank you for your feedback!";
            header("Location: profile.php");
        } else {
            $_SESSION['message'] = "Error submitting feedback. Please try again.";
        }
        $stmt->close();
    } else {
        $_SESSION['message'] = "Feedback cannot be empty.";
    }
}

header("Location: profile.php");
exit();
?>
