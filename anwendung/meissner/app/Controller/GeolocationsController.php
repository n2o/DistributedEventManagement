<?php
/**
 * Controller for Geolocations, preparation for the view index()
 */
App::uses('Sanitize', 'Utility');
class GeolocationsController extends AppController {
	public $helpers = array('Html', 'Form', 'Session', 'Event', 'User');
	public $components = array('Session');

	# Show all the events 
	public function index() {}
}