<?php
require '../config.php';

// Fetch total users
$queryUsers = "SELECT COUNT(*) AS total_users FROM Users";
$resultUsers = $conn->query($queryUsers);
$totalUsers = $resultUsers->fetch_assoc()['total_users'];

// Fetch total boards
$queryBoards = "SELECT COUNT(*) AS total_boards FROM Boards";
$resultBoards = $conn->query($queryBoards);
$totalBoards = $resultBoards->fetch_assoc()['total_boards'];

// Fetch total pins / images
$queryPins = "SELECT COUNT(*) AS total_pins FROM Pins";
$resultPins = $conn->query($queryPins);
$totalPins = $resultPins->fetch_assoc()['total_pins'];

// Return data as JSON
echo json_encode([
    'totalUsers' => $totalUsers,
    'totalBoards' => $totalBoards,
    'totalPins' => $totalPins
]);

?>