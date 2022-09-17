<?php
	



session_start();

include 'db_connect.php';

if (isset($_SESSION['username'])){
	$username = $_SESSION['username'];
}else{
	$username = "Player";
}
// $name = $_POST['username'];
// $name = $_POST['wins'];
// $name = $_POST['loses'];

if (isset($username)){
	try {
		$result = mysqli_query($conn,"SELECT * FROM `dashboard` WHERE username = '$username'");
		
		while($row = $result->fetch_assoc()) {

		    $array = array(
		        "id" => $row["id"],
		        "name" => $row["username"],
		        "games" => $row["games"],
		        "wins" => $row["wins"],
		        "draw" => $row["draw"],
		        "loses" => $row["loses"],
		        "score" => $row["score"]
		    );
		    // header('Content-Type: application/json; charset=utf-8');
		    echo json_encode($array);

	    
	  }
		
	}
	 catch(Exception $e) {
		echo $e;
	}
	
}else{
	echo "No data to insert";
}

