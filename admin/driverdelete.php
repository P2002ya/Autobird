<?php

include("config.php");

$did = $_GET['did'];

$result = mysqli_query($mysqli, "DELETE FROM kkdriver WHERE did=$did");

header("Location:viewdriver.php");
?>