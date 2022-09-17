<?php
	// $server = "sql300.epizy.com";
	// $username = "epiz_32538366";
	// $password = "seeVWAgCG6hUK";
	// $dbname = "epiz_32538366_my_db";

	// $conn  = mysqli_connect($server, $username, $password, $dbname);

	// if (!$conn) {
	// 	echo "Connection failed!";


	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "tictactoe";

	$conn = mysqli_connect($servername, $username, $password, $dbname);

	if (!$conn) {
	    echo 'Connection failed!';
	}

