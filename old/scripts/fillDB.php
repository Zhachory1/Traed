<?php
	$stocks  = split("[\n]",file_get_contents("../data/symbol_listing.csv"));
	$history = 0;
	$json    = 0;
	$data    = 0;
	$mysqli  = new mysqli("localhost", "root", "16Notefill", "traed");
	if ($mysqli->connect_errno) {
		echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}
	$open    = 0;
	$close   = 0;
	$high    = 0;
	$low     = 0;
	$volume  = 0;
	$date    = "";
	$sql     = "";

	foreach ($stocks as $stock) {
		$history = file_get_contents("http://marketdata.websol.barchart.com/getHistory.json?key=1c0449192076f19c7429b2c1ed1c594d&symbol=$stock&type=daily&startDate=20140422000000");

		$json   = json_decode($history, true);
		$data   = $json['results'];
		$open   = 0;
		$close  = 0;
		$high   = 0;
		$low    = 0;
		$volume = 0;
		$date   = "";
		$sql    = "";

		foreach($data as $row) {
			$open   = $row['open'];
			$close  = $row['close'];
			$high   = $row['high'];
			$low    = $row['low'];
			$volume = $row['volume'];
			$date   = $row['tradingDay'];

			$sql = "INSERT INTO `basic_data`(`stock_id`, `open`, `high`, `close`, `low`, `volume`, `nic`, `cc`, `date`) VALUES (0,$open,$high,$close,$low,$volume,0,0,'$date')";

			$mysqli->query($sql);
		}
	}
?>