<?php

class impresscart_total_subtotal_model extends impresscart_model {

	function update_setting( $data = array()) {
		$impresscart_totals = get_option('impresscart_totals', true);
		if(!is_array($impresscart_totals)) {
			$impresscart_totals =array();
		}
		 
		$impresscart_totals['impresscart']['total']['subtotal'] = $data;
		update_option('impresscart_totals', $impresscart_totals);
	}
	 
	function get_setting() {
		$impresscart_totals = get_option('impresscart_totals', true);
		if(is_array($impresscart_totals)) {
			return @$impresscart_totals['impresscart']['total']['subtotal'];
		}
		return self::getDefaultValues();
		
	}
	
	public static function getDefaultValues() {
		return (array(
				'name' =>  'subtotal',
				'order' => '1',
				'status' => 'no',
				'code' => 'subtotal',
				));
	}
	 
	public function getTotal(&$total_data, &$total, &$taxes) {
		
		$subtotal = $this->cart->getSubTotal();
		if(isset($this->session->data['vouchers']) && $this->session->data['vouchers']) {
			foreach ($this->session->data['vouchers'] as $voucher) {
				$subtotal += $voucher['amount'];
			}
		}
		
		$total_data[] = array( 
			'code'       => 'subtotal',
			'title'      => __('Sub Total', 'impressthemes'),
			'text'       => $this->currency->format($subtotal),
			'value'      => $subtotal,
			'sort_order' => $this->config->get('subtotal_sort_order')
		);
		$total += $subtotal;
	}
	 
}
?>