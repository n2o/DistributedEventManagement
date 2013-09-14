<div data-role="header">
	<a href="#" data-rel="back" data-role="button" data-inline="true" data-icon="arrow-l">Back</a>
	<h1>Add new column</h1>
</div>
<div data-role="content">
	<article>
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
</div>