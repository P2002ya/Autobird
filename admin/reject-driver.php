<?php
include_once("../config.php");

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Delete driver
    $delete = mysqli_query($mysqli, "DELETE FROM pending_drivers WHERE id = $id");

    if ($delete) {
        echo "<script>alert('Driver rejected and removed.');window.location.href='view-pending-drivers.php';</script>";
    } else {
        echo "<script>alert('Failed to delete driver.');window.location.href='view-pending-drivers.php';</script>";
    }
} else {
    echo "<script>alert('Invalid request.');window.location.href='view-pending-drivers.php';</script>";
}
