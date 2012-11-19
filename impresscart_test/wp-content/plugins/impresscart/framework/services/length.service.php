<?php
class impresscart_length_service extends impresscart_service {
	
	private $lengths = array();
	
	public function __construct() {
		
		global $wpdb;
		
		# length options
		$rows = impresscart_framework::table('unit')->fetchAll(array('conditions' => array( 'type' => 'length')));
			
    	foreach ($rows as $result) {
      		$this->lengths[$result->unit_id] = array(
				'length_class_id' => $result->unit_id,
        		'title'           => $result->title,
				'unit'            => $result->unit,
				'value'           => $result->value
      		);
    	}
  	}
	  
  	public function convert($value, $from, $to) {
		if ($from == $to) {
      		return $value;
		}
		
		if (isset($this->lengths[$from])) {
			$from = $this->lengths[$from]['value'];
		} else {
			$from = 0;
		}
		
		if (isset($this->lengths[$to])) {
			$to = $this->lengths[$to]['value'];
		} else {
			$to = 0;
		}		
		
		if($from == 0)
		{
			return 0;
		}
		
      	return $value * ($to / $from);
  	}

	public function format($value, $length_class_id, $decimal_point = '.', $thousand_point = ',') {
		if (isset($this->lengths[$length_class_id])) {
    		return number_format($value, 2, $decimal_point, $thousand_point) . $this->lengths[$length_class_id]['unit'];
		} else {
			return number_format($value, 2, $decimal_point, $thousand_point);
		}
	}
	
	public function getUnit($length_class_id) {
		if (isset($this->lengths[$length_class_id])) {
    		return $this->lengths[$length_class_id]['unit'];
		} else {
			return '';
		}
	}		
}
?>