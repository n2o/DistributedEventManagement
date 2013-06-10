<?php
class EventsController extends AppController {
	public $helpers = array('Html', 'Form', 'Session');
	public $components = array('Session');

	public function index() {
		$this->set('events', $this->Event->find('all'));
		$this->set('articleHeading', 'Show events');
	}

	public function view($id = null) {
		$this->set('articleHeading', 'Detailed event');
		if (!$id) {
			throw new NotFoundException(__('Invalid event.'));
		}

		$event = $this->Event->findById($id);
		if (!$event) {
			throw new NotFoundException(__('Invalid event.'));
		}
		$this->set('event', $event);
	}

	public function add() {
		$this->set('articleHeading', 'Add event');
		if ($this->request->is('post')) {  # Check if it is a valid HTTP POST requst
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

	public function edit($id = null) {
		$this->set('articleHeading', $event['Event']['title']);
		if (!$id) {
			throw new NotFoundException(__('Invalid event.'));
		}

		$event = $this->Event->findById($id);
		if (!$event) {
			throw new NotFoundException(__('Invalid event.'));
		}

		if ($this->request->is('post')||$this->request->is('put')) {
			$this->Event->id = $id;
			if ($this->Event->save($this->request->data)) {
				$this->Session->setFlash('Your event has been updated');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('Unable to update your event.');
			}
		}
		if (!$this->request->data) {	# If no new data has been entered, use the old one
			$this->request->data = $event;
		}
	}

	public function delete($id) {
		if ($this->request->is('get')) {
			throw new MethodNotAllowedException();
		}

		if ($this->Post->delete($id)) {
			$this->Session->setFlash('The post with id: '.$id.'has been deleted.');
			$this->redirect(array('action' => 'index'));
		}
	}
}






