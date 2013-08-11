$(function() {
		// Display the map on top
		$('#map').addClass('active');

		// Switch between distances and map
		$('.switchInfo').on('click',function() {
			$('section').toggleClass('active');
		});

		var latitude, longitude;

		// parameter position returns js object with current position
		navigator.geolocation.getCurrentPosition(function(position) {
			latitude = position.coords.latitude;
			longitude = position.coords.longitude;
			// create JSON object
			var options = {
				zoom: 17,
				center: new google.maps.LatLng(latitude,longitude),
				mapType: google.maps.MapTypeId.ROADMAP
			};

			map = new google.maps.Map($('#map')[0],options);

			// Get other positions from JSON file
			$.getJSON('json/positions.json', function(json) {
				// goes through each entry in json file and creates a new marker
				$.each(json,function(name,values) {

					$('#overlay_map').find('ul').append('<li>'+name+': <span>'+calcDistance(latitude,longitude,values.Position.Latitude,values.Position.Longitude)+'</span></li>');

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
			$('#ownPosition').html('Latitude: '+latitude+'<br/>Longitude: '+longitude);

			// Mark own position on map
			marker = new google.maps.Marker({
				map: map,
				position: new google.maps.LatLng(
					latitude,
					longitude
				),
				title: 'You are here!',
				icon: '//maps.gstatic.com/mapfiles/ms2/micons/green-dot.png',
				animation: google.maps.Animation.DROP
			});

			// Add an info window when you click on a marker
			marker.info = new google.maps.InfoWindow({
				content: "You are here!"
			});
			google.maps.event.addListener(marker, 'click', function() {
				marker.info.open(map, marker);
			});
		});
	});