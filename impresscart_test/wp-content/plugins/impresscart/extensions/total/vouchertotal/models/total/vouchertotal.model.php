<?php
class impresscart_total_vouchertotal_model extends impresscart_model {

	function update_setting( $data = array()) {
		$impresscart_totals = get_option('impresscart_totals', true);
		if(!is_array($impresscart_totals)) {
			$impresscart_totals =array();	
		}
		 
		$impresscart_totals['impresscart']['total']['vouchertotal'] = $data;
		update_option('impresscart_totals', $impresscart_totals);
	}
	 
	function get_setting() {
		$impresscart_totals = get_option('impresscart_totals', true);
		
		
		if(is_array($impresscart_totals) && @$impresscart_totals['impresscart']['total']['vouchertotal']) {
			return @$impresscart_totals['impresscart']['total']['vouchertotal'];
		}
		return self::getDefaultValues();
		
	}
	
	public static function getDefaultValues() {
		return (array(
				'name' =>  'voucher',
				'order' => '8',
				'status' => 'no',
				'code' => 'vouchertotal',
				));
	}

	public function getTotal(&$total_data, &$total, &$taxes) {
		
		if (isset($this->session->data['voucher'])) {
			$voucher_model = impresscart_framework::model('checkout/voucher');
			$voucher_info = $voucher_model->getVoucher($this->session->data['voucher'][0]['code']);
			if ($voucher_info) {
				if ($voucher_info['amount'] > $total) {
					$amount = $total;
				} else {
					$amount = $voucher_info['amount'];
				}
				 
				$total_data[] = array(
					'code'       => 'voucher',
        			'title'      => sprintf(__('Voucher'), $this->session->data['voucher']),
	    			'text'       => $this->currency->format(-$amount),
        			'value'      => -$amount,
					'sort_order' => $this->config->get('voucher_sort_order')
				);

				$total -= $amount;
			}
			
		}
	}

	public function confirm($order_info, $order_total) {
		$code = '';

		$start = strpos($order_total['title'], '(') + 1;
		$end = strrpos($order_total['title'], ')');

		if ($start && $end) {
			$code = substr($order_total['title'], $start, $end - $start);
		}

		$this->load->model('checkout/voucher');

		$voucher_info = $this->model_checkout_voucher->getVoucher($code);

		if ($voucher_info) {
			$this->model_checkout_voucher->redeem($voucher_info['voucher_id'], $order_info['order_id'], $order_total['value']);
		}
	}
}