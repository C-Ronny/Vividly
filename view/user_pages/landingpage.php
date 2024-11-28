<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vividly</title>
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
        <!--Container for boards-->
        <div class="boards-container">
            <!--Arts board-->
            <h4 class="category-name">Art</h4>
            <h4 class="category-name">Design</h4>
            <h4 class="category-name">Fashion</h4>
            <h4 class="category-name">Food</h4>
            <h4 class="category-name">Photography</h4>
            <h4 class="category-name">Travel</h4>


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




    <script src="../src/images_container.js"></script>
</body>

</html>