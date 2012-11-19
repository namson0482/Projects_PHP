<?php

class impresscart_payment_paypalstandard_model extends impresscart_model {    
  function update_setting( $data = array())
  {
	  	$impresscart_payment_methods = get_option('impresscart_payment_methods', true);
  		if(!is_array($impresscart_payment_methods)) $impresscart_payment_methods =array();
		
  		
  		$impresscart_payment_methods['impresscart']['payment_method']['paypalstandard'] = $data['paypalstandard'];
		update_option('impresscart_payment_methods', $impresscart_payment_methods);
  }
  
  function get_setting()
  {
	  	$impresscart_payment_methods = get_option('impresscart_payment_methods', true);
  		if(is_array($impresscart_payment_methods))
  		{  			
  			return @$impresscart_payment_methods['impresscart']['payment_method']['paypalstandard'];
  		}
  		return null;
  }
  
}
?>