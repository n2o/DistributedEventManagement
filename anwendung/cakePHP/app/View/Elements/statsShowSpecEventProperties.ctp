<?php 
/**
 * Show table for event specific stats
 */
 ?>
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