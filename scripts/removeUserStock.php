<?php
	session_start();
	$uid = $_SESSION['uid'];
	$sym = $_GET['remsym'];
	$mysqli  = new mysqli("localhost", "root", "16Notefill", "traed");
	if ($mysqli->connect_errno) {
		echo 0;
		exit();
	}

	$sql = "DELETE FROM `user_stock` WHERE `id`=$sym;";
	$mysqli->query($sql);
	echo $sym;
?>