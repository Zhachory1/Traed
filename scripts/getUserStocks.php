<?php
	session_start();
	$uid = $_SESSION['uid'];
	$mysqli  = new mysqli("localhost", "root", "16Notefill", "traed");
	if ($mysqli->connect_errno) {
		echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
		exit();
	}

	$sql = "SELECT us.`id` as 'Id', s.`name` as 'Name',  s.`symbol` as 'Symbol' 
			FROM stocks s, user_stock us 
			WHERE s.`id` = us.`stock_id` AND us.`user_id`=$uid;";
	$result = $mysqli->query($sql);
	if($result->num_rows == 0) {
		echo json_encode([]);
		exit();
	}
	$data = array();
	while($row = $result->fetch_row()) {
		array_push($data, array($row[2], $row[1], $row[0]));
	}
	echo json_encode($data);
?>