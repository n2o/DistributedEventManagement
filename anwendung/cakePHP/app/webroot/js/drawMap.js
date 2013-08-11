function drawMap(position) {
	var mapcanvas = document.createElement('div');
	mapcanvas.id = 'map';
	mapcanvas.style.height = '600px';
	mapcanvas.style.width = '100%';

	document.querySelector('article').appendChild(mapcanvas);

	var coords = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);

	var options = {
		zoom: 15,
		center: coords,
		navigationControlOptions: {
			style: google.maps.NavigationControlStyle.SMALL
		},
		mapTypeId: google.maps.MapTypeId.ROADMAP
	};
	var map = new google.maps.Map(document.getElementById("map"), options);

	var marker = new google.maps.Marker({
		position: coords,
		map: map,
		title:"You are here!",
		icon: '//maps.gstatic.com/mapfiles/ms2/micons/green-dot.png',
		animation: google.maps.Animation.DROP
	});
}

if (navigator.geolocation) {
	navigator.geolocation.getCurrentPosition(drawMap);
} else {
	error('Geo Location is not supported');
}