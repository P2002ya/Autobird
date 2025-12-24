<?php 
session_start();
include_once("../config.php");

// Check login
if (!isset($_SESSION['driver_id'])) {
    header("Location: ../login.php");
    exit;
}

$driver_id = $_SESSION['driver_id'];
$result = mysqli_query($mysqli, "SELECT * FROM kkdriver WHERE did = $driver_id");
$driver = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>AutoBird – Driver</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../bootstrap-5.0.2-dist/css/bootstrap.min.css">
</head>
<style>
    .nav-item { padding-right: 15px; }
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
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <h3 class="text-white">Auto<span style="color: orange;">bird</span></h3>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarDriver" aria-controls="navbarDriver" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarDriver">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link active" href="driverhome.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="viewgarage.php">Garages</a></li>
                    <li class="nav-item"><a class="nav-link" href="driverbookings.php">Bookings</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
                    <li class="nav-item">
                        <a class="nav-link" href="driverprofile.php">
                            <?php 
                            $photoPath = (!empty($driver['photo']) && file_exists("../images/driver/" . $driver['photo']))
                                ? $driver['photo']
                                : "default.png";
                            ?>
                            <img src="../images/driver/<?php echo $photoPath; ?>" alt="Profile" class="profile-img">
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
