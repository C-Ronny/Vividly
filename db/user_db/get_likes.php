<?php
session_start();
include '../config.php';

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode([
        'status' => 'error',
        'error' => [
            'code' => 'UNAUTHORIZED',
            'message' => 'User not logged in'
        ]
    ]);
    exit;
}

$pin_id = $_GET['pin_id'] ?? null;

if (!$pin_id) {
    http_response_code(400);
    echo json_encode([
        'status' => 'error',
        'error' => [
            'code' => 'MISSING_PARAMETER',
            'message' => 'Missing pin_id parameter'
        ]
    ]);
    exit;
}

// Get like count
$query = "SELECT COUNT(*) as likes FROM Likes WHERE pin_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $pin_id);
$stmt->execute();
$result = $stmt->get_result();
$likes = $result->fetch_assoc()['likes'];

echo json_encode([
    'status' => 'success',
    'data' => [
        'likes' => $likes
    ]
]);

$stmt->close();
$conn->close();
