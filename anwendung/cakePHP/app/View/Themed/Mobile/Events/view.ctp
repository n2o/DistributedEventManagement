<div data-role="header">
	<a href="#" data-rel="back" data-role="button" data-inline="true" data-icon="arrow-l">Back</a>
	<h1>Details for event</h1>
</div>
<div data-role="content">
	<article>
		<p>
			<?php 
				foreach($columns_event as $column) {
					echo "<strong>".ucfirst($column)."</strong><br />";
					echo $event['Event'][$column]."<br /><br />";
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
						if ($column != "password"&&$column != "event_id"&&$column != "has_login"&&$column != "created"&&$column != "modified") {	# Exlude some columns
							echo "<th>".ucfirst($column)."</th>";
							$columns[$i++] = $column;
						}
					}
				?>
				</tr>
				<?php
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
</div>