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
		if (!$id) {
			throw new NotFoundException(__('Invalid event.'));
		}
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
				$toJson = json_encode(array("field" => $this->request->data['Column']['field'], "type" => $this->request->data['Column']['type']));
				$this->Event->query("INSERT INTO event_details (`event_id`, `entry`, `value`) VALUES ('$id', 'form', '$toJson')");
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

		$specColumns = $this->Event->query("SELECT * FROM event_details WHERE event_id = $id AND entry = 'form'");
		var_dump($specColumns);

		foreach ($specColumns as $key => $value) {
			var_dump($key);
			echo $value["event_details"]["entry"];
		}

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
	public function deleteColumn($id, $column_name) {
		if ($this->request->is('get'))
			throw new MethodNotAllowedException();
		$this->Session->setFlash('The column $column_name has been deleted.');
		$this->redirect(array('action' => 'edit/'.$id));
	}
}