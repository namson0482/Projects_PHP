<?php

class impresscart_total_shippingtotal_model extends impresscart_model {

	function update_setting( $data = array()) {
		
		$impresscart_totals = get_option('impresscart_totals', true);
		if(!is_array($impresscart_totals)) {
			$impresscart_totals =array();
		}
		 
		$impresscart_totals['impresscart']['total']['shippingtotal'] = $data;
		update_option('impresscart_totals', $impresscart_totals);
	}
	 
	function get_setting() {
		$impresscart_totals = get_option('impresscart_totals', true);
		if(@$impresscart_totals['impresscart']['total']['shippingtotal'] && is_array($impresscart_totals)) {
			return @$impresscart_totals['impresscart']['total']['shippingtotal'];
		}
		return self::getDefaultValues();
		
	}
	
	public static function getDefaultValues() {
		return (array(
				'name' =>  'shippingtotal',
				'order' => '3',
				'status' => 'no',
				'code' => 'shippingtotal',
				));
	}
	
	public function getTotal(&$total_data, &$total, &$taxes) {
		if ($this->cart->hasShipping() && isset($this->session->data['shipping_method'])) {
			$total_data[] = array( 
				'code'       => 'shippingtotal',
        		'title'      => $this->session->data['shipping_method']['title'],
        		'text'       => $this->currency->format($this->session->data['shipping_method']['cost']),
        		'value'      => $this->session->data['shipping_method']['cost'],
				'sort_order' => $this->config->get('shipping_sort_order')
			);
			if ($this->session->data['shipping_method']['tax_class_id']) {
				$tax_rates = $this->tax->getRates($this->session->data['shipping_method']['cost'], $this->session->data['shipping_method']['tax_class_id']);
				foreach ($tax_rates as $tax_rate) {
					if (!isset($taxes[$tax_rate['tax_rate_id']])) {
						if(strcasecmp($tax_rate['type'], Goscom::GOSCOM_PERCENT) == 0) {
							$taxes[$tax_rate['tax_rate_id']] =  $tax_rate['amount'];
						}
					} else {
						if(strcasecmp($tax_rate['type'], Goscom::GOSCOM_PERCENT)    == 0) {
							$taxes[$tax_rate['tax_rate_id']] +=  $tax_rate['amount'];		
						} 
					}
				}
			}
			$total += $this->session->data['shipping_method']['cost'];
		}			
	}
		 
}
?>