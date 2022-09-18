<?php

session_start();


$str_json = file_get_contents('php://input'); //($_POST doesn't work here)
$response = json_decode($str_json, true); 

include 'db_connect.php';

if (isset($_SESSION['username'])){
	$username = $_SESSION['username'];
}else{
	$username = "Player";
}

$wins = $response['wins'];
$loses = $response['lose'];

if (isset($username)){
	try {
		$result = mysqli_query($conn,"SELECT * FROM `dashboard` WHERE username = '$username'");
		
		while($row = $result->fetch_assoc()) {
		
			$name = $row["username"];
			$totalGames += $row["games"] + 1;
			$totalWins += $row["wins"] + $wins;
			$totalLoses += $row["loses"] + $loses;
			$totalDraws += $totalGames - ($totalLoses + $totalWins);
			$score = $row["score"];
			if ($loses){
				$score = $row["score"] - 1;
				if ($score <= 0){
					$score = 0;
				}
			} else if ($wins){
				$score = $row["score"] + 1;
			}
			


			$Update = mysqli_query($conn, "UPDATE `dashboard` SET `username`='$name', `games`='$totalGames', `wins`='$totalWins', `draw`='$totalDraws', `loses`='$totalLoses',  `score`='$score' WHERE `username`= '$name'");


		    $array = array(
		        "id" => $row["id"],
		        "name" => $row["username"],
		        "games" => $totalGames,
		        "wins" => $totalWins,
		        "draw" => $totalDraws,
		        "loses" => $totalLoses,
		        "score" => $score,
		    );

		    $conn->close();

	    
	  }

	}
	 catch(Exception $e) {
		echo $e;
	}
	
}else{
	echo "No data to insert";
}

