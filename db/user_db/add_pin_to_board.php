<?php
require_once '../config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'error' => 'Not logged in']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pin_id = $_POST['pin_id'];
    $board_id = $_POST['board_id'];
    
    // Update the pin's board_id
    $query = "UPDATE Pins SET board_id = ? WHERE pin_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $board_id, $pin_id);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $conn->error]);
    }
    
    $stmt->close();
    $conn->close();
}
