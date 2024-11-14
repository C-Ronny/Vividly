<?php
include '../db/config.php';
session_start();
include '../util/error_config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fname = trim($_POST['fname']);
    $lname = trim($_POST['lname']);
    $email = trim($_POST['email']);
    $password = trim($_POST['psw']);
    $confirm_password = trim($_POST['psw-confirm']);
    $role = 2;

    // Check if any fields are empty
    if (empty($fname) || empty($lname) || empty($email) || empty($password) || empty($confirm_password)) {
        echo "<script>alert('All fields are required'); window.location.href='../view/register.php';</script>";
        exit;
    }

    // Check if password and confirm password match
    if ($password !== $confirm_password) {
        echo "<script>alert('Passwords do not match'); window.location.href='../view/register.php';</script>";
        exit;
    }

    // Check if email already exists
    $query = 'SELECT email FROM Users WHERE email = ?';
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('Registration failed, user already registered'); window.location.href='../view/register.php';</script>";
    } else {
        // Hash the password and insert new user details
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $insert_query = 'INSERT INTO Users (fname, lname, email, password, role) VALUES (?, ?, ?, ?, ?)';
        $stmt = $conn->prepare($insert_query);
        $stmt->bind_param('ssssi', $fname, $lname, $email, $hashed_password, $role);

        if ($stmt->execute()) {
            echo "<script>alert('Registration successful'); window.location.href='../view/login.php';</script>";
        } else {
            echo "<script>alert('Registration failed'); window.location.href='../view/register.php';</script>";
        }
    }

    $stmt->close();
    $conn->close();
}
?>