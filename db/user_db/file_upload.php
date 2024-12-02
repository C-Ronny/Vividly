<?php
// Include database connection
include('../config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $name = $_POST['name'];
    $category = $_POST['category'];
    
    // Check if file was uploaded
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        // Define upload directory based on the category
        $uploadDir = 'uploads/' . strtolower($category) . '/';
        
        // Create the directory if it doesn't exist
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Get file information
        $fileTmpPath = $_FILES['image']['tmp_name'];
        $fileName = $_FILES['image']['name'];
        $fileSize = $_FILES['image']['size'];
        $fileType = $_FILES['image']['type'];

        // Generate a unique file name to avoid overwriting
        $fileNameParts = pathinfo($fileName);
        $newFileName = uniqid() . '.' . $fileNameParts['extension'];

        // Define the full upload path
        $uploadFilePath = $uploadDir . $newFileName;

        // Move the uploaded file to the desired directory
        if (move_uploaded_file($fileTmpPath, $uploadFilePath)) {
            // Insert the data into the database (pins table)
            $sql = "INSERT INTO pins (name, category, image_path) VALUES (?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$name, $category, $uploadFilePath]);

            echo "File successfully uploaded and record added to the database.";
        } else {
            echo "Error uploading file.";
        }
    } else {
        echo "No file uploaded or file upload error.";
    }
}
?>
