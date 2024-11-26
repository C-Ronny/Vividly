<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vividly | Account</title>
    <link rel="stylesheet" href="../../assets/css/profile.css">
</head>

<body>
    <!-- Nav Bar -->
    <nav id="nav">
        <h2 id="vividly-logo"><a href="../user_pages/landingpage.php">Vividly</a></h2>

        <div class="nav-center">
            <a class="nav-a" href="landingpage.php">Home</a>
            <a class="nav-a" href="../user_pages/profile.php">Logout</a>
            <a href="profile.php"><img src="../../assets/images/bg1.jpg"></a>
        </div>

    </nav>
    <hr id="nav-rule">


    <main>
        <section id="personal-info">
            <div id="display-info">
                <a id="id-image" href="profile.php"><img src="../../assets/images/bg1.jpg"></a>
            </div>

            <div id="edit-info">
                <div class="form">
                    <form id="personal-details-edit" action="" method="PUT">
                        <div class="pde-display">
                            <label for="fname" class="form-label">First Name: </label>
                            <input type="text" class="form-control" id="fname" required>
                        </div>
                        <br>
                        <div class="pde-display">
                            <label for="lname" class="form-label">Last Name: </label>
                            <input type="text" class="form-control" id="lname" required>
                        </div>
                        <br>
                        <div class="pde-display">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" required>
                        </div>
                        <br>
                        <div class="pde-display">
                            <label for="file">Upload Profile:</label>
                            <input type="file" id="file" accept="image/png, image/jpeg ">
                        </div>
                        <br>
                        <button type="submit" id="btn">Save Changes</button>
                    </form>
                </div>
                
            </div>

        </section>

        <section id="personal-info-2">
            <!-- Cards -->
            <div id="cards">
                <div class="card">
                    <h2>Total No. of likes</h2>
                    <p>XX</p>
                </div>
                <div class="card">
                    <h2>Total No. of Boards Created</h2>
                    <p>XX</p>
                </div>
                <div class="card" id="images">
                    <h2>Total No. of Images uploaded</h2>
                    <p>XX</p>
                </div>                       
            </div>

            <!-- Pins added section -->
            <div id="pins-info">

            </div>

        </section>





        

    </main>


    <script src="../../functions/user_js/edit_profile_details.js"></script>




</body>

</html>