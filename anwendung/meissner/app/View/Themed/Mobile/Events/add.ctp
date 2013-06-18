<div data-role="header">
	<a href="#" data-rel="back" data-role="button" data-inline="true" data-icon="arrow-l">Back</a>
	<h1>Add new event</h1>
</div>
<div data-role="content">
	<article>
		<p>
			<?php 
				echo $this->Form->create('Event');	# creates HTML code for the <form>-Tag
				echo $this->Form->input('title');	# creates input form with name 'title'
				echo $this->Form->input('description', array('rows' => '3'));
				echo $this->Form->end('Save Event');
			?>
		</p>
	</article>
</div>