<?php
include_once "config.php";

if (isset($_POST['submit'])) {
    $fname = mysqli_real_escape_string($mysqli, $_POST['fname']);
    $lname = mysqli_real_escape_string($mysqli, $_POST['lname']);
    $username = mysqli_real_escape_string($mysqli, $_POST['username']);
    $email = mysqli_real_escape_string($mysqli, $_POST['email']);
    $phone = mysqli_real_escape_string($mysqli, $_POST['phone']);
    $lno = mysqli_real_escape_string($mysqli, $_POST['lno']);
    $password = mysqli_real_escape_string($mysqli, $_POST['password']);
    $latitude = mysqli_real_escape_string($mysqli, $_POST['latitude']);
    $longitude = mysqli_real_escape_string($mysqli, $_POST['longitude']);
    $location_name = mysqli_real_escape_string($mysqli, $_POST['location_name']);

    $file = $_FILES['photo'];
    $filename = $file['name'];
    $filepath = $file['tmp_name'];
    $fileerror = $file['error'];

    if ($filename != "") {
        if ($fileerror == 0) {
            $destfile = 'images/driver/' . $filename;
            move_uploaded_file($filepath, $destfile);
        }
    }

    $query = "INSERT INTO pending_drivers(fname, lname, username, email, phone, lno, password, photo, latitude, longitude, location_name)
              VALUES('$fname', '$lname', '$username', '$email', '$phone', '$lno', '$password', '$filename', '$latitude', '$longitude', '$location_name')";

    if (mysqli_query($mysqli, $query)) {
        echo "<script>alert('Signup successful! Please wait for admin approval.');</script>";
    } else {
        echo "<script>alert('Signup failed!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Driver Signup</title>
    <link rel="stylesheet" type="text/css" href="css/admin/signup1.css">
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
</head>
<body>
<div class="main">
    <div class="signup pt-5">
        <form action="" enctype="multipart/form-data" method="POST" name="form1">
            <h1 class="heading">Driver Signup</h1>
            <div class="col-md-12 d-flex flex-wrap">
                <div class="col-md-4 mt-3"><input type="text" name="fname" class="input" placeholder="First name" required></div>
                <div class="col-md-4 mt-3"><input type="text" name="lname" class="input" placeholder="Last name" required></div>
                <div class="col-md-4 mt-3"><input type="text" name="username" class="input" placeholder="Username" required></div>
                <div class="col-md-4 mt-3"><input type="text" name="phone" class="input" placeholder="Phone number" required maxlength="10"></div>
                <div class="col-md-4 mt-3"><input type="email" name="email" class="input" placeholder="Email" required></div>
                <div class="col-md-4 mt-3"><input type="text" name="lno" class="input" placeholder="License number" required></div>
                <div class="col-md-4 mt-3"><input type="password" name="password" class="input" placeholder="Password" required></div>
                <div class="col-md-4 mt-3"><input type="file" name="photo" class="input" required></div>
                <div class="col-md-4 mt-3"><input type="text" name="location_name" class="input" placeholder="Location Name" required></div>

                <div class="col-md-12 mt-3">
                    <label>Select Your Location (click on map)</label>
                    <div id="map" style="height:300px;"></div>
                </div>
                <div class="col-md-6 mt-3"><input type="text" name="latitude" id="latitude" class="input" placeholder="Latitude" readonly required></div>
                <div class="col-md-6 mt-3"><input type="text" name="longitude" id="longitude" class="input" placeholder="Longitude" readonly required></div>
                <div class="col-md-12 mt-3"><input type="submit" name="submit" value="Sign Up" class="btn btn-primary"></div>
            </div>
        </form>
    </div>
</div>

<script>
var map = L.map('map').setView([15.8497, 74.4977], 13); // Default: Belgaum
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: 'Map data © OpenStreetMap contributors'
}).addTo(map);

var marker;
map.on('click', function(e) {
    var lat = e.latlng.lat;
    var lng = e.latlng.lng;
    document.getElementById('latitude').value = lat;
    document.getElementById('longitude').value = lng;

    if (marker) map.removeLayer(marker);
    marker = L.marker([lat, lng]).addTo(map);
});
</script>
</body>
</html>
