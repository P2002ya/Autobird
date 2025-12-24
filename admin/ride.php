<?php
include("../config.php");
include 'admin-header.php';

// Assign driver to booking
if (isset($_POST['submit'])) {
    $driverId = intval($_POST['driverId']);
    $bookingId = intval($_POST['bookingId']);

    $updateBooking = mysqli_query($mysqli, "
        UPDATE booking SET driverId = $driverId WHERE bid = $bookingId
    ");

    if ($updateBooking) {
        mysqli_query($mysqli, "
            UPDATE kkdriver 
            SET is_assigned = 1, last_assigned = NOW(), total_rides = total_rides + 1 
            WHERE did = $driverId
        ");

        header('Location: ride.php');
        exit();
    }
}

// Cancel booking (optional)
if (isset($_POST['cancel'])) {
    $bookingId = intval($_POST['bookingId']);

    $driverQ = mysqli_query($mysqli, "SELECT driverId FROM booking WHERE bid = $bookingId");
    $driverData = mysqli_fetch_assoc($driverQ);
    $driverId = $driverData['driverId'];

    $updateBooking = mysqli_query($mysqli, "
        UPDATE booking SET status = 'cancelled' WHERE bid = $bookingId
    ");

    if ($updateBooking) {
        mysqli_query($mysqli, "
            UPDATE kkdriver SET is_assigned = 0 WHERE did = $driverId
        ");
        header('Location: ride.php');
        exit();
    }
}

$bookings = mysqli_query($mysqli, "
    SELECT booking.*, kkdriver.fname, kkdriver.lname 
    FROM booking 
    LEFT JOIN kkdriver ON booking.driverId = kkdriver.did
    ORDER BY booking.bid DESC
");

$drivers = mysqli_query($mysqli, "
    SELECT * FROM kkdriver 
    WHERE is_assigned = 0 
    ORDER BY total_rides ASC, last_assigned ASC
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin - Ride Assignment</title>
    <link rel="stylesheet" href="../bootstrap-5.0.2-dist/css/bootstrap.min.css">
</head>
<body>
<div class="container my-5">
    <h2 class="text-center mb-4">Booking Detail</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Picking Point</th>
                <th>Dropping Point</th>
                <th>Date</th>
                <th>Time</th>
                <th>Driver</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1; while ($row = mysqli_fetch_assoc($bookings)) { ?>
                <tr>
                    <td><?= $i++ ?></td>
                    <td><?= $row['pick'] ?></td>
                    <td><?= $row['dest'] ?></td>
                    <td><?= $row['bdate'] ?></td>
                    <td><?= date("h:i A", strtotime($row['btime'])) ?></td>
                    <td><?= $row['fname'] . ' ' . $row['lname'] ?></td>
                    <td>
                        <span class="badge bg-<?php 
                            echo ($row['status'] === 'cancelled') ? 'danger' : (($row['status'] === 'booked') ? 'warning text-dark' : 'success'); ?>">
                            <?= ucfirst($row['status']) ?>
                        </span>
                    </td>
                    <td>
                        <form method="post" class="d-flex">
                            <input type="hidden" name="bookingId" value="<?= $row['bid'] ?>">
                            <select name="driverId" class="form-select me-2" required>
                                <option value="">Select Driver</option>
                                <?php
                                mysqli_data_seek($drivers, 0);
                                while ($d = mysqli_fetch_assoc($drivers)) {
                                    echo "<option value='{$d['did']}'>{$d['fname']} {$d['lname']}</option>";
                                }
                                ?>
                            </select>
                            <button type="submit" name="submit" class="btn btn-success btn-sm">Assign</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
</body>
</html>
