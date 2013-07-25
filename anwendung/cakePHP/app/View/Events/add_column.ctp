<article>
	<h1>Add new column</h1>
	<p>
		<?php 
			echo $this->Form->create('Column');	# creates HTML code for the <form>-Tag
			echo $this->Form->input('field');
			echo $this->Form->input('type', array('options' => array(
				'standard' => 'Standard (Numbers, Text, ...)',
				'checkbox' => 'Checkbox'
			)));
			echo $this->Form->end('Save Column');
		?>
	</p>
</article>