<nav>
	<ul>
		<li><?php echo $this->Html->link('Events', array('controller' => 'events', 'action' => 'index')); ?></li>
		<li><?php echo $this->Html->link('Users', array('controller' => 'users', 'action' => 'index')); ?></li>
		<li>
			<?php echo $this->Html->link('Stats', array('controller' => 'stats', 'action' => 'index')); ?>
			<ul>
				<li><?php echo $this->Html->link('Overview', array('controller' => 'stats', 'action' => 'overview')); ?></li>
				<li><?php echo $this->Html->link('Spec. Event', array('controller' => 'stats', 'action' => 'specEvent')); ?></li>
			</ul>
		</li>
	</ul>
</nav>