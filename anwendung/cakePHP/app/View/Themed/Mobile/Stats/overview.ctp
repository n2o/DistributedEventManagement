<article>
	<h1>Statistics</h1>
	<p>
		<table>
			<tr>
				<td>Total Users:</td>
				<td><?php echo $stats['users']; ?></td>
			</tr>
			<tr>
				<td>Total Events:</td>
				<td><?php echo $stats['events']; ?></td>
			</tr>
		</table>

		<a href="#" class="slide_div button" rel="#eventsUsersDiv">Show / Hide Chart</a><br />
		<div id="eventsUsersDiv" class="slidingDiv">
			<div id="eventsUsersChart"></div>
		</div> 
	</p>
</article>

<?php 
	echo $this->element('createColumnChart', array('column' => 'eventsUsers', 'stats' => $eventsUsers, 'title' => 'Shows how many users are assigned to each event', 'type' => 'Users'));
?>