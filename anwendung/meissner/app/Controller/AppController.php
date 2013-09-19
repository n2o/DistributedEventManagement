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

	var $_jsVars = array(); # array to store system wide JavaScript variables

	var $isMobile = false;  # preparing for mobile view 

	# Specify here were to go to after login / logout
	public $components = array(
		'Session',
		'Auth' => array(
			'loginRedirect' => array('controller' => 'events', 'action' => 'index'),
			'logoutRedirect' => array('controller' => 'users', 'action' => 'login'),
			#'authorize' => array('Controller')
		),
		'Other'
	);

	# Store $value into the JS array
	private function setJsVar($name, $value) {
		$this->_jsVars[$name] = $value;
	}

	# Check the role of the clients
	public function isAuthorized($user) {
		# Admin can access every action
		if (isset($user['role']) && $user['role'] === 'admin') {
			return true;
		}
		# Default deny
		return false;
	}

	# Specifies what happens before the page is loaded
	public function beforeFilter() {
		parent::beforeFilter();

		# Guest can login and logout
		$this->Auth->allow('login', 'logout');

		# Make current username accessible for JavaScript
		$username = $this->Session->read('Auth.User.username');
		$username = Sanitize::paranoid($username, array(' '));
		$this->setJsVar('username', $username);
		$this->setJsVar('hostname', $_SERVER['HTTP_HOST']);
		$this->setJsVar('port', 9999); // do not forget to set this in OtherComponent.php
		$this->setJsVar('controller', $this->name);

		$id = $this->Session->read('Auth.User.id');

		# Prepare Publish/Subscribe for WebSocket server
		if (isset($id)) {
		# Create signature for syn message for websocket server
			require_once getcwd() . '/lib/ElephantIO/Client.php'; # includes library for socket.io
			$fileContents = file_get_contents(getcwd() . '/private.key');
			$privateKey = openssl_pkey_get_private($fileContents);

			$signature = "";
			if (!openssl_sign($username, $signature, $privateKey)) {
    			die('Failed to encrypt data');
			}
    		
    		# Remove $privateKey from RAM
    		openssl_free_key($privateKey);

    		$signature = base64_encode($signature);

			$synMessage = '{"name":"'.$username.'","type":"syn","sig":"'.$signature.'"}';
			$this->setJsVar('synMessage', $synMessage);

			$id = $this->Session->read('Auth.User.id');

			$subscriptions = array();
			# Set subscriptions
			$this->loadModel('User');
			$query = $this->User->query('SELECT id FROM events WHERE user_id = '.$id);
			$i = 0;
			foreach ($query as $key => $value) {
				$subscriptions[$i++] = $value['events']['id'];
			}

			# WebSocket: Save which events the user has subscribed
			$this->Other->sendElephantWebSocket(array('name'=>''.$username.'', 'type' => 'subscribe', 'events' => ''.json_encode($subscriptions).''));
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
		# Make JS variables accessible
		$this->set('jsVars', $this->_jsVars);

		# Prepare mobile view for all controllers
		if ($this->request->isMobile()||isset($this->request->query['mobile'])) {
			$this->viewClass = 'Theme';
			$this->theme = 'Mobile';    # Switch current theme to Mobile
			$this->layout = 'mobile';
		}
	}

	public function afterFilter() {
		parent::afterFilter();
		# if in mobile mode, check for a valid view and use it
		if (isset($this->is_mobile) && $this->is_mobile) {
			$view_file = file_exists( 'Views' . $this->name . DS . 'mobile/' . $this->action . '.ctp' );
			$layout_file = file_exists( 'Layouts' . 'mobile/' . $this->layout . '.ctp' );
			if($view_file || $layout_file) {
				$this->render($this->action, ($layout_file?'mobile/':'').$this->layout, ($view_file?'mobile/':'').$this->action);
			}
		}
	}
}