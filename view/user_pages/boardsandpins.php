<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vividly | Boards & Pins</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../../assets/css/boardsandpins.css">
</head>

<body>
    <!-- Nav Bar -->     
    <nav id="nav">
        <h2 id="vividly-logo"><a href="../user_pages/landingpage.php">Vividly</a></h2>      

        <div class="nav-center">
            <a class="nav-a" href="boardsandpins.php">Boards</a>
            <a class="nav-a" href="profile.php">Profile</a>
            <a class="nav-a" href="../../actions/logout_user.php">Logout</a>
            <a href="profile.php"><img src="../../assets/images/bg1.jpg"></a>
        </div>

    </nav>
    <hr id="nav-rule">

    <main>


        <!-- Create board button -->
        <div class="create-board">

        </div>










    <!--Boards Section-->
        <div class="categories-section">
            <h2 id="categories">Board #1</h2>
            <!--Container for boards-->
            <div class="boards-container">
                
                <div>
                    <img class="images cursor-pointer hover:opacity-90 transition-opacity" 
                        src="../../assets/images/Photography/ph1.jpg"
                        data-pin-id="1"
                        alt="Pin Image">
                </div>            

                <div>
                    <img class="images" src="#">
                </div>

                <div>
                    <img class="images" src="#">
                </div>

                <div>
                    <img class="images" src="#">
                </div>        

                <div>
                    <img class="images" src="#">
                </div>

                <div>
                    <img class="images" src="#">
                </div>

                <div>
                    <img class="images" src="#">
                </div>

                <div>
                    <img class="images" src="#">
                </div>

                <div>
                    <img class="images" src="#">
                </div>

                <div>
                    <img class="images" src="#">
                </div>

                <div>
                    <img class="images" src="#">
                </div>

                <div>
                    <img class="images" src="#">
                </div>

                <div>
                    <img class="images" src="#">
                </div>
            </div>

            <hr id="division">

        </div>

        <div class="categories-section">
            <h2 id="categories">Board #2</h2>
            <!--Container for boards-->
            <div class="boards-container">
                
                <div>
                    <img class="images cursor-pointer hover:opacity-90 transition-opacity" 
                        src="../../assets/images/Photography/ph1.jpg"
                        data-pin-id="1"
                        alt="Pin Image">
                </div>            

                <div>
                    <img class="images" src="#">
                </div>

                <div>
                    <img class="images" src="#">
                </div>

                <div>
                    <img class="images" src="#">
                </div>        

                <div>
                    <img class="images" src="#">
                </div>

                <div>
                    <img class="images" src="#">
                </div>

                <div>
                    <img class="images" src="#">
                </div>

                <div>
                    <img class="images" src="#">
                </div>

                <div>
                    <img class="images" src="#">
                </div>

                <div>
                    <img class="images" src="#">
                </div>

                <div>
                    <img class="images" src="#">
                </div>

                <div>
                    <img class="images" src="#">
                </div>

                <div>
                    <img class="images" src="#">
                </div>
            </div>

            <hr id="division">

        </div>

        <div class="categories-section">
            <h2 id="categories">Board #3</h2>
            <!--Container for boards-->
            <div class="boards-container">
                
                <div>
                    <img class="images cursor-pointer hover:opacity-90 transition-opacity" 
                        src="../../assets/images/Photography/ph1.jpg"
                        data-pin-id="1"
                        alt="Pin Image">
                </div>            

                <div>
                    <img class="images" src="#">
                </div>

                <div>
                    <img class="images" src="#">
                </div>

                <div>
                    <img class="images" src="#">
                </div>        

                <div>
                    <img class="images" src="#">
                </div>

                <div>
                    <img class="images" src="#">
                </div>

                <div>
                    <img class="images" src="#">
                </div>

                <div>
                    <img class="images" src="#">
                </div>

                <div>
                    <img class="images" src="#">
                </div>

                <div>
                    <img class="images" src="#">
                </div>

                <div>
                    <img class="images" src="#">
                </div>

                <div>
                    <img class="images" src="#">
                </div>

                <div>
                    <img class="images" src="#">
                </div>
            </div>

            <hr id="division">

        </div>

    </main>

    <!-- Photo Preview Modal -->
    <div id="photo-modal" class="fixed inset-0 hidden z-50 overflow-y-auto bg-black bg-opacity-75 flex items-center justify-center">
        <div class="relative bg-gray-900 w-full max-w-4xl rounded-lg shadow-xl flex">
            <!-- Left side - Photo -->
            <div class="w-2/3 relative">
                <img id="modal-image" src="" alt="Preview" class="w-full h-full object-contain rounded-l-lg">
            </div>
            
            <!-- Right side - Info & Comments -->
            <div class="w-1/3 bg-white dark:bg-gray-800 p-6 rounded-r-lg flex flex-col">
                <!-- Close button -->
                <button id="close-modal" class="absolute top-4 right-4 text-gray-400 hover:text-gray-500">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <!-- Image info -->
                <div class="mb-4">
                    <h3 id="modal-title" class="text-xl font-bold text-gray-900 dark:text-white"></h3>
                    <p id="modal-description" class="text-gray-600 dark:text-gray-300 mt-2"></p>
                </div>

                <!-- Likes section -->
                <div class="flex items-center gap-3 mb-4">
                    <button id="like-button" class="flex items-center gap-2 text-gray-600 dark:text-gray-300 hover:text-red-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                        <span id="likes-count">0</span>
                    </button>
                </div>

                <!-- Comments section -->
                <div class="flex-1 overflow-y-auto mb-4">
                    <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Comments</h4>
                    <div id="comments-container" class="space-y-4">
                        <!-- Comments will be dynamically inserted here -->
                    </div>
                </div>

                <!-- Comment input -->
                <form id="comment-form" class="mt-auto">
                    <div class="flex gap-2">
                        <input type="text" id="comment-input" class="flex-1 rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white" placeholder="Add a comment...">
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Post</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="../../functions/user_js/photo_modal.js"></script>
</body>

</html>