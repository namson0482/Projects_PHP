<?php

class impresscart_loworderfee_total {
	
}

add_filter('impresscart_totals', 'impresscart_loworderfee_total');
function impresscart_loworderfee_total($methods) {
	$methods[] = array(
		'code' => 'loworderfee',
		'title' => __('Total Low Order Fee'),
		'order' => 11,
	);
	return $methods;
}

add_filter('impresscart_application_path', 'impresscart_loworderfee_total_application_path');  
function impresscart_loworderfee_total_application_path($paths) {
	$paths[] = dirname(__FILE__);
    return $paths;
}



?>