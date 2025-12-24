<?php
include_once("../config.php");

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Fetch driver data
    $res = mysqli_query($mysqli, "SELECT * FROM pending_drivers WHERE id = $id");
    $row = mysqli_fetch_assoc($res);

    if ($row) {
        // Copy to kkdriver table
        $fname = $row['fname'];
        $lname = $row['lname'];
        $username = $row['username'];
        $email = $row['email'];
        $phone = $row['phone'];
        $lno = $row['lno'];
        $password = $row['password'];
        $photo = $row['photo'];
        $latitude = $row['latitude'];
        $longitude = $row['longitude'];
        $location_name = $row['location_name'];

        // Insert into kkdriver (active drivers)
        $insert = mysqli_query($mysqli, "INSERT INTO kkdriver(fname, lname, username, email, phone, lno, password, photo, latitude, longitude, location_name, is_assigned, total_rides)
                VALUES('$fname', '$lname', '$username', '$email', '$phone', '$lno', '$password', '$photo', '$latitude', '$longitude', '$location_name', 0, 0)");

        if ($insert) {
            // Delete from pending
            mysqli_query($mysqli, "DELETE FROM pending_drivers WHERE id = $id");
            echo "<script>alert('Driver approved successfully!');window.location.href='view-pending-drivers.php';</script>";
        } else {
            echo "<script>alert('Failed to add to driver table.');window.location.href='view-pending-drivers.php';</script>";
        }
    } else {
        echo "<script>alert('Driver not found.');window.location.href='view-pending-drivers.php';</script>";
    }
} else {
    echo "<script>alert('Invalid request.');window.location.href='view-pending-drivers.php';</script>";
}
