<?php

class impresscart_total_ordertotal_model extends impresscart_model {

	
	function update_setting( $data = array()) {
		$impresscart_totals = get_option('impresscart_totals', true);
		if(!is_array($impresscart_totals)) {
			$impresscart_totals =array();
		}
		
		$impresscart_totals['impresscart']['total']['ordertotal'] = $data;
		update_option('impresscart_totals', $impresscart_totals);
	}
	 
	function get_setting() {
		$impresscart_totals = get_option('impresscart_totals', true);
		if(@$impresscart_totals['impresscart']['total']['ordertotal'] && is_array($impresscart_totals) ) {
			return @$impresscart_totals['impresscart']['total']['ordertotal'];
		}
		return self::getDefaultValues();
		
	}
	
	public static function getDefaultValues() {
		return (array(
				'name' =>  'Order_Total',
				'order' => '9',
				'status' => 'no',
				'code' => 'ordertotal',
				));
	}
	 
	
	public function getTotal(&$total_data, &$total, &$taxes) {		
		$total_data[] = array(
			'code'       => 'total',
			'title'      => __('Total','impressthemes'),
			'text'       => $this->currency->format(max(0, $total)),
			'value'      => max(0, $total),
			'sort_order' => ''
		);
	}
}
?>