<?php
session_start();

$base_url = "http://" . $_SERVER['SERVER_NAME'] . '/grupo12/NFLDB';


$servername = "cc3201.dcc.uchile.cl";
$username = "cc3201";
$password = "grupo12";
$dbname = "cc3201";
$port = "5412";

// Create connection

$conn = pg_connect("host=$servername port=$port dbname=$dbname user=$username password='$password'")
		or die('Could not connect: ' . pg_last_error());

?>
