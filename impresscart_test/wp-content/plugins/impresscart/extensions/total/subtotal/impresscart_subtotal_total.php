<?php

class impresscart_subtotal_total {
        
}


add_filter('impresscart_totals', 'impresscart_subtotal_total');
function impresscart_subtotal_total($methods) {
	$methods[] = array(
		'code' => 'subtotal',
		'title' => __('Total Sub_Total'),
		'order' => 1,
	);
	return $methods;
}

add_filter('impresscart_application_path', 'impresscart_subtotal_total_application_path');  
function impresscart_subtotal_total_application_path($paths) {
	$paths[] = dirname(__FILE__);
    return $paths;
}

?>