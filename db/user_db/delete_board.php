<?php
require_once '../config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $board_id = $_POST['board_id'];
    $user_id = $_SESSION['user_id'];
    
    $query = "DELETE FROM Boards WHERE board_id = ? AND user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ii', $board_id, $user_id);
    
    echo json_encode(['success' => $stmt->execute()]);
}
