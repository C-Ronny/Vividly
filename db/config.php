<?php

// Define database server, username, password, and database name
$servername = 'localhost';
$username = 'root';
$password = 'Ronelle-0202731402-rocu';
// $password = '';
$dbname = 'webtech_fall2024_ronelle_cudjoe';
// $dbname = 'Vividly';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    error_log("Connection failed: " . $conn->connect_error);
    die("Connection failed: " . $conn->connect_error);
}

?>