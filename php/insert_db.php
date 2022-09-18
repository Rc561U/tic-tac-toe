<?php


include 'db_connect.php';

$name = $_POST['username'];

$response = array('status' => '', 'response' => '');

if (isset($name) && strlen($name) > 0){
	try {
		// create sissin 
		session_start();
		// session_regenerate_id();
		$_SESSION["username"] = $name;

		

		$sql = "INSERT INTO dashboard (username) VALUES(?)";

		$stmt= $conn->prepare($sql);
		$stmt->bind_param("s", $name);
		$stmt->execute();
		$conn->close();
		$response['status'] = 'true';
		$response['response'] = 'New username was created successfully!';
		echo json_encode($response);
	}
	 catch(Exception $e) {
	 	$response['status'] = 'false';
		$response['response'] = 'This username already exist!';
		echo json_encode($response);
		
	}
	
}else{
 	$response['status'] = 'false';
	$response['response'] = 'Username is required!';
	echo json_encode($response);
	
}
