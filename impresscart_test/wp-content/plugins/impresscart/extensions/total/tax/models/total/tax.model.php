<?php

class impresscart_total_tax_model extends impresscart_model {

	function update_setting( $data = array()) {
		$impresscart_totals = get_option('impresscart_totals', true);
		if(!is_array($impresscart_totals)) {
			$impresscart_totals =array();
		}
		 
		$impresscart_totals['impresscart']['total']['tax'] = $data;
		update_option('impresscart_totals', $impresscart_totals);
	}
	 
	function get_setting() {
		$impresscart_totals = get_option('impresscart_totals', true);
		if(is_array($impresscart_totals)) {
			return @$impresscart_totals['impresscart']['total']['tax'];
		}
		return self::getDefaultValues();
		
	}
	
	public static function getDefaultValues() {
		return (array(
				'name' =>  'tax',
				'order' => '5',
				'enabled' => 'no',
				'code' => 'tax',
				));
	}
	
	
	public function getTotal(&$total_data, &$total, &$taxes) {
		//
		foreach ($taxes as $key => $value) {
			if ($value > 0) {
				$total_data[] = array(
					'code'       => 'tax',
					'title'      => $this->tax->getRateName($key), 
					'text'       => $this->currency->format($value),
					'value'      => $value,
					'sort_order' => $this->config->get('tax_sort_order')
				);

				$total += $value;
			}
		}
	}
	 
}
?>