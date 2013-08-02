<?php 
App::uses('Component', 'Controller');
class StatsComponent extends Component {
	# Should be called within a controller: $this->Stats->example($this);
	public function example($obj) {
		$obj->loadModel('User');
		$obj->User->query("SELECT * FROM events");
	}

	/**
	 * Method to prepare properties with multiple values. 
	 *
	 * @param array $stats: all properties from event to be prepared
	 * @return array $dataCharts: array with prepared data for charts, like $dataCharts[columnName][differentValues][occurences]
	 */
	public function prepareCharts($stats) {
		$dataCharts = array();
		foreach ($stats as $column => $value)
			if (count($value) > 1)
				foreach ($value as $type => $sum)
					$dataCharts[$column][$type] = $sum;
		return $dataCharts;
	}

}