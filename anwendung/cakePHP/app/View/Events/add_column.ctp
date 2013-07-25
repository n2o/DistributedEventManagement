<article>
	<h1>Add new column</h1>
	<p>
		<?php 
			echo $this->Form->create('Column');
			echo $this->Form->input('name');
			echo $this->Form->input('value', array('options' => array(
				'text' => 'Standard (Numbers, Text, ...)',
				'checkbox' => 'Checkbox'
			)));
			echo $this->Form->end('Save Column');
		?>
	</p>
</article>