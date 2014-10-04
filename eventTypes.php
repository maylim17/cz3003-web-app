<?php
  $eventTypes = '{"error":0,"eventTypes":[{"id":1,"name":"Dengue"},{"id":2,"name":"Gas Leak"},{"id":3,"name":"Traffic Accident"}]}';
  $decoded = json_decode($eventTypes, TRUE);
  if (is_null($decoded)) {
    /*$response['status'] = array(
      'type' => 'error',
      'value' => 'Invalid JSON value found',
    );
    $response['request'] = $eventTypes;*/
    $response = array($eventTypes);
  }
  else {
    /*$response['status'] = array(
      'type' => 'message',
      'value' => 'Valid JSON value found',
    );
    //Send the original message back.
    $response['request'] = $decoded;*/
    $response = $decoded;
  }

$encoded = json_encode($response);
header('Content-type: application/json');
exit($encoded);