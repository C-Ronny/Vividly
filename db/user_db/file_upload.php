<?php
require_once '../config.php';
require_once '../../util/error_config.php';

session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../view/login.php");  // Redirect to login page if not logged in
    exit;
}

$user_id = $_SESSION['user_id'];  // Get the user ID from the session

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Form fields
    $category = $_POST['category'];
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);

    // File upload handling
    $image = $_FILES['image'];  // Assume the form contains an input with name="image"

    // Check if image is uploaded
    if ($image['error'] == 0) {
        // Get category name (e.g., Art, Food, etc.)
        $category_name = getCategoryName($category);

        // Directory to store the image based on category
        $uploadDir = "../../images/{$category_name}/";  // Save the image in the corresponding category folder
        
        // Create the folder if it doesn't exist
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Generate a unique file name to avoid conflicts
        $fileName = uniqid() . '-' . basename($image['name']);
        $filePath = $uploadDir . $fileName;

        // Move the uploaded file to the desired folder
        if (move_uploaded_file($image['tmp_name'], $filePath)) {
            // Insert the data into the Pins table
            $query = "INSERT INTO Pins (user_id, board_id, image_url, caption, description, category_id) 
                      VALUES (?, ?, ?, ?, ?, ?)";

            // Prepare and execute the query
            if ($stmt = $conn->prepare($query)) {
                // Assuming you have $board_id variable for the user's board
                // For example, you could retrieve this from the session or the POST data
                $board_id = 1;  // Example; adjust to get the actual board ID from the form or session

                // Bind the parameters for the query
                $stmt->bind_param("iisssi", $user_id, $board_id, $filePath, $title, $description, $category);

                // Execute the query
                if ($stmt->execute()) {
                    echo "File uploaded and data inserted successfully.";
                } else {
                    echo "Error: " . $stmt->error;
                }
                $stmt->close();
            } else {
                echo "Error: Unable to prepare the SQL query.";
            }
        } else {
            echo "Error: Failed to move uploaded file.";
        }
    } else {
        echo "Error: File upload error code: " . $image['error'];
    }
}

// Assuming you have a PDO database connection ($pdo)
function getCategoryName($category_id) {
  global $pdo;  // Ensure you're using the global database connection
  $sql = "SELECT name FROM Categories WHERE category_id = ?";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$category_id]);

  // Fetch the result and return the category name
  $category = $stmt->fetch(PDO::FETCH_ASSOC);
  return $category ? $category['name'] : null;  // Return category name or null if not found
}

?>

