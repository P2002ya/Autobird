<!-- <?php

if (isset($_POST['submit'])) {
	include('../config.php');
	session_start();
	if (isset($_POST['username'])) {
		$username = $_POST['username'];
		$password = $_POST['password'];

		$query = "SELECT * FROM kkdriver WHERE username='$username' and password = '$password'";
		$result = mysqli_query($mysqli, $query);
		$rows = mysqli_num_rows($result);
		$fetch = mysqli_fetch_assoc($result);

		if ($rows == 1) {
			$_SESSION['dUsername'] = $username;
			$_SESSION['driver_id'] = $fetch['did'];
			$_SESSION['user_type'] = 'driver';

			header('Location: driverhome.php');
		} else {
			$msg = '<div class="alert alert-danger col-sm-8 mb-2" role="alert">  Invalid username or password </div>';
		}
	}
} ?>

<!DOCTYPE html>
<html>

<head>
	<title>login page</title>
	<link rel="stylesheet" type="text/css" href="../css/driver/driverlogin.css">
	<link rel="stylesheet" href="../bootstrap-5.0.2-dist/css/bootstrap.min.css">

</head>

<body>
	<div class="main" style="background-color: #14195f;">

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
						<input type="submit" class="form-control-submit" value="signin" name="submit">
					</div>
				</form>
			</center>
		</div>


	</div>

</body>

</html> -->
<?php
if (isset($_POST['submit'])) {
	include('../config.php');
	session_start();
	if (isset($_POST['username'])) {
		$username = $_POST['username'];
		$password = $_POST['password'];

		$query = "SELECT * FROM kkdriver WHERE username='$username' and password = '$password'";
		$result = mysqli_query($mysqli, $query);
		$rows = mysqli_num_rows($result);
		$fetch = mysqli_fetch_assoc($result);

		if ($rows == 1) {
			$_SESSION['dUsername'] = $username;
			$_SESSION['driver_id'] = $fetch['did'];
			
			$_SESSION['user_type'] = 'driver';

			header('Location: driverhome.php');
		} else {
			$msg = '<div class="alert alert-danger col-sm-8 mb-2" role="alert">Invalid username or password</div>';
		}
	}
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<title>Driver Login</title>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="stylesheet" href="../bootstrap-5.0.2-dist/css/bootstrap.min.css" />
	<!-- Optional: Remove old driverlogin.css if it's not mobile-friendly -->

	<!-- ✅ Responsive Styling -->
	<style>
		body {
			margin: 0;
			padding: 0;
			background: url('../images/bb.jpg') no-repeat center center fixed;
			background-size: cover;
			font-family: Arial, sans-serif;
		}

		.main {
			min-height: 100vh;
			display: flex;
			align-items: center;
			justify-content: center;
			padding: 20px;
		}

		.sign-in {
			background-color: rgba(20, 25, 95, 0.95);
			width: 100%;
			max-width: 400px;
			padding: 30px;
			border-radius: 10px;
			color: white;
		}

		.sign-in h1 {
			text-align: center;
			margin-bottom: 30px;
		}

		.input {
			width: 100%;
			padding: 12px;
			margin-bottom: 20px;
			border-radius: 5px;
			border: none;
			box-sizing: border-box;
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
	</style>
</head>

<body>
	<div class="main">
		<div class="sign-in">
			<form method="post">
				<h1>Sign In</h1>
				<input type="text" class="input" name="username" placeholder="username" required />
				<input type="password" class="input" name="password" placeholder="password" required />

				<?php if (isset($msg)) echo $msg; ?>

				<input type="submit" class="form-control-submit" value="signin" name="submit" />
				<p style="text-align:center; color:white;">
					Don't have an account? <a href="driver-signup.php" style="color:yellow;">Register here</a>
				</p>


	
			</form>
		</div>
	</div>
</body>

</html>
