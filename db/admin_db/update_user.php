<?php
header('Content-Type: application/json');
include '../../db/config.php';

// Get JSON data
$data = json_decode(file_get_contents('php://input'), true);

// Debug log
error_log('Received update request: ' . print_r($data, true));

// Validate input
if (!isset($data['user_id']) || !isset($data['fname']) || !isset($data['lname']) || !isset($data['email']) || !isset($data['role'])) {
    echo json_encode(['success' => false, 'message' => 'Missing required fields']);
    exit;
}

// Update user
$stmt = $conn->prepare("UPDATE Users SET fname = ?, lname = ?, email = ?, role = ? WHERE user_id = ?");
$stmt->bind_param("sssii", $data['fname'], $data['lname'], $data['email'], $data['role'], $data['user_id']);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>