<?php
session_start();
include '../config.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'Not logged in']);
    exit;
}

$user_id = $_SESSION['user_id'];
$pin_id = $_POST['pin_id'] ?? null;

if (!$pin_id) {
    echo json_encode(['error' => 'Missing pin_id']);
    exit;
}

// Check if user already liked the pin
$check_query = "SELECT like_id FROM Likes WHERE user_id = ? AND pin_id = ?";
$check_stmt = $conn->prepare($check_query);
$check_stmt->bind_param("ii", $user_id, $pin_id);
$check_stmt->execute();
$result = $check_stmt->get_result();

if ($result->num_rows > 0) {
    // Unlike - remove the like
    $delete_query = "DELETE FROM Likes WHERE user_id = ? AND pin_id = ?";
    $delete_stmt = $conn->prepare($delete_query);
    $delete_stmt->bind_param("ii", $user_id, $pin_id);
    $success = $delete_stmt->execute();
    $delete_stmt->close();
} else {
    // Like - add new like
    $insert_query = "INSERT INTO Likes (user_id, pin_id) VALUES (?, ?)";
    $insert_stmt = $conn->prepare($insert_query);
    $insert_stmt->bind_param("ii", $user_id, $pin_id);
    $success = $insert_stmt->execute();
    $insert_stmt->close();
}

if ($success) {
    // Get updated like count
    $count_query = "SELECT COUNT(*) as likes FROM Likes WHERE pin_id = ?";
    $count_stmt = $conn->prepare($count_query);
    $count_stmt->bind_param("i", $pin_id);
    $count_stmt->execute();
    $count_result = $count_stmt->get_result();
    $likes_count = $count_result->fetch_assoc()['likes'];
    
    echo json_encode(['success' => true, 'likes' => $likes_count]);
    $count_stmt->close();
} else {
    echo json_encode(['error' => 'Failed to update like']);
}

$check_stmt->close();
$conn->close();
?> 