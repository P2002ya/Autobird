<?php include 'header.php'; ?>
<?php
// session_start();
include_once("config.php");

// Fetch user_id from session
if (!isset($_SESSION['user_id'])) {
    die("You must be logged in to see booking history.");
}
$user_id = intval($_SESSION['user_id']);




$result = mysqli_query($mysqli, 
    "SELECT booking.*, kkdriver.fname, kkdriver.lname 
     FROM booking 
     LEFT JOIN kkdriver ON booking.driverId = kkdriver.did  
     WHERE uid = $user_id 
     ORDER BY booking.bid DESC");
?>

<style>
    body {
        background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url("images/bb.JPG");
        background-repeat: no-repeat;
        background-size: cover;
    }
    .cancelled {
        background-color: #5c5c5c !important;
        color: #ff4d4d !important;
    }
</style>

<link rel="stylesheet" href="css/comman-table.css">

<div class="tablebox">
    <h1 class="text-center"><b style="color: orange;">Booking History</b></h1>
    <table class="table table-dark table-striped table-bordered">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th>Picking Point</th>
                <th>Dropping Point</th>
                <th>Date</th>
                <th>Time</th>
                <th>Driver</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $slno = 1;
            while ($res = mysqli_fetch_array($result)) {
                // Format time from '09:00:00.0000' to '09:00 AM'
                $formattedTime = date("h:i A", strtotime($res['btime']));

                // Highlight cancelled rows
                $rowClass = strtolower($res['status']) == 'cancelled' ? 'cancelled' : '';
                ?>
                <tr class="<?= $rowClass ?>">
                    <td><?= $slno ?></td>
                    <td><?= htmlspecialchars($res['pick']) ?></td>
                    <td><?= htmlspecialchars($res['dest']) ?></td>
                    <td><?= htmlspecialchars($res['bdate']) ?></td>
                    <td><?= $formattedTime ?></td>
                    <td><?= htmlspecialchars($res['fname'] . ' ' . $res['lname']) ?></td>
                    <td><?= htmlspecialchars($res['status']) ?></td>
                </tr>
                <?php
                $slno++;
            }

            if ($slno === 1) {
                echo '<tr><td colspan="7" class="text-center">No bookings found.</td></tr>';
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>
