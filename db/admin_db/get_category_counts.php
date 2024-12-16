<?php
require_once '../config.php';

// Query to count pins in each category
$query = "SELECT category_id, COUNT(*) as count 
          FROM Pins 
          GROUP BY category_id";

$result = $conn->query($query);

// Initialize array with zeros for all categories
$category_counts = array_fill(1, 6, 0);

// Fill in actual counts
while ($row = $result->fetch_assoc()) {
    $category_id = $row['category_id'];
    if ($category_id >= 1 && $category_id <= 6) {
        $category_counts[$category_id] = (int)$row['count'];
    }
}

echo json_encode($category_counts);

$conn->close();
?>
