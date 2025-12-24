<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <title>Sidebar Dashboard</title>
    <link rel="stylesheet" type="text/css" href="../css/dashboard.css">
    <link rel="stylesheet" type="text/css" href="../css/comman-table.css">
    <link rel="stylesheet" href="../css/all.css">
    <link rel="stylesheet" href="../bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</head>
<style>
.dd-driver:hover .dd-driver-content {
    display: block;
}

.dd-custemer-content,
.dd-driver-content {
    display: none;
    background-color: #00000;
}

.dd-custemer-content a,
.dd-driver-content a {
    padding-left: 60px;
    background-color: black;
}


.dd-custemer:hover .dd-custemer-content {
    display: block;
}
</style>

<body>
    <div class="sidebar">
        <center>
            <img src="../images/LLG.png" class="profile_image" alt="">
        </center>

        <div class="dd-driver">
            <a class="dropbtn text-white" href="viewdriver.php">Drivers</a>
            <!-- <div class="dd-driver-content">
                <a href="viewdriver.php">View Drivers</a>
                <a href="driverregister.php">Add Drivers</a>
            </div> -->
            <a href="view-pending-drivers.php" class="link">Pending Drivers</a>

        </div>

        <div class="dd-custemer">
            <a class="dropbtn text-white">Bookings <i class="fa fa-sort-down"></i></a>
            <div class="dd-custemer-content">
                <a href="ride.php">Ongoing</a>
                <a href="completed-rides.php">History</a>
            </div>
        </div>
        <a href="viewcustomer.php" class="link">Customers</a>
        <a href="viewfares.php" class="link">Fares</a>
        <a href="viewgarages.php" class="link">Garages</a>
        <a href="adminlogout.php">Logout</a>
    </div>
    </div>