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
        <!-- component -->
        <div class="relative h-screen w-full">
            <div class="absolute top-20 left-20 max-w-xs">
                <div class="bg-white shadow-xl rounded-lg py-3">
                    <div class="photo-wrapper p-2">
                        <img class="w-32 h-32 rounded-full mx-auto" src="../../assets/images/bg1.jpg" alt="John Doe">
                    </div>

                    <div class="p-2">            
                        <table class="text-xs my-3">
                            <tbody>
                                <tr>
                                    <td class="px-2 py-2 text-gray-500 font-semibold">First Name:</td>
                                    <td class="px-2 py-2 text-gray-500">John</td> 
                                </tr>
                                <tr>
                                    <td class="px-2 py-2 text-gray-500 font-semibold font-medium">Last Name:</td>
                                    <td class="px-2 py-2 text-gray-500">Doe</td> 
                                </tr>
                                <tr>
                                    <td class="px-2 py-2 text-gray-500 font-semibold">Email:</td>
                                    <td class="px-2 py-2 text-gray-500">john@exmaple.com</td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="text-center my-3">
                            <a class="text-xs text-indigo-500 italic hover:underline hover:text-indigo-600 font-medium" href="#">Edit Profile</a>
                        </div>

                    </div>
                </div>
            </div>
        </div>


    </main>


    <script src="../../functions/user_js/edit_profile_details.js"></script>




</body>

</html>