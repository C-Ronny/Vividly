<?php
require '../config.php';

// Query to fetch user details
$query = " SELECT fname, lname, email, `role`, created_at FROM Users";

$result = $conn->query($query);

$users = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}

// Return data as JSON
header('Content-Type: application/json');
echo json_encode($users);

?>