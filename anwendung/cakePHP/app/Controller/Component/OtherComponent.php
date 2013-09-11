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
		$reading = fopen('manifest.version', 'r');
		$writing = fopen('manifest.version.tmp', 'w');

		$replaced = false;

		while (!feof($reading)) {
			$line = fgets($reading);
			$line = (int) $line + 1; 
			
			if ($line > 1000)
				$line = 0;

			fputs($writing, $line);
		}
		fclose($reading); fclose($writing);
		// might as well not overwrite the file if we didn't replace anything
		rename('manifest.version.tmp', 'manifest.version');
	}
}