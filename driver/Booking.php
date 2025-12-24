<?php
ob_start(); // <--- Add this
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include 'header.php';
include_once("../config.php");

// 🔐 Ensure driver is logged in
if (!isset($_SESSION['driver_id'])) {
    header("Location: login.php");
    exit();
}
$driver_id = $_SESSION['driver_id'];

// ✅ Cancel and reassign logic
if (isset($_GET['cancel_booking_id'])) {
    $cancelBookingId = $_GET['cancel_booking_id'];

    // Step 1: Get pickup lat/lng AND current driver
    $stmt = $mysqli->prepare("SELECT pickup_lat, pickup_lng, driverId FROM booking WHERE bid = ?");
    $stmt->bind_param("i", $cancelBookingId);
    $stmt->execute();
    $stmt->bind_result($pickup_lat, $pickup_lng, $oldDriverId);

    if ($stmt->fetch()) {
        $stmt->close();

        // Step 2: Cancel booking & REMOVE old driverId
        $stmt = $mysqli->prepare("UPDATE booking SET status='Cancelled', driverId=NULL WHERE bid = ?");
        $stmt->bind_param("i", $cancelBookingId);
        $stmt->execute();

        // Step 3: Free the previous driver
        $stmt = $mysqli->prepare("UPDATE kkdriver SET is_assigned=0 WHERE did = ?");
        $stmt->bind_param("i", $oldDriverId);
        $stmt->execute();

        // Step 4: Find available drivers except old one
        $stmt = $mysqli->prepare("SELECT did, latitude, longitude FROM kkdriver WHERE is_assigned = 0 AND did != ?");
        $stmt->bind_param("i", $oldDriverId);
        $stmt->execute();
        $result = $stmt->get_result();

        $nearestDriver = null;
        $shortestDistance = PHP_FLOAT_MAX;

        while ($row = $result->fetch_assoc()) {
            $driverLat = $row['latitude'];
            $driverLng = $row['longitude'];
            $distance = 6371 * acos(
                cos(deg2rad($pickup_lat)) * cos(deg2rad($driverLat)) * cos(deg2rad($driverLng) - deg2rad($pickup_lng)) +
                sin(deg2rad($pickup_lat)) * sin(deg2rad($driverLat))
            );

            if ($distance < $shortestDistance) {
                $shortestDistance = $distance;
                $nearestDriver = $row;
            }
        }

        if ($nearestDriver) {
            $newDriverId = $nearestDriver['did'];

            // Assign new driver WITHOUT increasing total_rides
            $stmt = $mysqli->prepare("UPDATE booking SET driverId=?, status='booked' WHERE bid=?");
            $stmt->bind_param("ii", $newDriverId, $cancelBookingId);
            $stmt->execute();

            $stmt = $mysqli->prepare("UPDATE kkdriver SET is_assigned=1, last_assigned=NOW() WHERE did=?");
            $stmt->bind_param("i", $newDriverId);
            $stmt->execute();

            echo "<script>alert('✅ Driver reassigned successfully.'); window.location='Booking.php';</script>";
            exit;
        } else {
            // No driver found, booking remains cancelled
            echo "<script>alert('⚠️ No available drivers to reassign.'); window.location='Booking.php';</script>";
            exit;
        }
    }
}

// ✅ Status update logic
if (isset($_GET['status']) && isset($_GET['id'])) {
    $status = $_GET['status'];
    $bookingId = $_GET['id'];

    if ($status === 'onroute') {
        $stmt = $mysqli->prepare("UPDATE booking SET status = 'onroute' WHERE bid = ?");
        $stmt->bind_param("i", $bookingId);
        $stmt->execute();

        echo "<script>alert('🚗 Booking status updated to On Route.'); window.location='Booking.php';</script>";
        exit;
    }

    if ($status === 'dropped') {

    // 1. Update booking status to 'dropped'
    $stmt = $mysqli->prepare("UPDATE booking SET status = 'dropped' WHERE bid = ?");
    $stmt->bind_param("i", $bookingId);
    $stmt->execute();
    $stmt->close();

    // 2. Fetch the assigned driver ID and destination coordinates
    $stmt = $mysqli->prepare("SELECT driverId, dest_lat, dest_lng FROM booking WHERE bid = ?");
    $stmt->bind_param("i", $bookingId);
    $stmt->execute();
    $stmt->bind_result($driverId, $destLat, $destLng);
    
    if ($stmt->fetch()) {
        $stmt->close();  // always close after fetching

        // 3. Check if a driver is assigned
        if (!$driverId) {
            echo "<script>alert('❌ No driver assigned to this booking!'); window.location='Booking.php';</script>";
            exit;
        }

        // 4. Use Nominatim API to convert destination lat/lng to readable address
        $url = "https://nominatim.openstreetmap.org/reverse?format=json&lat=$destLat&lon=$destLng&zoom=18&addressdetails=1";
        $options = [
            "http" => [
                "header" => "User-Agent: AutoBird/1.0\r\n"
            ]
        ];
        $context = stream_context_create($options);
        $response = file_get_contents($url, false, $context);

        // 5. Decode JSON response
        $data = json_decode($response, true);

        if (!isset($data['display_name'])) {
            echo "<script>alert('❌ Failed to get address from coordinates.'); window.location='Booking.php';</script>";
            exit;
        }

        $dest_location_name = $data['display_name'];

        // 6. Update the driver status and location
        $stmt = $mysqli->prepare("UPDATE kkdriver 
            SET 
                is_assigned = 0,
                total_rides = total_rides + 1,
                last_assigned = NOW(),
                latitude = ?, 
                longitude = ?, 
                location_name = ?
            WHERE did = ?");
        
        if ($stmt) {
            $stmt->bind_param("ddsi", $destLat, $destLng, $dest_location_name, $driverId);

            if ($stmt->execute()) {
                echo "<script>alert('✅ Ride dropped and driver location updated.'); window.location='Booking.php';</script>";
            } else {
                echo "<script>alert('❌ Driver update failed: " . $stmt->error . "');</script>";
            }
            $stmt->close();
        } else {
            echo "<script>alert('❌ Prepare error: " . $mysqli->error . "');</script>";
        }
    } else {
        echo "<script>alert('❌ Failed to fetch booking.'); window.location='Booking.php';</script>";
    }
}


}
// ✅ Get active & past bookings
$historyStmt = $mysqli->prepare("SELECT booking.*, user.username, user.photo, user.phone FROM booking LEFT JOIN user ON booking.uid = user.uid WHERE driverId = ? AND booking.status IN ('dropped', 'cancelled') ORDER BY booking.bid ASC");
$historyStmt->bind_param("i", $driver_id);
$historyStmt->execute();
$result = $historyStmt->get_result();

$activeStmt = $mysqli->prepare("SELECT booking.*, user.username, user.photo, user.phone FROM booking LEFT JOIN user ON booking.uid = user.uid WHERE driverId = ? AND booking.status IN ('booked', 'onroute') ORDER BY booking.bid ASC");
$activeStmt->bind_param("i", $driver_id);
$activeStmt->execute();
$bookings = $activeStmt->get_result();
?>

<!-- ✅ Styles -->
<style>
body {
    background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url("images/bb.JPG");
    background-repeat: no-repeat;
    background-size: cover;
}
</style>
<link rel="stylesheet" href="../css/driver/Booking.css">

<!-- ✅ Booking Cards -->
<div class="row m-4">
<?php while ($res = $bookings->fetch_assoc()) { ?>
    <div class="booking-card col-md-4 my-4">
        <div class="card">
            <?php
            $photo = (!empty($res['photo']) && file_exists('../images/user/' . $res['photo'])) ? $res['photo'] : 'default.png';
            ?>
            <img src="../images/user/<?= $photo ?>" class="card-img-top" alt="User Photo">

            <div class="card-body">
                <h5 class="card-title">YOUR BOOKING</h5>

                <div class="d-flex mt-4">
                    <label class="text-secondary me-2">Pickup Point:</label>
                    <p class="card-text"><?= $res['pick'] ?></p>
                </div>

                <div class="d-flex mt-4">
                    <label class="text-secondary me-2">Dropping Point:</label>
                    <p class="card-text"><?= $res['dest'] ?></p>
                </div>

                <div class="d-flex mt-4">
                    <label class="text-secondary me-2">Date:</label>
                    <p class="card-text"><?= $res['bdate'] ?></p>
                </div>

                <div class="d-flex mt-4">
                    <label class="text-secondary me-2">Time:</label>
                    <p class="card-text"><?= date("h:i A", strtotime($res['btime'])) ?></p>
                </div>

                <div class="d-flex mt-4">
                    <label class="text-secondary me-2">User Name:</label>
                    <p class="card-text"><?= $res['username'] ?></p>
                </div>

                <div class="d-flex mt-4">
                    <label class="text-secondary me-2">User Phone:</label>
                    <p class="card-text"><?= $res['phone'] ?></p>
                </div>

                <h3 class="mt-4">
                    <span class="badge <?php
                        if ($res['status'] == 'booked') echo 'bg-warning text-dark';
                        else if ($res['status'] == 'onroute') echo 'bg-primary text-white';
                        else echo 'bg-success text-white';
                    ?>">
                        <?= $res['status'] ?>
                    </span>

                    <?php if ($res['status'] == 'booked') { ?>
                        <a href="Booking.php?status=onroute&id=<?= $res['bid'] ?>">
                            <span class="badge bg-primary text-white">onroute</span>
                        </a>
                    <?php } ?>

                    <?php if ($res['status'] == 'onroute') { ?>
                        <a href="Booking.php?status=dropped&id=<?= $res['bid'] ?>">
                            <span class="badge bg-success text-white">Drop</span>
                        </a>
                    <?php } ?>

                    <a href="Booking.php?cancel_booking_id=<?= $res['bid'] ?>" class="btn btn-danger btn-sm">Cancel</a>
                </h3>
            </div>
        </div>
    </div>
<?php } ?>
</div>

<!-- ✅ Booking History Table -->
<div class="container">
    <div class="tablebox">
        <h1 class="text-center mb-5">Booking History</h1>
        <table class="table table-dark table-striped table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Pickup</th>
                    <th>Drop</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>User</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $slno = 1;
                while ($res = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?= $slno ?></td>
                        <td><?= $res['pick'] ?></td>
                        <td><?= $res['dest'] ?></td>
                        <td><?= $res['bdate'] ?></td>
                        <td><?= date("h:i A", strtotime($res['btime'])) ?></td>
                        <td><?= $res['username'] ?></td>
                        <td><?= $res['status'] ?></td>
                    </tr>
                <?php $slno++; } ?>
            </tbody>
        </table>
    </div>
</div>
