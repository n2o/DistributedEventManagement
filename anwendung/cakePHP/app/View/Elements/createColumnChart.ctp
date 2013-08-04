<?php 
/**
 * Create column charts for each entry in event_properties with a minimum of two different values
 */
 ?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
	google.load("visualization", "1", {packages:["corechart"]});
	google.setOnLoadCallback(drawChart);
	
	function drawChart() {
		var data = google.visualization.arrayToDataTable([
			['Value', 'Occurences'],<?php foreach ($stats as $key => $value) echo "['$key', $value],"; ?>
		]);

		var options = {
			title: <?php echo "'".$title."'"; ?>,
			height: 400,
			width: window.innerWidth-200,
			colors: ['#9D0D16']
		};

		var chart = new google.visualization.ColumnChart(document.getElementById(<?php echo "'".$title."Chart'"; ?>));
		chart.draw(data, options);
	}
</script>