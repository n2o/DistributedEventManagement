<article>
	<h1>Statistics</h1>
	<p>
		<h2>Overview</h2>
		Get here an overview about all the Users and Events in this app.
		<div align="right"><?php echo $this->Html->link('Overview', array('action' => 'overview'), array('class' => 'button')); ?></div>
		<br>
		<h2>Select Event</h2>
		Here are some event-specific statistics.
		<div align="right"><?php echo $this->Html->link('Spec. Event', array('controller' => 'stats', 'action' => 'selectEvent'), array('class' => 'button')); ?></div>
	</p>
</article>