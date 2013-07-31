<?php
class StatsController extends AppController {
	public $helpers = array('Html', 'Form', 'Session', 'Event', 'User');
	public $components = array('Session');

	public function index() {
		$this->loadModel('User');
		$getEventTitles = $this->User->query("SELECT id, title FROM events");
		$eventTitlesWithUsers = array();
		foreach ($getEventTitles as $key => $value)
			$eventTitlesWithUsers[$value['events']['title']] = $value['events']['id'];

		$this->set('eventTitlesWithUsers', $eventTitlesWithUsers);
	}

	# Prepare total users, events and how many users are assigned to each event
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
			if (!isset($eventsUsers[$event])) 
				$eventsUsers[$event] = 0;
			$eventsUsers[$event]++;
		}
		
		# Create new array which replaces the event ids with the correct titles
		$getEventTitles = $this->User->query("SELECT id, title FROM events");
		$eventTitlesWithUsers = array();
		foreach ($getEventTitles as $key => $value)
			$eventTitlesWithUsers[$value['events']['title']] = $eventsUsers[$value['events']['id']];

		$this->set('eventsUsers', $eventTitlesWithUsers);
		$this->set('stats', $stats);
	}

	public function selectEvent() {

	}

	public function specEvent($id = null) {

	}
}