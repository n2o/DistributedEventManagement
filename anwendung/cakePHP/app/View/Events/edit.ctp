<article>
	<h1>Edit event</h1>
	<?php echo $_SERVER['HTTP_HOST']; ?>
	<p>
		<?php 
			echo $this->Form->create('Event');
			echo $this->Form->input('title');
			echo $this->Form->input('description', array('rows' => '3'));
			echo $this->Form->input('id', array('type' => 'hidden'));
			echo $this->Form->end('Save Event');
		?>
	</p>
</article>

<article>
	<h2>Edit specific columns</h2>
	<p>
		<?php echo $this->Html->link('Add Column', array('action' => 'addColumn', $id), array('class' => 'button'));?>
		<table>
			<tr>
				<th>Name</th>
				<th>Type</th>
				<th>Details</th>
			</tr>
			<?php foreach($fields as $field): ?>
			<tr>
				<td><?php echo $field['event_columns']['name']; ?></td>
				<td><?php echo $field['event_columns']['value']; ?></td>
				<td>
					<?php echo $this->Form->postLink(	# postLink uses javascript to do a post request
						'Delete',
						array('action' => 'deleteColumn', $id, $field['event_columns']['name']),
						array('confirm' => 'Are you sure?'));
					?>
				</td>
			</tr>
			<?php endforeach; ?>

		</table>
	</p>
</article>

<article>
	<h2>Users</h2>
	<p>
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
					echo "<th>Details</th>";
				?>
			</tr>
				<?php
					$j = 0;
					for ($i = 0; $i < count($users); $i = $i + 1) {
						echo "<tr>";

						foreach ($columns as $column)
							echo "<td>".$users[$i]['users'][$column]."</td>";
						echo "<td>".$this->Html->link('Edit', array('action' => 'editUser', $users[$i]['users']['id'], $id))."</td>";
						echo "</tr>";

					}
				?>
		</table>
	</p>
</article>