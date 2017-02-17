<?php
	$sym = $_GET['sym'];
	$context = stream_context_create(array('http'=>array('protocol_version'=>1.1)));
	$url = 'http://dev.markitondemand.com/MODApis/Api/v2/Quote/json?symbol='.$sym;
	echo file_get_contents($url, false, $context);
?>