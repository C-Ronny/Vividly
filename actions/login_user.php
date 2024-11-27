<?php
include '../db/config.php';
// Include config files for database connection

include '../util/error_config.php';

// Start session
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['psw']);

    // Check if email and password are not empty
    if (empty($email) || empty($password)) {
        echo "<script>alert('Please fill in all fields'); window.location.href='../view/login.php';</script>";
        exit();
    }

    // Prepare a query to check if the user exists
    $query = 'SELECT user_id, `password`, fname, lname, email, `role` FROM Users WHERE email = ?';
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $results = $stmt->get_result();

    if ($results->num_rows > 0) {
        // Fetch user data from the result set
        $row = $results->fetch_assoc();
        $user_id = $row['user_id'];
        $fname = $row['fname'];
        $lname = $row['lname'];
        $email = $row['email'];
        $userrole = $row['role'];
        $userpass = $row['password'];

        // Verify password
        if (password_verify($password, $userpass)) {
            // Start session and set session variables
            $_SESSION['user_id'] = $user_id;
            $_SESSION['email'] = $email;
            $_SESSION['userrole'] = $userrole;

            // Redirect to appropriate page
            if ($userrole == 1) {
                header('Location: view/dashboard.php');
            } else {
                header('Location: ../view/user_pages/landingpage.php');
            }
            exit();
        } else {
            echo "<script>alert('Invalid login credentials'); window.location.href='../view/login.php';</script>";
        }
    } else {
        echo "<script>alert('User does not exist'); window.location.href='../view/login.php';</script>";
    }

    // Close statement and connection
    $stmt->close();
}
$conn->close();
?>