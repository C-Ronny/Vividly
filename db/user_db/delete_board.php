<?php
session_start();
include '../config.php';

if (!isset($_SESSION['user_id']) || !isset($_POST['board_id'])) {
    header("Location: ../../view/logIn.php");
    exit();
}

$board_id = $_POST['board_id'];
$user_id = $_SESSION['user_id'];

// First verify that this board belongs to the current user
$verify_query = "SELECT user_id FROM Boards WHERE board_id = ?";
$verify_stmt = $conn->prepare($verify_query);
$verify_stmt->bind_param("i", $board_id);
$verify_stmt->execute();
$result = $verify_stmt->get_result();
$board = $result->fetch_assoc();

if (!$board || $board['user_id'] != $user_id) {
    header("Location: ../../view/user_pages/boards.php?error=unauthorized");
    exit();
}

// Delete all pins associated with this board first
$delete_pins = "DELETE FROM Pins WHERE board_id = ?";
$pins_stmt = $conn->prepare($delete_pins);
$pins_stmt->bind_param("i", $board_id);
$pins_stmt->execute();

// Then delete the board
$delete_board = "DELETE FROM Boards WHERE board_id = ?";
$board_stmt = $conn->prepare($delete_board);
$board_stmt->bind_param("i", $board_id);
$board_stmt->execute();

// Close statements
$verify_stmt->close();
$pins_stmt->close();
$board_stmt->close();
$conn->close();

// Redirect back to boards page
header("Location: ../../view/user_pages/boards.php?success=board_deleted");
exit();
?>
