<article>
	<h1>Set new password</h1>
	<p>
		<?php 
			echo $this->Form->create('User');
			echo $this->Form->input('password');
			echo $this->Form->end(__('Save User'));
		?>
	</p>
</article>