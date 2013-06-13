<article>
	<?php
		if (!$is_mobile) {
			echo "<h1>".$articleHeading."</h1>";
		}
	?>
	<p>
		<?php 
			foreach($columns_event as $column) {
				echo "<strong>".ucfirst($column)."</strong><br />";
				echo $event['Event'][$column]."<br /><br />";
			}
		?>
	</p>
</article>
<article>
	<p><h2>Users</h2>
		<?php 
			foreach($users as $user) {
				echo "<strong>".ucfirst($user)."</strong><br />";
				#echo $event['User'][$user]."<br /><br />";
			}
		?>
	</p>
</article>