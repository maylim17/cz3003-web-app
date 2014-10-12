<?php
	
	function getWeather() {
		
		$src = new DOMDocument('1.0', 'utf-8');
		$src->formatOutput = true;
		$src->preserveWhiteSpace = false;
		$content = file_get_contents("http://app2.nea.gov.sg/weather-climate/forecasts/3-hour-nowcast");
		@$src->loadHTML($content);
		$xpath = new DOMXPath($src);

		$values=$xpath->query('//td');
		$weatherData = array();
		
		for ($i=0;$i<90;$i++){
			$area = $values->item($i)->nodeValue;
	//		echo $area;
			$weatherData[] = array (
				"location" => [$area],
				"weather" =>  $values->item($i+1)->nodeValue,
			);
			$i++;	
		}
	//	print_r($weatherData);
	//	var_dump($weatherData);
	return ($weatherData);
	}
?>