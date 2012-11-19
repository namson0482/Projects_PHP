<?php

class impresscart_shipping_citylink_model extends impresscart_model {    
  function update_setting( $data = array())
  {
  		$impresscart_shipping_methods = get_option('impresscart_shipping_methods', true);
  		if(!is_array($impresscart_shipping_methods)) $impresscart_shipping_methods =array();
  		
  		$impresscart_shipping_methods['impresscart']['shipping_method']['citylink'] = $data['citylink'];
		update_option('impresscart_shipping_methods', $impresscart_shipping_methods); 
  }
  
  function get_setting()
  {
  		$impresscart_shipping_methods = get_option('impresscart_shipping_methods', true);
  		if(is_array($impresscart_shipping_methods))
  		return $impresscart_shipping_methods['impresscart']['shipping_method']['citylink'];
  }
  
function getQuote($address) {
	
		$setting = $this->get_setting();
	
		$table = impresscart_framework::table('zone_to_geo_zone');
	  	$rows = $table->fetchAll( array(
  			'conditions' => array(
	  			'geo_zone_id' => $setting['citylink_geo_zone_id'],
	  			'country_id' => $address['country_id'],
	  			'or' => array(
	  				'zone_id' => $address['zone_id'],
	  				'zone_id=0'
  			)
  			)
  		));
	
	
		
		
		if (!$setting['citylink_geo_zone_id']) {
			$status = true;
		} elseif (count($rows)) {
			$status = true;
		} else {
			$status = false;
		}
		

		$method_data = array();
	
		if ($status) {
			$cost = 0;
			$weight = $this->cart->getWeight();
			
			$rates = explode(',', $setting['citylink_rate']);
			
			foreach ($rates as $rate) {
  				$data = explode(':', $rate);
  					
				if ($data[0] >= $weight) {
					if (isset($data[1])) {
    					$cost = $data[1];
					}
					
   					break;
  				}
			}
			
			$quote_data = array();
			
			if ((float)$cost) {
				$quote_data['citylink'] = array(
        			'code'         => 'citylink.citylink',
        			'title'        => __('text_title') . '  (' . __('text_weight') . ' ' . $this->weight->format($weight, $this->config->get('weight_class_id')) . ')',
        			'cost'         => $cost,
        			'tax_class_id' => $setting['citylink_tax_class_id'],
					'text'         => $this->currency->format($this->tax->calculate($cost, $setting['citylink_tax_class_id'], $this->config->get('tax')))
      			);
				
      			$method_data = array(
        			'code'       => 'citylink',
        			'title'      => __('text_title'),
        			'quote'      => $quote_data,
					'sort_order' => @$setting['citylink_sort_order'],
        			'error'      => false
      			);
			}
		}
	
		return $method_data;
	}
  
}
?>