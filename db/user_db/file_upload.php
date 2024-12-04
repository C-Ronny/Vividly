<?php
require_once '../config.php';  // Include database connection and configuration
require_once '../../util/error_config.php';  // Include error configuration for better debugging

session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../view/login.php");  // Redirect to login page if not logged in
    exit;
}

$user_id = $_SESSION['user_id'];  // Get the user ID from the session

// Function to get category name from the database
function getCategoryName($category_id) {
    global $conn;
    $sql = "SELECT name FROM Categories WHERE category_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $category_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['name'];
    }
    return null;  // Return null if category doesn't exist
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize form inputs
    $category = trim($_POST['category']);
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);

    // File upload handling
    $image = $_FILES['image'];  // Assuming the form contains an input with name="image"

    // Check if image is uploaded without errors
    if ($image['error'] == 0) {
        // Get the category name from the database
        $category_name = getCategoryName($category);

        if ($category_name) {
            // Define the directory to store the image based on category
            $uploadDir = "../../images/{$category_name}/";  // Save the image in the corresponding category folder

            // Create the folder if it doesn't exist
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);  // Set 0777 permissions for testing (for production, use stricter permissions)
            }

            // Generate a unique file name to avoid conflicts
            $fileName = uniqid() . '-' . basename($image['name']);
            $filePath = $uploadDir . $fileName;

            // Move the uploaded file to the desired folder
            if (move_uploaded_file($image['tmp_name'], $filePath)) {
                // Prepare SQL query to insert data into the Pins table
                $query = "INSERT INTO Pins (user_id, board_id, image_url, caption, description, category_id) 
                          VALUES (?, ?, ?, ?, ?, ?)";

                // Assuming the board_id is coming from the form or other session data (adjust as needed)
                $board_id = 1;  // This should be dynamically set, you need to adjust it based on your logic

                // Prepare and execute the query
                if ($stmt = $conn->prepare($query)) {
                    // Bind parameters: user_id, board_id, image_url, caption, description, category_id
                    $stmt->bind_param("iissss", $user_id, $board_id, $filePath, $title, $description, $category_name);

                    // Execute the statement
                    if ($stmt->execute()) {
                        // Successfully inserted the data
                        echo "Data and image uploaded successfully!";
                    } else {
                        // Error executing query
                        echo "Error inserting data into the database: " . $stmt->error;
                    }

                    // Close the prepared statement
                    $stmt->close();
                } else {
                    // Error preparing the statement
                    echo "Error preparing the SQL statement: " . $conn->error;
                }
            } else {
                // Error moving the uploaded file
                echo "Error uploading the image file.";
            }
        } else {
            // Invalid category ID
            echo "Invalid category selected.";
        }
    } else {
        // Error with the uploaded image
        echo "Error with the image upload: " . $image['error'];
    }
}
?>
