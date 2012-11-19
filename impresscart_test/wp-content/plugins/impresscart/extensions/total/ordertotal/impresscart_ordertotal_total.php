<?php

class impresscart_ordertotal_total {
	
}

add_filter('impresscart_totals', 'impresscart_ordertotal_total');
function impresscart_ordertotal_total($methods) {
	$methods[] = array(
		'code' => 'ordertotal',
		'title' => __('Total Order_Total'),
		'order' => 9,
	);
	return $methods;
}

add_filter('impresscart_application_path', 'impresscart_ordertotal_total_application_path');  
function impresscart_ordertotal_total_application_path($paths) {
	$paths[] = dirname(__FILE__);
    return $paths;
}




?>