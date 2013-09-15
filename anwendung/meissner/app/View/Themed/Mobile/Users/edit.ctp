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
				echo $this->Html->link('Edit Password', array('controller' => 'users', 'action' => 'editPassword', $id), array('data-role' => 'button'));
				echo $this->Form->input('role', array('options' => array('user' => 'User', 'member' => 'Member', 'admin' => 'Admin')));
				echo $this->Form->input('has_login', array('label' => 'Allowed to login', 'type' => 'checkbox'));
				$elements = $this->User->getAllEvents($events);
				echo $this->Form->input('selected_events', array('label' => 'Selected events', 'type' => 'select', 'multiple' => 'checkbox', 'options' => $elements, 'selected' => $selectedEventIDs));
				unset($elements);
				echo $this->Form->end(__('Save User'));
			?>
		</p>
	</article>
</div>