<?php
/**
 * Preparing view for Chats
 */
App::uses('Sanitize', 'Utility');
class ChatsController extends AppController {
	public $helpers = array('Html', 'Form', 'Session', 'Event', 'User');
	public $components = array('Session');

	# Show all the events 
	public function index() {}
}