<?php

class impresscart_credit_total {
	
}

add_filter('impresscart_totals', 'impresscart_credit_total');
function impresscart_credit_total($methods) {
	$methods[] = array(
		'code' => 'credit',
		'title' => __('Total Credit'),
		'order' => 7,
	);
	return $methods;
}

add_filter('impresscart_application_path', 'impresscart_credit_total_application_path');  
function impresscart_credit_total_application_path($paths) {
	
	$paths[] = dirname(__FILE__);
    return $paths;
}



?>