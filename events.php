<?php
$url = 'http://localhost/eventTypes.php';
	$data = array('typeId' => 'value1', 'timePeriodInHour' => 'value2');
 	$postdata = http_build_query($data);

	// use key 'http' even if you send the request to https://...
	$options = array('http' => array(
		'method'  => 'POST',
		'header' => 'Content-type: application/json',
		'content' => $postdata
	));
	$context  = stream_context_create($options);
	$result = file_get_contents($url, false, $context);
 
	var_dump($result);
