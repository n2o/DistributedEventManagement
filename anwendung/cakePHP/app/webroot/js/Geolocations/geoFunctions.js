function calcDistance(myLat, myLong, otherLat, otherLong) {
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