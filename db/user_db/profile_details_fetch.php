<?php
require '../config.php';

// Query to fetch user details
$query = " SELECT fname, lname, email, profile_picture, created_at FROM Users WHERE user_id= ?";

$result = $conn->query($query);


?>
