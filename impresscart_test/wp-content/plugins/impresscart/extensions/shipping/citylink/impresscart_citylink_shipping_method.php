<?php

class impresscart_citylink_shipping_method {
	
}

add_filter('impresscart_shipping_methods', 'impresscart_citylink_shipping_method');
function impresscart_citylink_shipping_method($methods)
{
	$methods[] = array(
		'code' => 'citylink',
		'title' => __('Citylink Shipping Method'),
	);
	return $methods;
}

add_filter('impresscart_application_path', 'impresscart_citylink_shipping_method_application_path');  
function impresscart_citylink_shipping_method_application_path($paths)
{
	$paths[] = dirname(__FILE__);
    return $paths;
}

?>