<!DOCTYPE html>

<html>
  <head>
    <style type="text/css">
      html, body { height: 100%; margin: 0; padding: 0; font-family: "Calibri";} 

      .block { float: left;}

      #user-input { position: relative; height: 100%; width: 20%;}

      #options { position: absolute; top: 5%; left: 10%;}

      .form {}

      #map-canvas { height: 100%; width: 80%; margin: 0; padding: 0; }

    </style>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script type="text/javascript"
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC-ZJTx4_Nc8kpK1rlErHiWVGjSxU1Sj14">
    </script>

    <!--
	<script type="text/javascript">
      function initialize() {
        var mapOptions = {
          center: { lat: 1.371232, lng: 103.802948},
          zoom: 12
        };
        var map = new google.maps.Map(document.getElementById('map-canvas'),
            mapOptions);
      }
      google.maps.event.addDomListener(window, 'load', initialize);
    </script>
	-->
<!-- 
@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ 
-->
<!--
    <script>
var gmap = new google.maps.Map(document.getElementById('map-canvas'), {
  disableDefaultUI: true,
  keyboardShortcuts: false,
  draggable: false,
  disableDoubleClickZoom: true,
  scrollwheel: false,
  streetViewControl: false
});

var view = new ol.View({
  // make sure the view doesn't go beyond the 22 zoom levels of Google Maps
  maxZoom: 21
});
view.on('change:center', function() {
  var center = ol.proj.transform(view.getCenter(), 'EPSG:3857', 'EPSG:4326');
  gmap.setCenter(new google.maps.LatLng(center[1], center[0]));
});
view.on('change:resolution', function() {
  gmap.setZoom(view.getZoom());
});

var vector = new ol.layer.Vector({
  source: new ol.source.GeoJSON({
    url: 'data/geojson/countries.geojson',
    projection: 'EPSG:3857'
  }),
  style: new ol.style.Style({
    fill: new ol.style.Fill({
      color: 'rgba(255, 255, 255, 0.6)'
    }),
    stroke: new ol.style.Stroke({
      color: '#319FD3',
      width: 1
    })
  })
});

var olMapDiv = document.getElementById('olmap');
var map = new ol.Map({
  layers: [vector],
  interactions: ol.interaction.defaults({
    altShiftDragRotate: false,
    dragPan: false,
    rotate: false
  }).extend([new ol.interaction.DragPan({kinetic: null})]),
  target: olMapDiv,
  view: view
});
view.setCenter([0, 0]);
view.setZoom(1);

olMapDiv.parentNode.removeChild(olMapDiv);
gmap.controls[google.maps.ControlPosition.TOP_LEFT].push(olMapDiv);
    </script>
<!-- 
@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@	
@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ 
-->

<script type="text/javascript">
    
  var map;
  var infowindow;
  var coordinates;
  var myOptions;
  var events;
  var addrmap = new Object();
  var iterations = 0;


  // events = [
  //   {address: 'Singapore 320115', priority: 1}, 
  //   {address: 'Singapore 639798', priority: 2}
  // ];


  // Initialize the map on document ready
  $(document).ready(function () {
    myOptions = {
        zoom: 12,
        center: { lat: 1.371232, lng: 103.818948},
        mapTypeId: 'terrain'
    };
    map = new google.maps.Map($('#map_canvas')[0], myOptions);
  });


  // alert(JSON.stringify(inputArray)); //works
  // alert(inputArray.error); //works
  // alert(inputArray.events["1"]["location"]); //works

  
  // Geocode addresses of all points to be displayed to obtain coordinates
  function geocodePoints (eventsData) {

    events = eventsData;

    for (var x = 0; x < events.length; x++) {
          
      var p;
      var latlng;

      $.getJSON('http://maps.googleapis.com/maps/api/geocode/json?address='+events[x].address+'&sensor=false', null, function (data) {
        p = data.results[0].geometry.location 
        latlng = new google.maps.LatLng(p.lat, p.lng);
        addrmap[data.results[0].formatted_address] = latlng;

        iterations++;
        if (iterations == events.length) {
          populateWithMarkers();
        }
      });

    }
  }


  // Populate the map display with all the markers
  function populateWithMarkers () {
    for (var x = 0; x < events.length; x++) {
            createMarker(x);
    }
  }


  // Create each marker and add an infowindow listener 
  function createMarker (index) {

    // extract latlng coordinates
    coordinates = addrmap[events[index].address];

    // create marker object
    var marker = new google.maps.Marker({
      position: coordinates,
      map: map
    });

    // set the content string for the info window (address, description, priority)
    var contentString = "No data..";
    if (events[index].priority==1)
      contentString = "<p><b>" + events[index].address + "</b><br />" + events[index].description + "<br />Severity: Mild</p>";
    else if  (events[index].priority==2)
      contentString = "<p><b>" + events[index].address + "</b><br />" + events[index].description + "<br />Severity: Urgent</p>";
    else if  (events[index].priority==3)
      contentString = "<p><b>" + events[index].address + "</b><br />" + events[index].description + "<br />Severity: Critical</p>";
    else
      contentString = "<p><b>" + events[index].address + "</b><br />" + events[index].description + "<br />Severity: No data..</p>";

    // add click event listener to marker which opens infowindow          
    google.maps.event.addListener(marker, 'click', function() {
      if (infowindow) infowindow.close();
      infowindow = new google.maps.InfoWindow({content: contentString});
      infowindow.open(map,marker); 
    });

  }
    
</script>


  </head>
  <body>
      <div class="block" id="user-input">
        <div id="box">
        <div id="options">
          
		  <!--
          <div id="crisis-type">	
            Please select crisis type(s):
            <form class="form"> 
              <input type="radio" name="type" value="Weather"/>Weather<br>
              <input type="radio" name="type" value="Dengue">Dengue Fever<br>
              <input type="radio" name="type" value="Fire">Fire Outbreak<br>
              <input type="radio" name="type" value="Gas">Gas Leakage
            </form>
          </div>
			-->
			<div id="crisis-type">	
			<?php 
				if (!isset($_POST['type']) || $_POST['type']=='Weather') {
					echo "Displaying Weather Map.";
				} else {
					echo "Displaying ",$_POST['type'], " cases in the last 24 hours.";
				};
				
			?>
            <br>
			<br>
			Please select crisis type:<br>
            <form action = "testmapphp.php" method="POST">
			  <input type="radio" name="type" value="Weather" >Weather<br>
              <input type="radio" name="type" value="Dengue">Dengue Fever<br>
              <input type="radio" name="type" value="Gas">Gas Leakage<br>
			  <input type="radio" name="type" value="Traffic">Traffic Accident<br>
			  <!--<input type="radio" name="type" value="Fire">Fire Outbreak<br>-->
			  <input type="submit" name="submission" value="Submit"<br>
			</form><br>
            
			<?php
				if (isset($_POST['type']) && $_POST['type']!='Weather') {
					$type = $_POST['type'];
			
					include	 'events.php';
         /* $eventTypes = getEventTypes ();
          $typeID = 0;
          $typeID = eventTypes['eventTypes'][$type];*/
					
					switch ($type) {
						case 'Dengue':
							$typeID = 1;
							break;
						case 'Gas':
							$typeID = 2;
							break;
						case 'Traffic':
							$typeID = 3;
							break;
						default:
							break;
					}
					if ($typeID!=0) {
						$events = getTestEvents($typeID, 24);	// for testing
						//getEvents($typeID, 24);
						var_dump($events);
					//	echo '<script type="text/javascript">', 'populateWithMarkers();', '</script>';
					}
				}
			?>	
			
			<script type="text/javascript">
			var eventsData = <?php echo json_encode($events) ?>;
			geocodePoints(eventsData);
			</script>
			
			</div>
			
          <br><br>
		  

		  
<!--
          <div id="crisis-region">
            Please select region(s):
            <form class="form">
              <input type="checkbox" name="region" value="North">North<br>
              <input type="checkbox" name="region" value="South">South<br>
              <input type="checkbox" name="region" value="Central">Central<br>
              <input type="checkbox" name="region" value="East">East<br>
              <input type="checkbox" name="region" value="West">West
            </form>
          </div>
-->
        </div>
        </div>
      </div>
      <div class="block" id="map-canvas"></div>
  </body>
</html>