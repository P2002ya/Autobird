<?php
@session_start(); // ✅ Starts session safely, hides warning if already started

if (!isset($_SESSION["user_id"])) {
    header("Location: userhome.php");
    exit(); // ✅ Important to stop execution after redirect
}


