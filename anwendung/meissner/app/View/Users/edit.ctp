<article>
	<h1>Edit user</h1>
	<p>
		<?php 
			echo $this->Form->create('User');
			echo $this->Form->input('username');
			echo $this->Html->link('Edit Password', array('controller' => 'users', 'action' => 'editPassword', $id), array('class' => 'button'));
			echo $this->Form->input('role', array('options' => array('user' => 'User', 'member' => 'Member', 'admin' => 'Admin')));
			echo $this->Form->input('has_login', array('label' => 'Allowed to login', 'type' => 'checkbox'));
			$elements = $this->User->getAllEvents($events);
			if (sizeof($elements) > 0)
				echo $this->Form->input('selected_events', array('label' => 'Selected events', 'type' => 'select', 'multiple' => 'checkbox', 'options' => $elements, 'selected' => $selectedEventIDs));
			unset($elements);
			echo $this->Form->end(__('Save User'));
		?>
	</p>
</article>