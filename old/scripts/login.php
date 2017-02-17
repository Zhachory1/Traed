<?php
	session_start();
	$email  = $_POST['email'];
	$psword = md5("LLks!w/TIs,Bw/TMd;&T4isWCup1d9aintdBld.".$_POST['password']);

	$conn = new mysqli("localhost", "root", "16Notefill", "traed");
	/* check connection */
	if ($conn->connect_errno) {
	    echo 2;
	    exit();
	}

	$result = $conn->query("SELECT * from `users` where `email`='$email' AND `password`='$psword'");
	if($result->num_rows == 0) {
		echo 1;
		exit();
	}
	echo 0;
	$count = $result->fetch_row();
	$_SESSION['login'] = 1;
	$_SESSION['uid']   = $count[0];
	$_SESSION['name']  = $count[1];
	$conn->query("UPDATE `users` SET `last_login`=CURRENT_TIMESTAMP WHERE `id`=".$count[0]);
?>