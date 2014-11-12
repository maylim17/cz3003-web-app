<?php
	function getTestEvents ($requestedTypeId, $requestedTimePeriodInHour) {
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
			  'postalCode' => '320114',
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
			  'postalCode' => '320111',
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
			  'postalCode' => '320114',
			  'location' => 'South',
			  'callerPhone' => '111',
			  'description' => 'Dengue here',
			),
		  ),
		);
		return $sampleArray;
	}

	// Connects to server and retrieves events 
	// Returns the array
	function getEvents ($requestedTypeId, $requestedTimePeriodInHour)
	{
		$url = 'http://172.22.238.237:9000/events';
		$data = array('typeID' => $requestedTypeId, 'timePeriodInHour' => $requestedTimePeriodInHour);
		$postdata = http_build_query($data);
		
		// use key 'http' even if you send the request to https://...
		$options = array('http' => array(
			'method'  => 'POST',
			'header' => 'Content-type: application/x-www-form-urlencoded\r\n',
			'content' => $postdata
		));
		$context  = stream_context_create($options);
		$result = file_get_contents($url, false, $context);
		//echo 'var_dump: ';
		//var_dump($result);
		
		$eventArray = json_decode($result, true);
		
		//Sample JSON:
		//{"error":0,"events":[{"id":55,"eventType":"Dengue","priority":1,"callingTime":1411106400000,"postalCode":"11111","location":"SouthWest","callerPhone":"111","description":"Dengue again and again. "},{"id":44,"eventType":"Dengue","priority":1,"callingTime":1411102800000,"postalCode":"11111","location":"SouthWest","callerPhone":"111","description":"Dengue again"},{"id":11,"eventType":"Dengue","priority":1,"callingTime":1411099200000,"postalCode":"11111","location":"SouthWest","callerPhone":"111","description":"Dengue here"}]}
	
		if ($eventArray['error']!=0) {
			echo ('error in server response');
			return null;
		} else {
			return $eventArray;
		};
		
		
	}
 ?>