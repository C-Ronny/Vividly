<?php

// include config file for db connection
include 'config.php';

//start a session
session_start();



//check if the user is already logged in
if($_REQUEST('REQUEST_METHOD') == 'POST'){
  $email = trim($_POST('eml'));
  $password = trim($_POST('psw'));
  
  if(empty($email) || empty($password)){
    echo "Please fill in all fields";
  }





}





?>