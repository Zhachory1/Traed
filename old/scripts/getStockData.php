<?php
	$sym = $_GET['sym'];
	$paramOHLC = '{'
		.'"Normalized":false,'
		.'"NumberOfDays":365,'
		.'"DataPeriod":"Day",'
		.'"Elements":['
			.'{'
				.'"Symbol":"'.$sym.'",'
				.'"Type":"price",'
				.'"Params":['
					.'"ohlc"'
				.']'
			.'}'
		.']'
	.'}';
	$paramVOL = '{'
		.'"Normalized":false,'
		.'"NumberOfDays":365,'
		.'"DataPeriod":"Day",'
		.'"Elements":['
			.'{'
				.'"Symbol":"'.$sym.'",'
				.'"Type":"volume",'
				.'"Params":[]'
			.'}'
		.']'
	.'}';
	$paramSMA = '{'
		.'"Normalized":false,'
		.'"NumberOfDays":365,'
		.'"DataPeriod":"Day",'
		.'"Elements":['
			.'{'
				.'"Symbol":"'.$sym.'",'
				.'"Type":"sma",'
				.'"Params":[20]'
			.'}'
		.']'
	.'}';
	$context = stream_context_create(array('http'=>array('protocol_version'=>1.1)));
	$url = 'http://dev.markitondemand.com/MODApis/Api/v2/InteractiveChart/json?parameters='.urlencode($paramOHLC);
	$ohlcJSON = file_get_contents($url, false, $context);
	$url = 'http://dev.markitondemand.com/MODApis/Api/v2/InteractiveChart/json?parameters='.urlencode($paramVOL);
	$volJSON = file_get_contents($url, false, $context);
	$url = 'http://dev.markitondemand.com/MODApis/Api/v2/InteractiveChart/json?parameters='.urlencode($paramSMA);
	$smaJSON = file_get_contents($url, false, $context);

	$ohlc1 = json_decode($ohlcJSON, true);
	$vol1 = json_decode($volJSON, true);
	$sma1 = json_decode($smaJSON, true);
	$ohlc = (array) $ohlc1["Elements"][0];
	$vol = (array) $vol1["Elements"][0];
	$sma = (array) $sma1["Elements"][0];

	$final = [
		"Open" => $ohlc["DataSeries"]["open"]["values"], 
		"High" => $ohlc["DataSeries"]["high"]["values"], 
		"Close" => $ohlc["DataSeries"]["close"]["values"], 
		"Low" => $ohlc["DataSeries"]["low"]["values"], 
		"Volume" => $vol["DataSeries"]["volume"]["values"], 
		"SMA" => $sma["DataSeries"]["sma"]["values"], 
		"Date" => $ohlc1["Dates"]
	];

	echo json_encode($final);
?>