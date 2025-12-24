<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION["driver_id"])) {
    header("Location:driverlogin.php");
    exit(); // ✅ always add exit after redirect
}


