<?php
class UsersController extends AppController {

	# Execute in AppController the beforeFilter() function
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('add'); // Letting users register themselves
	}

	public function login() {
        $this->set('articleHeading', 'Login');
	    if ($this->request->is('post')) {
	        if ($this->Auth->login()) {
                $this->Session->setFlash(__('Login was successful.'));
	            $this->redirect($this->Auth->redirect());
	        } else {
	            $this->Session->setFlash(__('Invalid username or password, try again'));
	        }
	    }
	}

	public function logout() {
        $this->set('articleHeading', 'Logout');
        $this->Session->setFlash(__('Logout was successful.'));
		$this->redirect($this->Auth->logout());
	}

	# Show login form
	public function index() {
        $this->set('articleHeading', 'Show users');
        $this->User->recursive = 0;
        $this->set('users', $this->paginate());
    }

	# Same code as it was in creating a post...
	public function view($id = null) {
        $this->set('articleHeading', 'View user');
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        $this->set('user', $this->User->read(null, $id));
    }

	# Add a new user to the database
	public function add() {
        $this->set('articleHeading', 'Add user');
        if ($this->request->is('post')) {
            $this->User->create();
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('The user has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The user could not be saved. Please, try again.'));
            }
        }
    }

	# Edit an user
	public function edit($id = null) {
        $this->set('articleHeading', 'Edit user');
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('The user has been saved'));
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
        $this->set('articleHeading', 'Delete user');
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->User->delete()) {
            $this->Session->setFlash(__('User deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('User was not deleted'));
        $this->redirect(array('action' => 'index'));
    }
}