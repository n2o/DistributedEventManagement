<article>
	<h1>Edit user</h1>
	<p>
		<?php 
			echo $this->Form->create('User');
			echo $this->Form->input('username');
			echo $this->Form->input('role', array('options' => array('user' => 'User', 'member' => 'Member', 'admin' => 'Admin')));
			echo $this->Form->input('has_login', array('label' => 'Allowed to login', 'type' => 'checkbox'));
			$elements = $this->User->getAllEvents($events);
			echo $this->Form->input('selected_events', array('label' => 'Select events', 'type' => 'select', 'multiple' => 'checkbox', 'options' => $elements));
			unset($elements);

			echo $this->Form->end(__('Save User'));
		?>
	</p>
</article>