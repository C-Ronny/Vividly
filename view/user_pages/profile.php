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
                <div id="profile-photo" class="text-center my-2">
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
                    <div id="edit-profile" class="text-center my-3">
                        <a class="text-xs text-indigo-400 italic hover:underline hover:text-indigo-300 font-medium" href="#">
                        Edit Profile
                        </a>
                    </div>
                </div>
            </div>
        </div>


        <!-- Update Profile Details Modal -->
        <div class="flex items-center justify-center p-3">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Edit your Profile Details
                    </h3>                
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5">
                    <form class="space-y-4"
                    method="PUT" enctype="multipart/form-data" id="form" action="../../db/user_db/profile_details_fetch.php"
                    >
                        <div>
                            <label id="fname" for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">First Name:</label>
                            <input type="text" name="fname" id="fname" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="" />
                        </div>
                        <div>
                            <label id="lname" for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Last Name:</label>
                            <input type="lname" name="lname" id="password" placeholder="" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"/>
                        </div>
                        <div>
                            <label id="email" for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email:</label>
                            <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder=""/>
                        </div>
                        <!-- Image Upload Field -->
                        <div class="col-span-2">
                                                <label for="image" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Upload Image (jpeg/jpg/png)</label>
                                                <input type="file" id="image" name="image" accept="image/*" class="block w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-600 dark:border-gray-500 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" onchange="previewImage(event)" />
                                            </div>

                                            <!-- Image Preview Section -->
                                            <div id="image-preview" class="col-span-2 mt-4">
                                                <!-- Initially hidden image element -->
                                                <img id="preview" src="" alt="Image Preview" class="hidden min-w-full h-auto rounded-lg" />
                                            </div>
                        <button id="close" type="submit" class="flex w-full text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">Cancel</button>
                        <button type="submit" class="flex w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Confirm Changes</button>                   
                        
                    </form>
                </div>
            </div>
        </div>




    </main>

    <script src="../../functions/user_js/profile_updates.js"></script>
    <script src="../../functions/user_js/edit_profile_details.js"></script>




</body>

</html>