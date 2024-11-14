<?php

// Establish connection to database

// Define database server, username, password, and database name
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'vividly_db';

// Create a new MySQLi connection object using the specified credentials
$conn = new  mysqli($servername, $username, $password, $dbname);


// Check if the connection was successful
if($conn->connect_error){
  die("Connection failed");
}else{
  // echo "Connection successful";
}
?>