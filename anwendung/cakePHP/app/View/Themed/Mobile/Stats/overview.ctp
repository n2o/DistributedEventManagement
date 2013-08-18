<script type="text/javascript" src="https://www.google.com/jsapi"></script>

<div data-role="header">
	<a href="#" data-rel="back" data-role="button" data-inline="true" data-icon="arrow-l">Back</a>
	<h1>Statistics</h1>
</div>
<div data-role="content">
	<article>
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
	</article>

	<article>
		<div id="eventsUsersChart"></div>
	</article>
</div>

<?php 
	#echo $this->element('createColumnChart', array('column' => 'eventsUsers', 'stats' => $eventsUsers, 'title' => 'Shows how many users are assigned to each event', 'type' => 'Users'));
?>