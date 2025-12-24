<?php

session_start();
//destroying all sessions
session_destroy();
//redirecting to home page
header("location: userLogin.php");