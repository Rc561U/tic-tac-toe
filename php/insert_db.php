<?php


include 'db_connect.php';

$name = $_POST['username'];

if (isset($name) && strlen($name) > 0){
	try {
		// create sissin 
		session_start();
		// session_regenerate_id();
		$_SESSION["username"] = $name;

		echo ($_SESSION["username"]);
		$sql = "INSERT INTO dashboard (username) VALUES(?)";
		$stmt= $conn->prepare($sql);
		$stmt->bind_param("s", $name);
		$stmt->execute();
		// echo $name .' successfully insert';
	}
	 catch(Exception $e) {
		// echo 'This name already exist!';
	}
	
}else{
	// echo "No data to insert";
}
