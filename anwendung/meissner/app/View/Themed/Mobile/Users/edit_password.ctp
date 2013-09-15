<div data-role="header">
	<a href="#" data-rel="back" data-role="button" data-inline="true" data-icon="arrow-l">Back</a>
	<h1>Set new password</h1>
</div>
<div data-role="content">
	<article>
		<p>
			<?php 
				echo $this->Form->create('User');
				echo $this->Form->input('password');
				echo $this->Form->end(__('Save User'));
			?>
		</p>
	</article>
</div>