<article>
	<?php 
		echo $this->Session->flash('auth');
		echo $this->Form->create('User'); 

		echo "<h1>".$articleHeading."</h1>";
	?>
		<p>
	        <?php echo __('Please enter your username and password'); ?>
	        <?php 
				echo $this->Form->input('username');
	        	echo $this->Form->input('password');
	        ?>
	    </p>
	<?php echo $this->Form->end(__('Login')); ?>
</article>