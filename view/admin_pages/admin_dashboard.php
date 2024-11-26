<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vividly | Dashboard</title>
    <link rel="stylesheet" href="../../assets/css/admin_dashboard.css">
</head>

<body>
    <!-- Nav Bar -->
    <nav id="nav">
        <h2 id="vividly-logo">Vividly</h2>

        <div class="nav-links">
            <!-- <a class="nav-a" href="#">Boards</a> -->
            <a class="nav-a" href="../user_pages/profile.php">Logout</a>
            <a href="#"><img src="../../assets/images/bg1.jpg"></a>
        </div>

    </nav>
    <hr id="nav-rule">

    <main>

        <div class="welcome">
            <h1>Welcome back, user</h1>
            <p>Here's the site overview</p>
        </div>


        <!-- Cards -->
        <section class="container">
            <div class="card">
                <h2>Total No. of Users</h2>
                <p>XX</p>
            </div>
            <div class="card">
                <h2>Total No. of Boards</h2>
                <p>XX</p>
            </div>
            <div class="card" id="images">
                <h2>Total No. of Images</h2>
                <p>XX</p>
            </div>
            <div class="card">
                <h2>Total No. of Users</h2>
                <p>XX</p>
            </div>
            <div class="card">
                <h2>Total No. of Boards</h2>
                <p>XX</p>
            </div>

        </section>

        <!--Tables and images-->
        <section class="other_stats">
            <div class="data_table">
                
                <div class="tbl-header">
                    <table cellpadding="0" cellspacing="0">
                        <thead>
                            <tr>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Date Joined</th>
                                <th>No. of Pins Uploaded</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="tbl-content">
                    <table class="content-table" cellpadding="0" cellspacing="0">
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
                
            </div>
            <div class="data_images">
                <h1 id="title_text">Top 5 liked Content</h1>
            </div>
        </section>


    </main>



    <script src="../../functions/admin_js/users_table.js"></script>
</body>

</html>