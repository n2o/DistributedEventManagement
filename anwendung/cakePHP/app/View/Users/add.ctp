<article>
	<h1>Add new user</h1>
	<p>
		<?php 
			echo $this->Form->create('User');
	        echo $this->Form->input('username');
	        echo $this->Form->input('password');
	        echo $this->Form->input('role', array('options' => array('user' => 'User', 'member' => 'Member', 'admin' => 'Admin')));

			#echo $this->Form->input('event_id', array('options' => $elements));
			echo "<label for=\"UserHasLogin\">Is able to login</label> ".$this->Form->checkbox('has_login')."<br /><br />";

			#echo $form->input('Event.title');

			# Menu to choose one of the events
			$elements = $this->User->getAllEvents($events);
			echo $this->Form->input('selected_events', array('label' => 'selected_events', 'type' => 'select', 'multiple' => 'checkbox', 'options' => $elements));
			unset($elements);
		?>
	</p>
	<?php echo $this->Form->end(__('Submit')); ?>
</article>