<article>
	<h1>Statistics</h1>
	<p>
		<table>
			<tr>
				<td>Total Users:</td>
				<td><?php echo $stats['users']; ?></td>
			</tr>
			<tr>
				<td>Total Events:</td>
				<td><?php echo $stats['events']; ?></td>
			</tr>
		</table>

		<a href="#" class="slide_div button" rel="#eventsUsersDiv">Toggle Chart</a><br />
		<div id="eventsUsersDiv" class="slidingDiv">
			<div id="eventsUsersChart"></div>
		</div> 
	</p>
</article>

<!-- JavaScript Section -->
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
	google.load("visualization", "1", {packages:["corechart"]});
	google.setOnLoadCallback(drawChart);
	
	function drawChart() {
		var data = google.visualization.arrayToDataTable([
			['Event', 'Users'],<?php foreach ($eventsUsers as $key => $value) echo "['$key', $value],"; ?>
		]);

		var options = {
			title: 'See how many of the total users are assigned to the events',
			height: 400,
			width: window.innerWidth-200,
			colors: ['#9D0D16']
		};

		var chart = new google.visualization.ColumnChart(document.getElementById('eventsUsersChart'));
		chart.draw(data, options);
	}
</script>