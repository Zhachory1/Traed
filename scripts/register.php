<?php
	$name   = $_POST['name'];
	$email  = $_POST['email'];
	$psword = md5("LLks!w/TIs,Bw/TMd;&T4isWCup1d9aintdBld.".$_POST['password']);

	$conn = new mysqli("localhost", "root", "16Notefill", "traed");
	/* check connection */
	if ($conn->connect_errno) {
	    echo 2;
	    exit();
	}

	if($conn->query("INSERT INTO `users` (`name`, `email`, `password`) VALUES ('$name', '$email', '$psword')")) {
		$result  = $conn->query("SELECT id FROM `users` where `email`='$email';");
		$data 	 = $result->fetch_row();
		$user_id = $data[0];
		$conn->query("INSERT INTO `user_stock` (`stock_id`, `user_id`) VALUES (5288, $user_id);");
		$conn->query("INSERT INTO `user_stock` (`stock_id`, `user_id`) VALUES (6701, $user_id);");
		$conn->query("INSERT INTO `user_stock` (`stock_id`, `user_id`) VALUES (7366, $user_id);");
		echo 0;
		exit();
	} else {
		echo 1;
		exit();
	}
	
?>