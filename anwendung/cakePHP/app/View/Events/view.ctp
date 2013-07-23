<article>
	<h1>Details for event</h1>
	<p>
		<?php 
			foreach($columns_event as $column) {
				if ($column == "user_id") {
					echo "<strong>Created by</strong><br />";
					echo $username;
				} else {
					echo "<strong>".ucfirst($column)."</strong><br />";
					echo $event['Event'][$column];
				}
				echo "<br /><br />";
			}
		?>
	</p>
</article>
<article>
	<p><h2>Users</h2>
		<table>
			<tr>
				<?php
					# Get all relevant column names and prepare a good view
					$columns = array();
					$i = 0;
					foreach($columns_user as $column) {
						if ($column != "password"&&$column != "has_login") {	# Exlude some columns
							echo "<th>".ucfirst($column)."</th>";
							$columns[$i++] = $column;

							if ($i > 6)	# break after $i elements in the heading
								break;
						}
					}
				?>
			</tr>
				<?php
					$j = 0;
					for ($i = 0; $i < count($users); $i = $i + 1) {
						echo "<tr>";
						foreach ($columns as $column)
							echo "<td>".$users[$i]['users'][$column]."</td>";
						echo "</tr>";
					}
				?>
		</table>
	</p>
</article>