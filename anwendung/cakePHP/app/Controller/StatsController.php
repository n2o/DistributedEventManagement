<?php
class StatsController extends AppController {
	public $helpers = array('Html', 'Form', 'Session', 'Event', 'User');
	public $components = array('Session');

	public function index() {	
	}

	public function overview() {
		$stats = array();
		$this->loadModel('User');

		# Store how many events and users exist in database
		$temp = $this->User->query("SELECT COUNT(*) FROM users");
		$stats['users'] = $temp[0][0]['COUNT(*)'];
		$temp = $this->User->query("SELECT COUNT(*) FROM events");
		$stats['events'] = $temp[0][0]['COUNT(*)'];

		# Take now a look which users belong to which event and sum them up
		$query = $this->User->query("SELECT * from events_users");
		$eventsUsers = array();
		foreach ($query as $key => $value) {
			$event = $value['events_users']['event_id'];
			if (!isset($eventsUsers[$event])) $eventsUsers[$event] = 0;
			$eventsUsers[$event]++;
		}
		
		

		$this->set('eventsUsers', $eventsUsers);
		$this->set('stats', $stats);
	}

	public function specEvent() {

	}

}