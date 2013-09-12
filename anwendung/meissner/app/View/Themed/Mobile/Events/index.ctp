<div data-role="header">
	<a href="#nav" data-role="button" data-inline="true" data-icon="bars">Menu</a>
	<h1>Overview of events</h1>
	<?php 
	echo $this->Html->link('Add', array('controller' => 'events', 'action' => 'add'), array('data-icon' => 'add', 'data-theme' => 'b'));
	?>
</div>
<div data-role="content">
		<article>
		<p>
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
						<?php echo $this->Html->link('', array('action' => 'edit', $event['Event']['id']), array('data-role' => 'button', 'data-icon' => 'edit', 'data-theme' => 'c', 'data-iconpos' => 'notext', 'data-inline' => 'true'));?>
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