<?php

include('config.php');

session_start();

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    //to prevent from mysqli injection
    $username = stripcslashes($username);
    $password = stripcslashes($password);
    $username = mysqli_real_escape_string($mysqli, $username);
    $password = mysqli_real_escape_string($mysqli, $password);

    $result = mysqli_query($mysqli, "select * from admin where name='$username' and pass='$password'");

    if (mysqli_num_rows($result) == 1) {
        $_SESSION['adminUsername'] = $username;
        header('Location:viewdriver.php');
    } else {
        $msg = '<div class="alert alert-danger col-sm-12 mb-2" role="alert">  Invalid username or password </div>';

    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="../css/all.css">
    <link rel="stylesheet" type="text/css" href="../css/admin/login.css" />

    <link rel="stylesheet" href="../fontawesome-free-5.15.1-web/fontawesome-free-5.15.1-web/css/all.css">
    <link rel="stylesheet" href="../bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
        </script>
    <title>Admin Login</title>
</head>

<body>
    <form name="f1" action="" method="post">
        <div class="login-div">
            <img src="../images/LLG.png">
            <div class="title">Auto bird</div>
            <div class="sub-title">admin login</div>
            <div class="fields">
                <div class="username d-flex">
                    <i class="fas fa-user m-2"></i>
                    <input type="username" name="username" class="user-input" placeholder="username"
                        required="required" />
                </div>
                <div class="password d-flex">
                    <i class="fas fa-lock m-2"></i>
                    <input type="password" name="password" class="pass-input" placeholder="password"
                        required="required" />
                </div>
            </div>
            <?php if (isset($msg)) {
                echo $msg;
            } ?>
            <button class="signin-button" type="submit" name="submit">login</button></button>
            <!-- <a href="#">Forgot password?</a> -->
        </div>
        </div>
    </form>
</body>

</html>