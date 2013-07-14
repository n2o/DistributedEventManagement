<div data-role="header">
	<!--<a data-icon="grid" class="menu-trigger">Menu</a>-->
	<a href="#nav" data-role="button" data-inline="true" data-icon="bars">Menu</a>
	<h1>Where are my friends?</h1>
	<button>Toggle</button>
</div>
<div class="body" data-role="content">

	<section id="map"></section>
	<section id="overlay_map">
		<strong>Distances</strong>
		<ul></ul>
	</section>

	<!-- Include Google Maps API -->
	<script src="http://maps.googleapis.com/maps/api/js?sensor=true"></script>
	<script>
	$(function() {
		// Display the map on top
		$('#map').addClass('active');

		// Switch between distances and map
		$('button').on('click',function() {
			$('section').toggleClass('active');
		});

		var latitude, longitude;

		// parameter position returns js object with current position
		navigator.geolocation.getCurrentPosition(function(position) {
			latitude = position.coords.latitude;
			longitude = position.coords.longitude;

			// create JSON object
			var options = {
				zoom: 13,
				center: new google.maps.LatLng(latitude,longitude),
				mapType: google.maps.MapTypeId.ROADMAP
			};

			map = new google.maps.Map($('#map')[0],options);

			var getDistance = function(myLat, myLong, otherLat, otherLong) {
				radius = 6371; 	// radius of earth in km

				// convert all latitudes and longitudes to degrees
				myLat = myLat * (Math.PI/180);
				myLong = myLong * (Math.PI/180);
				otherLat = otherLat * (Math.PI/180);
				otherLong = otherLong * (Math.PI/180);

				// convert latitude and longitude to x,y coords
				x0 = myLat * radius * Math.cos(myLat);
				y0 = myLong * radius;
				x1 = otherLat * radius * Math.cos(otherLat);
				y1 = otherLong * radius;

				dx = x0 - x1;
				dy = y0 - y1;

				// pythagorean theorem for the distance d between two points
				d = Math.sqrt((dx*dx) + (dy*dy));

				if (d < 1)
					return Math.round(d*1000)+" m";
				else
					return Math.round(d*10)/10+" km";
			};

			// Mark own position on map
			marker = new google.maps.Marker({
				map: map,
				position: new google.maps.LatLng(
					latitude,
					longitude
				),
				animation: google.maps.Animation.DROP
			});

			// Get other positions from JSON file
			$.getJSON('json/positions.json', function(json) {
				// goes through each entry in json file and creates a new marker
				$.each(json,function(name,values) {

					$('#overlay_map').find('ul').append('<li>'+name+': <span>'+getDistance(latitude,longitude,values.Position.Latitude,values.Position.Longitude)+'</span></li>');

					marker = new google.maps.Marker({
						map: map,
						position: new google.maps.LatLng(
							values.Position.Latitude,
							values.Position.Longitude
						),
						animation: google.maps.Animation.DROP
					});
				});
			});
		});
	});
	</script>
</div>