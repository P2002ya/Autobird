<!DOCTYPE html>
<html>
<head>
	<title>Access Google Maps API in PHP</title>
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script type="text/javascript" src="js/googlemap.js"></script>
	<style type="text/css">
		.container {
			height: 450px;
		}
		#map {
			width: 100%;
			height: 100%;
			border: 1px solid blue;
		}
		#data, #allData {
			display: none;
		}
	</style>
</head>
<body>
	<div class="container">
		<center><h1>View all garages </h1></center>
		<?php 

			require 'gmap.php';
			$edu = new autobird;
			$coll = $edu->getCollegesBlankLatLng();
			$coll = json_encode($coll, true);
			echo '<div id="data">' . $coll . '</div>';

			$allData = $edu->getAllColleges();
			$allData = json_encode($allData, true);
			echo '<div id="allData">' . $allData . '</div>';			
		 ?>
		
		<div id="map"></div>
	</div>
</body>

    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBLOCE4_Cqf4VKhfMPrAf5RjejqGosF1LI&callback=loadMap">
</script>

</html>