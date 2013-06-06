<article>
	<?php echo $this->Session->flash('auth'); ?>
	<?php echo $this->Form->create('User'); ?>
		<h1>Login</h1>
		<p>
	        <?php echo __('Please enter your username and password'); ?>
	        <?php 
				echo $this->Form->input('username');
	        	echo $this->Form->input('password');
	        ?>
	    </p>
	<?php echo $this->Form->end(__('Login')); ?>
</article>