<?php
include_once("../config.php");
$result = mysqli_query($mysqli, "SELECT * FROM garege ORDER BY gid DESC");

include 'admin-header.php';
include_once "config.php";

if (isset($_POST['submit'])) {
    $gname = mysqli_real_escape_string($mysqli, $_POST['gname']);
    $gaddress = mysqli_real_escape_string($mysqli, $_POST['gaddress']);
    $result3 = "INSERT INTO  garege(gname, gaddress) VALUES('$gname', '$gaddress')";
    $iquery = mysqli_query($mysqli, $result3);

    if ($iquery) {
        header("Location:viewgarages.php");
    } else {
        echo "record cannot be inserted";

    }

}


if (isset($_POST['editFare'])) {
    $editId = mysqli_real_escape_string($mysqli, $_POST['id']);
    $gname = mysqli_real_escape_string($mysqli, $_POST['gname']);
    $gaddress = mysqli_real_escape_string($mysqli, $_POST['gaddress']);
    $result3 = "UPDATE garege SET gname = '$gname', gaddress = '$gaddress' WHERE gid = $editId";
    $iquery = mysqli_query($mysqli, $result3);

    if ($iquery) {
        header("Location:viewgarages.php");
    } else {
        // echo "updated";

    }

}

if (isset($_POST['delete'])) {
    $deleteId = mysqli_real_escape_string($mysqli, $_POST['deleteId']);
    $result2 = mysqli_query($mysqli, "DELETE FROM garege WHERE gid=$deleteId");
    header("Location:viewgarages.php");
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
            <h1 style="margin-top: 0"> Garage Details</h1>
            <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" style="height:45px;">Add
                Garage</a>
        </div>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $slno = 1;
                while ($res = mysqli_fetch_array($result)) {

                    echo "<tr>";
                    echo "<td>" . $slno . "</td>";
                    echo "<td>" . $res['gname'] . "</td>";
                    echo "<td>" . $res['gaddress'] . "</td>";
                    ?>


                    <td>
                        <div class="d-flex justify-content-center">
                            <form action="" method="POST">
                                <input type="hidden" name="editId" value="<?= $res['gid']; ?>">
                                <input type="submit" name="edit" class="btn btn-success" Value="Edit">
                            </form>

                            <form action="" method="POST" class="ms-2">
                                <input type="hidden" name="deleteId" value="<?= $res['gid']; ?>">
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
            $editRes = mysqli_query($mysqli, "SELECT * FROM garege where gid = $editId");

            while ($ress = mysqli_fetch_array($editRes)) {
                $gname = $ress['gname'];
                $gaddress = $ress['gaddress'];
                //$photo = $res['photo'];
        
            }
            ?>
            <script>
                document.addEventListener("DOMContentLoaded", function () {
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
                        <a href="viewgarages.php"><button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button></a>
                    </div>
                    <div class="modal-body">
                        <form action="" method="POST">
                            <div class="">
                                <div class="mb-3">

                                    <input type="hidden" name="id" class="form-control" value="<?php if (isset($_POST['edit']))
                                        echo $editId ?>" placeholder="gname" required>


                                        <input type="text" name="gname" class="form-control" value="<?php if (isset($_POST['edit']))
                                        echo $gname ?>" placeholder="gname" required>
                                    </div>
                                    <div class="mb-3">
                                        <input type="text" name="gaddress" class="form-control" placeholder="gaddress"
                                            value="<?php if (isset($_POST['edit']))
                                        echo $gaddress ?>" required>
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