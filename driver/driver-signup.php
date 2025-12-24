<?php
include_once "../config.php";

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
            $destfile = '../images/driver/' . $filename;
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
    <link rel="stylesheet" href="../bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
    <style>
        body {
            background: #f0f0f0;
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 950px;
            margin: 40px auto;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 25px;
        }

        .form-control, .form-select {
            margin-bottom: 15px;
        }

        #suggestions {
            list-style: none;
            padding-left: 0;
            background: white;
            max-height: 200px;
            overflow-y: auto;
            border: 1px solid #ccc;
            position: absolute;
            width: 100%;
            z-index: 1000;
        }

        #suggestions li {
            padding: 6px 10px;
            cursor: pointer;
        }

        #suggestions li:hover {
            background-color: #f0f0f0;
        }

        #map {
            height: 300px;
            border-radius: 10px;
            margin-top: 15px;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Driver Signup</h1>
    <form method="POST" enctype="multipart/form-data" autocomplete="off">
        <div class="row">
            <div class="col-md-4"><input type="text" name="fname" class="form-control" placeholder="First Name" required></div>
            <div class="col-md-4"><input type="text" name="lname" class="form-control" placeholder="Last Name" required></div>
            <div class="col-md-4"><input type="text" name="username" class="form-control" placeholder="Username" required></div>

            <div class="col-md-4">
            <input type="tel" name="phone" class="form-control" placeholder="Phone Number" maxlength="10"
            pattern="[0-9]{10}" title="Enter 10 digit number" required
            oninput="this.value=this.value.replace(/[^0-9]/g,'');">
            </div>

            <div class="col-md-4"><input type="email" name="email" class="form-control" placeholder="Email" required></div>
            <div class="col-md-4"><input type="text" name="lno" class="form-control" placeholder="License Number" required></div>

            <div class="col-md-4"><input type="password" name="password" class="form-control" placeholder="Password" required></div>
            <div class="col-md-4"><input type="file" name="photo" class="form-control" required></div>

            <div class="col-md-4 position-relative">
                <input type="text" name="location_name" id="location_name" class="form-control" placeholder="Search Location" required>
                <ul id="suggestions"></ul>
            </div>

            <div class="col-md-6">
                <input type="text" name="latitude" id="latitude" class="form-control" placeholder="Latitude" readonly required>
            </div>
            <div class="col-md-6">
                <input type="text" name="longitude" id="longitude" class="form-control" placeholder="Longitude" readonly required>
            </div>

            <div class="col-md-12">
                <div id="map"></div>
            </div>

            <div class="col-md-12 text-center mt-4">
                <input type="submit" name="submit" class="btn btn-primary" value="Sign Up">
            </div>
        </div>
    </form>
</div>

<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
<script>
var map = L.map('map').setView([15.8497, 74.4977], 13);
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

<script>
const input = document.getElementById("location_name");
const suggestionBox = document.getElementById("suggestions");

input.addEventListener("input", function () {
    let query = input.value.trim();
    if (query.length < 3) {
        suggestionBox.innerHTML = "";
        return;
    }
    fetch(`https://photon.komoot.io/api/?q=${query}&limit=5`)
        .then(res => res.json())
        .then(data => {
            suggestionBox.innerHTML = "";
            data.features.forEach(feature => {
                let li = document.createElement("li");
                li.textContent = feature.properties.name + ", " + (feature.properties.city || "") + ", " + (feature.properties.state || "");
                li.onclick = () => {
                    input.value = li.textContent;
                    document.getElementById("latitude").value = feature.geometry.coordinates[1];
                    document.getElementById("longitude").value = feature.geometry.coordinates[0];
                    suggestionBox.innerHTML = "";

                    if (marker) map.removeLayer(marker);
                    marker = L.marker([feature.geometry.coordinates[1], feature.geometry.coordinates[0]]).addTo(map);
                    map.setView([feature.geometry.coordinates[1], feature.geometry.coordinates[0]], 15);
                };
                suggestionBox.appendChild(li);
            });
        });
});
</script>

</body>
</html>
