<?php
# private user (logged in user)
add_action('wp_ajax_framework', 'wp_ajax_framework_callback');

# noprivate user (not logged in user)
add_action('wp_ajax_nopriv_framework', 'wp_ajax_framework_callback');

function wp_ajax_framework_callback() {
	
	# TODO: must have a filter here to allow user to access allowed actions
	# without this fix the big hole of security will be here

	# @example:
	# - public user can't access admin action
	# - something like that

	
	$baseParams = array(
		'action' => $_REQUEST['action'],
	);

	impresscart_framework::getInstance()
		->setBaseParams($baseParams)
		->dispatch();
	exit(0);
}