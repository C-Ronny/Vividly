<?php
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");  // Redirect to login page if not logged in
    exit;
}

$user_id = $_SESSION['user_id'];  // Access the user_id from the session

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
    
</head>

<body>
    <!-- Nav Bar -->
    <nav id="nav">
        <h2 id="vividly-logo"><a href="../user_pages/landingpage.php">Vividly</a></h2>

        <!--Search bar-->
        <!-- <div class="search">
            <input type="text" placeholder="Search your Boards...">
        </div> -->

        <div class="middle-section">
        <a class="nav-a" href="boardsandpins.php">Boards</a>
        <a class="nav-a" href="profile.php">Profile</a>
        </div>

        <div class="nav-center">
            
            <a class="nav-a" href="../../actions/logout_user.php">Logout</a>
            <a href="profile.php"><img src="../../assets/images/bg1.jpg"></a>
        </div>

    </nav>
    <hr id="nav-rule">

    <!--Boards Section-->
    <div class="categories-section">

    
    
        <!--Container for boards-->
        <div class="boards-container">
            <!--Arts board-->
            <h4 class="category-name"><a>Art</a></h4>
            <h4 class="category-name">Design</h4>
            <h4 class="category-name">Fashion</h4>
            <h4 class="category-name">Food</h4>
            <h4 class="category-name">Photography</h4>
            <h4 class="category-name">Travel</h4>

            <!-- Modal toggle -->
            
            <div class="absolute top-20 right-40 m-4">
                <input class="peer hidden" type="checkbox" id="toggle" />
                <label
                    class="absolute z-10 flex size-[3.2rem] cursor-pointer items-center justify-center rounded-full border bg-black duration-500 peer-checked:rotate-45 peer-checked:bg-red-500"
                    for="toggle"
                >
                    <svg class="fill-white" viewBox="0 0 0.6 0.6" height="20" width="20">
                        <path
                            d="M.325.275H.55v.05H.325V.55h-.05V.325H.05v-.05h.225V.05h.05z"
                            fill-rule="evenodd"
                        ></path>
                    </svg>
                </label>
            </div>

            <!-- Main modal -->
            <div id="crud-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative p-4 w-full max-w-md max-h-full">
                    <!-- Modal content -->
                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                        <!-- Modal header -->
                        <div class="flex items-center justify-center w-full p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white text-center">
                                Add Pin
                            </h3>
                        </div>

                        
                        <!-- Modal Body -->
            <form class="p-4 md:p-5" method="POST" enctype="multipart/form-data" action="../../db/user_db/file_upload.php">
                <div class="grid gap-4 mb-4 grid-cols-2">
                    <div class="col-span-2">
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Title</label>
                        <input type="text" name="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Type product name" required="">
                    </div>                   
                                <div class="col-span-2 sm:col-span-1">
                                    <label for="category" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Category</label>
                                    <select id="category" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                        <option selected="">Select category</option>
                                        <option value="TV">Art</option>
                                        <option value="PC">Design</option>
                                        <option value="GA">Fashion</option>
                                        <option value="PH">Food</option>
                                        <option value="PH">Photography</option>
                                        <option value="PH">Travel</option>
                                    </select>
                                </div>
                                <div class="col-span-2 sm:col-span-1">
                                    <label for="boards" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Board</label>
                                    <select id="boards" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                        <option selected="">Select board</option>
                                        <option value="TV">TV/Monitors</option>
                                        <option value="PC">PC</option>
                                        <option value="GA">Gaming/Console</option>
                                        <option value="PH">Phones</option>
                                    </select>
                                </div>
                                <div class="col-span-2">
                                    <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
                                    <textarea id="description" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Write product description here"></textarea>                    
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
                                <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                                Add Pin
                            </button>
                        </form>

                    </div>
                </div>
            </div> 




            
        </div>
    </div>

    <br><br><br>

    <!--Main page-->
    <main class="main_pins">
        <div class="masonry">
            <div class="item item1"><img src="../../assets/images/Travel/tr1.jpeg"></div>
            <div class="item item2"><img src="../../assets/images/Photography/ph1.jpg"></div>
            <div class="item item3"><img src="../../assets/images/Travel/tr1.jpeg"></div>
            <div class="item item4"><img src="../../assets/images/Photography/ph1.jpg"></div>
            <div class="item item5"><img src="../../assets/images/Travel/tr1.jpeg"></div>
            <div class="item item6"><img src="../../assets/images/Photography/ph1.jpg"></div>
            <div class="item item7"><img src="../../assets/images/Travel/tr1.jpeg"></div>
            <div class="item item8"><img src="../../assets/images/Photography/ph1.jpg"></div>
            <div class="item item9"><img src="../../assets/images/Travel/tr1.jpeg"></div>
            <div class="item item10"><img src="../../assets/images/Photography/ph1.jpg"></div>
            <div class="item item11"><img src="../../assets/images/Travel/tr1.jpeg"></div>
            <div class="item item12"><img src="../../assets/images/Photography/ph1.jpg"></div>
            <div class="item item13"><img src="../../assets/images/Travel/tr1.jpeg"></div>
            <div class="item item14"><img src="../../assets/images/Photography/ph1.jpg"></div>
            <div class="item item15"><img src="../../assets/images/Travel/tr1.jpeg"></div>
            <div class="item item16"><img src="../../assets/images/Photography/ph1.jpg"></div>
            <div class="item item17"><img src="../../assets/images/Travel/tr1.jpeg"></div>
            <div class="item item18"><img src="../../assets/images/Photography/ph1.jpg"></div>
            <div class="item item19"><img src="../../assets/images/Travel/tr1.jpeg"></div>
            <div class="item item20"><img src="../../assets/images/Photography/ph1.jpg"></div>
        </div>
    </main>


    <script src="../../functions/user_js/add_pins_modal.js"></script>    
    

</body>

</html>