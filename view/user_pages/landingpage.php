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
        <!-- <h2 id="categories">Categories</h2> -->
        

        <!-- Position the toggle at top-right of the body -->
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
    
    
        <!--Container for boards-->
        <div class="boards-container">
            <!--Arts board-->
            <h4 class="category-name">Art</h4>
            <h4 class="category-name">Design</h4>
            <h4 class="category-name">Fashion</h4>
            <h4 class="category-name">Food</h4>
            <h4 class="category-name">Photography</h4>
            <h4 class="category-name">Travel</h4>

<!---------------------------------------------------------------------------------------------------------------------------------------------->



<!-- Modal toggle -->
<button data-modal-target="crud-modal" data-modal-toggle="crud-modal" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
  Toggle modal
</button>

<!-- Main modal -->
<div id="crud-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Create New Product
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="crud-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <form class="p-4 md:p-5">
                <div class="grid gap-4 mb-4 grid-cols-2">
                    <div class="col-span-2">
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                        <input type="text" name="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Type product name" required="">
                    </div>
                    <div class="col-span-2 sm:col-span-1">
                        <label for="price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Price</label>
                        <input type="number" name="price" id="price" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="$2999" required="">
                    </div>
                    <div class="col-span-2 sm:col-span-1">
                        <label for="category" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Category</label>
                        <select id="category" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            <option selected="">Select category</option>
                            <option value="TV">TV/Monitors</option>
                            <option value="PC">PC</option>
                            <option value="GA">Gaming/Console</option>
                            <option value="PH">Phones</option>
                        </select>
                    </div>
                    <div class="col-span-2">
                        <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Product Description</label>
                        <textarea id="description" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Write product description here"></textarea>                    
                    </div>
                </div>
                <button type="submit" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                    Add new product
                </button>
            </form>
        </div>
    </div>
</div> 


<!---------------------------------------------------------------------------------------------------------------------------------------------->

            <!-- <a id="art" href="#">
                <div class="category">
                    <h4 class="category-name">Art</h4>
                    <img src="#">
                </div>
            </a> -->
            <!--Design board-->
            <!-- <a id="design" href="#">
                <div class="category">
                    <h4 class="category-name">Design</h4>
                    <img src="#">
                </div>
            </a> -->
            <!--Fashion board-->
            <!-- <a id="fashion" href="#">
                <div class="category">
                    <h4 class="category-name">Fashion</h4>
                    <img src="#">
                </div>
            </a> -->
            <!--Food board-->
            <!-- <a id="food" href="#">
                <div class="category">
                    <h4 class="category-name">Food</h4>
                    <img src="#">
                </div>
            </a> -->
            <!--Food board-->
            <!-- <a id="photography" href="#">
                <div class="category">
                    <h4 class="category-name">Photography</h4>
                    <img src="#">
                </div>
            </a> -->
            <!--Travel board-->
            <!-- <a id="travel" href="#">
                <div class="category">
                    <h4 class="category-name">Travel</h4>
                    <img src="#">
                </div>
            </a> -->
        </div>
    </div>

    <br><br><br>

    <!--Main page-->
    <main class="main_pins">
        <div class="masonry">
            <div class="item item1"><img src="../../assets/images/Travel/tr1.jpeg"></div>
            <div class="item item2"><img src="../../assets/images/Photography/ph1.jpg"></div>
            <div class="item item3">Item 3</div>
            <div class="item item4">Item 4</div>
            <div class="item item5">Item 5</div>
            <div class="item item6">Item 6</div>
            <div class="item item7">Item 7</div>
            <div class="item item8">Item 8</div>
            <div class="item item9">Item 9</div>
            <div class="item item10">Item 10</div>
            <div class="item item11"><img src="../../assets/images/Travel/tr1.jpeg"></div>
            <div class="item item12"><img src="../../assets/images/Photography/ph1.jpg"></div>
            <div class="item item13">Item 13</div>
            <div class="item item14">Item 14</div>
            <div class="item item15">Item 15</div>
            <div class="item item16">Item 16</div>
            <div class="item item17">Item 17</div>
            <div class="item item18">Item 18</div>
            <div class="item item19">Item 19</div>
            <div class="item item20">Item 20</div>
        </div>
    </main>


    <script src="../../src/modal.js"></script>    
</body>

</html>