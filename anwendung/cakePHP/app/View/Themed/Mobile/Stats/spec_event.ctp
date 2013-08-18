<script type="text/javascript" src="https://www.google.com/jsapi"></script>

<div data-role="header">
	<a href="#" data-rel="back" data-role="button" data-inline="true" data-icon="arrow-l">Back</a>
	<h1>Statistics</h1>
</div>
<div data-role="content">
	<article>
		<h1>Statistics</h1>
		<p>
			Here are all event specific columns with the appropiate values of the users. They are all summed up over their occurences in the database to see, how many users have added the same values. So they are comparable and worth plotting a chart.
			<br><br>
			<?php 
			#	echo $this->element('statsShowSpecEventProperties');
			?>
		</p>
	</article>

	<article>
		<h1>Charts</h1>
		<p>
			<?php 
			if (sizeof($dataCharts) > 0) {
				foreach ($dataCharts as $column => $value)
					echo "<div id='".$column."Chart'></div>";	
			} else {
				echo "No data charts available.";
			}
			
			?>
		</p>
	</article>
</div>

<?php 
foreach ($dataCharts as $column => $value)
	#echo $this->element('createColumnChart', array('column' => $column, 'stats' => $value, 'type' => 'Occurences'));
?>