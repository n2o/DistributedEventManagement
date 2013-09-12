<article>
	<h1>Overview of Users</h1>
	<p>
		<?php 
			echo $this->Html->link('Add User', array('controller' => 'users', 'action' => 'add'), array('class' => 'button'));
		?>
		<br>
		<table>
		    <tr>
		        <th>Id</th>
		        <th>Username</th>
		        <th>Role</th>
		        <th>Details</th>
		        <th>Created</th>
		    </tr>
		    <!-- Here is where we loop through our $users array, printing out user info -->
			<?php foreach ($users as $user): ?> 
			<tr>
				<td>
					<?php echo $user['User']['id']; ?>
				</td> 
				<td>
					<?php echo $this->Html->link($user['User']['username'], array('controller' => 'users', 'action' => 'view', $user['User']['id'])); ?>
				</td>
				<td>
					<?php echo $user['User']['role']; ?>
				</td>
				<td>
					<?php echo $this->Html->link('Edit', array('action' => 'edit', $user['User']['id']));?>
					<?php echo $this->Form->postLink(	# userLink uses javascript to do a user request
						'Delete',
						array('action' => 'delete', $user['User']['id']),
						array('confirm' => 'Are you sure?')); 
					?>
				</td>
				<td>
					<?php echo $user['User']['created']; ?>
				</td>
			</tr>
			<?php endforeach; ?>
			<?php unset($user); ?> 
		</table>
	</p>
</article>