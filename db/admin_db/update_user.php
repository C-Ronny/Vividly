<?php
header('Content-Type: application/json');
include '../../db/config.php';

// Debug log all POST data
error_log('POST data received: ' . print_r($_POST, true));

// Get form data
$user_id = $_POST['editUserId'] ?? null;
$fname = $_POST['editFname'] ?? null;
$lname = $_POST['editLname'] ?? null;
$email = $_POST['editEmail'] ?? null;
$role = $_POST['editRole'] ?? null;

// Validate user_id specifically
if ($user_id === 'undefined' || $user_id === null) {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid User ID'
    ]);
    exit;
}

// Debug log individual fields
error_log("User ID: $user_id");
error_log("First Name: $fname");
error_log("Last Name: $lname");
error_log("Email: $email");
error_log("Role: $role");

// Validate input
if (empty($user_id) || empty($fname) || empty($lname) || empty($email) || $role === null) {
    $missing_fields = [];
    if (empty($user_id)) $missing_fields[] = 'User ID';
    if (empty($fname)) $missing_fields[] = 'First Name';
    if (empty($lname)) $missing_fields[] = 'Last Name';
    if (empty($email)) $missing_fields[] = 'Email';
    if ($role === null) $missing_fields[] = 'Role';
    
    echo json_encode([
        'success' => false, 
        'message' => 'Missing required fields: ' . implode(', ', $missing_fields)
    ]);
    exit;
}

// Update user
$stmt = $conn->prepare("UPDATE Users SET fname = ?, lname = ?, email = ?, role = ? WHERE user_id = ?");
$stmt->bind_param("sssii", $fname, $lname, $email, $role, $user_id);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'User updated successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>