<?php

class impresscart_total_credit_model extends impresscart_model {

	function update_setting( $data = array()) {
		$impresscart_totals = get_option('impresscart_totals', true);
		
		if(!is_array($impresscart_totals)) { 
			$impresscart_totals =array();
		}
		$impresscart_totals['impresscart']['total']['credit'] = $data;
		update_option('impresscart_totals', $impresscart_totals);
	}

	function get_setting() {
		
		$impresscart_totals = get_option('impresscart_totals', true);
		if(is_array($impresscart_totals) && @$impresscart_totals['impresscart']['total']['credit']) {
			return @$impresscart_totals['impresscart']['total']['credit'];
		}
		
		return self::getDefaultValues();
	}
	
	public static function getDefaultValues() {
		return (array(
			'name' =>  'credit',
			'order' => '7',
			'status' => 'no',
			'code' => 'credit',
			));
	}
	


	public function getTotal(&$total_data, &$total, &$taxes) {
				
		$storeCredit = $this->customer->getStoreCreditAvaiables();
		if ((float)$storeCredit) {
			if ($storeCredit > $total) {
				$credit = $total;
			} else {
				$credit = $storeCredit;
			}
			if ($credit > 0) {
				$total_data[] = array(
					'code'       => 'credit',
					'title'      => __('Store Credit'),
					'text'       => $this->currency->format(-$credit),
					'value'      => -$credit,
					'sort_order' => $this->config->get('credit_sort_order')
				);
					
				$total -= $credit;
			}
		}
	}

}
?>