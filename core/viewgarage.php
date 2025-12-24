<?php include 'header.php' ?>

<?php
include_once("config.php");

if (isset($_REQUEST['searchsubmit'])) {
    $name = $_REQUEST['name'];

    $result = mysqli_query($mysqli, "SELECT * FROM garege where gname Like '%$name%' ORDER BY gid DESC");
} else {
    $result = mysqli_query($mysqli, "SELECT * FROM garege ORDER BY gid DESC");
}
?>
<style>
body {
    background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url("images/bb.JPG");
    background-repeat: no-repeat;
    background-size: cover;
}
</style>
<link rel="stylesheet" href="css/comman-table.css">

<div class="tablebox">
    <h1 class="text-center"> Garage detail</h1>
    <form action="" method="POST" class="d-print-none mb-3">
        <div class="form-row d-flex">
            <div class="form-group col-md-2">
                <input type="text" class="form-control" id="startdate" name="name" placeholder="Search">
            </div>
            <div class="form-group ms-2">
                <input type="submit" class="btn btn-secondary" name="searchsubmit" value="Search"
                    style="background-color: #115173; color: #fff;">

            </div>
        </div>
    </form>
    <h3 class="test-light" style="color: white">Grages</h3>
    <table class="table table-dark table-striped table-bordered">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th>Name</th>
                <th>Address</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $slno = 1;
            while ($res = mysqli_fetch_array($result)) { ?>
            <tr>
                <td scope="row">
                    <?= $slno ?>
                </td>
                <td>
                    <?= $res['gname'] ?>
                </td>
                <td>
                    <?= $res['gaddress'] ?>
                </td>
            </tr>
            <?php
                $slno++;
            }
            ?>
        </tbody>
    </table>
    </body>

    </html>