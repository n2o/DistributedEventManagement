<div data-role="header">
	<h1>Overview of events</h1>
</div>
<div data-role="content">
		<article>
		<p>
			<?php 
				echo $this->Html->link('Add Event', array('controller' => 'events', 'action' => 'add'), array('data-role' => 'button', 'data-icon' => 'plus'));
			?><br/>
			<br/>
			<table>
			    <tr>
			        <th>Title</th>
			        <th>Description</th>
			        <th>Details</th>
			    </tr>
			    <!-- Here is where we loop through our $events array, printing out post info -->
				<?php foreach ($events as $event): ?> 
				<tr>
					<td>
						<?php echo $this->Html->link($event['Event']['title'], array('controller' => 'events', 'action' => 'view', $event['Event']['id'])); ?>
					</td>
					<td>
						<?php echo $event['Event']['description']; ?>
					</td>
					<td>
						<?php echo $this->Html->link('Edit', array('action' => 'edit', $event['Event']['id']));?>
						<?php echo $this->Form->postLink(	# postLink uses javascript to do a post request
							'Delete',
							array('action' => 'delete', $event['Event']['id']),
							array('confirm' => 'Are you sure?')); 
						?>
					</td>
				</tr>
				<?php endforeach; ?>
				<?php unset($event); ?> 
			</table>
		</p>
	</article>
</div>