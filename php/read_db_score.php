<?php  

include "db_conn.php";

$sql = "SELECT id,name,score FROM users ORDER BY id DESC";
$result = mysqli_query($conn, $sql);