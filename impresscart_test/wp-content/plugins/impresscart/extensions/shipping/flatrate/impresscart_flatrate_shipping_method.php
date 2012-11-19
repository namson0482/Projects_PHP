<?php

class impresscart_flatrate_shipping_method {
	
}

add_filter('impresscart_shipping_methods', 'impresscart_flatrate_shipping_method');
function impresscart_flatrate_shipping_method($methods)
{
	$methods[] = array(
		'code' => 'flatrate',
		'title' => __('Flat Rate Shipping Method'),
	);
	return $methods;
}

add_filter('impresscart_application_path', 'impresscart_flatrate_shipping_method_application_path');  
function impresscart_flatrate_shipping_method_application_path($paths)
{
	$paths[] = dirname(__FILE__);
    return $paths;
}

?>