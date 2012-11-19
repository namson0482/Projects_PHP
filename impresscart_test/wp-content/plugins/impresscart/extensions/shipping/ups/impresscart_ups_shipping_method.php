<?php

add_filter('impresscart_shipping_methods', 'impresscart_ups_shipping_method');
function impresscart_ups_shipping_method($methods)
{
	$methods[] = array(
		'code' => 'ups',
		'title' => __('UPS Shipping Method'),
	);
	return $methods;
}

add_filter('impresscart_application_path', 'impresscart_ups_shipping_method_application_path');  
function impresscart_ups_shipping_method_application_path($paths)
{
	$paths[] = dirname(__FILE__);
    return $paths;
}

?>