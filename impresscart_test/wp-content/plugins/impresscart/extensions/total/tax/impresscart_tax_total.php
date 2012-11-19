<?php

class impresscart_tax_total {
	
}

add_filter('impresscart_totals', 'impresscart_tax_total');
function impresscart_tax_total($methods) {
	$methods[] = array(
		'code' => 'tax',
		'title' => __('Total Tax'),
		'order' => 5,
	);
	return $methods;
}

add_filter('impresscart_application_path', 'impresscart_tax_total_application_path');  
function impresscart_tax_total_application_path($paths) {
	$paths[] = dirname(__FILE__);
    return $paths;
}



?>