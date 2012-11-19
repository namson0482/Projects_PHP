<?php

class impresscart_coupontotal_total {
        
}


add_filter('impresscart_totals', 'impresscart_coupon_total');
function impresscart_coupon_total($methods) {
	$methods[] = array(
		'code' => 'coupontotal',
		'title' => __('Total Coupon'),
		'order' => 4,
	);
	return $methods;
}

add_filter('impresscart_application_path', 'impresscart_coupontotal_total_application_path');  
function impresscart_coupontotal_total_application_path($paths) {
	$paths[] = dirname(__FILE__);
    return $paths;
}

?>