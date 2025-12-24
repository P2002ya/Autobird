<?php

if (isset($_POST['submit'])) {
    include('config.php');
    session_start();
    $username = $_POST['username'];
    $password = $_POST['password'];

    //to prevent from mysqli injection
    // $username = stripcslashes($username);
    // $password = stripcslashes($password);
    // $username = mysqli_real_escape_string($mysqli, $username);
    // $password = mysqli_real_escape_string($mysqli, $password);

    $result = mysqli_query($mysqli, "select * from user where username='$username' and password='$password'");

    $fetch = mysqli_fetch_assoc($result);
    if (mysqli_num_rows($result) == 1) {
        $_SESSION['username'] = $username;
        $_SESSION['user_id'] = $fetch['uid'];
        header('Location:userhome.php');
    } else {
        $msg = '<div class="alert alert-danger col-sm-8 mb-2" role="alert">  Invalid username or password </div>';

    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>login page</title>
    <link rel="stylesheet" type="text/css" href="css/login1.css">
    <link rel="stylesheet" href="bootstrap-5.0.2-dist/css/bootstrap.min.css">
</head>

<body>

    </div>
    <div class="main">

        <div class="sign-in">
            <center>
                <form action="" method="post">

                    <h1 class="text-white mt-5">Sign In</h1><br>
                    <div class="eye mb-5">

                        <input type="text" class="input" name="username" placeholder="username" required>
                    </div>
                    <div class="eye mb-5">

                        <input type="password" class="input" name="password" placeholder="password" required>
                    </div>

                    <?php if (isset($msg)) {
                        echo $msg;
                    } ?>

                    <div class="eye mb-5">
                        <input type="submit" class="form-control-submit" name="submit" value="Sign In">
                    </div>

                    <p style="color: white">Not yet registered? <a href="signup.php"><u> Sign-up here.</u></a></p>
                </form>
            </center>
        </div>


    </div>

</body>

</html>