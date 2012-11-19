<?php 
class impresscart_paypalstandard_payment_method 
{
}


add_filter('impresscart_payment_methods', 'impresscart_paypalstandard_payment_method');
function impresscart_paypalstandard_payment_method($methods)
{
	$methods[] = array(
		'code' => 'paypalstandard',
		'title' => __('Paypal Standard '),
	);
	return $methods;
}

add_filter('impresscart_application_path', 'impresscart_paypalstandard_payment_method_application_path');  
function impresscart_paypalstandard_payment_method_application_path($paths)
{
	$paths[] = dirname(__FILE__);
    return $paths;
}

?>