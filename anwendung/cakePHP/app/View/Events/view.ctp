<article>
	<?php
		if (!$is_mobile) {
			echo "<h1>".$articleHeading."</h1>";
		}
	?>
	<p><small>Created: <?php echo $event['Event']['created']; ?></small></p>
	<p><?php echo h($event['Event']['description']); ?></p>
</article>