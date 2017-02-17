<?php
	session_start();
	$uid = $_SESSION['uid'];
	$sym = $_GET['sym'];
	$mysqli  = new mysqli("localhost", "root", "16Notefill", "traed");
	if ($mysqli->connect_errno) {
		echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
		exit();
	}

	$sql = "SELECT `id` FROM `stocks` WHERE `symbol`='$sym';";
	$result = $mysqli->query($sql);
	if($result->num_rows == 0) {
		echo 0;
		exit();
	}
	$row = $result->fetch_row();
	$stock_id = $row[0];

	$sql = "INSERT INTO `user_stock` (`stock_id`, `user_id`) VALUES ($stock_id, $uid);";
	$mysqli->query($sql);
	echo $stock_id;
?>