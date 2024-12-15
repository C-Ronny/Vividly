<?php
// Set headers first
header('Content-Type: application/json');

// Include database configuration
include '../../db/config.php';

// Query to get top 5 users with most pins
$query = "SELECT u.fname, COUNT(p.pin_id) as pin_count 
          FROM Users u 
          LEFT JOIN Pins p ON u.user_id = p.user_id 
          GROUP BY u.user_id, u.fname 
          ORDER BY pin_count DESC 
          LIMIT 5";

$result = $conn->query($query);
$data = array();

if ($result) {
    while($row = $result->fetch_assoc()) {
        $data[] = array(
            'name' => $row['fname'],
            'count' => (int)$row['pin_count']
        );
    }
}

// Make sure there's no output before this point
echo json_encode($data);

$conn->close();
?> 