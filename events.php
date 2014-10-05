<?php

	getEvents(1,1);
	
	function getEvents ($requestedTypeId, $requestedTimePeriodInHour)
	{
	$url = 'http://localhost/eventTypes.php';
	$data = array('typeId' => $requestedTypeId, 'timePeriodInHour' => $requestedTimePeriodInHour);
 	$postdata = http_build_query($data);
	
	echo "postdata is: ", $postdata;
	
	// use key 'http' even if you send the request to https://...
	$options = array('http' => array(
		'method'  => 'POST',
		'header' => 'Content-type: application/json',
		'content' => $postdata
	));
	$context  = stream_context_create($options);
	$result = file_get_contents($url, false, $context);
	echo 'var_dump: ';
	var_dump($result);
	
	//still need to decode?
	$eventArray = json_decode($result, true);
	echo 'var_dump: ';
	var_dump($eventArray);
 
	//Sample JSON:
	//{"error":0,"events":[{"id":55,"eventType":"Dengue","priority":1,"callingTime":1411106400000,"postalCode":"11111","location":"SouthWest","callerPhone":"111","description":"Dengue again and again. "},{"id":44,"eventType":"Dengue","priority":1,"callingTime":1411102800000,"postalCode":"11111","location":"SouthWest","callerPhone":"111","description":"Dengue again"},{"id":11,"eventType":"Dengue","priority":1,"callingTime":1411099200000,"postalCode":"11111","location":"SouthWest","callerPhone":"111","description":"Dengue here"}]}
	// Create the sample array for testing parsing
	$sampleArray = array (
	  'error' => 0,
	  'events' => 
	  array (
		0 => 
		array (
		  'id' => 55,
		  'eventType' => 'Dengue',
		  'priority' => 1,
		  'callingTime' => 1411106400000,
		  'postalCode' => '11111',
		  'location' => 'North',
		  'callerPhone' => '111',
		  'description' => 'Dengue again and again. ',
		),
		1 => 
		array (
		  'id' => 44,
		  'eventType' => 'Dengue',
		  'priority' => 1,
		  'callingTime' => 1411102800000,
		  'postalCode' => '11111',
		  'location' => 'South',
		  'callerPhone' => '111',
		  'description' => 'Dengue again',
		),
		2 => 
		array (
		  'id' => 11,
		  'eventType' => 'Dengue',
		  'priority' => 1,
		  'callingTime' => 1411099200000,
		  'postalCode' => '11111',
		  'location' => 'South',
		  'callerPhone' => '111',
		  'description' => 'Dengue here',
		),
	  ),
	);
	
	
	$eventArray = $sampleArray; // for testing only, to be removed for actual http request
	
	if ($eventArray['error']!=0) {
		echo ('error in server response');
	}
	
	$North = 0;
	$South = 0;
	$East = 0;
	$West = 0;
	$Central = 0;
	
	foreach ($eventArray['events'] as $element) {
		switch ($element['location']) {
			case 'North':
				$North++;
				break;
			case 'South':
				$South++;
				break;
			case 'East':
				$East++;
				break;
			case 'West':
				$West++;
				break;
			case 'Central':
				$Central++;
				break;
		}		
	}
	
	echo ("N,S,E,W,C:\n");
	echo $North,' ',$South,' ',$East,' ',$West,' ',$Central;
	
	
	$eventCount = array (
		'North' => $North,
		'South' => $South,
		'East' => $East,
		'West' => $West,
		'Central' => $Central
	);
	
	echo 'returning the array:';
	var_dump ($eventCount);
	return $eventCount;
	}
 ?>