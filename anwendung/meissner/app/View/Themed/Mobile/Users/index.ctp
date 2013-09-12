<div data-role="header">
	<!--<a data-icon="grid" class="menu-trigger">Menu</a>-->
	<a href="#nav" data-role="button" data-inline="true" data-icon="bars">Menu</a>
	<h1>Overview of users</h1>
	<?php 
	echo $this->Html->link('Add', array('controller' => 'users', 'action' => 'add'), array('data-icon' => 'add', 'data-theme' => 'b'));
	?>
</div>
<div data-role="content">
	<article>
		<p>
			<table>
			    <tr>
			        <th>Username</th>
			        <th>Role</th>
			        <th>Details</th>
			    </tr>
			    <!-- Here is where we loop through our $users array, printing out user information -->
				<?php foreach ($users as $user): ?> 
				<tr>
					<td>
						<?php echo $this->Html->link($user['User']['username'], array('controller' => 'users', 'action' => 'view', $user['User']['id'])); ?>
					</td>
					<td>
						<?php echo $user['User']['role']; ?>
					</td>
					<td>
						<?php echo $this->Html->link('', array('action' => 'edit', $user['User']['id']), array('data-role' => 'button', 'data-icon' => 'edit', 'data-theme' => 'c', 'data-iconpos' => 'notext', 'data-inline' => 'true'));?>
						<?php echo $this->Form->postLink(	# userLink uses javascript to do a user request
							'Delete',
							array('action' => 'delete', $user['User']['id']),
							array('confirm' => 'Are you sure?')); 
						?>
					</td>
				</tr>
				<?php endforeach; ?>
				<?php unset($user); ?> 
			</table>
		</p>
	</article>
</div>