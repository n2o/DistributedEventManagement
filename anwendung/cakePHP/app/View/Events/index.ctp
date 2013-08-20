<?php 
	
	$host = 'localhost';  //where is the websocket server
	$port = 9999;
	$local = "http://localhost/";  //url where this script run
	$data = 'hello world!';  //data to be send

	$head = "GET / HTTP/1.1"."\r\n".
		"Upgrade: WebSocket"."\r\n".
		"Connection: Upgrade"."\r\n".
		"Origin: $local"."\r\n".
		"Host: $host"."\r\n".
		"Content-Length: ".strlen($data)."\r\n"."\r\n";

	//WebSocket handshake
	$sock = fsockopen($host, $port, $errno, $errstr, 2);
	fwrite($sock, $head ) or die('error:'.$errno.':'.$errstr);
	$headers = fread($sock, 2000);
	fwrite($sock, "\x00$data\xff" ) or die('error:'.$errno.':'.$errstr);
	$wsdata = fread($sock, 2000);  //receives the data included in the websocket package "\x00DATA\xff"
	fclose($sock);
 ?>


<article>
	<h1>Overview of events</h1>
	<p>
		<?php echo $this->Html->link('Add Event', array('controller' => 'events', 'action' => 'add'), array('class' => 'button')); ?>
		<table>
		    <thead>
		        <th>Id</th>
		        <th>Title</th>
		        <th>Description</th>
		        <th>Details</th>
		        <th>Created</th>
		    </thead>
		    <!-- Here is where we loop through our $events array, printing out post info -->
			<?php foreach ($events as $event): ?> 
			<tr>
				<td>
					<?php echo $event['Event']['id']; ?>
				</td> 
				<td>
					<?php echo $this->Html->link($event['Event']['title'], array('controller' => 'events', 'action' => 'view', $event['Event']['id'])); ?>
				</td>
				<td>
					<?php echo $event['Event']['description']; ?>
				</td>
				<td>
					<?php echo $this->Html->link('Edit', array('action' => 'edit', $event['Event']['id']));?>
					<?php echo $this->Form->postLink(	# postLink uses javascript to do a post request
						'Delete',
						array('action' => 'delete', $event['Event']['id']),
						array('confirm' => 'Are you sure?')); 
					?>
				</td>
				<td>
					<?php echo $event['Event']['created']; ?>
				</td>
			</tr>
			<?php endforeach; ?>
			<?php unset($event); ?> 
		</table>
	</p>
</article>


<?php
	$this->Js->set("foo", "42");
 ?>