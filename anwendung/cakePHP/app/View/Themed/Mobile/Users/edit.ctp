<div data-role="header">
	<h1>Edit user</h1>
</div>
<div data-role="content">
	<article>
		<p>
			<?php 
				echo $this->Form->create('User');
				echo $this->Form->input('username');
				echo $this->Form->input('password');
				echo $this->Form->input('role', 
					array('options' => 
						array('admin' => 'Admin', 
							  'member' => 'Member', 
							  'user' => 'User')));

				$elements = $this->User->getAllEvents($events);
				echo $this->Form->input('event_id', array('options' => $elements));

				echo $this->Form->input('id', array('type' => 'hidden'));
				echo $this->Form->end('Save User');
			?>
		</p>
	</article>
</div>