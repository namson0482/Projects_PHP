<?php

class impresscart_voucher_total {
        
}


add_filter('impresscart_totals', 'impresscart_voucher_total');
function impresscart_voucher_total($methods) {
	$methods[] = array(
		'code' => 'vouchertotal',
		'title' => __('Total Voucher'),
		'order' => 8,
	);
	return $methods;
}

add_filter('impresscart_application_path', 'impresscart_voucher_total_application_path');  
function impresscart_voucher_total_application_path($paths) {
	$paths[] = dirname(__FILE__);
    return $paths;
}

?>