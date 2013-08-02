<div align="right">
	<hr /><br />
	<?php 
		# If user is logged in, show logout, else show login
		if (!$this->Session->read('Auth.User')) {
			echo $this->Html->link('Login', array('controller' => 'users', 'action' => 'login')); 
		} else {
			echo "Logged in as ".$this->Session->read('Auth.User.username').". Role: ".$this->Session->read('Auth.User.role').". ".$this->Html->link('Logout', array('controller' => 'users', 'action' => 'logout')); 
		}
	?>
</div>