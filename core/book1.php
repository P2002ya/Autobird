<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include("config.php");
include 'header.php';

if (isset($_GET['reassigned']) && $_GET['reassigned'] == 1) {
    echo "<script>alert('✅ A new driver has been assigned after cancellation');</script>";
}

if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Please login first'); window.location='login.php';</script>";
    exit();
}

$uid = $_SESSION['user_id'];
$msg = "";
$bookingData = [];
$availableDrivers = [];

// Haversine Function Global
function haversine($lat1, $lon1, $lat2, $lon2) {
    $earth_radius = 6371;
    $dLat = deg2rad($lat2 - $lat1);
    $dLon = deg2rad($lon2 - $lon1);
    $a = sin($dLat / 2) * sin($dLat / 2) +
        cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
        sin($dLon / 2) * sin($dLon / 2);
    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
    return $earth_radius * $c;
}


// ✅ Check if user has latest booking (booked or pending)
$query = "SELECT * FROM booking 
          WHERE uid = '$uid' AND (status = 'booked' OR status = 'pending')
          ORDER BY bid DESC LIMIT 1";
$booking = mysqli_query($mysqli, $query);

if ($booking && mysqli_num_rows($booking) > 0) {
    $bookingData = mysqli_fetch_assoc($booking);

    


    // 🔁 Reassign if driver is NULL (pending)
    if ($bookingData['status'] == 'pending' || empty($bookingData['driverId'])) {
        echo "<div style='background:orange;padding:10px;margin:10px 0;'>🚫 Driver Cancelled. Reassigning New Driver...</div>";
    // ✅ Driver reassigned, redirect to refresh page cleanly
    // header("Location: book1.php?reassigned=1);
    // exit;
        // Fetch available drivers
        $driverResult = mysqli_query($mysqli, "SELECT * FROM kkdriver WHERE is_assigned = 0");
        $candidates = [];

        while ($driver = mysqli_fetch_assoc($driverResult)) {
            $distance = haversine($bookingData['pickup_lat'], $bookingData['pickup_lng'], $driver['latitude'], $driver['longitude']);
            $driver['distance'] = $distance;
            $candidates[] = $driver;
        }

        if (!empty($candidates)) {
            usort($candidates, function ($a, $b) {
                if (round($a['distance'], 4) != round($b['distance'], 4)) {
                    return $a['distance'] <=> $b['distance'];
                }

                if ($a['total_rides'] != $b['total_rides']) {
                    return $a['total_rides'] <=> $b['total_rides'];
                }

                return strtotime($a['last_assigned']) <=> strtotime($b['last_assigned']);
            });


            $bestDriver = $candidates[0];
            $driverId = $bestDriver['did'];

           // Calculate new ETA and Fare for the new driver
            $distanceKm = $bestDriver['distance'];
            $etaMinutes = ceil(($distanceKm / 25) * 60);
            $rideDistance = haversine($bookingData['pickup_lat'], $bookingData['pickup_lng'], $bookingData['dest_lat'], $bookingData['dest_lng']);
            $rideDistance = round($rideDistance, 2); // ✅ Round
            $baseFare = 15;
            $perKmFare = 5;

            if ($rideDistance <= 1) {
                $fare = $baseFare;
            } else {
                $fare = $baseFare + (($rideDistance - 1) * $perKmFare);
            }
            $fare = round($fare);


            // Update booking with new driver, ETA, and fare
            mysqli_query($mysqli, "UPDATE booking SET driverId = '$driverId', status = 'booked', eta = '$etaMinutes', fare = '$fare', distance = '$rideDistance' WHERE bid = {$bookingData['bid']}");

                        // Fetch updated booking and driver details
            $booking = mysqli_query($mysqli, "SELECT * FROM booking WHERE bid = {$bookingData['bid']}");
            $bookingData = mysqli_fetch_assoc($booking);

            // Get the newly assigned driver info
            $driverResult = mysqli_query($mysqli, "SELECT * FROM kkdriver WHERE did = {$bookingData['driverId']}");
            $driver = mysqli_fetch_assoc($driverResult);

            // Merge driver data with booking
            $bookingData = array_merge($bookingData, $driver);

           // Recalculate ETA from *actual* assigned driver to pickup location
            $driverToPickupDistance = haversine(
                $driver['latitude'],
                $driver['longitude'],
                $bookingData['pickup_lat'],
                $bookingData['pickup_lng']
            );
            $etaMinutes = ceil(($driverToPickupDistance / 25) * 60); // 25 km/h

            // Update in DB
            mysqli_query($mysqli, "UPDATE booking 
                SET eta = '$etaMinutes' 
                WHERE bid = {$bookingData['bid']}");

            // Update in memory
            $bookingData['eta'] = $etaMinutes;  // 👈 And this

            mysqli_query($mysqli, "UPDATE booking 
                SET eta = '$etaMinutes', fare = '$fare', distance = '$rideDistance' 
                WHERE bid = {$bookingData['bid']}");

            ob_clean();
            header("Location: book1.php?reassigned=1"); // ✅ Show popup after redirect
            exit;
                


        } else {
            echo "<div style='background:red;padding:10px;margin:10px 0;color:white;'>❌ No drivers available for reassignment</div>";
        }
    } else {
       $driverResult = mysqli_query($mysqli, "SELECT * FROM kkdriver WHERE did = {$bookingData['driverId']}");
$driver = mysqli_fetch_assoc($driverResult);
$bookingData = array_merge($bookingData, $driver);

// ✅ Recalculate ETA from driver to pickup
$driverToPickup = haversine(
    $driver['latitude'],
    $driver['longitude'],
    $bookingData['pickup_lat'],
    $bookingData['pickup_lng']
);
$eta = ceil(($driverToPickup / 25) * 60);
$bookingData['eta'] = $eta;

// ✅ Recalculate ride distance (pickup → destination)
$rideDistance = haversine(
    $bookingData['pickup_lat'],
    $bookingData['pickup_lng'],
    $bookingData['dest_lat'],
    $bookingData['dest_lng']
);
$rideDistance = round($rideDistance, 2);
$bookingData['distance'] = $rideDistance;

// ✅ Recalculate fare
$baseFare = 15;
$perKmFare = 5;

if ($rideDistance <= 1) {
    $fare = $baseFare;
} else {
    $fare = $baseFare + (($rideDistance - 1) * $perKmFare);
}
$bookingData['fare'] = round($fare);
// ✅ Save changes to database
mysqli_query($mysqli, "UPDATE booking 
    SET eta = '$eta', fare = '{$bookingData['fare']}', distance = '$rideDistance' 
    WHERE bid = {$bookingData['bid']}");

    }
}

 else {
    $driverResult = mysqli_query($mysqli, "SELECT * FROM kkdriver WHERE is_assigned = 0");
    while ($driver = mysqli_fetch_assoc($driverResult)) {
        $availableDrivers[] = $driver;
    }
}

if (isset($_POST['submit'])) {
    $pickup = $_POST['pickup'];
    $pickup_lat = floatval($_POST['pickup_lat']);
    $pickup_lng = floatval($_POST['pickup_lng']);



    $destination = $_POST['destination'];
    $dest_lat = floatval($_POST['dest_lat']);
    $dest_lng = floatval($_POST['dest_lng']);
    // 🚫 Prevent same pickup and drop
    if ($pickup == $destination) {
        echo "<script>alert('Pickup and Drop location cannot be the same'); window.location='book.php';</script>";
        exit(); // Stop the script
    }

    $date = mysqli_real_escape_string($mysqli, $_POST['date']);
    $time = mysqli_real_escape_string($mysqli, $_POST['time']);
    
if (!empty($pickup) && !empty($destination) && !empty($date) && !empty($time) && !empty($pickup_lat) && !empty($pickup_lng) && !empty($dest_lat) && !empty($dest_lng)) {

    $driverResult = mysqli_query($mysqli, "SELECT * FROM kkdriver WHERE is_assigned = 0");
    $candidates = [];

    while ($driver = mysqli_fetch_assoc($driverResult)) {
    $distance = round(haversine($pickup_lat, $pickup_lng, $driver['latitude'], $driver['longitude']), 4);
    $driver['distance'] = $distance;
    $candidates[] = $driver;

    echo "<div style='color:yellow; font-weight:bold;'>🛺 {$driver['fname']} is " . round($distance, 2) . " km away</div>";
    }


            if (!empty($candidates)) {
                // ✅ Sort by: distance ASC, total_rides ASC. last_assigned ASC,
                usort($candidates, function ($a, $b) {
                if (round($a['distance'], 4) != round($b['distance'], 4)) {
                    return $a['distance'] <=> $b['distance'];
                }

                if ($a['total_rides'] != $b['total_rides']) {
                    return $a['total_rides'] <=> $b['total_rides'];
                }

                return strtotime($a['last_assigned']) <=> strtotime($b['last_assigned']);
            });

                $bestDriver = $candidates[0];
            }

                    // 👉 DEBUG: Show all drivers and distances
            echo "<div style='margin-top:10px; padding:10px; background:#111; color:#fff; border-radius:10px;'>";
            echo "<h4>📍 Nearby Drivers and Distances:</h4>";
            foreach ($candidates as $d) {
                echo "🛺 <b>{$d['fname']} {$d['lname']}</b> – " . round($d['distance'], 2) . " km<br>";
            }
            echo "<hr style='border-color:gray'>";
            echo "✅ <b>Selected:</b> {$bestDriver['fname']} {$bestDriver['lname']} – " . round($bestDriver['distance'], 2) . " km";
            echo "</div>";


        // echo "<div style='color:lime; font-weight:bold;'>✅ Selected: {$bestDriver['fname']} – " . round($bestDriver['distance'], 2) . " km away</div>";

        $driverId = $bestDriver['did'];

        // ETA calculation (simple logic)
        $eta = ceil(($bestDriver['distance'] / 25) * 60); // speed ~25km/hr
                // Calculate Fare based on pickup → destination (not driver)
        $rideDistance = haversine($pickup_lat, $pickup_lng, $dest_lat, $dest_lng);
        $rideDistance = round($rideDistance, 2); // ✅ Round to 2 decimals
        $baseFare = 15;
        $perKmFare = 5;

        if ($rideDistance <= 1) {
            $fare = $baseFare;
        } else {
            $extraKm = $rideDistance - 1;
            $fare = $baseFare + ($extraKm * $perKmFare);
        }
        $fare = round($fare);


        // Save booking
        mysqli_query($mysqli, "INSERT INTO booking(uid, pick, dest, bdate, btime, driverId, status, pickup_lat, pickup_lng, dest_lat, dest_lng, eta, fare, distance)
        VALUES('$uid', '$pickup', '$destination', '$date', '$time', '$driverId', 'booked', '$pickup_lat', '$pickup_lng', '$dest_lat', '$dest_lng', '$eta', '$fare', '$rideDistance')");

        mysqli_query($mysqli, "UPDATE kkdriver SET is_assigned = 1, last_assigned = NOW() WHERE did = $driverId");

        echo "<script>window.location='book1.php';</script>";
        exit;
    } else {
        $msg = "⚠️ No available drivers!";
    }

    } else {
        $msg = "❗ All fields are required!";
    }

    

if (isset($_POST['cancel'])) {
    mysqli_query($mysqli, "UPDATE booking SET status = 'cancelled' WHERE uid = '$uid' AND status = 'booked' LIMIT 1");
    $get_driver = mysqli_query($mysqli, "SELECT driverId FROM booking WHERE uid = '$uid' ORDER BY bid DESC LIMIT 1");
    $driver_row = mysqli_fetch_assoc($get_driver);
    if ($driver_row) {
        $driver_id = $driver_row['driverId'];
        mysqli_query($mysqli, "UPDATE kkdriver SET is_assigned = 0 WHERE did = '$driver_id'");
    }
    echo "<script>window.location='book1.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>AutoBird - Book a Ride</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <!-- <style>
        body { font-family: Arial, sans-serif; background: url("images/bb.JPG") no-repeat center center fixed; background-size: cover; margin: 0; padding: 0; color: #fff; }
        .form-box { background: rgba(0, 0, 0, 0.75); width: 90%; max-width: 400px; margin: 100px auto; padding: 30px; border-radius: 10px; }
        input { width: 100%; padding: 10px; margin-top: 15px; border: none; border-radius: 5px; }
        .btn { background-color: #ff9900; color: white; margin-top: 20px; cursor: pointer; border: none; font-weight: bold; transition: 0.3s ease; }
        .btn:hover { background-color: #e68a00; }
        .cancel-btn { background-color: #e60000; color: white; padding: 10px; margin-top: 15px; font-weight: bold; border: none; border-radius: 5px; width: 100%; cursor: pointer; transition: 0.3s ease; }
        .cancel-btn:hover { background-color: #cc0000; }
        .card { background: white; color: black; width: 90%; max-width: 400px; margin: 30px auto; border-radius: 10px; padding: 20px; text-align: center; }
        .label { font-weight: bold; color: #333; }
        .link { display: block; text-align: center; margin-top: 10px; font-weight: bold; color: cyan; text-decoration: none; }
        /* #map { height: 400px; margin-top: 15px; } */
        #map {
        width: 100%;
        height: 500px;
        margin-top: 15px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.4);
    }
        /* @media (max-width: 600px) {
            .form-box, .card { width: 95%; }
            #map { height: 300px; }
        }
        @media (max-width: 400px) {
            .form-box, .card { width: 100%; }
            input, .btn, .cancel-btn { font-size: 14px; }
            #map { height: 250px; }
        } */

    </style> -->
    <style>
    body {
        font-family: Arial, sans-serif;
        background: url("images/bb.JPG") no-repeat center center fixed;
        background-size: cover;
        margin: 0;
        padding: 0;
        color: #fff;
    }
    .form-box, .card {
        background: rgba(0, 0, 0, 0.75);
        width: 90%;
        max-width: 400px;
        margin: 20px auto;
        padding: 20px;
        border-radius: 10px;
    }
    input {
        width: 100%;
        padding: 10px;
        margin-top: 15px;
        border: none;
        border-radius: 5px;
    }
    .btn {
        background-color: #ff9900;
        color: white;
        margin-top: 20px;
        cursor: pointer;
        border: none;
        font-weight: bold;
        transition: 0.3s ease;
        width: 100%;
    }
    .btn:hover {
        background-color: #e68a00;
    }
    .cancel-btn {
        background-color: #e60000;
    }
    .cancel-btn:hover {
        background-color: #cc0000;
    }
    .link {
        display: block;
        text-align: center;
        margin-top: 10px;
        font-weight: bold;
        color: cyan;
        text-decoration: none;
    }
    #map {
        width: 100%;
        height: 500px;
        margin: 20px 0;
        border-radius: 12px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.4);
    }
</style>

</head>
<body>

<?php if (!empty($bookingData)): ?>
<?php
// 1. Get lat/lng from booking data
$pickupLat = $bookingData['pickup_lat'];
$pickupLng = $bookingData['pickup_lng'];
$dropLat = $bookingData['dest_lat'];
$dropLng = $bookingData['dest_lng'];

// 2. Haversine formula function
function haversineDistance($lat1, $lon1, $lat2, $lon2) {
    $earthRadius = 6371; // in kilometers
    $latDelta = deg2rad($lat2 - $lat1);
    $lonDelta = deg2rad($lon2 - $lon1);
    $a = sin($latDelta / 2) * sin($latDelta / 2) +
         cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
         sin($lonDelta / 2) * sin($lonDelta / 2);
    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
    return $earthRadius * $c;
}

// 3. Calculate distance and fare
// Step 2: Set base fare and rate
$baseFare = 15;     // ₹15 for first 1 km
$perKmRate = 5;     // ₹5 per km after first 1 km

$shortestDistance = haversineDistance($pickupLat, $pickupLng, $dropLat, $dropLng);
if ($shortestDistance <= 1) {
    $estimatedFare = 15;
} else {
    $estimatedFare = 15 + (($shortestDistance - 1) * 5);
}
$estimatedFare = round($estimatedFare);
?>


    <div class="card">
    <img src="images/driver/<?= htmlspecialchars($bookingData['driverPhoto'] ?? 'tuktuk.jpg') ?>" alt="Driver Image">
   
    <h3>Your Booking</h3>
    
    <p><span class="label">Pickup:</span> <?= htmlspecialchars($bookingData['pick']) ?></p>
    <p><span class="label">Dropping Point:</span> <?= htmlspecialchars($bookingData['dest']) ?></p>

    <?php
    $pickupDateFormatted = date("d-M-Y", strtotime($bookingData['bdate']));
    $pickupTimeFormatted = date("h:i A", strtotime($bookingData['btime']));
    ?>
    <!-- <p><span class="label">Pickup Date:</span> <?= $pickupDateFormatted ?></p>
    <p><span class="label">Pickup Time:</span> <?= $pickupTimeFormatted ?></p>

    <p><span class="label">Driver:</span> <?= htmlspecialchars($bookingData['fname'] . ' ' . $bookingData['lname']) ?> | <?= htmlspecialchars($bookingData['phone']) ?></p>
    <p>Estimated Arrival: <?= htmlspecialchars($bookingData['eta']) ?> minutes</p>
    <p>Distance:</span> <?= round($bookingData['distance'], 2) ?> km</p>

    <p>Estimated Fare: ₹<?= htmlspecialchars($bookingData['fare']) ?></p>
 -->
    <?php
        // Format date and time
        $pickupDateFormatted = date("d-M-Y", strtotime($bookingData['bdate']));
        $pickupTimeFormatted = date("h:i A", strtotime($bookingData['btime']));

        // Calculate time difference (in minutes)
        $currentTime = new DateTime();
        $pickupDateTime = new DateTime($bookingData['bdate'] . ' ' . $bookingData['btime']);
        $diffInMinutes = ($pickupDateTime->getTimestamp() - $currentTime->getTimestamp()) / 60;
        ?>

        <p><span class="label">Pickup Date:</span> <?= $pickupDateFormatted ?></p>
        <p><span class="label">Pickup Time:</span> <?= $pickupTimeFormatted ?></p>

        <p><span class="label">Driver:</span> <?= htmlspecialchars($bookingData['fname'] . ' ' . $bookingData['lname']) ?> | <?= htmlspecialchars($bookingData['phone']) ?></p>

        <?php if ($diffInMinutes <= 15): ?>
            <?php if ((float)$bookingData['eta'] == 0): ?>
                <p><strong>Estimated Arrival:</strong> Driver has arrived</p>
            <?php else: ?>
                <p><strong>Estimated Arrival:</strong> <?= htmlspecialchars($bookingData['eta']) ?> minutes</p>
            <?php endif; ?>
            <p><strong>Driver Distance:</strong> <?= round($bookingData['distance'], 2) ?> km</p>
        <?php else: ?>
            <p><strong>Scheduled Ride:</strong> Driver will arrive near your pickup time.</p>
        <?php endif; ?>

        <p><strong>Estimated Fare:</strong> ₹<?= htmlspecialchars($bookingData['fare']) ?></p>


        <form method="post" onsubmit="return confirm('Cancel this booking?');">
            <input type="submit" name="cancel" value="Cancel Booking" class="cancel-btn">
        </form>
        <a class="link" href="userbookings.php">View My Booking History</a>

        <div id="map"></div>

        <script>
        // Add this first – colored marker styles
        var redIcon = new L.Icon({
            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-red.png',
            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/images/marker-shadow.png',
            iconSize: [25, 41], iconAnchor: [12, 41], popupAnchor: [1, -34], shadowSize: [41, 41]
        });

       var autoRickshawIcon = new L.Icon({
            iconUrl: 'https://cdn-icons-png.flaticon.com/512/3448/3448612.png',
            iconSize: [38, 38],
            iconAnchor: [19, 38],
            popupAnchor: [0, -38],
        });



        var greenIcon = new L.Icon({
            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-green.png',
            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/images/marker-shadow.png',
            iconSize: [25, 41], iconAnchor: [12, 41], popupAnchor: [1, -34], shadowSize: [41, 41]
        });

            
       var map = L.map('map').setView([<?= $bookingData['pickup_lat'] ?>, <?= $bookingData['pickup_lng'] ?>], 14);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        // 🔴 Pickup – RED
        var pickupMarker = L.marker([<?= $bookingData['pickup_lat'] ?>, <?= $bookingData['pickup_lng'] ?>], { icon: redIcon })
            .addTo(map)
            .bindPopup("Pickup: <?= addslashes($bookingData['pick']) ?>");

        
       // 🛺 Driver – Auto Rickshaw Icon
        var driverMarker = L.marker([<?= $bookingData['latitude'] ?>, <?= $bookingData['longitude'] ?>], { icon: autoRickshawIcon })
            .addTo(map)
            .bindPopup("Driver: <?= addslashes($bookingData['fname'] . ' ' . $bookingData['lname']) ?>");


        // 🟢 Destination – GREEN
        var destinationMarker = L.marker([<?= $bookingData['dest_lat'] ?>, <?= $bookingData['dest_lng'] ?>], { icon: greenIcon })
            .addTo(map)
            .bindPopup("Destination: <?= addslashes($bookingData['dest']) ?>");

        // Fit map to all markers
        var group = new L.featureGroup([pickupMarker, driverMarker, destinationMarker]);
        map.fitBounds(group.getBounds());



        </script>
        <!-- <script>
        // Red icon for pickup
        var redIcon = new L.Icon({
            iconUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/images/marker-icon-red.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
        });

        // Default blue for driver (or custom rickshaw icon if you want)
        var map = L.map('map');
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

        // Pickup marker with user's name
        var pickupMarker = L.marker([<?= $bookingData['pickup_lat'] ?>, <?= $bookingData['pickup_lng'] ?>], { icon: redIcon })
            .addTo(map)
            .bindPopup("Pickup: <?= addslashes($bookingData['pick']) ?><br>User: <?= addslashes($_SESSION['username']) ?>")
            .openPopup();

        // Driver marker
        var driverMarker = L.marker([<?= $bookingData['latitude'] ?>, <?= $bookingData['longitude'] ?>])
            .addTo(map)
            .bindPopup("Driver: <?= addslashes($bookingData['fname'] . ' ' . $bookingData['lname']) ?><br>Location: <?= addslashes($bookingData['location_name'] ?? '-') ?>");

        // (Optional) Destination marker in green color
        var greenIcon = new L.Icon({
            iconUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/images/marker-icon-green.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
        });
        <?php if (!empty($bookingData['dest'])): ?>
        L.marker([<?= $bookingData['pickup_lat'] + 0.002 ?>, <?= $bookingData['pickup_lng'] + 0.002 ?>], { icon: greenIcon })
            .addTo(map)
            .bindPopup("Dropping: <?= addslashes($bookingData['dest']) ?>");
        <?php endif; ?>

        var group = new L.featureGroup([pickupMarker, driverMarker]);
        map.fitBounds(group.getBounds()); 
        </script> -->

    </div>

            <?php else: ?>
                <div class="form-box">
                    <h2>Book a Ride</h2>
                    <form method="post" onsubmit="return checkFormBeforeSubmit();">
                        <!-- Pickup Location with Autocomplete -->
            <div class="mb-3">
            <label for="pickup">Pickup Location:</label>
            <input type="text" id="pickup" class="form-control" placeholder="Type pickup location..." required>
            <input type="hidden" name="pickup" id="pickup-hidden">
            <input type="hidden" name="pickup_lat" id="pickup-lat">
            <input type="hidden" name="pickup_lng" id="pickup-lng">
            <div id="pickup-suggestions" class="list-group mt-1"></div>
            </div>

            <!-- Destination Location with Autocomplete -->
            <div class="mb-3">
            <label for="destination">Destination:</label>
            <input type="text" id="destination" class="form-control" placeholder="Type destination..." required>
            <input type="hidden" name="destination" id="destination-hidden">
            <input type="hidden" name="dest_lat" id="destination-lat">
            <input type="hidden" name="dest_lng" id="destination-lng">
            <div id="destination-suggestions" class="list-group mt-1"></div>
            </div>

            <input type="date" name="date" required>
            <input type="time" name="time" required>
            
            <input type="submit" name="submit" value="Book Now" class="btn">
        </form>
        <?php if (!empty($msg)): ?>
            <p style="color: cyan; font-weight: bold; margin-top: 20px;"><?= $msg ?></p>
        <?php endif; ?>
        <a class="link" href="userbookings.php">View My Booking History</a>

        <div id="map"></div>

        <script>
        var map = L.map('map').setView([15.85, 74.5], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

        

        <?php
            $adjust = 0.00005;  // Tiny shift value
            $count = 0;
            if (!empty($availableDrivers)) {
                foreach ($availableDrivers as $driver) {
                    $shiftedLat = $driver['latitude'] + ($count * $adjust);
                    $shiftedLng = $driver['longitude'] + ($count * $adjust);
            ?>
                    L.marker([<?= $shiftedLat ?>, <?= $shiftedLng ?>])
                        .addTo(map)
                        .bindPopup("Driver: <?= addslashes($driver['fname'] . ' ' . $driver['lname']) ?><br>Location: <?= addslashes($driver['location_name']) ?>");
            <?php
                    $count++;
                }
            }
            ?>

        </script>
    </div>
<?php endif; ?>

<script>
function setupSearch(inputId, hiddenNameId, latId, lngId, suggestionsId) {
  const input = document.getElementById(inputId);
  const hiddenInput = document.getElementById(hiddenNameId);
  const latInput = document.getElementById(latId);
  const lngInput = document.getElementById(lngId);
  const suggestionsBox = document.getElementById(suggestionsId);

  input.addEventListener('input', function () {
    const query = input.value;
    if (query.length < 3) return;

    fetch(`https://photon.komoot.io/api/?q=${query}&limit=5`)
      .then(response => response.json())
      .then(data => {
        suggestionsBox.innerHTML = '';
        data.features.forEach(feature => {
          const name = feature.properties.name;
          const city = feature.properties.city || '';
          const state = feature.properties.state || '';
          const lat = feature.geometry.coordinates[1];
          const lon = feature.geometry.coordinates[0];
          const full = `${name}, ${city}, ${state}`;

          const item = document.createElement('div');
          item.classList.add('list-group-item', 'list-group-item-action');
          item.textContent = full;

          item.addEventListener('click', function () {
            input.value = full;
            hiddenInput.value = full;
            latInput.value = lat;
            lngInput.value = lon;
            suggestionsBox.innerHTML = '';
          });

          suggestionsBox.appendChild(item);
        });
      });
  });
}

setupSearch('pickup', 'pickup-hidden', 'pickup-lat', 'pickup-lng', 'pickup-suggestions');
setupSearch('destination', 'destination-hidden', 'destination-lat', 'destination-lng', 'destination-suggestions');
</script>
<!-- <?php include 'footer.php'; ?> -->
<script>
function checkFormBeforeSubmit() {
    const pickup = document.getElementById('pickup').value.trim().toLowerCase();
    const destination = document.getElementById('destination').value.trim().toLowerCase();

    if (pickup === destination) {
        alert("Pickup and Destination cannot be the same.");
        return false;
    }
    return true;
}
</script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const dateInput = document.querySelector('input[name="date"]');
    const timeInput = document.querySelector('input[name="time"]');

    // Step 1: Set min date = today
    const today = new Date().toISOString().split("T")[0];
    dateInput.setAttribute("min", today);

    // Step 2: When date changes, check if time should be restricted
    dateInput.addEventListener("change", function () {
        const selectedDate = new Date(dateInput.value);
        const now = new Date();

        if (selectedDate.toDateString() === now.toDateString()) {
            // Same day, set min time to current time
            let hours = now.getHours().toString().padStart(2, "0");
            let minutes = now.getMinutes().toString().padStart(2, "0");
            let minTime = `${hours}:${minutes}`;
            timeInput.min = minTime;
        } else {
            // Future date, allow any time
            timeInput.removeAttribute("min");
        }
    });
});
</script>
</body>
</html>

