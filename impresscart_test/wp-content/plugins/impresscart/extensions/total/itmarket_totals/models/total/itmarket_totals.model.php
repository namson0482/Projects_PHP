<?php

class impresscart_total_impresscart_totals_model extends impresscart_model {

	
	function update_setting( $data = array()) {
		
		$impresscart_totals = get_option('impresscart_totals', true);
		if(!is_array($impresscart_totals)) {
			$impresscart_totals =array();
		}
		 
		$impresscart_totals['impresscart']['total']['impresscart_totals'] = $data['impresscart_totals'];
		update_option('impresscart_totals', $impresscart_totals);
	}
	 
	function get_setting() {
		
		$impresscart_totals = get_option('impresscart_totals', true);
		if(is_array($impresscart_totals)) {
			return $impresscart_totals['impresscart']['total']['impresscart_totals'];
		}
		return self::getDefaultValues();
		
	}
	
	public static function getDefaultValues() {
		return (array(
				'name' =>  'impresscart_totals',
				'order' => '1',
				'status' => 'no',
				'code' => 'impresscart_totals',
				));
	}

	static function get_enabled_totals() {
			
		$impresscart_totals = get_option('impresscart_totals', true);
			
		$enabled_totals = array();
			
		foreach($impresscart_totals['impresscart']['total'] as $key => $setting)
		{
			if($setting['status'] == 'yes')
			{
				$enabled_totals[$key] = array(
						'code' => $setting['code'],
						'title' => $setting['name'],
						'sort_order' => $setting['order'],
				);
			}
		}

		return $enabled_totals;
	}

}
?>