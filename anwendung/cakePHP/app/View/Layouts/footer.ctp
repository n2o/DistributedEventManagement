<div align="right">
	<hr /><br />
	<?php 
		# If user is logged in, show logout, else show login
		if (!$this->Session->read('Auth.User')) {
			echo $this->Html->link('Login', array('controller' => 'users', 'action' => 'login')); 
		} else {
			echo "Logged in as ".$this->Session->read('Auth.User.username').". ".$this->Html->link('Logout', array('controller' => 'users', 'action' => 'logout')); 
		}
	?>
</div>
<!--
<div align="right">
	<?php echo $this->Html->link(
		$this->Html->image('cake.power.gif', array('alt' => $cakeDescription, 'border' => '0')),
		'http://www.cakephp.org/',
		array('target' => '_blank', 'escape' => false));
	?>
</div>
-->