<?php

class impresscart_handling_total {
        
}


add_filter('impresscart_totals', 'impresscart_handling_total');
function impresscart_handling_total($methods) {
	$methods[] = array(
		'code' => 'handling',
		'title' => __('Total Handling'),
		'order' => 10,
	);
	return $methods;
}

add_filter('impresscart_application_path', 'impresscart_handling_total_application_path');  
function impresscart_handling_total_application_path($paths) {
	
	$paths[] = dirname(__FILE__);
	
    return $paths;
}

?>