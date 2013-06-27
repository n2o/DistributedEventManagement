<?php
class Event extends AppModel {
	public $validate = array(
		'title' => array('rule' => 'notEmpty'),
		'description' => array('rule' => 'notEmpty'));
	var $name = 'Event';
}