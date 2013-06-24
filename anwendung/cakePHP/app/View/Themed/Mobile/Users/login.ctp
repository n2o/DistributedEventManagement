<div data-role="header">
	<a href="#nav" data-role="button" data-inline="true" data-icon="bars">Menu</a>
	<h1>Login</h1>
</div>
<div data-role="content">
	<article>
		<?php
			echo $this->Session->flash('auth');
			echo $this->Form->create('User'); 
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
</div>