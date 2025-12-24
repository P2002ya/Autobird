<?php
include_once("config.php");

if (isset($_POST['signup'])) {
    $username = mysqli_real_escape_string($mysqli, $_POST['username']);
    $email = mysqli_real_escape_string($mysqli, $_POST['email']);
    $phone = mysqli_real_escape_string($mysqli, $_POST['phone']);
    $password = mysqli_real_escape_string($mysqli, $_POST['password']);

    // Hash password before saving
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $result = mysqli_query($mysqli, "INSERT INTO user(username,email,phone,password) VALUES('$username','$email','$phone','$hashedPassword')");
    header('Location: userLogin.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Sign Up</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <style>
        body {
            margin: 0;
            background: url('images/bb.jpg') no-repeat center center fixed;
            background-size: cover;
            font-family: Arial, sans-serif;
        }

        .main {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .signup {
            width: 100%;
            max-width: 400px;
            background-color: rgba(0, 0, 0, 0.85);
            padding: 30px;
            border-radius: 10px;
            color: white;
        }

        .input {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: none;
        }

        .form-control-submit {
            width: 100%;
            padding: 12px;
            background-color: orange;
            color: white;
            border: none;
            border-radius: 5px;
            font-weight: bold;
        }

        .form-control-submit:hover {
            background-color: darkorange;
        }

        p {
            text-align: center;
        }

        a {
            color: #feca57;
        }
    </style>
</head>
<body>
<div class="main">
    <div class="signup">
        <form method="post" onsubmit="return checkForm(this);">
            <h2 class="text-center mb-4">Sign up</h2>

            <input type="text" name="username" class="input" placeholder="Username" required>
            <input type="email" name="email" class="input" placeholder="Email" required>
           
            <input type="tel" name="phone" class="input" placeholder="Phone Number" maxlength="10" pattern="[0-9]{10}" title="Enter 10 digit number" required oninput="this.value=this.value.replace(/[^0-9]/g,'');">
            
            <input type="password" name="password" class="input" placeholder="Password" required>
            <input type="password" name="cpassword" class="input" placeholder="Confirm Password" required>

            <input type="submit" name="signup" class="form-control-submit" value="Sign Up">

            <p>Already registered? <a href="userLogin.php">Sign in here.</a></p>
        </form>
    </div>
</div>

<script>
function checkForm(form) {
    if (form.password.value !== form.cpassword.value) {
        alert("Passwords do not match.");
        form.password.focus();
        return false;
    }
    return true;
}
</script>
</body>
</html>

<!-- <?php
include_once("config.php");
if (isset($_POST['signup'])) {
    $username = mysqli_real_escape_string($mysqli, $_POST['username']);
    $email = mysqli_real_escape_string($mysqli, $_POST['email']);
    $password = mysqli_real_escape_string($mysqli, $_POST['password']);

    $result = mysqli_query($mysqli, "INSERT INTO user(username,email,password) VALUES('$username','$email','$password')");
    header('Location:userLogin.php');
}

?>

<!DOCTYPE html>
<html>

<head>
    <title></title>
    <link rel="stylesheet" type="text/css" href="css/signup.css">
</head>

<body>
    <div class="main">
        <div class="signup">
            <center>

                <form action="" method="post" name="form1" onsubmit="return checkForm(this);">
                    <h1 style="color: white">Sign up</h1>

                    <input type="text" name="username" class="input" placeholder="username" required>
                    <br><br>

                    <input type="email" name="email" class="input" placeholder="email" required>
                    <br><br>

                    <input type="password" name="password" class="input" placeholder="password" required>
                    <br><br>

                    <input type="password" name="cpassword" class="input" placeholder="confirm password" required>
                    <br><br>
                    <input type="submit" class="form-control-submit" name="signup" value="signup">
                    <br>
                    <p style="color: white">already registered?<a href="userLogin.php"><u>sign in here.</u></a></p>
                </form>
            </center>
        </div>
    </div>
    <script type="text/javascript">
        function checkForm(form) {
            if (form1.password.value !== "" && form1.password.value === form1.cpassword.value) {
                return true;
            } else {
                alert("Error:Please check that you your password and confirm password are same");
                form1.password.focus();
                return false;

            }
        }
    </script>

</body>

</html> -->