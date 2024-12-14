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
if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $fname = trim($_POST['fname']);
    $lname = trim($_POST['lname']);
    $email = trim($_POST['email']);
    $profile_photo = $_FILES['image'];  // Take the image file with name="image"

    
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $uploadDir = "../../assets/images/Profile_Photos/";

        // Generate a unique file name to avoid conflicts
        $fileName = $_FILES['image']['name'];
        $filePath = $uploadDir . $fileName;

        
        if (move_uploaded_file($profile_photo['tmp_name'], $filePath)) {
            // Prepare update query
            $update_query = "UPDATE Users SET fname = ?, lname = ?, email = ?, profile_picture = ? WHERE user_id = ?";

            if ($update_stmt = $conn->prepare($update_query)) {
                $update_stmt->bind_param('ssssi', $fname, $lname, $email, $filePath, $user_id);

                if ($update_stmt->execute()) {
                    // Update successful
                    echo json_encode(['success' => true, 'message' => 'Profile updated successfully']);
                    header("Location: ../../view/user_pages/account.php");  // Take back to landing page
                } else {
                    // Update failed
                    echo json_encode(['success' => false, 'error' => $update_stmt->error]);
                }
                // Close the prepared statement
                $update_stmt->close();
            } else {
                // Error preparing the statement
                echo "Error preparing the SQL statement: " . $conn->error;
            }   
        } else {
            echo json_encode(['success' => false, 'error' => 'No image uploaded']);
        }

        exit();
    } else {
        echo json_encode(['success' => false]);
    }
}
?>