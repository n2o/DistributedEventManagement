<article>
	<h1>Add new column</h1>
	<p>
		<?php 
			echo $this->Form->create('Column');	# creates HTML code for the <form>-Tag
			echo $this->Form->input('Name');
			echo $this->Form->input('Type');
			echo $this->Form->end('Save Column');
		?>
	</p>
</article>