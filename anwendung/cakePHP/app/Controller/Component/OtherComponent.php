<?php 
App::uses('Component', 'Controller');
class OtherComponent extends Component {

	/**
	 * Create notification on screen
	 * Possible types: alert, success, error, warning, information, confirm
	 */
	public function noty($text, $type) {
		echo "<script>noty({text: $text, type: $type});</script>";
	}

}