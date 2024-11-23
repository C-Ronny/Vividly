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
        <div class="search">
            <input type="text" placeholder="Search your Boards...">
        </div>

        <div class="nav-center">
            <a class="nav-a" href="#">Boards</a>
            <a class="nav-a" href="profile.php">Profile</a>
            <a href="profile.php"><img src="../../assets/images/bg1.jpg"></a>
        </div>

    </nav>
    <hr id="nav-rule">

    <!--Boards Section-->
    <div class="categories-section">
        <h2 id="categories">Categories</h2>
        <!--Container for boards-->
        <div class="boards-container">
            <!--Arts board-->
            <a id="art" href="#">
                <div class="category">
                    <h4 class="category-name">Art</h4>
                    <img src="#">
                </div>
            </a>
            <!--Design board-->
            <a id="design" href="#">
                <div class="category">
                    <h4 class="category-name">Design</h4>
                    <img src="#">
                </div>
            </a>
            <!--Fashion board-->
            <a id="fashion" href="#">
                <div class="category">
                    <h4 class="category-name">Fashion</h4>
                    <img src="#">
                </div>
            </a>
            <!--Food board-->
            <a id="food" href="#">
                <div class="category">
                    <h4 class="category-name">Food</h4>
                    <img src="#">
                </div>
            </a>
            <!--Food board-->
            <a id="photography" href="#">
                <div class="category">
                    <h4 class="category-name">Photography</h4>
                    <img src="#">
                </div>
            </a>
            <!--Travel board-->
            <a id="travel" href="#">
                <div class="category">
                    <h4 class="category-name">Travel</h4>
                    <img src="#">
                </div>
            </a>
        </div>
    </div>

    <br><br><br>

    <!--Main page-->
    <main class="main_pins">
        <div class="masonry">
            <div class="item item1"><img src="../../assets/images/Travel/tr1.jpeg"></div>
            <div class="item item2">Item 2</div>
            <div class="item item3">Item 3</div>
            <div class="item item4">Item 4</div>
            <div class="item item5">Item 5</div>
            <div class="item item6">Item 6</div>
            <div class="item item7">Item 7</div>
            <div class="item item8">Item 8</div>
            <div class="item item9">Item 9</div>
            <div class="item item10">Item 10</div>
        </div>
    </main>




    <script src="../src/images_container.js"></script>
</body>

</html>