<article>
	<?php
		echo "<h1>".$articleHeading."</h1>";
	?>
	<p>
		<?php 
			echo $this->Form->create('Event');	# creates HTML code for the <form>-Tag
			echo $this->Form->input('title');	# creates input form with name 'title'
			echo $this->Form->input('description', array('rows' => '3'));
			echo $this->Form->end('Save Event');
		?>
	</p>
</article>