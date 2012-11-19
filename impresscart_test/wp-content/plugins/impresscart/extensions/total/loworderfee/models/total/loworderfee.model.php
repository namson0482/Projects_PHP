<?php

class impresscart_total_loworderfee_model extends impresscart_model {
	
	
	function update_setting( $data = array()) {
		$impresscart_totals = get_option('impresscart_totals', true);
		if(!is_array($impresscart_totals)) {
			$impresscart_totals =array();
		}
		 
		$impresscart_totals['impresscart']['total']['loworderfee'] = $data;
		update_option('impresscart_totals', $impresscart_totals);
	}
	 
	function get_setting() {
		$impresscart_totals = get_option('impresscart_totals', true);
		if(is_array($impresscart_totals) && @$impresscart_totals['impresscart']['total']['loworderfee']) {
			return @$impresscart_totals['impresscart']['total']['loworderfee'];
		}
		return self::getDefaultValues();
		
	}
	
	public static function getDefaultValues() {
		return (array(
				'name' =>  'loworderfee',
				'order' => '11',
				'status' => 'no',
				'code' => 'loworderfee',
				));
	}
	
	public function getTotal(&$total_data, &$total, &$taxes) {

		if ($this->cart->getSubTotal() && ($this->cart->getSubTotal() < $this->config->get('loworderfee_total'))) {

			$total_data[] = array(
				'code'       => 'loworderfee',
        		'title'      => __('Low order fee','impressthemes'),
        		'text'       => $this->currency->format($this->get('fee')),
        		'value'      => $this->get('fee'),
				'sort_order' => $this->get('sort_order')
			);


			$total += $this->get('fee');
		}
	}
	
}
?>