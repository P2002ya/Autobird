<?php
include_once("../config.php");
include 'admin-header.php';
$result = mysqli_query($mysqli, "SELECT * FROM kkdriver ORDER BY did DESC");
?>

<div class="main pt-5" style="margin-left: 10%;">
    <div class="tablebox">
        <div class="d-flex justify-content-between">
            <h1>Drivers Detail</h1>
            <a class="btn btn-primary" href="add-driver.php" style="height:45px;">Add Drivers</a>
        </div>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>First Name</th>
                    <th>Phone</th>
                    <th>Location</th>
                    <!-- <th>Lat / Lng</th> -->
                    <th>Photo</th>
                    <th>Total Rides</th>
                    <th>Status</th> <!-- NEW -->
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $slno = 1;
                while ($res = mysqli_fetch_array($result)) {
                    echo "<tr>";
                    echo "<td>" . $slno++ . "</td>";
                    echo "<td>" . htmlspecialchars($res['fname']) . " " . htmlspecialchars($res['lname']) . "</td>";
                    echo "<td>" . htmlspecialchars($res['phone']) . "</td>";
                    echo "<td>" . htmlspecialchars($res['location_name']) . "</td>";
                    // echo "<td>" . htmlspecialchars($res['latitude']) . " / " . htmlspecialchars($res['longitude']) . "</td>";
                    echo "<td>" . htmlspecialchars($res['photo']) . "</td>";
                    echo "<td>" . $res['total_rides'] . "</td>";

                    // Check free or busy
                    $status = ($res['is_assigned'] == 0) ? "Available" : "Busy";
                    echo "<td>" . $status . "</td>";

                    echo "<td><a href=\"driveredit.php?did={$res['did']}\">Edit</a> | <a href=\"driverdelete.php?did={$res['did']}\" onClick=\"return confirm('Are you sure you want to delete?')\">Delete</a></td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
