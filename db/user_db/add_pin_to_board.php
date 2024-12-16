<?php
session_start();
include '../config.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'Not logged in']);
    exit;
}

$user_id = $_SESSION['user_id'];
$pin_id = $_POST['pin_id'] ?? null;
$board_id = $_POST['board_id'] ?? null;

if (!$pin_id || !$board_id) {
    echo json_encode(['error' => 'Missing parameters']);
    exit;
}

// Verify the board belongs to the user
$verify_query = "SELECT board_id FROM Boards WHERE board_id = ? AND user_id = ?";
$verify_stmt = $conn->prepare($verify_query);
$verify_stmt->bind_param("ii", $board_id, $user_id);
$verify_stmt->execute();
$verify_result = $verify_stmt->get_result();

if ($verify_result->num_rows === 0) {
    echo json_encode(['error' => 'Invalid board']);
    exit;
}

// Check if pin is already in the board
$check_query = "SELECT * FROM Board_Pins WHERE board_id = ? AND pin_id = ?";
$check_stmt = $conn->prepare($check_query);
$check_stmt->bind_param("ii", $board_id, $pin_id);
$check_stmt->execute();

if ($check_stmt->get_result()->num_rows > 0) {
    echo json_encode(['error' => 'Pin already in board']);
    exit;
}

// Add pin to board
$insert_query = "INSERT INTO Board_Pins (board_id, pin_id) VALUES (?, ?)";
$insert_stmt = $conn->prepare($insert_query);
$insert_stmt->bind_param("ii", $board_id, $pin_id);

if ($insert_stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['error' => 'Failed to add pin to board']);
}

$verify_stmt->close();
$check_stmt->close();
$insert_stmt->close();
$conn->close();
?>
