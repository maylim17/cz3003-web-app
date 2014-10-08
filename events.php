<?php
	/*
	echo 'hi';
	if (isset($_POST['type'])) {
		echo 'hi';
		if (isset($_POST['type'])) {
			echo "You have selected ",$_POST['type'];
		}
	}		
	//getEvents(1	,1);
	*/
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
		return $sampleArray;
		//return parseArray($sampleArray);
	}
	
	//Parse the array of a specific event type.
	//Currently not in use.
	function parseArray ($eventArray) {
	
		$NorthWest = 0;
		$SouthWest = 0;
		$NorthEast = 0;
		$SouthEast = 0;
		$CentralSingapore = 0;
		
		foreach ($eventArray['events'] as $element) {
			switch ($element['location']) {
				case 'NorthWest':
					$NorthWest++;
					break;
				case 'SouthWest':
					$SouthWest++;
					break;
				case 'NorthEast':
					$NorthEast++;
					break;
				case 'SouthEast':
					$SouthEast++;
					break;
				case 'CentralSingapore':
					$CentralSingapore++;
					break;
			}		
		}
		
		echo ("N,S,E,W,C:\n");
		echo $NorthWest,' ',$NorthEast,' ',$SouthEast,' ',$SouthWest,' ',$CentralSingapore	;
		
		
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

	// Connects to server and retrieves events 
	// Returns the array
	function getEvents ($requestedTypeId, $requestedTimePeriodInHour)
	{
		$url = 'http://172.22.245.232:9000/events';
		$data = array('typeID' => $requestedTypeId, 'timePeriodInHour' => $requestedTimePeriodInHour);
		//$data = array('typeID' => 1, 'timePeriodInHour' => 1);
		$postdata = http_build_query($data);
		
		// use key 'http' even if you send the request to https://...
		$options = array('http' => array(
			'method'  => 'POST',
			'header' => 'Content-type: application/x-www-form-urlencoded\r\n',
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
		
		
		if ($eventArray['error']!=0) {
			echo ('error in server response');
			return null;
		} else {
			return $eventArray;
		};
		
		//parseArray($eventArray);
	
	}
	
	
 ?>