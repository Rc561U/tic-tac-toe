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
		$conn->close();
		while($row = $result->fetch_assoc()) {
			// $wins = $row["wins"] === 0 ? 0 : $row["wins"]zz


		    $array = array(
		        "id" => $row["id"],
		        "name" => $row["username"],
		        "games" => $row["games"] === null ? 0 : $row["games"],
		        "wins" => $row["wins"] === null ? 0 : $row["wins"],
		        "draw" => $row["draw"] === null ? 0 : $row["draw"],
		        "loses" => $row["loses"] === null ? 0 : $row["loses"],
		        "score" => $row["score"] === null ? 0 : $row["score"]
		    );
		    header('Content-Type: application/json; charset=utf-8');
		    echo json_encode($array);

	    
	  }
		
	}
	 catch(Exception $e) {
		echo $e;
	}
	
}else{
	echo "No data to insert";
}

