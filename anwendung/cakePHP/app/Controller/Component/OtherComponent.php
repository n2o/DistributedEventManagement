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

	/**
	 * Send WebSockets via PHP. Used to publish changes in database
	 *
	 * Using the library of www.elephant.io
	 *
	 * @param: array $data = specify what data should be emitted. 
	 *						for example array('type' => 'publishEvent', 'id' => '1') 
	 */
	function sendElephantWebSocket($data) {
		try {
			$json = json_encode($data);
			// do not forget to set this in AppController.php
			$elephant = new ElephantIO\Client('http://'.$_SERVER['HTTP_HOST'].':9999', 'socket.io', 1, false, true, true);
			$elephant->init();
			$elephant->send(
				ElephantIO\Client::TYPE_EVENT,
				null,
				null,
				json_encode(array('name' => 'message', 'args' => $json))
			);
			$elephant->close();	
		} catch (Exception $e) {
		}
	}
}