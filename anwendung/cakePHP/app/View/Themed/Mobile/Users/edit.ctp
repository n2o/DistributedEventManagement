<div data-role="header">
	<a href="#" data-rel="back" data-role="button" data-inline="true" data-icon="arrow-l">Back</a>
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
				echo "<label for=\"UserHasLogin\">Is able to login</label> ".$this->Form->checkbox('has_login');
				echo $this->Form->input('id', array('type' => 'hidden'));
				echo $this->Form->end('Save User');
			?>
		</p>
	</article>
</div>