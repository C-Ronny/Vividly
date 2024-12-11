<?php
// Include the database configuration
include '../../db/config.php';

// Start the session
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../logIn.php");
    exit();
}

// Fetch user details from the database
$user_id = $_SESSION['user_id'];

$query = "SELECT fname, lname, email FROM Users WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if the user exists
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "User not found.";
    exit();
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vividly | Account</title>
    <link rel="stylesheet" href="../../assets/css/profile.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body>
    <!-- Nav Bar -->
    <nav id="nav">
        <h2 id="vividly-logo"><a href="../user_pages/landingpage.php">Vividly</a></h2>

        <div class="nav-center">
            <a class="nav-a" href="landingpage.php">Home</a>
            <a class="nav-a" href="../../actions/logout_user.php">Logout</a>
            <a href="profile.php"><img src="../../assets/images/bg1.jpg"></a>
        </div>

    </nav>
    <hr id="nav-rule">


    <main>
        <!-- Dark Mode Profile Card -->
        <div class="absolute top-20 left-20 max-w-xs mt-20">
            <div class="bg-gray-800 shadow-xl rounded-lg py-3 text-gray-200">
                <div class="photo-wrapper p-2">
                <img class="w-32 h-32 rounded-full mx-auto" src="../../assets/images/bg1.jpg" alt="Profile Photo">
                </div>
                <div id="profile_photo" class="text-center my-2">
                        <a class="text-xs text-indigo-400 italic hover:underline hover:text-indigo-300 font-medium" href="#">
                        Update Profile Photo
                        </a>
                    </div>
                <div class="p-2">
                    <table class="text-xs my-3 w-full">
                        <tbody>
                        <tr>
                            <td class="px-2 py-2 text-gray-400 font-semibold">First Name:</td>
                            <td class="px-2 py-2 text-gray-300"><?= htmlspecialchars($user['fname']) ?></td>
                        </tr>
                        <tr>
                            <td class="px-2 py-2 text-gray-400 font-semibold">Last Name:</td>
                            <td class="px-2 py-2 text-gray-300"><?= htmlspecialchars($user['lname']) ?></td>
                        </tr>
                        <tr>
                            <td class="px-2 py-2 text-gray-400 font-semibold">Email:</td>
                            <td class="px-2 py-2 text-gray-300"><?= htmlspecialchars($user['email']) ?></td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="text-center my-3">
                        <a class="text-xs text-indigo-400 italic hover:underline hover:text-indigo-300 font-medium" href="#">
                        Edit Profile
                        </a>
                    </div>
                </div>
            </div>
        </div>


        <!-- Update Profile Photo Modal -->
        <div class="bg-gray-100 h-screen flex items-center justify-center p-3">
            <div class="w-full max-w-md p-9 bg-white rounded-lg shadow-lg">
                <h1 class="text-center text-2xl sm:text-2xl font-semibold mb-4 text-gray-800">File Drop and Upload</h1>
                <div class="bg-gray-100 p-8 text-center rounded-lg border-dashed border-2 border-gray-300 hover:border-blue-500 transition duration-300 ease-in-out transform hover:scale-105 hover:shadow-md" id="dropzone">
                    <label for="fileInput" class="cursor-pointer flex flex-col items-center space-y-2">
                        <svg class="w-16 h-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        <span class="text-gray-600">Drag and drop your files here</span>
                        <span class="text-gray-500 text-sm">(or click to select)</span>
                    </label>
                    <input type="file" id="fileInput" class="hidden" multiple>
                </div>
                <button id="close" class="inline-flex w-full justify-center rounded-md bg-red-600 mt-6 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto" type="button">Deactivate</button>
                <div class="mt-6 text-center" id="fileList"></div>
            </div>
        </div>


    </main>

    <script src="../../functions/user_js/profile_updates.js"></script>
    <script src="../../functions/user_js/edit_profile_details.js"></script>




</body>

</html>