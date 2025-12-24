<?php include 'header.php';

if (isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($mysqli, $_POST['email']);
    $username = mysqli_real_escape_string($mysqli, $_POST['username']);
    $phone = mysqli_real_escape_string($mysqli, $_POST['phone']);


    $file = $_FILES['photo'];
    $filename = $file['name'];
    $lphoto = $_POST['lphoto'];

    $filepath = $file['tmp_name'];
    $fileerror = $file['error'];

    if ($filename != "") {
        if ($fileerror == 0) {
            $destfile = 'images/user/' . $filename;
            move_uploaded_file($filepath, $destfile);
        }
    } else {
        $filename = $lphoto;
    }

    $result = mysqli_query($mysqli, "UPDATE user SET email='$email', username='$username', photo='$filename', phone='$phone' WHERE uid= $user_id");
    header("Location: userprofile.php");
}
?>
<link rel="stylesheet" type="text/css" href="css/userprofile.css">

<section class="py-1 my-2">
    <div class="container d-flex justify-content-center">
        <!-- Center the container -->
        <div class="profile-tab-nav border-right align-item-center col-md-5">
            <div class="profilecontainer p-5 rounded">
                <div class="tab-content justify-content-center" id="v-pills-tabContent">
                    <div class="tab-pane fade show active justify-content-center" id="account" role="tabpanel"
                        aria-labelledby="account-tab">
                        <form method="POST" action="" enctype="multipart/form-data">
                            <div class="img-circle text-center">
                                <!-- Add text-center class here -->
                                <img src="images/user/<?php echo ($user['photo'] != null) ? $user['photo'] : "default.png";
                                ?>" alt="Image" class="shadow" id="profileImage">
                            </div>


                            <div class="form-group">
                                <label for="phone">Choose New Profile</label>
                                <input type="file" name="photo" class="form-control" value="">
                                <input type="hidden" name="lphoto" class="form-control" value="<?= $user['photo'] ?>">
                            </div>

                            <div class="row">
                                <div class="form-group">
                                    <label for="username">Name</label>
                                    <input type="text" id="username" name="username" class="form-control"
                                        value="<?= $user['username'] ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" id="email" name="email" class="form-control"
                                    value="<?= $user['email'] ?>">
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone number</label>
                                <input type="text" id="phone" name="phone" class="form-control"
                                    value="<?= $user['phone'] ?>">
                            </div>




                            <div>
                                <button class="btn btn-primary" type="submit" data-toggle="modal"
                                    data-target="#updateModal" name="submit">Update</button>
                                <button class="btn btn-light">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

</html>