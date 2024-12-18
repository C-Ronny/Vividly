<?php
// Include the database configuration
include '../config.php';

// Start the session
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit();
}

// Check if pin_id was provided
if (!isset($_POST['pin_id'])) {
    echo json_encode(['success' => false, 'message' => 'No pin specified']);
    exit();
}

$user_id = $_SESSION['user_id'];
$pin_id = $_POST['pin_id'];

// Delete the like
$query = "DELETE FROM Likes WHERE user_id = ? AND pin_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $user_id, $pin_id);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to unlike pin']);
}

// Close the statement and connection
$stmt->close();
$conn->close();
?> 