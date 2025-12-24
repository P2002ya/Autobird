<?php
include_once("config.php");

$did = (int) $_GET['did']; // Securely cast to int

if (isset($_POST['submit'])) {
    $fname = mysqli_real_escape_string($mysqli, $_POST['fname']);
    $lname = mysqli_real_escape_string($mysqli, $_POST['lname']);
    $email = mysqli_real_escape_string($mysqli, $_POST['email']);
    $username = mysqli_real_escape_string($mysqli, $_POST['username']);
    $phone = mysqli_real_escape_string($mysqli, $_POST['phone']);
    $lno = mysqli_real_escape_string($mysqli, $_POST['lno']);
    $latitude = mysqli_real_escape_string($mysqli, $_POST['latitude']);
    $longitude = mysqli_real_escape_string($mysqli, $_POST['longitude']);
    $location_name = mysqli_real_escape_string($mysqli, $_POST['location_name']);

    $result = mysqli_query($mysqli, "UPDATE kkdriver 
        SET fname='$fname', lname='$lname', email='$email', username='$username', phone='$phone', lno='$lno', 
            latitude='$latitude', longitude='$longitude', location_name='$location_name' 
        WHERE did=$did");

    header("Location: viewdriver.php");
    exit();
}

$result = mysqli_query($mysqli, "SELECT * FROM kkdriver WHERE did=$did");
if ($res = mysqli_fetch_array($result)) {
    $fname = $res['fname'];
    $lname = $res['lname'];
    $email = $res['email'];
    $username = $res['username'];
    $phone = $res['phone'];
    $lno = $res['lno'];
    $latitude = $res['latitude'];
    $longitude = $res['longitude'];
    $location_name = $res['location_name'];
}
include 'admin-header.php';
?>

<link rel="stylesheet" type="text/css" href="../css/admin/signup1.css">

<div class="main">
    <div class="signup pt-5">
        <form action="" method="POST" name="form1" onsubmit="return checkForm(this);">
            <h1 class="heading">Edit Driver</h1>
            <div class="col-md-12 d-flex flex-wrap">
                <div class="col-md-4 mt-3">
                    <label>first name</label><br><input type="text" name="fname" class="input" placeholder="first name"
                        required value="<?php echo $fname; ?>">
                </div>
                <div class="col-md-4 mt-3">
                    <label>last name</label><br><input type="text" name="lname" class="input" placeholder="last name"
                        required value="<?php echo $lname; ?>">
                </div>
                <div class="col-md-4 mt-3">
                    <label>username</label><br><input type="text" name="username" class="input" placeholder="username"
                        required value="<?php echo $username; ?>">
                </div>
                <div class="col-md-4 mt-3">
                    <label>phone</label><br><input type="tel" name="phone" class="input" placeholder="phone number"
                        required value="<?php echo $phone; ?>">
                </div>
                <div class="col-md-4 mt-3">
                    <label> email</label><br><input type="email" name="email" class="input" placeholder="email" required
                        value="<?php echo $email; ?>">
                </div>
                <div class="col-md-4 mt-3">
                    <label> licence number</label><br><input type="text" name="lno" class="input"
                        placeholder="licence number" required value="<?php echo $lno; ?>">
                </div>        

                 <!-- 📍 Location Fields -->
                <div class="col-md-8 mt-3">
                    <label>Search Location</label><br>
                    <input type="text" id="location_name" name="location_name" class="input" placeholder="e.g. KLE Belgaum" required value="<?php echo $location_name; ?>">
                </div>
                <div class="col-md-4 mt-3">
                    <label>Latitude</label><br>
                    <input type="text" id="lat" name="latitude" class="input" required value="<?php echo $latitude; ?>">
                </div>
                <div class="col-md-4 mt-3">
                    <label>Longitude</label><br>
                    <input type="text" id="lon" name="longitude" class="input" required value="<?php echo $longitude; ?>">
                </div>
        
                
                <div class="col-md-4 mt-3">
                    <br><input type="submit" class="form-control-submit" name="submit">
                </div>
            </div>
            <div class="col-md-4">
                <p style="color: white">already registered?<a href="driveradminLogin.php"><u>sign in here.</u></a></p>
            </div>
        </form>
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