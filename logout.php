<?php
	include_once('dbconnect.php');
	session_destroy();
	unset($_SESSION['username']);
	$_SESSION['message'] = "You are now logged out";
	header("location: index.php");
?>