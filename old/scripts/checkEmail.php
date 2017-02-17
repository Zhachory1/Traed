<?php
	$email = $_GET['email'];
	$conn = new mysqli("localhost", "root", "16Notefill", "traed");
	/* check connection */
	if ($conn->connect_errno) {
	    echo 2;
	    exit();
	}

	$result = $conn->query("SELECT COUNT(*) as 'cnt' from users where `email`='$email'");
	$count = $result->fetch_row();
	if($count[0] != 0) {
		echo 1;
		exit();
	}
	echo 0;
?>	