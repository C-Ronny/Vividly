<?php
require_once '../config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $pin_id = $data['pin_id'];
    $board_id = $data['board_id'];
    $user_id = $_SESSION['user_id'];

    // Verify board belongs to user
    $verify_query = "SELECT board_id FROM Boards WHERE board_id = ? AND user_id = ?";
    $verify_stmt = $conn->prepare($verify_query);
    $verify_stmt->bind_param('ii', $board_id, $user_id);
    $verify_stmt->execute();
    $result = $verify_stmt->get_result();

    if ($result->num_rows > 0) {
        // Add pin to board
        $query = "UPDATE Pins SET board_id = ? WHERE pin_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('ii', $board_id, $pin_id);
        
        echo json_encode(['success' => $stmt->execute()]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Unauthorized']);
    }
}
