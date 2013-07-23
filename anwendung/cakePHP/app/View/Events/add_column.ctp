<article>
	<h1>Add new column</h1>
	<p>
		<?php 
			echo $this->Form->create('Column');	# creates HTML code for the <form>-Tag
			echo $this->Form->input('field');
			echo $this->Form->input('type', array('options' => array(
				'int(11)' => 'Number (int(11))',
				'varchar(64)' => 'String (varchar(64))', 
				'varchar(1024)' => 'Large Text (varchar(1024))'
			)));

			echo $this->Form->end('Save Column');
		?>
	</p>
</article>