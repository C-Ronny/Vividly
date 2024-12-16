<?php
session_start();
include '../config.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'Not logged in']);
    exit;
}

$pin_id = $_GET['pin_id'] ?? null;

if (!$pin_id) {
    echo json_encode(['error' => 'Missing pin_id']);
    exit;
}

// Get like count
$query = "SELECT COUNT(*) as likes FROM Likes WHERE pin_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $pin_id);
$stmt->execute();
$result = $stmt->get_result();
$likes = $result->fetch_assoc()['likes'];

echo json_encode(['success' => true, 'likes' => $likes]);

$stmt->close();
$conn->close();
?> 