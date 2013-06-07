<article>
	<h1><?php echo h($event['Event']['title']);?></h1>
	<p><small>Created: <?php echo $event['Event']['created']; ?></small></p>
	<p><?php echo h($event['Event']['description']); ?></p>
</article>