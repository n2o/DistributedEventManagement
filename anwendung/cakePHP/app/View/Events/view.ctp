<article>
	<?php
		if (!$is_mobile) {
			echo "<h1>".$articleHeading."</h1>";
		}
	?>
	<p><small>Created: <?php echo $event['Event']['created']; ?></small></p>
	
	<?php 
		foreach($columns as $column) {
			echo "<strong>".ucfirst($column)."</strong><br />";
			echo $event['Event'][$column]."<br /><br />";
		}
	 ?>
</article>