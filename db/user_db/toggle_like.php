<?php
session_start();
require '../config.php';

$data = json_decode(file_get_contents('php://input'), true);
$pin_id = $data['pin_id'];
$user_id = $_SESSION['user_id'];

// Check if user already liked the pin
$check_query = "SELECT like_id FROM Likes WHERE pin_id = ? AND user_id = ?";
$check_stmt = $conn->prepare($check_query);
$check_stmt->bind_param('ii', $pin_id, $user_id);
$check_stmt->execute();
$result = $check_stmt->get_result();

if ($result->num_rows > 0) {
    // Unlike
    $delete_query = "DELETE FROM Likes WHERE pin_id = ? AND user_id = ?";
    $delete_stmt = $conn->prepare($delete_query);
    $delete_stmt->bind_param('ii', $pin_id, $user_id);
    $delete_stmt->execute();
} else {
    // Like
    $insert_query = "INSERT INTO Likes (pin_id, user_id) VALUES (?, ?)";
    $insert_stmt = $conn->prepare($insert_query);
    $insert_stmt->bind_param('ii', $pin_id, $user_id);
    $insert_stmt->execute();
}

// Get updated likes count
$count_query = "SELECT COUNT(*) as likes_count FROM Likes WHERE pin_id = ?";
$count_stmt = $conn->prepare($count_query);
$count_stmt->bind_param('i', $pin_id);
$count_stmt->execute();
$count_result = $count_stmt->get_result();
$likes_count = $count_result->fetch_assoc()['likes_count'];

echo json_encode([
    'success' => true,
    'likes_count' => $likes_count
]); 