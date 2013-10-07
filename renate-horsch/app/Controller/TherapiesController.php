<?php
/**
 * Preparing view for Therapies
 */
class TherapiesController extends AppController {
	public $helpers = array('Html', 'Form', 'Session');
	public $components = array('Session');

	# Show all the events 
	public function index() {}
	public function children() {}
	public function classic() {}
	public function medical() {}
	public function psychotherapy() {}
	public function psychotherapy_rogers() {}
}