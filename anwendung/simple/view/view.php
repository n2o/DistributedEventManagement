<?php
class View{

	private $path = 'templates';
	// setting default as current template
	private $template = 'default';

	/**
	 * Contains all the data in one array, ready to publish
	 */
	private $_ = array();

	/**
	 * Simple map to assign some values
	 *
	 * @param String $key Schlüssel
	 * @param String $value Variable
	 */
	public function assign($key, $value){
		$this->_[$key] = $value;
	}


	/**
	 * Choose which template is needed
	 *
	 * @param String $template Name des Templates.
	 */
	public function setTemplate($template = 'default'){
		$this->template = $template;
	}


	/**
	 * Load the template and return it
	 *
	 * @return string returns output of template
	 */
	public function loadTemplate(){
		$tpl = $this->template;
		// Pfad zum Template erstellen & überprüfen ob das Template existiert.
		$file = $this->path . DIRECTORY_SEPARATOR . $tpl . '.php';
		$exists = file_exists($file);

		if ($exists){
			// Store the output in a buffer and wait
			ob_start();

			// Include template file and store its output to $output
			include $file;
			$output = ob_get_contents();
			ob_end_clean();
				
			return $output;
		}
		else {
			return 'could not find template';
		}
	}
}
?>