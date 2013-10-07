<?php
/**
 * Preparing view for Practices
 */
class PracticeController extends AppController {
	public $helpers = array('Html', 'Form', 'Session');
	public $components = array('Session');

	public function index() {}
	public function treatment() {}
	public function costs() {}
	public function tariffs() {}
	public function consultation() {}
	public function pics() {}
}