<?php
// Include the database configuration
include '../config.php';

// Start the session
session_start();

// Check if category_id is provided
if (!isset($_GET['category_id'])) {
    echo json_encode(['error' => 'Category ID is required']);
    exit();
}

$category_id = intval($_GET['category_id']);

// Validate category_id (1-6)
if ($category_id < 1 || $category_id > 6) {
    echo json_encode(['error' => 'Invalid category ID']);
    exit();
}

// Fetch pins for the specified category
$query = "SELECT p.*, u.fname, u.lname 
          FROM Pins p 
          JOIN Users u ON p.user_id = u.user_id 
          WHERE p.category_id = ?
          ORDER BY p.created_at DESC";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $category_id);
$stmt->execute();
$result = $stmt->get_result();

$pins = [];
while ($row = $result->fetch_assoc()) {
    $pins[] = $row;
}

// Close the statement and connection
$stmt->close();
$conn->close();

// Return the pins as JSON
header('Content-Type: application/json');
echo json_encode($pins);
?> 