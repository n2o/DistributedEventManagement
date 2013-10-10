<?php 
/**
 * Create column charts for each entry in event_properties with a minimum of two different values
 * @param String $column: Specify which column should be part of the chart
 * @param Array  $stats:  Array with value => occurences for the chart data
 * @param String $title:  If not set use column name as chart name 
 * @param String $type:   Spec. which text should be shown in the legend
 */
 ?>
<script type="text/javascript">
	google.load("visualization", "1", {packages:["corechart"]});
	google.setOnLoadCallback(drawChart);
	
	function drawChart() {
		var type = <?php echo "'".$type."'"; ?>;

		var data = google.visualization.arrayToDataTable([
			['Value', type],<?php foreach ($stats as $key => $value) echo "['$key', $value],"; ?>
		]);

		<?php 
		if (!isset($title))
			echo "var title = '".$column."';";
		else
			echo "var title = '".$title."'";
		?>

		var options = {
			title: title,
			height: 400,
			width: window.innerWidth-200,
			colors: ['#9D0D16'],
			vAxis: {minValue: 0, maxValue: 4, gridline:{count: 6}}
		};

		var chart = new google.visualization.ColumnChart(document.getElementById(<?php echo "'".$column."Chart'"; ?>));
		chart.draw(data, options);
	}
</script>