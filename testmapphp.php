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
							$typeID = 0;
							break;
					}
					if ($typeID!=0) {
						$events = getTestEvents($typeID, 24);	// for testing
						//getEvents($typeID, 24);
						//var_dump($events);
					}
				} else {
          $events = 'weather';  
          include 'weather.php';
          $weatherData = getWeather();
        }
			?>	
			
			</div>
			
          <br><br>
		  
<script type="text/javascript">
    
  var map;
  var infowindow;
  var coordinates;
  var myOptions;
  var events;
  var addrmap = new Object();
  var denguemap = new Object();
  var iterations = 0;
  var postalcodestring;
  var eventType;


  var weathermap = new Object();
  weathermap["ANG MO KIO"] = {lat: 1.369929, lng: 103.848983};
  weathermap["BEDOK"] = {lat: 1.324140, lng: 103.930041};
  weathermap["BISHAN"] = {lat: 1.351142, lng: 103.848215};
  weathermap["BUKIT BATOK"] = {lat: 1.348876, lng: 103.749246};
  weathermap["BUKIT PANJANG"] = {lat: 1.378450, lng: 103.763582};
  weathermap["BUKIT TIMAH"] = {lat: 1.352553, lng: 103.783333};
  weathermap["CHANGI"] = {lat: 1.364758, lng: 103.991477};
  weathermap["CHOA CHU KANG"] = {lat: 1.385723, lng: 103.744186};
  weathermap["CITY"] = {lat: 1.304533, lng: 103.832440};
  weathermap["CLEMENTI"] = {lat: 1.315554, lng: 103.765276};
  weathermap["CHAI CHEE"] = {lat: 1.332181, lng: 103.922162};
  weathermap["HOLLAND VILLAGE"] = {lat: 1.312111, lng: 103.796316};
  weathermap["HOUGANG"] = {lat: 1.371222, lng: 103.892405};
  weathermap["JURONG INDUSTRIAL ESTATE"] = {lat: 1.303308, lng: 103.655834};
  weathermap["JURONG EAST/WEST"] = {lat: 1.306951, lng: 103.733508};
  weathermap["KALLANG"] = {lat: 1.311807, lng: 103.871442};
  weathermap["KATONG"] = {lat: 1.303881, lng: 103.901270};
  weathermap["KRANJI"] = {lat: 1.425225, lng: 103.761863};
  weathermap["LIM CHU KANG"] = {lat: 1.428526, lng: 103.710610};
  weathermap["MACPHERSON"] = {lat: 1.326645, lng: 103.890008};
  weathermap["MACRITCHIE RESERVOIR"] = {lat: 1.346072, lng: 103.822425};
  weathermap["MARINE PARADE"] = {lat: 1.302089, lng: 103.897494};
  weathermap["PANDAN"] = {lat: 1.312109, lng: 103.753165};
  weathermap["PASIR PANJANG"] = {lat: 1.276194, lng: 103.791379};
  weathermap["PASIR RIS"] = {lat: 1.372534, lng: 103.949527};
  weathermap["PUNGGOL"] = {lat: 1.404657, lng: 103.902351};
  weathermap["PEIRCE RESERVOIR"] = {lat: 1.371132, lng: 103.823223};
  weathermap["PULAU TEKONG"] = {lat: 1.416271, lng: 104.038282};
  weathermap["PULAU UBIN"] = {lat: 1.414556, lng: 103.958059};
  weathermap["JURONG ISLAND"] = {lat: 1.280684, lng: 103.676855};
  weathermap["QUEENSTOWN"] = {lat: 1.294879, lng: 103.787040};
  weathermap["SELETAR"] = {lat: 1.418671, lng: 103.865764};
  weathermap["SEMBAWANG"] = {lat: 1.448977, lng: 103.820002};
  weathermap["SENTOSA"] = {lat: 1.249363, lng: 103.830517};
  weathermap["SERANGOON"] = {lat: 1.349307, lng: 103.873582};
  weathermap["SIMEI"] = {lat: 1.343238, lng: 103.953357};
  weathermap["SOUTHERN ISLAND"] = {lat: 1.222971, lng: 103.854236};
  weathermap["TAMPINES"] = {lat: 1.353108, lng: 103.945261};
  weathermap["TOA PAYOH"] = {lat: 1.332740, lng: 103.847820};
  weathermap["TUAS"] = {lat: 1.294871, lng: 103.630793};
  weathermap["TELOK BLANGAH"] = {lat: 1.270610, lng: 103.809742};
  weathermap["UPPER BUKIT TIMAH"] = {lat: 1.361048, lng: 103.770974};
  weathermap["WEST COAST"] = {lat: 1.289898, lng: 103.769553};
  weathermap["WOODLANDS"] = {lat: 1.437056, lng: 103.786463};
  weathermap["YISHUN"] = {lat: 1.429415, lng: 103.835225};


  // events = [
  //   {address: 'Singapore 320115', priority: 1}, 
  //   {address: 'Singapore 639798', priority: 2}
  // ];

  // var weatherData = [
  //   {location: 'ANG MO KIO', weather: 'Fair (Day)'}, 
  //   {location: 'CITY', weather: 'Fair (Night)'}, 
  //   {location: 'WEST COAST', weather: 'Passing Showers'}, 
  //   {location: 'YISHUN', weather: 'Hazy'}, 
  //   {location: 'CHANGI', weather: 'Windy'}, 
  //   {location: 'PUNGGOL', weather: 'Rain'}, 
  //   {location: 'KRANJI', weather: 'Thundery Showers'}, 
  //   {location: 'WOODLANDS', weather: 'Showers'}, 
  //   {location: 'SIMEI', weather: 'Cloudy'}, 
  //   {location: 'TAMPINES', weather: 'Partly Cloudy'}
  // ];


  // Initialize the map on document ready
  $(document).ready(function () {
    myOptions = {
        zoom: 12,
        center: { lat: 1.371232, lng: 103.818948},
        mapTypeId: 'terrain'
    };
    map = new google.maps.Map($('#map-canvas')[0], myOptions);
  
  var eventsData = <?php echo json_encode($events) ;?>;
  var weatherData = <?php echo json_encode($weatherData); ?>;
  //console.log(eventsData);
  if (eventsData!='weather') {
    geocodePoints(eventsData);
  } else {
    populateWeatherMarkers(weatherData);
    //geocodeWeather(weatherData);
  }
      
  });


  // alert(JSON.stringify(inputArray)); //works
  // alert(inputArray.error); //works
  // alert(inputArray.events["1"]["location"]); //works

  
  // Geocode addresses of all points to be displayed to obtain coordinates
  function geocodePoints (eventsData) {

    events = eventsData;
    eventType = eventsData.events[0]["eventType"];

    if (eventType == "Dengue")
      events = calculateDengueCases(eventsData);

	//alert(events.events[0]["postalCode"]);//["location"]); //works
    for (var x = 0; x < events.events.length; x++) {
      var p;
      var latlng;

      if (eventType == "Dengue")
        postalcodestring = "Singapore " + events[x]["postalCode"];
      else 
        postalcodestring = "Singapore " + events.events[x]["postalCode"];

      $.getJSON('http://maps.googleapis.com/maps/api/geocode/json?address='+postalcodestring+'&sensor=false', null, function (data) {
        p = data.results[0].geometry.location 
        latlng = new google.maps.LatLng(p.lat, p.lng);
        addrmap[data.results[0].formatted_address] = latlng;
        iterations++;
        if (iterations == events.events.length) {
          populateCrisisMarkers();
        }
      });
    }
  }

  function calculateDengueCases (eventsData) {

    // var dengueArray = new Object();

    // for (var x = 0; x < eventsData.events.length; x++) {
    //   var postal = eventsData.events[x]["postalCode"]
    //   if (dengueArray[postal] == null)
    //     dengueArray[postal] = 0;
    //   else
    //     dengueArray[postal]++;
    // }
  }


  // Populate the map display with all the crisis markers
  function populateCrisisMarkers () {
    for (var x = 0; x < events.events.length; x++) {
            createCrisisMarker(x);
    }
  }


  // Create each crisis marker and add an infowindow listener 
  function createCrisisMarker (index) {
    markerPostalCode = "Singapore "+events.events[index]["postalCode"];
    console.log (markerPostalCode);
    // extract latlng coordinates
    coordinates = addrmap[markerPostalCode];
    console.log(coordinates);

    // create marker object
    var marker = new google.maps.Marker({
      position: coordinates,
      map: map
    });

    // set the content string for the info window (address, description, priority)
    var contentString = "No data..";
    if (events.events[index]["priority"]==1)
      contentString = "<p><b>" + markerPostalCode + "</b><br />" + events.events[index]["description"] + "<br />Severity: Mild</p>";
    else if  (events[index]["priority"]==2)
      contentString = "<p><b>" + markerPostalCode + "</b><br />" + events.events[index]["description"] + "<br />Severity: Urgent</p>";
    else if  (events[index]["priority"]==3)
      contentString = "<p><b>" + markerPostalCode + "</b><br />" + events.events[index]["description"] + "<br />Severity: Critical</p>";
    else
      contentString = "<p><b>" + markerPostalCode + "</b><br />" + events.events[index]["description"] + "<br />Severity: No data..</p>";
    
    console.log(contentString);
    
    // add click event listener to marker which opens infowindow          
    google.maps.event.addListener(marker, 'click', function() {
      if (infowindow) infowindow.close();
      infowindow = new google.maps.InfoWindow({content: contentString});
      infowindow.open(map,marker); 
    });

  }



  // Populate the map display with all the weather markers
  function populateWeatherMarkers (weatherData) {
    events = weatherData;
    console.log(events.length);
    for (var x = 0; x < events.length; x++) {
            createWeatherMarker(x);
    }
  }


  // Create each weather marker w custom icon, and add an infowindow listener 
  function createWeatherMarker (index) {
 
    // extract latlng coordinates
    var place = events[index]["location"];
    //place = place.replace(/\s+/g, ""); 
    var point = weathermap[place];
    console.log(place);
    console.log(point);
    var coord = new google.maps.LatLng(point.lat, point.lng);
    var weather = events[index]["weather"];

    var temp = weather.replace(/\s+/g, ""); // remove whitespace characters 
    temp = temp.replace(/[()]/g,""); // remove "(" and ")"
    var iconurl = 'http://localhost:8888/weather/' + temp.toLowerCase() + '.png';

    // create marker object
    var marker = new google.maps.Marker({
      position: coord,
      icon: iconurl,
      map: map
    });

    // set the content string for the info window (address, description, priority)
    var contentString = "No data..";
    contentString = "<p><b>" + place + "</b><br />" + weather + "</p>";

    // if (events[index]["condition"] == "Fair (Day)") 
    //   contentString = "<p><b>" + place + "</b><br />Fair (Day)</p>";
    // else if (events[index]["condition"] == "Fair (Night)")
    //   contentString = "<p><b>" + place + "</b><br />Fair (Night)</p>";
    // else if (events[index]["condition"] == "Partly Cloudy")
    //   contentString = "<p><b>" + place + "</b><br />Partly Cloudy</p>";
    // else if (events[index]["condition"] == "Cloudy")
    //   contentString = "<p><b>" + place + "</b><br />Cloudy</p>";

    console.log(contentString);
    
    // add click event listener to marker which opens infowindow          
    google.maps.event.addListener(marker, 'click', function() {
      if (infowindow) infowindow.close();
      infowindow = new google.maps.InfoWindow({content: contentString});
      infowindow.open(map,marker); 
    });

  }

</script>



		  
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