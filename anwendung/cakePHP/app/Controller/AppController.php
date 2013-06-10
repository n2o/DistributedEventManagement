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
    // Admin can access every action
        if (isset($user['role']) && $user['role'] === 'admin') {
            return true;
        }

        // Default deny
        return false;
    }

	# Specify which pages can be accessed without being logged in
    public function beforeFilter() {
        parent::beforeFilter();
        # Guest can login and logout
        $this->Auth->allow('login', 'logout');

        if($this->request->isMobile()||isset($this->params['url']['mobile'])) {
            $this->layout = 'mobile';
            $this->isMobile = true;
        }
        $this->set('is_mobile', $this->isMobile);
    }

    # Prepare mobile view for all controllers
    public function beforeRender() {
        if ($this->request->is('mobile')||isset($this->request->query['mobile'])) {
            $this->viewClass = 'Theme';
            $this->theme = 'Mobile';
            $this->layout = 'mobile';
        }
        parent::beforeRender();

#        if ($this->isMobile) {
 #           $this->action = 'mobile/' . $this->action;
  #      }
    }
}
