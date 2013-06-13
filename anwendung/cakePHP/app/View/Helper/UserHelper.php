<?php
App::uses('AppHelper', 'View/Helper');

class UserHelper extends AppHelper {

	# Get all events from SQL to create an array
	public function getAllEvents($events) {
        $elements = array();
        $elements[0] = 'None';
        foreach ($events as $event) {
	        $elements[$event['Event']['id']] = $event['Event']['title'];
		}
		unset($event);
		return $elements;
	}
}

?>