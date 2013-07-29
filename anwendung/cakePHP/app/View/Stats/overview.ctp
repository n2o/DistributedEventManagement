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
		<div id="eventsUsers" style="width: 700px; height: 400px;"></div>
	</p>
</article>

<!-- JavaScript Section -->
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
	google.load("visualization", "1", {packages:["corechart"]});
	google.setOnLoadCallback(drawChart);
	function drawChart() {
		var data = google.visualization.arrayToDataTable([
			['Event', 0],
			<?php foreach ($eventsUsers as $key => $value) echo "['$key', $value],"; ?>
		]);

		var options = {
			title: 'See how many of the total users are assigned to the events'
		};

		var chart = new google.visualization.PieChart(document.getElementById('eventsUsers'));
		chart.draw(data, options);
	}
</script>