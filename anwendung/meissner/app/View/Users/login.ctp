<article>
	<?php 
		echo $this->Session->flash('auth');
		echo $this->Form->create('User'); 
	?>
	<h1>Login</h1>
	<p>
        <?php echo __('Please enter your username and password'); ?>
        <?php 
			echo $this->Form->input('username');
        	echo $this->Form->input('password');
        	echo $this->Form->end(__('Login'));
        ?>
    </p>
</article>