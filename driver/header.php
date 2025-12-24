<?php

include('../config.php');
include 'driver_auth.php';
$driver_id = $_SESSION['driver_id'];

$result = mysqli_query($mysqli, "SELECT * FROM kkdriver where did = $driver_id");
$driver = mysqli_fetch_assoc($result)

    ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome-free-5.15.1-web/fontawesome-free-5.15.1-web/css/all.css">
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
                        <a class="nav-link active" aria-current="page" href="driverhome.php">Home</a>
                    </li>
                    <!-- <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="Booking.php" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Booking
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="rides.php">Rides</a></li>
                            <li><a class="dropdown-item" href="Booking.php">Booking</a></li>
                        </ul>
                    </li> -->
                    <li class="nav-item">
                        <a class="nav-link" href="Booking.php">Booking</a></a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="faretable.php">Fare Table</a></a>
                    </li>


                    <?php if (isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'driver') { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="viewgarage.php">Garages</a>
                    </li>
                    <?php } ?>

                    <li class="nav-item">
                        <a class="nav-link" href="contact.php">Contact</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="about.php">About us</a>
                    </li>
                    <?php

                    if (isset($_SESSION["dUsername"])) { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                    <?php
                    } else { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="driverlogin.php">Logout</a>
                    </li>
                    <?php
                    }
                    ?>
                </ul>
                <li class="nav-item">
                    <a class="nav-link" href="driverprofile.php">
                        <img src="../images/driver/<?php echo ($driver['photo'] != null) ? $driver['photo'] : "default.png";
                        ?>" alt="Profile Image" class="profile-img"></a>
                </li>
            </div>
        </div>
    </nav>