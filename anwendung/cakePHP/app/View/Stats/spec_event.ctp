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
					echo $this->element('createColumnChart');
					#if (count($value) > 1)
						# print chart
				}
			?>
		</table>
	</p>
</article>