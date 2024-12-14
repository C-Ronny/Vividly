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

$query = "SELECT fname, lname, email, profile_picture FROM Users WHERE user_id = ?";
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
    <title>Vividly | Account Settings</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../../assets/css/account.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script>
        // Show modal when edit profile is clicked
    function openEditModal() {
        document.getElementById('editModal').classList.remove('hidden');
    }

    // Close modal when close button is clicked
    closeButton.addEventListener('click', (e) => {
        e.preventDefault();
        fileDropModal.style.display = 'none';
    });

    // Close modal when clicking outside the modal content
    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
    }

    //Profile picture submission
    function handleProfilePicChange(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('profilePreview').src = e.target.result;
                document.getElementById('modalProfilePreview').src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    }
    </script>
</head>

<body>
    <div class="app-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <h1 class="logo"><a href="landingpage.php">Vividly</a></h1>
            </div>

            <nav class="sidebar-nav">
                <a id="profile" href="account.php" class="nav-item">
                    <i class="fas fa-user"></i>
                    <span >Profile</span>
                </a>
                <a href="boards.php" class="nav-item">
                    <i class="fas fa-th-large"></i>
                    <span>Boards</span>
                </a>
            </nav>

            <div class="sidebar-footer">
                <a href="landingpage.php" class="back-button">
                    <i class="fas fa-arrow-left"></i>
                    <span>Back</span>
                </a>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <h1 id="welcome">Welcome <?= htmlspecialchars($user['fname']) ?> !</h1>
            <p id="welcome-text">View your profile and manage your account settings here.</p>

                <div class="w-full max-w-md bg-gray-800 rounded-2xl shadow-2xl border border-gray-700 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-purple-600 h-24 absolute w-full top-0 left-0 opacity-50"></div>
            
            <div class="relative z-10 p-6">
                <div class="flex items-center space-x-6 mb-6">
                    <div class="relative">
                        <img id="profilePreview" src="/api/placeholder/150/150" alt="Profile" 
                            class="w-32 h-32 rounded-full object-cover border-4 border-white/20 shadow-lg ring-4 ring-blue-500/30">
                        <div class="absolute bottom-0 right-0 bg-blue-600 text-white rounded-full p-2 shadow-lg">
                            <svg src="<?= htmlspecialchars($user['profile_picture']) ?>" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4 5a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V7a2 2 0 00-2-2h-1.586a1 1 0 01-.707-.293l-1.414-1.414A1 1 0 0011.586 3H8.414a1 1 0 00-.707.293L6.293 4.707A1 1 0 015.586 5H4zm6 9a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                    <div>
                        <h2 class="text-3xl font-bold text-white mb-2"><?= htmlspecialchars($user['fname']) ?> <?= htmlspecialchars($user['lname']) ?></h2>
                        <p class="text-blue-200 text-sm"><?= htmlspecialchars($user['email']) ?></p>
                    </div>
                </div>

                <button onclick="openEditModal()" 
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-lg 
                            transition duration-300 ease-in-out transform hover:scale-105 
                            focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                    Edit Profile
                </button>
            </div>
        

        <!-- Edit Modal -->
        <div id="editModal" 
            class="fixed inset-0 bg-black bg-opacity-60 hidden z-50 flex items-center justify-center p-4">
            <div class="bg-gray-800 rounded-2xl w-full max-w-md mx-auto 
                        border border-gray-700 shadow-2xl overflow-hidden 
                        transform transition-all duration-300 scale-95 hover:scale-100">
                <div class="bg-gradient-to-r from-blue-600 to-purple-600 h-1 w-full"></div>
                
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-2xl font-bold text-white">Edit Profile</h3>
                        <button onclick="closeEditModal()" 
                                class="text-gray-400 hover:text-white hover:bg-red-500/20 
                                    rounded-full p-2 transition duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    

                    <form class="space-y-4" method="POST" enctype="multipart/form-data" id="form" action="../../db/user_db/profile_details_fetch.php">
                        <div class="flex flex-col items-center mb-6">
                            <div class="relative">
                                <img id="modalProfilePreview" src="/api/placeholder/150/150" 
                                    alt="Profile" class="w-40 h-40 rounded-full object-cover 
                                    border-4 border-white/20 shadow-lg ring-4 ring-blue-500/30">
                                <label class="absolute bottom-0 right-0 bg-blue-600 text-white 
                                            rounded-full p-3 cursor-pointer shadow-lg hover:bg-blue-700 
                                            transition duration-300">
                                    <input type="file" accept="image/*" class="hidden" name="image" 
                                        onchange="handleProfilePicChange(event)">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </label>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2" id="fname" for="name">First Name</label>
                            <input value="<?= htmlspecialchars($user['fname']) ?>" type="text" name="fname" id="fname" 
                                class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 
                                        text-white focus:outline-none focus:ring-2 focus:ring-blue-500 
                                        transition duration-300" 
                                placeholder="Enter first name">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2"id="lname" for="name">Last Name</label>
                            <input value="<?= htmlspecialchars($user['lname']) ?>" type="text" name="lname" id="lname" 
                                class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 
                                        text-white focus:outline-none focus:ring-2 focus:ring-blue-500 
                                        transition duration-300" 
                                placeholder="Enter last name">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Email</label>
                            <input value="<?= htmlspecialchars($user['email']) ?>" type="email" name="email" id="email" 
                                class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 
                                        text-white focus:outline-none focus:ring-2 focus:ring-blue-500 
                                        transition duration-300" 
                                placeholder="Enter email address">
                        </div>
                        <div class="flex space-x-4 pt-2">
                            <button type="button" onclick="closeEditModal()" 
                                    class="w-full bg-gray-700 hover:bg-gray-600 text-white 
                                        px-4 py-3 rounded-lg transition duration-300 
                                        transform hover:scale-105 focus:outline-none 
                                        focus:ring-2 focus:ring-gray-500">
                                Cancel
                            </button>
                            <button type="submit" 
                                    class="w-full bg-blue-600 hover:bg-blue-700 text-white 
                                        px-4 py-3 rounded-lg transition duration-300 
                                        transform hover:scale-105 focus:outline-none 
                                        focus:ring-2 focus:ring-blue-500">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        </main>
    </div>
    
</body>

</html>