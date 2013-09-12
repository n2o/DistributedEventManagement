<nav>
	<ul>
		<li><?php echo $this->Html->link('Events', array('controller' => 'events', 'action' => 'index')); ?></li>
		<li><?php echo $this->Html->link('Users', array('controller' => 'users', 'action' => 'index')); ?></li>
		<li><?php echo $this->Html->link('Geolocations', array('controller' => 'geolocations', 'action' => 'index')); ?></li>
		<li><?php echo $this->Html->link('Statistics', array('controller' => 'stats', 'action' => 'index')); ?></li>
		<li><?php echo $this->Html->link('Chat', array('controller' => 'chats', 'action' => 'index')); ?></li>
	</ul>
</nav>