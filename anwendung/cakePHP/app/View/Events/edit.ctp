<article>
	<?php
		echo "<h1>".$articleHeading."</h1>";
	?>
	<p>
		<?php 
			echo $this->Form->create('Event');
			echo $this->Form->input('title');
			echo $this->Form->input('description', array('rows' => '3'));
			echo $this->Form->input('id', array('type' => 'hidden'));
			echo $this->Form->end('Save Event');
		?>
	</p>
</article>