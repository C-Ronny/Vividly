<?php 
require '../config.php';
require  '../../util/error_config.php';

// Fetch all image URLs from the Pins table
$query = "SELECT image_url FROM Pins";

$result = $conn->query($query);

// Array to store image URLs
$pins = [];

// Check if query was successful
if ($result) {
  // Fetch all image URLs into an array
  while ($row = $result->fetch_assoc()) {
      $pins[] = $row;
  }
  // Return images as JSON// Return images as JSON
  header('Content-Type: application/json');
  echo json_encode($pins);

} else {
  // Handle query error
  http_response_code(500);
  echo json_encode(['error' => 'Failed to fetch images']);
}

?>