<?php
/*
Copyright 2010-2011 Impress Dev LLC. This software is distributed under the GNU General Public License version 2. 

Contact: support@impressdev.com
*/
/**
 *
 * @author giappv
 *
 */
//add_filter('impresscart_user_profile', 'impresscart_user_profile_metabox');



add_action( 'show_user_profile', 'extra_user_profile_fields' );
add_action( 'edit_user_profile', 'extra_user_profile_fields' );

function extra_user_profile_fields( $user ) {
	$html = '';
	ob_start();
	impresscart_framework::getInstance()->dispatch('/admin/user/index/' . $user->ID);
	$html .= ob_get_contents();
	ob_end_clean();
	echo $html;
}

add_action( 'personal_options_update', 'save_extra_user_profile_fields' );
add_action( 'edit_user_profile_update', 'save_extra_user_profile_fields' );

function save_extra_user_profile_fields( $user_id ) {
	
	$transactions = get_user_meta($user_id, 'transactions');
	update_user_meta($user_id, 'transactions', $_POST['impresscart']['credit']);
}
