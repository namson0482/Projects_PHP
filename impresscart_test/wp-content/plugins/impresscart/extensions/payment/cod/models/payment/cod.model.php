<?php

class impresscart_payment_cod_model extends impresscart_model {    
  function update_setting( $data = array())
  {
  		$impresscart_payment_methods = get_option('impresscart_payment_methods', true);
  		if(!is_array($impresscart_payment_methods)) $impresscart_payment_methods =array();
  		
  		$impresscart_payment_methods['impresscart']['payment_method']['cod'] = $data['cod'];
		update_option('impresscart_payment_methods', $impresscart_payment_methods); 
  }
  
  function get_setting()
  {
  		$impresscart_payment_methods = get_option('impresscart_payment_methods', true);
  		if(is_array($impresscart_payment_methods))
  		return $impresscart_payment_methods['impresscart']['payment_method']['cod'];
  }
  
}
?>