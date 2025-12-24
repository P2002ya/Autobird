<?php
include_once("../config.php");
$result = mysqli_query($mysqli, "SELECT * FROM user ORDER BY uid DESC");

include 'admin-header.php';
?>

<style>
.main {
    margin-left: 10%
}

.heading {
    color: orange;
    margin-top: 80px;
    font-weight: bold;
    /* font-style: italic; */
    font-family: serif;

}
</style>
<div class="main pt-5">
    <div class="tablebox">
        <h1 style="margin-top: 0" class="heading"> Customers detail</h1>
        <table class="table  table-striped table-bordered">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th>image </th>
                    <th>username </th>
                    <th>email </th>
                    <th>phone </th>
                </tr>
            </thead>
            <tbody>
                <?php
				$slno = 1;
				while ($res = mysqli_fetch_array($result)) {
					?>
                <tr>
                    <td>
                        <?= $slno ?>
                    </td>
                    <td>
                        <?= $res['photo'] ?>
                    </td>
                    <td>
                        <?= $res['username'] ?>
                    </td>
                    <td>
                        <?= $res['email'] ?>
                    </td>
                    <td>
                        <?= $res['phone'] ?>
                    </td>
                </tr>
                <?php
					$slno++;
				}
				?>
            </tbody>
        </table>