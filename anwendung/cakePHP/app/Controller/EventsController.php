<?php
class EventsController extends AppController {
	public $helpers = array('Html', 'Form', 'Session', 'Event', 'User');
	public $components = array('Session');

	# Show all the events 
	public function index() {
		$this->set('events', $this->Event->find('all'));
	}

	# View one specific element by id
	public function view($id = null) {
		if (!$id)
			throw new NotFoundException(__('Invalid event.'));

		$event = $this->Event->findById($id);
		if (!$event) {
			throw new NotFoundException(__('Invalid event.'));
		}
		# Make current event available for the View
		$this->set('event', $event);

		# Take an event, look up the column types and return their names
		$this->set('columns_event', array_keys($this->Event->getColumnTypes()));

		# Load Model User to get their column types
		$this->loadModel('User');
		$user = $this->User->findById($event["Event"]["user_id"]);
		$this->set('username', $user['User']['username']);

		# SQL query to get all users which are attached to this event
		$this->set('users', $this->Event->query('SELECT users.* FROM events_users LEFT JOIN users ON users.id = events_users.user_id WHERE event_id ='.$id));

		# Save all columns for user in an array
		$this->set('columns_user', array_keys($this->User->getColumnTypes()));
	}

	# Add a new event to the sql table
	public function add() {
		if ($this->request->is('post')) {  # Check if it is a valid HTTP POST request
			$this->Event->create();
			$this->request->data['Event']['user_id'] = $this->Auth->user('id');
			if ($this->Event->save($this->request->data)) {
				$this->Session->setFlash('Your event has been saved.');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('Unable to add your event.');
			}
		}
	}

	# Add specific column for event via key-value-store and json encoding
	public function addColumn($id = null) {
		if (!$id)
			throw new NotFoundException(__('Invalid id.'));

		if ($this->request->is('post')||$this->request->is('put')) {
			if ($this->request->data['Column']) {
				# Get data from view, encode it to json and save it into the key-value-store
				$toJson = json_encode(array("use" => "form", "field" => $this->request->data['Column']['field'], "type" => $this->request->data['Column']['type']));
				$this->Event->query("INSERT INTO event_details (`entry`, `value`) VALUES ('$id', '$toJson')");
				$this->Session->setFlash('Added a column to your event.');
				$this->redirect(array('action' => 'edit/'.$id));
			} else {
				$this->Session->setFlash('Unable to update your event.');
			}
		}
	}

	public function edit($id = null) {
		if (!$id)
			throw new NotFoundException(__('Invalid id.'));

		$event = $this->Event->findById($id);

		if (!$event)
			throw new NotFoundException(__('Invalid event.'));

		$this->set('id', $id); # Make $id accessible for View

		# Get all entries corresponding to this event
		$specColumns = $this->Event->query("SELECT * FROM event_details WHERE entry = $id");
		
		# Evaluate all form elements from key-value event_details
		$json = array();
		$i = 0;
		foreach ($specColumns as $key => $value) {
			$json[$i] = json_decode($value["event_details"]["value"], true);
			if ($json[$i]["use"] == "form") $i++;
		}

		# Prepare array for view
		$fields = array();
		$i = 0;
		foreach ($json as $key => $value) {
			$fields[$value["field"]] = $value["type"];
		}
		$this->set("fields", $fields);

		# Show list of users which are assigned to the event
		$this->loadModel('User');
		$this->set('users', $this->Event->query('SELECT users.* FROM events_users LEFT JOIN users ON users.id = events_users.user_id WHERE event_id ='.$id));

		# Save all columns for user in an array
		$this->set('columns_user', array_keys($this->User->getColumnTypes()));


		# Update event
		if ($this->request->is('post')||$this->request->is('put')) {
			$this->Event->id = $id;
			if ($this->Event->save($this->request->data)) {
				$this->Session->setFlash('Your event has been updated.');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('Unable to update your event.');
			}
		}

		if (!$this->request->data)	# If no new data has been entered, use the old one
			$this->request->data = $event;
	}

	public function editUser($userId = null, $eventId = null) {
		if (!$userId)
			throw new NotFoundException(__('Invalid user id.'));
		$this->loadModel('User');
		$user = $this->User->findById($userId);

		$eventDetails = $this->Event->query("SELECT * FROM event_details WHERE entry = $eventId");
		#var_dump($eventDetails);
		$i = 0;

		foreach ($eventDetails as $key => $value) {
			$temp = json_decode($value["event_details"]["value"], true);
			if ($temp["use"] == "form") 
				$json[$i++] = $temp;
		}

		$this->set("columns", $json);

		if ($this->request->is('post')||$this->request->is('put')) {
			if ($this->request->data['inputColumn']) {
				# Get data from view, encode it to json and save it into the key-value-store
				$toJson = json_encode(array("use" => "form", "field" => $this->request->data['inputColumn']['field'], "type" => $this->request->data['inputColumn']['type']));
				$this->Event->query("INSERT INTO event_details (`entry`, `value`) VALUES ('$id', '$toJson')");
				$this->Session->setFlash('Added specific user value to Event.');
				$this->redirect(array('action' => 'edit/'.$eventId));
			} else {
				$this->Session->setFlash('Unable to update your event.');
			}
		}
	}

	# Delete whole event
	public function delete($id) {
		if ($this->request->is('get'))
			throw new MethodNotAllowedException();

		if ($this->Event->delete($id)) {
			$this->Event->query("DELETE FROM events_users WHERE event_id = $id");
			$this->Event->query("DELETE FROM event_details WHERE event_id = $id");
			$this->Session->setFlash('The event with id: $id has been deleted.');
			$this->redirect(array('action' => 'index'));
		}
	}

	# Delete specific column
	public function deleteColumn($id, $field) {
		if ($this->request->is('get'))
			throw new MethodNotAllowedException();
		$this->Session->setFlash('The column $field has been deleted.');
		$this->redirect(array('action' => 'edit/'.$id));
	}
}