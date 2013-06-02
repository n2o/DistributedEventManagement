<h1>Add Post</h1>
<?php 
	echo $this->Form->create('Post');	# creates HTML code for the <form>-Tag
	echo $this->Form->input('title');	# creates input form with name 'title'
	echo $this->Form->input('body', array('rows' => '3'));
	echo $this->Form->end('Save Post'); # creates a submit button with name 'Save Post'
?>