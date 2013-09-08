<!--
	Edit here the mobile view for the navigation
 -->
<div data-role="panel" id="nav" data-position="left" data-display="reveal" data-theme="a">
	<h3>Navigation</h3>
	<div data-role="controlgroup">
		<?php 
			echo $this->Html->link('Events', array('controller' => 'events', 'action' => 'index'), array('data-role' => 'button', 'data-theme' => 'a'));
			echo $this->Html->link('Users', array('controller' => 'users', 'action' => 'index'), array('data-role' => 'button', 'data-theme' => 'a'));
			echo $this->Html->link('Geolocations', array('controller' => 'geolocations', 'action' => 'index'), array('data-role' => 'button', 'data-theme' => 'a'));
			echo $this->Html->link('Statistics', array('controller' => 'stats', 'action' => 'index'), array('data-role' => 'button', 'data-theme' => 'a'));
			echo $this->Html->link('Chat', array('controller' => 'chats', 'action' => 'index'), array('data-role' => 'button', 'data-theme' => 'a'));
		?>
	</div>

	<div data-role="controlgroup">
		<br><br><br><br>
		<?php
			if (!$this->Session->read('Auth.User')) {
				echo $this->Html->link('Login', array('controller' => 'users', 'action' => 'login'), array('data-role' => 'button', 'data-theme' => 'a')); 
			} else {
				echo $this->Html->link('User: '.$this->Session->read('Auth.User.username').'. Logout', array('controller' => 'users', 'action' => 'logout'), array('data-role' => 'button', 'data-theme' => 'a')); 
			}
		?>
	</div>
</div>