<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");  // Redirect to login page if not logged in
    exit;
}

$user_id = $_SESSION['user_id'];  // Get the user ID from the session

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Form fields
    $name = $_POST['name'];
    $category = $_POST['category'];
    $caption = $_POST['caption'];  // Add a caption field if needed
    $description = $_POST['description'];  // Add description field if needed

    // File upload handling
    $image = $_FILES['image'];  // Assume the form contains an input with name="image"

    // Check if image is uploaded
    if ($image['error'] == 0) {
        $category_name = getCategoryName($category);  // Get category name (Art, Food, etc.)
        $uploadDir = "../../uploads/{$category_name}/";  // Save the image in the corresponding category folder
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);  // Create the folder if it doesn't exist
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
                $stmt->bind_param("iisssi", $user_id, $board_id, $filePath, $caption, $description, $category);
                if ($stmt->execute()) {
                    echo "Image uploaded and data saved successfully.";
                } else {
                    echo "Error: " . $stmt->error;
                }
                $stmt->close();
            }
        } else {
            echo "Failed to upload image.";
        }
    } else {
        echo "Error with file upload.";
    }
}
?>
