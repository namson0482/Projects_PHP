<?php

class impresscart_reward_total {
	
}

add_filter('impresscart_totals', 'impresscart_reward_total');
function impresscart_reward_total($methods) {
	$methods[] = array(
		'code' => 'reward',
		'title' => __('Total Reward'),
		'order' => 2,
	);
	return $methods;
}

add_filter('impresscart_application_path', 'impresscart_reward_total_application_path');  
function impresscart_reward_total_application_path($paths) {
	$paths[] = dirname(__FILE__);
    return $paths;
}



?>