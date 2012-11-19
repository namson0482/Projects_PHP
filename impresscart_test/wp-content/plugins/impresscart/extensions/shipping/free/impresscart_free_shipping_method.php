<?php

class impresscart_free_shipping_method {
	
}

add_filter('impresscart_shipping_methods', 'impresscart_free_shipping_method');
function impresscart_free_shipping_method($methods)
{
	$methods[] = array(
		'code' => 'free',
		'title' => __('Free Shipping Method'),
	);
	return $methods;
}

add_filter('impresscart_application_path', 'impresscart_free_shipping_method_application_path');  
function impresscart_free_shipping_method_application_path($paths)
{
	$paths[] = dirname(__FILE__);
    return $paths;
}

?>