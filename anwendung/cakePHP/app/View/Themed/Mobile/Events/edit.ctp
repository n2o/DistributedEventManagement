<div data-role="header">
	<a href="#" data-rel="back" data-role="button" data-inline="true" data-icon="arrow-l">Back</a>
	<h1>Edit event</h1>
</div>
<div data-role="content">
	<article>
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
</div>