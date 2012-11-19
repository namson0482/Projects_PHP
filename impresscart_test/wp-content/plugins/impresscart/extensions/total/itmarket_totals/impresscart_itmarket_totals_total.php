<?php

class impresscart_impresscart_totals_total {
	
}

add_filter('impresscart_totals', 'impresscart_impresscart_totals_total');
function impresscart_impresscart_totals_total($methods) {
	$methods[] = array(
		'code' => 'impresscart_totals',
		'title' => __('Total impresscart_totals'),
	);
	return $methods;
}

add_filter('impresscart_application_path', 'impresscart_impresscart_totals_total_application_path');  
function impresscart_impresscart_totals_total_application_path($paths) {
	$paths[] = dirname(__FILE__);
    return $paths;
}



?>