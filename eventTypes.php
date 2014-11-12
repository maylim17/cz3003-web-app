<?php
function getEventTypes(){
//$eventTypes = '{"error":0,"eventTypes":[{"id":1,"name":"Dengue"},{"id":2,"name":"Gas Leak"},{"id":3,"name":"Traffic Accident"}]}';
$url = "http://172.22.238.237:9000/getEventTypes";

$result = file_get_contents($url);
//echo $result;
$decoded = json_decode($result, TRUE);
//var_dump($decoded);

return $decoded;
}
  
/*function getEventTypesTest() {

	$eventTypes = array (
		'error'=> 0,
		'eventTypes'=> array (
			0=> array (
				'id'=>1,
				'name'=>"Dengue",
				),
			1=> array (
				'id'=>1,
				'name'=>"Gas Leak",
				),
			2=> array (
				'id'=>1,
				'name'=>"Traffic Accident",
				),
			3=> array (
				'id'=>1,
				'name'=>"Fire",
				),
			),
		);
		
	return $eventTypes;

}*/

 
?>