<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
	public $helpers = array('Html', 'Form', 'Session', 'Event', 'User');

	var $isMobile = false;  # preparing for mobile view 

	# Specify here were to go to after login / logout
	public $components = array(
		'Session',
		'Auth' => array(
			'loginRedirect' => array('controller' => 'events', 'action' => 'index'),
			'logoutRedirect' => array('controller' => 'users', 'action' => 'login'),
			#'authorize' => array('Controller')
		)
	);

	public function isAuthorized($user) {
		# Admin can access every action
		if (isset($user['role']) && $user['role'] === 'admin')
			return true;

		# Default deny
		return false;
	}

	# Specifies what happens before the page is loaded
	public function beforeFilter() {
		parent::beforeFilter();

		# Make current username accessible for JavaScript
		$this->set('username', $this->Session->read('Auth.User.username'));

		# Guest can login and logout
		$this->Auth->allow('login', 'logout');
		$id = $this->Session->read('Auth.User.id');

		$i = 0;

		# Create an array $subscriptions where all events  created by the user are stored
		if (isset($id)) {
			$this->loadModel('User');
			$query = $this->User->query('SELECT id FROM events WHERE user_id = '.$id);
			foreach ($query as $key => $value)
				$subscriptions[$i++] = array('event' => $value['events']['id']);

			$this->set('subscriptions', json_encode($subscriptions));
		}

		# if device is mobile, change layout to mobile
		if ($this->request->isMobile()) {
			$this->layout = 'mobile';
			# and if a mobile view file has been created for the action, serve it instead of the default view file
			$mobileViewFile = strtolower($this->params['controller']) . '/mobile/' . $this->params['action'] . '.ctp';
			if (file_exists($mobileViewFile)) {
				$mobileView = strtolower($this->params['controller']) . '/mobile/';
				$this->viewPath = $mobileView;
			}
		}

		$this->set('is_mobile', $this->isMobile);
	}

	# Specifies what happens before the page is shown
	public function beforeRender() {
		parent::beforeRender();
		# Prepare mobile view for all controllers
		if ($this->request->isMobile()||isset($this->request->query['mobile'])) {
			$this->viewClass = 'Theme';
			$this->theme = 'Mobile';    # Switch current theme to Mobile
			$this->layout = 'mobile';
		}
	}

	public function afterFilter() {
	# if in mobile mode, check for a valid view and use it
		if (isset($this->is_mobile) && $this->is_mobile) {
			$view_file = file_exists( 'Views' . $this->name . DS . 'mobile/' . $this->action . '.ctp' );
			$layout_file = file_exists( 'Layouts' . 'mobile/' . $this->layout . '.ctp' );
			if($view_file || $layout_file)
				$this->render($this->action, ($layout_file?'mobile/':'').$this->layout, ($view_file?'mobile/':'').$this->action);
		}
	}
}