<?php 

class impresscart_cod_payment_method 
{
	
}


add_filter('impresscart_payment_methods', 'impresscart_cod_payment_method');
function impresscart_cod_payment_method($methods)
{
	$methods[] = array(
		'code' => 'cod',
		'title' => __('Cash on delivery'),
	);
	return $methods;
}

add_filter('impresscart_application_path', 'impresscart_cod_payment_method_application_path');  
function impresscart_cod_payment_method_application_path($paths)
{
	$paths[] = dirname(__FILE__);
    return $paths;
}

?>