<?php
include_once("../config.php");
$result = mysqli_query($mysqli, "SELECT * FROM booking where booking.status in('cancelled', 'dropped') ORDER BY bid DESC");

include 'admin-header.php';
?>

<style>
.main {
    margin-left: 10%
}
</style>
<div class="main pt-5">
    <div class="tablebox">
        <h1 style="margin-top: 0">Booking detail</h1>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th>picking point </th>
                    <th>droping point </th>
                    <th>date </th>
                    <th>time </th>
                    <th>status </th>

                </tr>
            </thead>
            <tbody>
                <?php
                $slno = 1;
                while ($res = mysqli_fetch_array($result)) {

                    echo "<tr>";
                    echo "<td>" . $slno . "</td>";
                    echo "<td>" . $res['pick'] . "</td>";
                    echo "<td>" . $res['dest'] . "</td>";
                    echo "<td>" . $res['bdate'] . "</td>";
                    echo "<td>" . $res['btime'] . "</td>";
                    echo "<td>" . $res['status'] . "</td>";
                    echo "</tr>";
                    $slno++;
                }
                ?>
            </tbody>
        </table>
        </body>

        </html>