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

// Check if pin exists and get its current board_id
$check_query = "SELECT board_id FROM Pins WHERE pin_id = ?";
$check_stmt = $conn->prepare($check_query);
$check_stmt->bind_param("i", $pin_id);
$check_stmt->execute();
$check_result = $check_stmt->get_result();

if ($check_result->num_rows === 0) {
    echo json_encode(['error' => 'Pin not found']);
    exit;
}

// Update the pin's board_id
$update_query = "UPDATE Pins SET board_id = ? WHERE pin_id = ?";
$update_stmt = $conn->prepare($update_query);
$update_stmt->bind_param("ii", $board_id, $pin_id);

if ($update_stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['error' => 'Failed to add pin to board']);
}

$verify_stmt->close();
$check_stmt->close();
$update_stmt->close();
$conn->close();
?>
