<?php
include 'header.php';
if (isset($_POST['submit'])) {
    $fname = mysqli_real_escape_string($mysqli, $_POST['fname']);
    $lname = mysqli_real_escape_string($mysqli, $_POST['lname']);
    $email = mysqli_real_escape_string($mysqli, $_POST['email']);
    $phone = mysqli_real_escape_string($mysqli, $_POST['phone']);
    // $lno = mysqli_real_escape_string($mysqli, $_POST['lno']);

    $result = mysqli_query($mysqli, "UPDATE kkdriver SET fname='$fname', lname='$lname', email='$email', phone='$phone' WHERE did = $driver_id");
    header("Location: driverprofile.php");
}


if (isset($_POST['changePassword'])) {
    $oldpassword = mysqli_real_escape_string($mysqli, $_POST['oldpassword']);
    $newpassword = mysqli_real_escape_string($mysqli, $_POST['newpassword']);
    $confirmpassword = mysqli_real_escape_string($mysqli, $_POST['confirmpassword']);

    if ($oldpassword != $driver['password']) {
        $msg = '<div class="alert alert-danger col-sm-8 mb-2" role="alert">  incorrect password </div>';
    } else if ($newpassword != $confirmpassword) {
        $msg = '<div class="alert alert-danger col-sm-8 mb-2" role="alert">  Password and Confirm Password is not matching </div>';
    } else {
        $result = mysqli_query($mysqli, "UPDATE kkdriver SET password='$newpassword' WHERE did = $driver_id");
        header("Location: driverprofile.php");
    }
}
?>

<head>
    <meta charset="UTF-8">
    <title>Account Settings UI Design</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../css/driver/driverprofile.css">
</head>

<body>
    <section class="py-1 my-2">
        <div class="container">
            <div class="profilecontainer shadow rounded-lg d-block d-sm-flex">
                <div class="profile-tab-nav border-right">
                    <div class="p-4">
                        <div class="img-circle text-center mb-3">
                            <img src="../images/driver/<?php echo ($driver['photo'] != null) ? $driver['photo'] : "default.png";
                            ?>" alt="Image" class="shadow">
                        </div>
                        <h4 class="text-center">
                            <?= $driver['fname'] . ' ' . $driver['lname'] ?>
                        </h4>
                    </div>
                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <a class="nav-link active" id="account-tab" data-toggle="pill" href="#account" role="tab"
                            aria-controls="account" aria-selected="true">
                            <i class="fa fa-home text-center mr-1"></i>
                            Account
                        </a>
                        <a class="nav-link" id="password-tab" data-toggle="pill" href="#password" role="tab"
                            aria-controls="password" aria-selected="false">
                            <i class="fa fa-key text-center mr-1"></i>
                            Password
                        </a>
                    </div>
                </div>
                <div class="tab-content p-4 p-md-5" id="v-pills-tabContent">
                    <div class="tab-pane fade show active" id="account" role="tabpanel" aria-labelledby="account-tab">
                        <h3 class="mb-4">Account Settings</h3>
                        <form method="POST" action="">
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Licence No.</label>
                                        <input type="text" class="form-control disabled" disabled
                                            value="<?= $driver['lno'] ?>">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Username</label>
                                        <input type="text" class="form-control disabled " disabled
                                            value="<?= $driver['username'] ?>">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>First Name</label>
                                        <input type="text" name="fname" class="form-control"
                                            value="<?= $driver['fname'] ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Last Name</label>
                                        <input type="text" name="lname" class="form-control"
                                            value="<?= $driver['lname'] ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="text" name="email" class="form-control"
                                            value="<?= $driver['email'] ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Phone number</label>
                                        <input type="text" name="phone" class="form-control"
                                            value="<?= $driver['phone'] ?>">
                                    </div>
                                </div>
                            </div>
                            <div>
                                <button class="btn btn-primary" type="submit" data-toggle="modal"
                                    data-target="#updateModal" name="submit">Update</button>
                                <button class="btn btn-light">Cancel</button>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="password" role="tabpanel" aria-labelledby="password-tab">
                        <h3 class="mb-4">Password Settings</h3>
                        <form method="POST" action="">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Old password</label>
                                        <input type="password" name="oldpassword" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>New password</label>
                                        <input type="password" name="newpassword" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Confirm new password</label>
                                        <input type="password" name="confirmpassword" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div>
                                <button class="btn btn-primary" type="submit" data-toggle="modal"
                                    data-target="#updateModal" name="changePassword">Update</button>
                                <button class="btn btn-light">Cancel</button>
                            </div>
                            <?php if (isset($msg)) {
                                echo $msg;
                            } ?>

                        </form>
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