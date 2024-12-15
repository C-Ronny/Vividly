<?php
header('Content-Type: application/json');
include '../../db/config.php';

// Get JSON data
$data = json_decode(file_get_contents('php://input'), true);

// Debug log
error_log('Received delete request: ' . print_r($data, true));

if (!isset($data['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User ID is required']);
    exit;
}

$conn->begin_transaction();

try {
    // Delete user's pins
    $stmt = $conn->prepare("DELETE FROM Pins WHERE user_id = ?");
    $stmt->bind_param("i", $data['user_id']);
    $stmt->execute();

    // Delete user's boards
    $stmt = $conn->prepare("DELETE FROM Boards WHERE user_id = ?");
    $stmt->bind_param("i", $data['user_id']);
    $stmt->execute();

    // Finally, delete the user
    $stmt = $conn->prepare("DELETE FROM Users WHERE user_id = ?");
    $stmt->bind_param("i", $data['user_id']);
    $stmt->execute();

    $conn->commit();
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}

$stmt->close();
$conn->close();
?>