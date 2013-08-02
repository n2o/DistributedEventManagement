<?php
class StatsController extends AppController {
	public $helpers = array('Html', 'Form', 'Session', 'Event', 'User');
	public $components = array('Stats', 'Session');

	# Main page, which displays all events and make them clickable
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

	public function specEvent($id = null) {
		$this->loadModel('User');
		$stats = array();	# Array where all stats are stored

		# Get sum of all users belonging to this event
		$sumUsers = $this->User->query("SELECT COUNT(*) FROM events_users WHERE event_id = '$id'");
		$stats['Total Users for this Event'][$sumUsers[0][0]['COUNT(*)'].""] = "";

		# Query all specific columns and initialize array
		$columnNames = $this->User->query("SELECT name FROM event_columns WHERE event_id = '$id'");
		foreach ($columnNames as $key => $value)
			$stats[$value['event_columns']['name']] = array();

		# Now query all properties of the users for the columns above...
		$query = $this->User->query("SELECT name, value FROM event_properties WHERE event_id = '$id'");

		# ...and count the occurences of each value
		foreach ($query as $key => $entry) {
			$name = $entry['event_properties']['name'];
			$value = $entry['event_properties']['value'];
			
			# Initialize possible values
			if (!isset($stats[$name][$value]))
				$stats[$name][$value] = 0;

			$stats[$name][$value]++;
		}

		$this->set('dataCharts', $this->Stats->prepareCharts($stats));

		$this->set('stats', $stats);
	}
}