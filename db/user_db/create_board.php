<?php
require_once '../config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    
    $query = "INSERT INTO Boards (user_id, title, description) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('iss', $user_id, $title, $description);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'board_id' => $stmt->insert_id]);
    } else {
        echo json_encode(['success' => false, 'error' => $stmt->error]);
    }
    
    $stmt->close();
    $conn->close();
}
