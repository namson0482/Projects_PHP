<?php

class impresscart_shippingtotaltotal_total {
        
}


add_filter('impresscart_totals', 'impresscart_shippingtotal_total');
function impresscart_shippingtotal_total($methods) {
	$methods[] = array(
		'code' => 'shippingtotal',
		'title' => __('Total Shipping_Total'),
		'order' => 3,
	);
	return $methods;
}

add_filter('impresscart_application_path', 'impresscart_shippingtotal_total_application_path');  
function impresscart_shippingtotal_total_application_path($paths) {
	$paths[] = dirname(__FILE__);
    return $paths;
}

?>