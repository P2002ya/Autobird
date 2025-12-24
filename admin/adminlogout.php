<?php

session_start();
//destroying all sessions
if (session_destroy()) {
	//redirecting to home page
	header("location:adminLogin.php");
}