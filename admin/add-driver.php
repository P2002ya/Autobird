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
            $destfile = '../images/driver/' . $filename;
            move_uploaded_file($filepath, $destfile);
        }
    }

    $result = "INSERT INTO kkdriver(fname, lname, username, email, phone, lno, password, photo, latitude, longitude, location_name)
               VALUES('$fname', '$lname', '$username', '$email', '$phone', '$lno', '$password', '$filename', '$latitude', '$longitude', '$location_name')";

    $iquery = mysqli_query($mysqli, $result);

    if ($iquery) {
        header("Location: viewdriver.php");
    } else {
        echo "Record cannot be inserted.";
    }
}

include 'admin-header.php';
?>

<link rel="stylesheet" type="text/css" href="../css/admin/signup1.css">

<div class="main">
    <div class="signup pt-5">
        <form action="" enctype="multipart/form-data" method="POST" name="form1" onsubmit="return checkForm(this);">
            <h1 class="heading">Add Driver</h1>
            <div class="col-md-12 d-flex flex-wrap">
                <div class="col-md-4 mt-3">
                    <input type="text" name="fname" class="input" placeholder="First name" required>
                </div>
                <div class="col-md-4 mt-3">
                    <input type="text" name="lname" class="input" placeholder="Last name" required>
                </div>
                <div class="col-md-4 mt-3">
                    <input type="text" name="username" class="input" placeholder="Username" required>
                </div>
                <div class="col-md-4 mt-3">
                    <input type="phone" name="phone" class="input" placeholder="Phone number" required maxlength="10">
                </div>
                <div class="col-md-4 mt-3">
                    <input type="email" name="email" class="input" placeholder="Email" required>
                </div>
                <div class="col-md-4 mt-3">
                    <input type="text" name="lno" class="input" placeholder="License number" required>
                </div>


                <!-- 🌍 Search Location (auto fill lat/lng) -->
                <div class="col-md-8 mt-3">
                    <input type="text" id="location_name" name="location_name" class="input" placeholder="Search Location (e.g. KLE Belgaum)" required>
                </div>


                <div class="col-md-4 mt-3">
                    <input type="text" id="lat" name="latitude" class="input" placeholder="Latitude" required>
                </div>
                <div class="col-md-4 mt-3">
                    <input type="text" id="lon" name="longitude" class="input" placeholder="Longitude" required>
                </div>


                <div class="col-md-4 mt-3">
                    <input type="password" name="password" class="input" placeholder="Password" required>
                </div>
                <div class="col-md-4 mt-3">
                    <input type="password" name="cpassword" class="input" placeholder="Confirm password" required>
                </div>
                <div class="col-md-4 mt-3">
                    <input type="file" name="photo" class="input" required>
                </div>
                <div class="col-md-4 mt-3">
                    <input type="submit" class="form-control-submit" name="submit" value="Add Driver">
                </div>
            </div>
        </form>
    </div>
</div>

<script>
function checkForm(form) {
    if (form.password.value !== form.cpassword.value) {
        alert("❌ Passwords do not match.");
        return false;
    }

    if (!form.latitude.value || !form.longitude.value) {
        alert("📍 Please select a valid location from the dropdown suggestions.");
        return false;
    }

    return true; // All good, allow form submit
}
</script>

<script>
document.getElementById("location_name").addEventListener("input", function () {
    const query = this.value;
    if (query.length < 3) return;

    fetch("https://photon.komoot.io/api/?q=" + encodeURIComponent(query))
        .then(response => response.json())
        .then(data => {
            if (data.features.length > 0) {
                const place = data.features[0];
                const lat = place.geometry.coordinates[1];
                const lon = place.geometry.coordinates[0];

                document.getElementById("lat").value = lat;
                document.getElementById("lon").value = lon;
            }
        });
});
</script>
<script>
let resultsDropdown;

document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("location_name");
    const latInput = document.getElementById("lat");
    const lonInput = document.getElementById("lon");

    resultsDropdown = document.createElement("div");
    resultsDropdown.style.position = "absolute";
    resultsDropdown.style.zIndex = "1000";
    resultsDropdown.style.background = "white";
    resultsDropdown.style.border = "1px solid #ccc";
    resultsDropdown.style.width = searchInput.offsetWidth + "px";
    resultsDropdown.style.display = "none";
    document.body.appendChild(resultsDropdown);

    searchInput.addEventListener("input", function () {
        const query = this.value;
        if (query.length < 3) {
            resultsDropdown.style.display = "none";
            return;
        }

        fetch("https://photon.komoot.io/api/?q=" + encodeURIComponent(query))
            .then(response => response.json())
            .then(data => {
                resultsDropdown.innerHTML = "";
                if (data.features.length > 0) {
                    resultsDropdown.style.display = "block";
                    data.features.forEach(place => {
                        const name = place.properties.name || "";
                        const city = place.properties.city || "";
                        const country = place.properties.country || "";
                        const lat = place.geometry.coordinates[1];
                        const lon = place.geometry.coordinates[0];

                        const option = document.createElement("div");
                        option.textContent = `${name}, ${city}, ${country}`;
                        option.style.padding = "8px";
                        option.style.cursor = "pointer";

                        option.onclick = () => {
                            searchInput.value = `${name}, ${city}, ${country}`;
                            latInput.value = lat;
                            lonInput.value = lon;
                            resultsDropdown.style.display = "none";
                        };

                        resultsDropdown.appendChild(option);
                    });
                    const rect = searchInput.getBoundingClientRect();
                    resultsDropdown.style.top = rect.bottom + window.scrollY + "px";
                    resultsDropdown.style.left = rect.left + "px";
                } else {
                    resultsDropdown.style.display = "none";
                }
            });
    });

    document.addEventListener("click", function (e) {
        if (!resultsDropdown.contains(e.target) && e.target !== searchInput) {
            resultsDropdown.style.display = "none";
        }
    });
});
</script>

</body>
</html>
