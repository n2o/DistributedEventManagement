<?php
/**
 * Logic used for Events is prepared here.
 *
 * Every function is a preparation for a view and can accessed by calling 
 * 'events/view', 'events/add' etc.
 */
App::uses('Sanitize', 'Utility');
class EventsController extends AppController {
	public $helpers = array('Html', 'Form', 'Session', 'Event', 'User');
	public $components = array('Session', 'Other');

	# Show all the events 
	public function index() {
		$this->set('events', $this->Event->find('all'));
	}

	# View one specific element by id
	public function view($id = null) {
		if (!$id)
			throw new NotFoundException(__('Invalid event.'));
		$id = Sanitize::paranoid($id);		

		$event = $this->Event->findById($id);
		if (!$event)
			throw new NotFoundException(__('Invalid event.'));

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
				$this->Session->setFlash('The event has been saved.');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('Unable to add your event.');
			}
		}
	}

	# Add specific column for event via key-value-store
	public function addColumn($id = null) {
		if (!$id)
			throw new NotFoundException(__('Invalid id.'));
		$id = Sanitize::paranoid($id);

		if ($this->request->is('post')||$this->request->is('put')) {
			if ($this->request->data['Column']) {
				# Get data from view and save it into the key-value-store
				$name = $this->request->data['Column']['name'];
				$value = $this->request->data['Column']['value'];


				$this->Event->query("INSERT INTO event_columns (`event_id`, `name`, `value`) VALUES ($id, '$name', '$value')");
				$this->Session->setFlash('Added a column to the event.');

				# WebSocket: Save which event has been updated to send the user a notification
				$this->Other->sendElephantWebSocket(array('type' => 'publishEvent', 'id' => ''.$id.''));
				
				$this->redirect(array('action' => 'edit/'.$id));
			} else {
				$this->Session->setFlash('Unable to update your event.');
			}
		}
	}

	public function edit($id = null) {
		if (!$id)
			throw new NotFoundException(__('Invalid id.'));
		$id = Sanitize::paranoid($id);

		$event = $this->Event->findById($id);

		if (!$event)
			throw new NotFoundException(__('Invalid event.'));

		$this->set('id', $id); # Make $id accessible for View
		$title = $event['Event']['title'];

		# Get all entries corresponding to this event
		$fields = $this->Event->query("SELECT * FROM event_columns WHERE event_id = $id");
		$this->set("fields", $fields);

		# Show list of users which are assigned to the event
		$this->set('users', $this->Event->query('SELECT users.* FROM events_users LEFT JOIN users ON users.id = events_users.user_id WHERE event_id ='.$id));

		# Save all columns for user in an array
		$this->set('columns_user', array_keys($this->User->getColumnTypes()));

		# Update event
		if ($this->request->is('post')||$this->request->is('put')) {
			$this->Event->id = $id;
			if ($this->Event->save($this->request->data)) {
				$this->Session->setFlash('Update successful.');
				
				# WebSocket: Save which event has been updated to send the user a notification
				$this->Other->sendElephantWebSocket(array('type' => 'publishEvent', 'title' => ''.$title.'', 'id' => ''.$id.''));

				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('Unable to update your event.');
			}
		}

		if (!$this->request->data)	# If no new data has been entered, use the old one
			$this->request->data = $event;
	}

	# Edit event specific users and their properties
	public function editUser($user_id = null, $event_id = null) {
		if (!$user_id)
			throw new NotFoundException(__('Invalid user id.'));
		$user_id = Sanitize::paranoid($user_id);
		$event_id = Sanitize::paranoid($event_id);

		$fields = $this->Event->query("SELECT * FROM event_columns WHERE event_id = $event_id");
		$this->set("fields", $fields);

		$alreadTypedIn = $this->Event->query("SELECT * FROM event_properties WHERE user_id = $user_id AND event_id = $event_id");

		$posted = array();
		foreach ($alreadTypedIn as $entry => $value)
			$posted[$value['event_properties']['name']] = $value['event_properties']['value'];

		$this->set("alreadyTypedIn", $posted);

		if ($this->request->is('post')||$this->request->is('put')) {
			if ($this->request->data['inputColumn']) {
				# Get data from view, encode it to json and save it into the key-value-store

				for ($i = 0; $i < count($fields); $i++) {
					$postName = $fields[$i]['event_columns']['name'];
					$postValue = $this->request->data['inputColumn']['post'.$i];
					if ($postValue != "")
						$this->Event->query("REPLACE INTO event_properties (`user_id`, `event_id`, `name`, `value`) VALUES ('$user_id', '$event_id', '$postName', '$postValue')");
				}
				$this->Session->setFlash('Added specific user value to Event.');

				# WebSocket: Save which event has been updated to send the user a notification
				$this->Other->sendElephantWebSocket(array('type' => 'publishEvent', 'id' => ''.$event_id.''));

				$this->redirect(array('action' => 'edit/'.$event_id));
			} else {
				$this->Session->setFlash('Unable to update your event.');
			}
		}
	}

	# Delete whole event
	public function delete($id) {
		if ($this->request->is('get'))
			throw new MethodNotAllowedException();
		$id = Sanitize::paranoid($id);

		if ($this->Event->delete($id)) {
			$this->Event->query("DELETE FROM events_users WHERE event_id = $id");
			$this->Event->query("DELETE FROM event_columns WHERE event_id = $id");
			$this->Event->query("DELETE FROM event_properties WHERE event_id = $id");
			$this->Session->setFlash('The event with id: $id has been deleted.');

			# WebSocket: Save which event has been updated to send the user a notification
			$this->Other->sendElephantWebSocket(array('type' => 'publishEvent', 'id' => ''.$id.''));

			$this->redirect(array('action' => 'index'));
		}
	}

	public function deleteColumn($id, $name) {
		if ($this->request->is('get'))
			throw new MethodNotAllowedException();
		$id = Sanitize::paranoid($id);

		$this->Event->query("DELETE FROM event_columns WHERE event_id = $id AND name = '$name'");
		$this->Event->query("DELETE FROM event_properties WHERE event_id = $id AND name = '$name'");
		$this->Session->setFlash("The column ".$name." has been deleted.");

		# WebSocket: Save which event has been updated to send the user a notification
		$this->Other->sendElephantWebSocket(array('type' => 'publishEvent', 'id' => ''.$id.''));

		$this->redirect(array('action' => 'edit', $id));
	}

	public function deleteUser($user_id, $user_name, $event_id) {
		if ($this->request->is('get'))
			throw new MethodNotAllowedException();
		$user_id = Sanitize::paranoid($user_id);
		$event_id = Sanitize::paranoid($event_id);

		$this->Event->query("DELETE FROM events_users WHERE user_id = '$user_id' AND event_id = '$event_id'");
		$this->Event->query("DELETE FROM event_properties WHERE user_id = '$user_id' AND event_id = '$event_id'");
		$this->Session->setFlash("The User ".$user_name." is no longer part of this event.");

		# WebSocket: Save which event has been updated to send the user a notification
		$this->Other->sendElephantWebSocket(array('type' => 'publishEvent', 'id' => ''.$event_id.''));

		$this->redirect(array('action' => 'edit', $event_id));
	}
}