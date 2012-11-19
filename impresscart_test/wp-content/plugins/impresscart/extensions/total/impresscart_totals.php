<?php

class impresscart_totals {
	
	
		static function restoreDefaults() {
			$defaults = array(
				'voucher' => array(
							'name' =>  'voucher' ,
  						    'order' =>  '8' ,
      						'status' =>  'yes' ,
      						'code' =>  'vouchertotal' ,
							),
							
				'coupon' => array(
					      'name' =>  'coupon' ,
					      'order' =>  '4' ,
					      'status' =>  'yes' ,
					      'code' =>  'coupontotal' ,
						  ),
				'credit' => array(  
					      'name' =>  'credit' ,
					      'order' =>  '7' ,
					      'status' =>  'yes' ,
					      'code' =>  'credit' ,
						  ),
						  
				'handling' => array(
					      'name' =>  'handling' ,
					      'order' =>  '10' ,
					      'status' =>  'yes' ,
					      'code' =>  'handling' ,
						  ),
						  
				'subtotal' => array(
					    
					      'name' =>  'subtotal' ,
					      'order' =>  '1' ,
					      'status' =>  'yes' ,
					      'code' =>  'subtotal' ,
						  ),
						  
				'tax' => array(
					      'name' =>  'tax' ,
					      'order' =>  '5' ,
					      'status' =>  'yes' ,
					      'code' =>  'tax' ,
						  ),
						  
				'loworderfee' => array(
					      'name' =>  'loworderfee' ,
					      'order' =>  '11' ,
					      'status' =>  'yes' ,
					      'code' =>  'loworderfee' ,
						  ),

				'ordertotal' => array(
				      'name' =>  'ordertotal' ,
				      'order' =>  '9' ,
				      'status' =>  'yes' ,
				      'code' =>  'ordertotal' ,
					  ),
				  
				'reward' => array(
				      'name' =>  'reward' ,
				      'order' =>  '2' ,
				      'status' =>  'yes' ,
				      'code' =>  'reward' ,
					  ),		  
	  
  				'shippingtotal' => array(
				      'name' =>  'shippingtotal' ,
				      'order' =>  '3' ,
				      'status' =>  'yes' ,
				      'code' =>  'shippingtotal' ,
					  ),
			);
			//Sub-Total 1 Total 9 
			$impresscart_totals = get_option('impresscart_totals', true);
			$impresscart_totals['impresscart']['total'] = $defaults;
			$update = update_option('impresscart_totals', $impresscart_totals);
		}
		
		static function dumpAllExtensionTotals() {
			$impresscart_totals = get_option('impresscart_totals', true);
			var_dump($impresscart_totals['impresscart']['total']);
		}
		
		static function get_all_totals() {
			$impresscart_totals = get_option('impresscart_totals', true);
			$enabled_totals = array();
			if(is_array(@$impresscart_totals['impresscart']['total'])) {
				foreach($impresscart_totals['impresscart']['total'] as $key => $setting) {
					$enabled_totals[$key] = array(
						'code' => $setting['code'],
						'title' => $setting['name'],
						'order' => $setting['order'],
						'status' => $setting['status'],
					);
				}
			}
			return $enabled_totals;
		}

		static function get_enabled_totals() {
			$impresscart_totals = get_option('impresscart_totals', true);
			$enabled_totals = array();
			$temp = array();
			$sort_order = array();
			if(is_array($impresscart_totals)) {
				foreach($impresscart_totals['impresscart']['total'] as $key => $setting) {
					if($setting['status'] == 'yes') {						
						$temp[$setting['order']] = array($key,$setting);						
					}
				}			
				
				ksort($temp);
				foreach($temp as $row ) {
					$enabled_totals[$row[0]] = array(
							'code' => $row[1]['code'],
							'title' => $row[1]['name'],
							'order' => $row[1]['order'],
						);
				}
			}
			
			return $enabled_totals;
		}
		
}
