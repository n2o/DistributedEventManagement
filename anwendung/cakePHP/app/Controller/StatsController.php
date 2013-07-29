<?php
class StatsController extends AppController {
	public $helpers = array('Html', 'Form', 'Session', 'Event', 'User');
	public $components = array('Session');

	public function index() {	
	}

	public function overview() {
		$stats = array();
		$this->loadModel('User');
		$temp = $this->User->query("SELECT COUNT(*) FROM users");
		$stats['users'] = $temp[0][0]['COUNT(*)'];

		$temp = $this->User->query("SELECT COUNT(*) FROM events");
		$stats['events'] = $temp[0][0]['COUNT(*)'];

		$this->set('stats', $stats);

	}

	public function specEvent() {

	}

}