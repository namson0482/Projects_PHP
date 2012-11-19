<?php

class impresscart_shipping_flatrate_model extends impresscart_model {    
  function update_setting( $data = array())
  {
  		$impresscart_shipping_methods = get_option('impresscart_shipping_methods', true);
  		if(!is_array($impresscart_shipping_methods)) $impresscart_shipping_methods =array();
  		
  		$impresscart_shipping_methods['impresscart']['shipping_method']['flatrate'] = $data['flatrate'];
		update_option('impresscart_shipping_methods', $impresscart_shipping_methods); 
  }
  
  function get_setting()
  {
  		$impresscart_shipping_methods = get_option('impresscart_shipping_methods', true);
  		if(is_array($impresscart_shipping_methods))
  		return @$impresscart_shipping_methods['impresscart']['shipping_method']['flatrate'];
  }
  
	function getQuote($address) {
		
		$flat_setting = $this->get_setting();
		$table = impresscart_framework::table('zone_to_geo_zone');
	  	$rows = $table->fetchAll( array(
	  					'conditions' => array(
	  						'geo_zone_id' => $flat_setting['geo_zone'],
	  						'country_id' => $address['country_id'],
	  						'or' => array(
	  							'zone_id' => $address['zone_id'],
	  							'zone_id=0'
	  						)
	  					)));
		
		if ($flat_setting['geo_zone']) {
			$status = true;
		} elseif (count($rows)) {
			$status = true;
		} else {
			$status = false;
		}
		
		$method_data = array();
	
		if ($status) {
			$quote_data = array();
			
	      	$quote_data['flatrate'] = array(
	        	'code'         => 'flatrate',
	        	'title'        => $flat_setting['name'],
	        	'cost'         => $flat_setting['cost'],
	        	'tax_class_id' => $flat_setting['tax_class'],
				'text'         => $this->currency->format($this->tax->calculate($flat_setting['cost'], $flat_setting['tax_class'], $this->config->get('tax')))
	      	);
	
	      	$method_data = array(
	        	'code'       => 'flatrate',
	        	'title'      => $flat_setting['name'],
	        	'quote'      => $quote_data,
				'sort_order' => $flat_setting['order'],
	        	'error'      => false
	      	);
		}
		
		return $method_data;
	}
  
}
?>