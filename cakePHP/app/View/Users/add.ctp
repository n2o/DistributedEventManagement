<div class="users form">
	<article>
		<?php echo $this->Form->create('User'); ?>
		    <fieldset>
		        <legend><?php echo __('Add User'); ?></legend>
		        <?php 
			        echo $this->Form->input('username');
			        echo $this->Form->input('password');
			        echo $this->Form->input('role', array('options' => array('admin' => 'Admin', 'helper' => 'Helper', 'guest' => 'Guest')));
		    	?>
		    </fieldset>
		<?php echo $this->Form->end(__('Submit')); ?>
	</article>
</div>