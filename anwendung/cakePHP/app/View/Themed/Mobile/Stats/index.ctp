<div data-role="header">
	<a href="#nav" data-role="button" data-inline="true" data-icon="bars">Menu</a>
	<h1>Statistics</h1>
</div>
<div data-role="content">
	<article>
		<p>
			<h2>Overview</h2>
			Get here an overview about all the Users and Events in this app.
			<?php echo $this->Html->link('Overview', array('action' => 'overview'), array('data-role' => 'button')); ?>
			<br>
			<h2>Select Event</h2>
			Here are some event-specific statistics.
			<div data-role="controlgroup">
			<?php 
				foreach ($eventTitlesWithUsers as $title => $id)
					echo $this->Html->link($title, array('controller' => 'stats', 'action' => 'specEvent/'.$id), array('data-role' => 'button'));
			?>
			</div>
		</p>
	</article>
</div>