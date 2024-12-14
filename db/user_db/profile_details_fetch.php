<?php 
require '../config.php';
require_once '../../util/error_config.php';

session_start();
$user_id = $_SESSION['user_id'];

// Check if user is logged in
if (!isset($user_id)) {
    header("Location: ../../view/login.php");
    exit();
}

// If it's a POST request, update user details
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fname = trim($_POST['fname']);
    $lname = trim($_POST['lname']);
    $email = trim($_POST['email']);
    
    // Initialize query parts
    $updateFields = array();
    $types = '';
    $params = array();

    // Add fields to update only if they are not empty
    if (!empty($fname)) {
        $updateFields[] = "fname = ?";
        $types .= 's';
        $params[] = $fname;
    }
    
    if (!empty($lname)) {
        $updateFields[] = "lname = ?";
        $types .= 's';
        $params[] = $lname;
    }
    
    if (!empty($email)) {
        $updateFields[] = "email = ?";
        $types .= 's';
        $params[] = $email;
    }

    // Handle image upload if present
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $uploadDir = "../../assets/images/Profile_Photos/";
        $fileName = $_FILES['image']['name'];
        $filePath = $uploadDir . $fileName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $filePath)) {
            $updateFields[] = "profile_picture = ?";
            $types .= 's';
            $params[] = $filePath;
        }
    }

    // Only proceed if there are fields to update
    if (!empty($updateFields)) {
        // Add user_id to params array and types
        $types .= 'i';
        $params[] = $user_id;

        // Create the UPDATE query
        $update_query = "UPDATE Users SET " . implode(", ", $updateFields) . " WHERE user_id = ?";

        // Prepare and execute the statement
        if ($update_stmt = $conn->prepare($update_query)) {
            // Create array reference for bind_param
            $bindParams = array($types);
            for ($i = 0; $i < count($params); $i++) {
                $bindParams[] = &$params[$i];
            }
            call_user_func_array(array($update_stmt, 'bind_param'), $bindParams);

            if ($update_stmt->execute()) {
                // Update successful
                echo json_encode(['success' => true, 'message' => 'Profile updated successfully']);
                header("Location: ../../view/user_pages/account.php");
            } else {
                // Update failed
                echo json_encode(['success' => false, 'error' => $update_stmt->error]);
            }
            $update_stmt->close();
        } else {
            // Error preparing the statement
            echo json_encode(['success' => false, 'error' => 'Error preparing the SQL statement: ' . $conn->error]);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'No fields to update']);
    }
    exit();
}
?>