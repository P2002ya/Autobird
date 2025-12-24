<?php
include_once("../config.php");
$result = mysqli_query($mysqli, "SELECT * FROM fares ORDER BY id DESC");

include 'admin-header.php';
include_once "config.php";

if (isset($_POST['submit'])) {
    $distance = mysqli_real_escape_string($mysqli, $_POST['distance']);
    $cost = mysqli_real_escape_string($mysqli, $_POST['cost']);
    $result3 = "INSERT INTO  fares(distance, cost) VALUES('$distance', '$cost')";
    $iquery = mysqli_query($mysqli, $result3);

    if ($iquery) {
        header("Location:viewfares.php");
    } else {
        echo "record cannot be inserted";

    }

}


if (isset($_POST['editFare'])) {
    $editId = mysqli_real_escape_string($mysqli, $_POST['id']);
    $distance = mysqli_real_escape_string($mysqli, $_POST['distance']);
    $cost = mysqli_real_escape_string($mysqli, $_POST['cost']);
    $result3 = "UPDATE fares SET distance = '$distance', cost = '$cost' WHERE id = $editId";
    $iquery = mysqli_query($mysqli, $result3);

    if ($iquery) {
        header("Location:viewfares.php");
    } else {
        // echo "updated";

    }

}

if (isset($_POST['delete'])) {
    $deleteId = mysqli_real_escape_string($mysqli, $_POST['deleteId']);
    $result2 = mysqli_query($mysqli, "DELETE FROM fares WHERE id=$deleteId");
    header("Location:viewfares.php");
}
?>

<style>
.main {
    margin-left: 10%
}
</style>
<div class="main pt-5">
    <div class="tablebox">
        <div class="d-flex justify-content-between">
            <h1 style="margin-top: 0"> Fares</h1>
            <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" style="height:45px;">Add
                Fares</a>
        </div>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th>Distance</th>
                    <th>Cost</th>
                    <th>Actions</th>
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
                    ?>


                <td>
                    <div class="d-flex justify-content-center">
                        <form action="" method="POST">
                            <input type="hidden" name="editId" value="<?= $res['id']; ?>">
                            <input type="submit" name="edit" class="btn btn-success" Value="Edit">
                        </form>

                        <form action="" method="POST" class="ms-2">
                            <input type="hidden" name="deleteId" value="<?= $res['id']; ?>">
                            <input type="submit" name="delete" class="btn btn-danger" value="Delete">
                        </form>
                        <div>
                </td>
                <?php echo "</tr>";
                    $slno++;
                }
                ?>
            </tbody>
        </table>

        <!-- Modal -->

        <?php if (isset($_POST['edit'])) {
            $editId = mysqli_real_escape_string($mysqli, $_POST['editId']);
            $editRes = mysqli_query($mysqli, "SELECT * FROM fares where id = $editId");

            while ($ress = mysqli_fetch_array($editRes)) {
                $distance = $ress['distance'];
                $cost = $ress['cost'];
                //$photo = $res['photo'];
        
            }
            ?>
        <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Trigger the modal display
            var myModal = new bootstrap.Modal(document.getElementById("exampleModal"));
            myModal.show();
        });
        </script>

        <?php
        }
        ?>

        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
            data-bs-backdrop="static">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Fare</h5>
                        <a href="viewfares.php"><button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button></a>
                    </div>
                    <div class="modal-body">
                        <form action="" method="POST">
                            <div class="">
                                <div class="mb-3">

                                    <input type="hidden" name="id" class="form-control" value="<?php if (isset($_POST['edit']))
                                        echo $editId ?>" placeholder="Distance" required>


                                    <input type="text" name="distance" class="form-control" value="<?php if (isset($_POST['edit']))
                                        echo $distance ?>" placeholder="Distance" required>
                                </div>
                                <div class="mb-3">
                                    <input type="text" name="cost" class="form-control" placeholder="Cost" value="<?php if (isset($_POST['edit']))
                                        echo $cost ?>" required>
                                </div>
                            </div>
                            <input type="submit" class="btn btn-primary" name="<?php
                                    if (isset($_POST['edit'])) {
                                        echo 'editFare';
                                    } else {
                                        echo 'submit';
                                    } ?>" class="btn">

                        </form>
                    </div>

                </div>
            </div>
        </div>


        </body>

        </html>