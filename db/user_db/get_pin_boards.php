<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['user_id']) || !isset($_GET['pin_id'])) {
    echo json_encode(['success' => false, 'error' => 'Invalid request']);
    exit;
}

$userId = $_SESSION['user_id'];
$pinId = $_GET['pin_id'];

try {
    $stmt = $pdo->prepare("
        SELECT b.board_id, b.title 
        FROM boards b
        INNER JOIN board_pins bp ON b.board_id = bp.board_id
        WHERE bp.pin_id = ? AND b.user_id = ?
    ");
    
    $stmt->execute([$pinId, $userId]);
    $boards = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode([
        'success' => true,
        'boards' => $boards
    ]);
} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'error' => 'Database error'
    ]);
}
?> 