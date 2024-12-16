<?php
session_start();
include '../config.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'Not logged in']);
    exit;
}

$user_id = $_SESSION['user_id'];

$query = "SELECT board_id, title FROM Boards WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$boards = [];
while ($row = $result->fetch_assoc()) {
    $boards[] = $row;
}

echo json_encode(['success' => true, 'boards' => $boards]);

$stmt->close();
$conn->close();
?> 