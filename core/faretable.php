<?php include 'header.php';

include_once("config.php");
$result = mysqli_query($mysqli, "SELECT * FROM fares ORDER BY id DESC");
?>

<title>web page</title>
<link rel="stylesheet" type="text/css" href="css/fare.css">
<link rel="stylesheet" href="css/comman-table.css">


</div>
<div class="tablebox">
    <h1>FARES TABLE</h1>

    <table class="table table-dark table-striped table-bordered">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th>distance</th>
                <th>cost</th>
            </tr>
        </thead>
        <tbody>

            <?php
            $slno = 1;
            while ($res = mysqli_fetch_array($result)) {

                echo "<tr>";
                echo "<td>" . $slno . "</td>";
                echo "<td>" . $res['distance'] . "</td>";
                echo "<td>" . $res['cost'] . "</td>";
                echo "</tr>";
                $slno++;
            } ?>
        </tbody>
    </table>
</div>


</body>

</html>