<?php
class impresscart_weight_service extends impresscart_service {
	private $weights = array();

	public function __construct() {

		global $wpdb;

		$this->db = $wpdb;
		$this->config = impresscart_framework::service('config');
		$this->session = impresscart_framework::service('session');

		$weightTable = impresscart_framework::table('unit');

		$rows = $weightTable->fetchAll(array('conditions' => array(
											'type' => 'weight'
										)), ARRAY_A);
		foreach ($rows as $result) {
			$this->weights[$result['unit_id']] = array(
				'weight_class_id' => $result['unit_id'],
				'title'           => $result['title'],
				'unit'            => $result['unit'],
				'value'           => $result['value']
			);
		}
	}

  	public function convert($value, $from, $to) {
		if ($from == $to) {
      		return $value;
		}

		if (!isset($this->weights[$from]) || !isset($this->weights[$to])) {
			return $value;
		} else {
			$from = $this->weights[$from]['value'];
			$to = $this->weights[$to]['value'];

			return $value * ($to / $from);
		}
  	}

	public function format($value, $weight_class_id, $decimal_point = '.', $thousand_point = ',') {
		if (isset($this->weights[$weight_class_id])) {
    		return number_format($value, 2, $decimal_point, $thousand_point) . $this->weights[$weight_class_id]['unit'];
		} else {
			return number_format($value, 2, $decimal_point, $thousand_point);
		}
	}

	public function getUnit($weight_class_id) {
		if (isset($this->weights[$weight_class_id])) {
    		return $this->weights[$weight_class_id]['unit'];
		} else {
			return '';
		}
	}
}
?>