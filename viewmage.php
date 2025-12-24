<?php
include_once("config.php");
$result = mysqli_query($mysqli, "SELECT * FROM kkdriver ORDER BY did DESC");
?>
<html>

<head>
	<title>home page</title>
	<style type="text/css">
		body {
			background-image: url('images/bb.JPG');
			background-repeat: no-repeat;
			background-size: cover;

		}

		span {
			font-size: 29px;
			background-color: skyblue;
		}

		table {
			border: 2px solid black;
			margin-top: 100px;
			margin-left: 150px;
			background: orange;

		}


		a {
			text-decoration: none;
			color: white;


		}

		.bor {
			text-align: center;
		}

		.cen {
			background-color: orange;
			text-align: center;
		}

		header {
			text-align: center;
			font-size: 100px;
			color: black;
			font-style: italic;
			border: 2PX solid black;
			margin-left: 360px;
			margin-right: 350px;
			background-color: orange;

		}
	</style>


</head>

<body>

	<a href="dashboard.html"><span>go back</span></a><br /><br />
	<header>customer info</header>
	<table width='80%' border=0>
		<tr bgcolor='#cccccc'>
			<div class="bor">
				<td style="background-color: black; height: 40px;text-align: center; font-size: 20px; color: orange">
					first name</td>
				<td style="background-color: black; height: 40px;text-align: center; font-size: 20px; color: orange">
					last time</td>
				<td style="background-color: black; height: 40px;text-align: center; font-size: 20px; color: orange">
					email</td>
				<td style="background-color: black; text-align: center; font-size: 20px; color: orange">username</td>
				<td style="background-color: black; text-align: center; font-size: 20px; color: orange">lno</td>
				<td style="background-color: black; text-align: center; font-size: 20px; color: orange">phone</td>
				<td style="background-color: black; text-align: center; font-size: 20px; color: orange">photo</td>

			</div>



		</tr>
		<div class="cen">
			<?php
			while ($res = mysqli_fetch_array($result)) {
				echo "<tr>";
				echo "<td>" . $res['fname'] . "</td>";
				echo "<td>" . $res['lname'] . "</td>";
				echo "<td>" . $res['email'] . "</td>";
				echo "<td>" . $res['username'] . "</td>";
				echo "<td>" . $res['lno'] . "</td>";
				echo "<td>" . $res['phone'] . "</td>"; ?>
				<td> <img src="data:image/jpg;charset=utf8;base64 ,<?php echo base64_encode($res['photo']); ?>" width="100"
						height="100" /></td>
			<?php }
			?>

		</div>
	</table>
</body>

</html>