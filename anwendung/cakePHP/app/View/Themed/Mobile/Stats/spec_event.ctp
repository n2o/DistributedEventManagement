<article>
	<h1>Statistics</h1>
	<p>
		Here are all event specific columns with the appropiate values of the users. They are all summed up over their occurences in the database to see, how many users have added the same values. So they are comparable and worth plotting a chart.
		<br><br>
		<?php 
			echo $this->element('statsShowSpecEventProperties');
		?>
	</p>
</article>
<article>
	<h1>Charts</h1>
	<p>
		<?php 
		foreach ($dataCharts as $column => $value)
			echo $this->element('statsShowSpecEventButtons', array('column' => $column));
		?>
	</p>
</article>

<?php 
foreach ($dataCharts as $column => $value)
	echo $this->element('createColumnChart', array('column' => $column, 'stats' => $value, 'type' => 'Occurences'));
?>