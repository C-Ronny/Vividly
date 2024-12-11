<?php 
require '../config.php';
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../view/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// If it's a GET request, fetch user details
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Query to fetch user details with prepared statement
    $query = "SELECT fname, lname, email FROM Users WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    
    echo json_encode($user);
    exit();
}

// If it's a POST request, update user details
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $fname = $_POST['fname'] ?? '';
    $lname = $_POST['lname'] ?? '';
    $email = $_POST['email'] ?? '';

    // Prepare update query
    $update_query = "UPDATE Users SET fname = ?, lname = ?, email = ? WHERE user_id = ?";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param('sssi', $fname, $lname, $email, $user_id);

    if ($update_stmt->execute()) {
        // Update successful
        echo json_encode(['success' => true, 'message' => 'Profile updated successfully']);
    } else {
        // Update failed
        echo json_encode(['success' => false, 'error' => $update_stmt->error]);
    }
    exit();
}
?>