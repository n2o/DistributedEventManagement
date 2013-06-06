<article>
	<h1>Edit User</h1>
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
			echo $this->Form->input('id', array('type' => 'hidden'));
			echo $this->Form->end('Save User');
		?>
	</p>
</article>