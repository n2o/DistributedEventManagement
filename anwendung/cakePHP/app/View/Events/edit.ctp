<article>
	<h1>Edit event</h1>
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
		<table>
			<tr>
				<th>Name</th>
				<th>Type</th>
				<th>Details</th>
			</tr>
			<?php foreach($columns_event as $column): ?>
			<tr>
				<td>
					<?php echo key($column); ?>
				</td>
				<td>
					<?php echo $column[key($column)]; ?>
				</td>
				<td>
					Edit <?php # need to add button ?>
					<?php echo $this->Form->postLink(
						'Delete',
						array('action' => 'deleteColumn', $id, key($column)),
						array('confirm' => 'Are you sure?')); 
					?>
				</td>
			</tr>
		<?php endforeach; ?>
		</table>
		<?php echo $this->Html->link('Add Column', array('action' => 'addColumn', $id));?>
	</p>
</article>