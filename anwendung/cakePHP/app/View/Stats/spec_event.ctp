<article>
	<h1>Statistics</h1>
	<p>
		Here are all event specific columns with the appropiate values of the users. They are all summed up over their occurences in the database to see, how many users have added the same values. So they are comparable.
		<br><br>
		<table>
			<thead>
				<th>Column</th>
				<th>Value</th>
				<th>Occurences</th>
			</thead>
			<?php 
				foreach ($stats as $column => $value) {
					foreach ($value as $type => $sum) {
						echo "<tr>";
						echo "<td>$column</td>";
						echo "<td>$type</td>";
						echo "<td>$sum</td>";
						echo "</tr>";
						$column = "";
					}
				}
			?>
		</table>
	</p>
</article>
<article>
	<h1>Charts</h1>
	<p>
		<?php foreach ($dataCharts as $column => $value) {
			echo "
				<a href='#' class='slide_div button' rel='#".$column."Div'>$column Chart</a><br>
				<div id='".$column."Div' class='slidingDiv'>
					<div id='".$column."Chart'></div>
				</div>";

		}
		?>
	</p>
</article>
<?php 
foreach ($dataCharts as $column => $value)
	echo $this->element('createColumnChart', array('title' => $column, 'stats' => $value));
?>