<?php
require_once '../config.php';  // Include database connection and configuration
require_once '../../util/error_config.php';  // Include error configuration for better debugging

session_start();
$user_id = $_SESSION['user_id'];  // Get the user ID from the session

// Check if the user is logged in
if (!isset($user_id)) {
    header("Location: ../../view/login.php");  // Redirect to login page if not logged in
    exit;
}

function getCategoryId($category)
{
    global $conn;  // Ensure you have access to the database connection

    // Correct query with parameter placeholder
    $query = "SELECT category_id FROM Categories WHERE name = ?";  // Use ? for binding in mysqli
    $stmt = $conn->prepare($query);  // Prepare the statement

    // Bind the category parameter
    $stmt->bind_param('s', $category);  // 's' for string type parameter

    $stmt->execute();  // Execute the statement

    // Fetch the result
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    // Return the category_id or null if not found
    return $row ? $row['category_id'] : null;
}




if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize form inputs
    $category = trim($_POST['category']);
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);

    $category_id = getCategoryId($category); // get the category id

    // File upload handling
    $image = $_FILES['image'];  // Assuming the form contains an input with name="image"

    // Check if image is uploaded without errors
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        // Get the category name from the database
        if ($category) {
            // Define the directory to store the image based on category
            $uploadDir = "../../assets/images/{$category}/";  // Save the image in the corresponding category folder
            echo $uploadDir;
            echo realpath($uploadDir);  // This will output the absolute path to the folder


            // Generate a unique file name to avoid conflicts
            $fileName = $_FILES['image']['name'];
            $filePath = $uploadDir . $fileName;
            $filesize = $_FILES['image']['size'];

            // Move the uploaded file to the desired folder
            if (move_uploaded_file($image['tmp_name'], $filePath)) {
                // Prepare SQL query to insert data into the Pins table
                $query = "INSERT INTO Pins (user_id, board_id, image_url, file_size, caption, description, category_id) VALUES (?, ?, ?, ?, ?, ?)";


                // Write function to dynamically generate board_id_id based on user selection
                
                $board_id = 1; 

                // Prepare and execute the query
                if ($stmt = $conn->prepare($query)) {
                    // Bind parameters: user_id, board_id, image_url, caption, description, category_id
                    $stmt->bind_param("iisisss", $user_id, $board_id, $filePath, $filesize, $title, $description, $category_id);

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
