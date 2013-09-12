<article>
	<h1>Statistics</h1>
	<p>
		<h2>Overview</h2>
		Get here an overview about all the Users and Events in this app.
		<div align="right"><?php echo $this->Html->link('Overview', array('action' => 'overview'), array('class' => 'button')); ?></div>
		<br>
		<h2>Select Event</h2>
		Here are some event-specific statistics.
		<p>
		<br>
		<?php 
			foreach ($eventTitlesWithUsers as $title => $id)
				echo $this->Html->link($title, array('controller' => 'stats', 'action' => 'specEvent/'.$id), array('class' => 'button', 'style' => 'float: right;'));
		?>
		</p>
	</p>
</article>