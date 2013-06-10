<article>
	<?php 
		echo $this->Form->create('User');
		if (!$is_mobile) {
			echo "<h1>".$articleHeading."</h1>";
		}
	?>
	<p>
		<?php 
	        echo $this->Form->input('username');
	        echo $this->Form->input('password');
	        echo $this->Form->input('role', array('options' => array('admin' => 'Admin', 'member' => 'Member', 'user' => 'User')));
		?>
	</p>
	<?php echo $this->Form->end(__('Submit')); ?>
</article>