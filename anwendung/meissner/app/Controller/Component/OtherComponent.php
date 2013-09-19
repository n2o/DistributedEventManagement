<?php 
App::uses('Component', 'Controller');
class OtherComponent extends Component {
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
			// $elephant = new ElephantIO\Client('https://'.$_SERVER['HTTP_HOST'].':9999', 'socket.io', 1, false, true, true);
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

	/**
	 * Force clients to get updates from server if the data in SQL database has changed
	 *
	 * Needed for a proper use of Application Cache
	 */
	function incrementManifestVersion() {
		$version = file_get_contents("manifest.version");
		$version = (int) $version + 1;
		file_put_contents("manifest.version", $version);
	}

	/**
	 * Method to prepare properties with multiple values. 
	 *
	 * This method gets all entries from event_columns and the data from event_properties from the Controller
	 * and prepares the data provided by these tables to be easier accessed in the Views. It only sorts the
	 * data new for better usability
	 */
	public function prepareCharts($stats) {
		return array_filter($stats, function($v) {
			return count($v) > 1;
		});
	}
}