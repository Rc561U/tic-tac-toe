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
$wins = $_POST['wins'];
$loses = $_POST['lose'];

if (isset($username)){
	try {
		$result = mysqli_query($conn,"SELECT * FROM `dashboard` WHERE username = '$username'");
		
		while($row = $result->fetch_assoc()) {
			// $id = $row["id"];
			$name = $row["username"];
			$totalGames = $row["games"] + 1;
			$totalWins = $row["wins"] + $wins;
			$totalLoses = $row["loses"] + $loses;
			$totalDraws = $totalGames - ($totalLoses + $totalWins);
			$score = $totalWins - $totalLoses < 0 ? 0 : $totalWins - $totalLoses;

			
			// $Update =  "UPDATE `dashboard` SET `username`='$name', `games`='$totalGames', `wins`='$totalWins', `draw`='totalDraws', `loses`='totalLoses', `score`='$score' WHERE `username`= '$name'";
			$Update = mysqli_query($conn, "UPDATE `dashboard` SET `username`='$name', `games`='$totalGames', `wins`='$totalWins', `draw`='$totalDraws', `loses`='$totalLoses',  `score`='$score' WHERE `username`= '$name'");

			// mysql_query($conn, $Update);
			// die(mysql_error());
			// echo $name .' successfully insert';
		    $array = array(
		        "id" => $row["id"],
		        "name" => $row["username"],
		        "games" => $totalGames,
		        "wins" => $totalWins,
		        "draw" => $totalDraws,
		        "loses" => $totalLoses,
		        "score" => $score,
		    );
		    // header('Content-Type: application/json; charset=utf-8');
		    echo json_encode($array);

	    
	  }
		// $sql = "INSERT INTO dashboard (username) VALUES(?,?,?,?,?) WHERE username = '$username'";
		// $stmt= $conn->prepare($sql);
		// $stmt->bind_param("ssssss",$name, $totalGames, $totalWins, $totalDraws, $totalLoses, $score);
		// $stmt->execute();
		
	}
	 catch(Exception $e) {
		echo $e;
	}
	
}else{
	echo "No data to insert";
}

