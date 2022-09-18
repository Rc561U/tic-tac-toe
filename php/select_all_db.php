<?php

	include 'db_connect.php';


	$sql = "SELECT * FROM dashboard ORDER BY score DESC";
	$result = $conn->query($sql);
	$arr = array();
	if ($result->num_rows > 0) {
	  
	  while($row = $result->fetch_assoc()) {
	    
	    $array = array(
	        "id" => $row["id"],
	        "name" => $row["username"],
	        "games" => $row["games"],
	        "wins" => $row["wins"],
	        "draw" => $row["draw"],
	        "loses" => $row["loses"],
	        "score" => $row["score"] === null ? 0 : $row["score"]
	    );
	    array_push($arr, $array);
	    
	  }
		
	} else {
	  echo "0 results";
	}
	echo json_encode($arr);
	
	$conn->close();