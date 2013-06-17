<article>
	<h1>Add new event</h1>
	<p>
		<?php 
			echo $this->Form->create('Event');	# creates HTML code for the <form>-Tag
			echo $this->Form->input('title');	# creates input form with name 'title'
			echo $this->Form->input('description', array('rows' => '3'));
		?>
	</p>
	<?php echo $this->Form->end('Save Event'); ?>
</article>