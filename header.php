<?php
include_once("auth.php");
include_once("config.php");
$user_id = $_SESSION['user_id'];
$result = mysqli_query($mysqli, "SELECT * FROM user where uid = $user_id ");
$user = mysqli_fetch_assoc($result)
    ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap-5.0.2-dist/css/bootstrap.min.css">

    <link rel="stylesheet" type="text/css" href="css/all.css">
    <title>AutoBird</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
        </script>
</head>
<style>
    .nav-item {
        padding-right: 15px;
    }

    .profile-img {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
        transform: translateY(-10px);
        border: 3px solid orange;
    }
</style>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark" style="z-index: 100">
        <div class="container-fluid">
            <h3 class="text-white" style="font-size: 30px;">Auto<span style="color: orange;">
                    bird</span></h3>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="userhome.php">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Booking
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="userbookings.php">My Bookings</a></li>
                            <li><a class="dropdown-item" href="book1.php">Ride</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="faretable.php">Fares</a>
                    </li>


                    <!-- <li class="nav-item">
                        <a class="nav-link" href="viewgarage.php">Garages</a>
                    </li> -->

                    <li class="nav-item">
                        <a class="nav-link" href="contact.php">Contact</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="about.php">About us</a>
                    </li>
                    <?php

                    if (isset($_SESSION["username"])) { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Logout</a>
                        </li>
                        <?php
                    } else { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="userLogin.php">Logout</a>
                        </li>
                        <?php
                    }
                    ?>


                    <li class="nav-item">
                        <a class="nav-link" href="userprofile.php">
                            <img src="images/user/<?php echo ($user['photo'] != null) ? $user['photo'] : "default.png";
                            ?>" alt="Profile Image" class="profile-img"></a>
                    </li>
                </ul>

            </div>
        </div>
    </nav>