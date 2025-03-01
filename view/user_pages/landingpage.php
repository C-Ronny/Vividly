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

// Fetch user's boards
$boards_query = "SELECT board_id, title FROM Boards WHERE user_id = ?";
$boards_stmt = $conn->prepare($boards_query);
$boards_stmt->bind_param("i", $user_id);
$boards_stmt->execute();
$boards_result = $boards_stmt->get_result();
$userBoards = $boards_result->fetch_all(MYSQLI_ASSOC);

$boards_stmt->close();
// Close the statement and connection
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vividly</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../../assets/css/landingpage.css">
    <script src="../../functions/user_js/photo_modal.js" defer></script>
    <script src="../../functions/user_js/images_display.js" defer></script>

</head>

<body>
    <!-- Nav Bar -->
    <nav id="nav">
        <h2 id="vividly-logo"><a href="../user_pages/landingpage.php">Vividly</a></h2>

        <!--Search bar-->
        <!-- <div class="search">
            <input type="text" placeholder="Search your Boards...">
        </div> -->

        <div class="nav-center">
            <a class="nav-a" href="./account.php">Account</a>
            <a class="nav-a" href="../../actions/logout_user.php">Logout</a>
            <a href="account.php"><img src="<?= htmlspecialchars($user['profile_picture']) ?> " class="w-10 h-10 rounded-full object-cover"></a>
        </div>

    </nav>


    <!--Boards Section-->
    <div class="categories-section">



        <!--Container for boards-->
        <div class="boards-container">
            <!--Arts board-->
            <h4 class="category-name"><a href="landingpage.php">All Pins</a></h4>
            <h4 class="category-name"><a href="#" data-category="1" onclick="filterByCategory(1)">Art</a></h4>
            <h4 class="category-name"><a href="#" data-category="2" onclick="filterByCategory(2)">Design</a></h4>
            <h4 class="category-name"><a href="#" data-category="3" onclick="filterByCategory(3)">Fashion</a></h4>
            <h4 class="category-name"><a href="#" data-category="4" onclick="filterByCategory(4)">Food</a></h4>
            <h4 class="category-name"><a href="#" data-category="5" onclick="filterByCategory(5)">Photography</a></h4>
            <h4 class="category-name"><a href="#" data-category="6" onclick="filterByCategory(6)">Travel</a></h4>

            <!-- Modal toggle -->
            <div class="absolute top-20 right-40 m-4">
                <input class="peer hidden" type="checkbox" id="toggle" />
                <label
                    class="absolute z-10 flex size-[3.2rem] cursor-pointer items-center justify-center rounded-full border bg-black duration-500 peer-checked:rotate-45 peer-checked:bg-red-500"
                    for="toggle">
                    <svg class="fill-white" viewBox="0 0 0.6 0.6" height="20" width="20">
                        <path
                            d="M.325.275H.55v.05H.325V.55h-.05V.325H.05v-.05h.225V.05h.05z"
                            fill-rule="evenodd"></path>
                    </svg>
                </label>
            </div>

            <!-- Main modal -->
            <div id="crud-modal" tabindex="-1" aria-hidden="true" class="hidden fixed inset-0 z-50 flex items-center justify-center w-full h-full bg-gray-900 bg-opacity-50" style="overflow-x: hidden; overflow-y:auto;" onclick="handleModalClick(event)">
                <div class="relative p-4 w-full max-w-md max-h-full">
                    <!-- Modal content -->
                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                        <!-- Modal header -->
                        <div class="flex items-center justify-between w-full p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                Add New Pin
                            </h3>
                            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" onclick="closeModal()">
                                <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>
                        <!-- Modal body -->
                        <div class="p-6 space-y-6">
                            <!-- Add your modal content here -->
                            <form class="p-4 md:p-5" method="POST" enctype="multipart/form-data" action="../../db/user_db/file_upload.php">
                                <div class="grid gap-4 mb-4 grid-cols-2">
                                    <div class="col-span-2">
                                        <label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Title</label>
                                        <input type="text" name="title" id="title" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Type product name" required="">
                                    </div>
                                    <div class="col-span-2 sm:col-span-1">
                                        <label for="category" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Category</label>
                                        <select id="category" name="category" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                            <option selected="">Select category</option>
                                            <option value="Art">Art</option>
                                            <option value="Design">Design</option>
                                            <option value="Fashion">Fashion</option>
                                            <option value="Food">Food</option>
                                            <option value="Photography">Photography</option>
                                            <option value="Travel">Travel</option>
                                        </select>
                                    </div>
                                    <div class="col-span-2 sm:col-span-1">
                                        <label for="boards" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Board</label>
                                        <select id="boards" name="board_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
                                            <option value="">Select board</option>
                                            <?php
                                            // Reset the result pointer in case it was used before
                                            if ($boards_result) {
                                                $boards_result->data_seek(0);
                                                while ($board = $boards_result->fetch_assoc()):
                                            ?>
                                                    <option value="<?= htmlspecialchars($board['board_id']) ?>">
                                                        <?= htmlspecialchars($board['title']) ?>
                                                    </option>
                                            <?php
                                                endwhile;
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-span-2">
                                        <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
                                        <textarea id="description" name="description" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Write product description here"></textarea>
                                    </div>


                                    <!-- Image Upload Field -->
                                    <div class="col-span-2">
                                        <label for="image" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Upload Image (jpeg/jpg/png)</label>
                                        <input type="file" id="image" name="image" accept="image/*" class="block w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-600 dark:border-gray-500 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" onchange="previewImage(event)" />
                                    </div>

                                    <!-- Image Preview Section -->
                                    <div id="image-preview" class="col-span-2 mt-4">
                                        <!-- Initially hidden image element -->
                                        <img id="preview" src="" alt="Image Preview" class="hidden max-w-full h-auto rounded-lg" />
                                    </div>
                                </div>
                                <button type="submit" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                    <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    Add Pin
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                function handleModalClick(event) {
                    // Only close if clicking the backdrop (crud-modal) directly
                    if (event.target.id === 'crud-modal') {
                        closeModal();
                    }
                }

                function closeModal() {
                    document.getElementById('toggle').checked = false;
                    document.getElementById('crud-modal').classList.add('hidden');
                }
            </script>


            <script>
                // Close the modal when clicking the "Close" button
                document.getElementById("close-modal").addEventListener("click", () => {
                    toggle.checked = false;
                    modal.classList.add("hidden");
                });
            </script>



        </div>
    </div>

    <br><br><br>

    <!--Main page-->
    <main class="main_pins">
        <div class="masonry">
            <!-- Dynamically filled from user uploads -->
            <section id="extra_space">
            </section>


    </main>


    <script src="../../functions/user_js/add_pins_modal.js"></script>
    <script src="../../functions/user_js/images_display.js"></script>

    <!-- Add this modal HTML before closing body tag -->
    <div id="photo-modal" class="fixed inset-0 hidden z-50 overflow-y-auto bg-black bg-opacity-75 flex items-center justify-center">
        <div class="relative bg-gray-900 w-full max-w-4xl rounded-lg shadow-xl flex">
            <!-- Left side - Photo -->
            <div class="w-2/3 relative">
                <img id="modal-image" src="" alt="Preview" class="w-full h-full object-contain rounded-l-lg">
            </div>

            <!-- Right side - Info & Actions -->
            <div class="w-1/3 bg-white dark:bg-gray-800 p-6 rounded-r-lg flex flex-col">
                <!-- Close button -->
                <button onclick="closePhotoModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-500">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <!-- Image info -->
                <div class="mb-4">
                    <h3 id="modal-title" class="text-xl font-bold text-gray-900 dark:text-white"></h3>
                    <p id="modal-description" class="text-gray-600 dark:text-gray-300 mt-2"></p>
                </div>

                <!-- Like section -->
                <div class="flex items-center space-x-2 mb-4">
                    <button id="like-button" class="flex items-center space-x-1 text-gray-600 hover:text-red-500 transition-colors">
                        <i class="fas fa-heart"></i>
                        <span id="likes-count"></span>
                    </button>
                </div>

                <!-- Add to Board Section -->
                <div class="mb-4">
                    <select id="board-select" class="w-full p-2 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        <option value="">Select a board</option>
                        <?php
                        // Fetch current user's boards
                        $boards_query = "SELECT board_id, title FROM Boards WHERE user_id = ?";
                        $boards_stmt = $conn->prepare($boards_query);
                        $boards_stmt->bind_param("i", $_SESSION['user_id']);
                        $boards_stmt->execute();
                        $boards_result = $boards_stmt->get_result();

                        while ($board = $boards_result->fetch_assoc()) {
                            echo "<option value='" . htmlspecialchars($board['board_id']) . "'>" .
                                htmlspecialchars($board['title']) . "</option>";
                        }
                        ?>
                    </select>
                    <button onclick="addToBoard()" id="add-to-board-btn" class="mt-2 w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Add to Board
                    </button>
                </div>

            </div>
        </div>
    </div>

    <!-- Add this JavaScript before closing body tag -->
    <script>
        let currentPinId = null;

        function openPhotoModal(imageUrl, title, description, pinId) {
            currentPinId = pinId;
            document.getElementById('modal-image').src = imageUrl;
            document.getElementById('modal-title').textContent = title;
            document.getElementById('modal-description').textContent = description;
            document.getElementById('photo-modal').classList.remove('hidden');
        }

        function closePhotoModal() {
            document.getElementById('photo-modal').classList.add('hidden');
            currentPinId = null;
        }

        function addToBoard() {
            const boardId = document.getElementById('board-select').value;
            if (!boardId) {
                alert('Please select a board');
                return;
            }

            fetch('../../db/user_db/add_pin_to_board.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `pin_id=${currentPinId}&board_id=${boardId}`
                })
                .then(response => response.json())
                .then(response => {
                    if (response.status === 'success') {
                        alert('Pin added to board successfully!');
                        closePhotoModal();
                    } else {
                        alert('Error: ' + response.error.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while adding the pin to board');
                });
        }

        // Close modal when clicking outside
        document.getElementById('photo-modal').addEventListener('click', function(e) {
            if (e.target === this) {
                closePhotoModal();
            }
        });
    </script>

</body>

</html>