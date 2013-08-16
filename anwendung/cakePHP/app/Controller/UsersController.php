<?php
class UsersController extends AppController {
	public $helpers = array('Html', 'Form', 'Session', 'Event', 'User');

	# Execute in AppController the beforeFilter() function
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('add'); // Letting users register themselves
	}

	# Function to handle the login
	public function login() {
		# Automatic redirect if the user is already logged in
		if ($this->Session->read('Auth.User.id') != "") {
			$this->redirect(array('controller' => 'events', 'action' => 'index'));
		}
		if ($this->request->is('post')) {
			if ($this->Auth->login()) { # If login was successful
				if ($this->Session->read('Auth.User.has_login')) { # Check if has_login is set
					$this->Session->setFlash(__('Login was successful.'));
					$this->redirect($this->Auth->redirect());
				} else {
					$this->Session->setFlash(__('Your account has no permission to log in'));
				}
			} else {
				$this->Session->setFlash(__('Invalid username or password, try again.'));
			}
		}
	}

	public function logout() {
		$this->Session->setFlash(__('Logout was successful.'));
		$this->redirect($this->Auth->logout());
	}

	# Show list of users
	public function index() {
		$this->paginate = array('limit' => -1); # set how many users are shown
		$this->User->recursive = 0;
		$this->set('users', $this->paginate());
	}

	# Same code as it was in creating a post...
	public function view($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		$this->set('user', $this->User->read(null, $id));
	}

	# Add a new user to the database
	public function add() {
		# Load the Model Event to get access to the sql entries
		$this->loadModel('Event');
		$this->set('events', $this->Event->find('all'));


		if ($this->request->is('post')) {
			$this->User->create();
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved'));

				# Write all events in event_user
				$user_id = $this->User->getLastInsertID();
				$selected = $this->request->data['User']['selected_events'];
				if ($selected != "")
					for ($i = 0; $i < count($selected); $i++)
						$this->User->query("INSERT INTO events_users (event_id, user_id) VALUES (".$selected[$i].",".$user_id.") ON DUPLICATE KEY UPDATE user_id=".$user_id);
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
		}
	}

	# Edit an user
	public function edit($id = null) {
		# Load the Model Event to get access to the sql entries
		$this->loadModel('Event');
		$this->set('events', $this->Event->find('all'));
		$eventIds = $this->Event->find('list', array('fields' => array('id')));

		$mappedEvents = array();
		foreach ($eventIds as $event_id) {
			$mappedEvents += array($event_id => '0');
		}

		$this->User->id = $id;

		# Get all marked entries from events_users, where the user is assigned to
		$selectedFromSQL = $this->User->query("SELECT event_id FROM events_users WHERE user_id=$id");
		if (count($selectedFromSQL) > 0) {
			$i = 0;
			foreach ($selectedFromSQL as $key => $value)
				$selectedEventsOld[$i++] = $value['events_users']['event_id'];
			$this->set('selectedEventIDs', $selectedEventsOld);
		} else {
			$this->set('selectedEventIDs', null); # if no events are assigned, return NULL
		}

		if (!$this->User->exists())
			throw new NotFoundException(__('Invalid user'));

		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved'));

				# Write all events in event_user
				$selected = $this->request->data['User']['selected_events'];

				if ($selected != null) {
					# Mark selected events with 1, rest stays at 0
					foreach ($selected as $select)
						$mappedEvents[$select] = 1;
					
					foreach ($mappedEvents as $event => $value)
						if ($value == 1)
							$this->User->query("REPLACE INTO events_users (event_id, user_id) VALUES ($event, $id)");
						else 
							$this->User->query("DELETE FROM events_users WHERE user_id = $id AND event_id = $event");
				}

				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->User->read(null, $id);
			unset($this->request->data['User']['password']);
		}
	}

	# Delete an user
	public function delete($id = null) {
		if (!$this->request->is('post'))
			throw new MethodNotAllowedException();
		$this->User->id = $id;
		if (!$this->User->exists())
			throw new NotFoundException(__('Invalid user'));

		if ($this->User->delete()) {
			$this->User->query("DELETE FROM events_users WHERE user_id = $id");
			$this->Session->setFlash(__('User deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('User was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}