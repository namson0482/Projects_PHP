<?php
/*
 Plugin Name: Impress Cart
 Plugin URI: http://impressthemes.com/impresscart/
 Description: An eCommerce plugin for wordpress.
 Version: 1.0
 Author: impressthemes
 Author URI: http://impressthemes.com
 License: GPLv2
 */

/*
Copyright 2010-2011 Impress Dev LLC. This software is distributed under the GNU General Public License version 2. 

Contact: support@impressdev.com
*/

/*
 * internationalization
 */


//define constants
if (!defined('IMPRESSCART_VERSION')) define('IMPRESSCART_VERSION', '1.0');

define('IMPRESSCART_PATH', dirname(__FILE__));
define('IMPRESSCART_LANGUAGES',IMPRESSCART_PATH . '/languages' );
define('IMPRESSCART_URL', plugins_url( '' , __FILE__ ));
define('IMPRESSCART_CSS',  plugins_url( 'assets/css' , __FILE__ ));
define('IMPRESSCART_JS',  plugins_url( 'assets/js' , __FILE__ ));
define('IMPRESSCART_IMAGES',  plugins_url( 'assets/images' , __FILE__ ));
define('IMPRESSCART_INCLUDE', IMPRESSCART_PATH . '/includes');
define('IMPRESSCART_CLASSES', IMPRESSCART_INCLUDE . '/classes');
define('IMPRESSCART_EXTENSION', IMPRESSCART_PATH . '/extensions');
define('IMPRESSCART_WIDGETS' , IMPRESSCART_PATH . '/widgets');
define('IMPRESSCART_LOG', IMPRESSCART_PATH . '/logs');
define('IMPRESSCART_FRAMEWORK_APP_DIR', IMPRESSCART_PATH . '/framework');

define('IMPRESSCART_DIR_DOWNLOAD', WP_CONTENT_DIR . '/uploads');

include IMPRESSCART_PATH . '/framework/framework.php';
include IMPRESSCART_INCLUDE . '/functions.php';
include IMPRESSCART_INCLUDE . '/ajax-functions.php';
include IMPRESSCART_INCLUDE . '/shortcode.php';
include IMPRESSCART_INCLUDE . '/impresscart-hooks.php';

# start session
if (!session_id()){
	session_start();
}

/**
 * Activation
 **/
if (is_admin()) :

/**
 * Installs and upgrades
 **/
register_activation_hook( __FILE__, 'activate_impresscart_plugin' );

endif;


/*
function writeFileToDebug() {
	$File = "son.txt";
	$Handle = fopen($File, 'w');
	$Data = "Jane Doe\n";
	fwrite($Handle, $Data);
	$Data = "Bilbo Jones\n";
	fwrite($Handle, $Data);
	print "Data Written";
	fclose($Handle);
	
}
*/

/**
 * This function init values in first time that to install impresscart plugin.
 */
function initDefaultValues() {
	$option = get_option(IMPRESSCART_OPTIONS_NAME);
	if($option == false || empty($option)) {
		$defaults = array(
				'country' =>  '222' ,
				'region' =>  '0' ,
				'language' =>  '1' , 
				'admin_language' =>  '1' , 
				'currency' =>  'GBP'  ,
				'decimal_point' =>  '.' , 
				'thousand_point' =>  ''  ,
				'auto_update_currency' =>  '0' , 
				'length_class' =>  '1'  ,
				'weight_class' =>  '4' ,
				'catalog_item_per_page' =>  '' , 
				'admin_item_per_page' =>  ''  ,
				'display_price_with_tax' =>  '0' , 
				'invoice_prefix' =>  '' ,
				'login_display_price' =>  '0' ,
				'guest_checkout' =>  '0'  ,
				'account_terms' =>  'none'  ,
				'checkout_terms' =>  'none'  ,
				'affiliate_terms' =>  'none'  ,
				'affiliate_commission' =>  'none' , 
				'display_stock' =>  '0' ,
				'show_out_of_stock' =>  '0' ,
				'out_of_stock_checkout' =>  '0' , 
				'out_of_stock_status' =>  '0' ,
				'order_status' =>  '0' ,
				'complete_order_status' =>  '0' , 
				'return_status' =>  '0' ,
				'allow_reviews' =>  '0' ,
				'allow_downloads' =>  '0'  ,
				'allow_upload_file_types' =>  '' , 
				'themedir' =>  '' ,
				'display_weight_on_cart_page' =>  '0' , 
				'mail_method' =>  'phpmail' ,
				'sender_email' =>  ''  ,
				'smtp_host' =>  '' ,
				'smtp_username' =>  '' , 
				'smtp_password' =>  ''  ,
				'smtp_port' =>  '' ,
				'new_order_alert_email' =>  '0' , 
				'new_account_alert_email' =>  '0' , 
				'additionals_alert_email' =>  '' ,
				'enable_ssl' =>  '0' ,
				'enable_sef' =>  '0' ,
				'google_analytics_code' =>  '' , 
				'encryption_key' =>  '' ,
				'display_errors' =>  '0' ,
				'log_errors' =>  '0' ,
				'error_log_filename' =>  'error.txt' ,
				'order_status_data' =>
					array (
							0 =>  'Pending' ,
							1 =>  'Processing' , 
							2 =>  'Shipped' ,
							3 =>  'Complete'  ,
							4 =>  'Canceled' ,
							5 =>  'Denied' ,
							6 =>  'Canceled Reversal' , 
							7 =>  'Failed' ,
							8 =>  'Refunded' , 
							9 =>  'Reversed'  ,
							10 =>  'Chargeback' , 
							11 =>  'Expired'  ,
							12 =>  'Processed' ,
							13 =>  'Voided' ,
							 
					) ,
				
				'stock_status_data' =>
					array ( 
							0 =>  '2 - 3 Days' , 
							1 =>  'In Stock' ,
							2 =>  'Out Of Stock ' ,  
							3 =>  'Pre-Order' ,
							) ,
				
				
				'return_status_data' =>
					array (
					0 =>  'Awaiting Products (Default)' ,
					1 =>  'Complete' ,
					2 =>  'Pending' ,
							),
				'return_action_data' =>
					array (
					0 =>  'Credit Issued' ,
					1 =>  'Refunded' ,
					2 =>  'Replacement Sent' ,
							),
				'return_reason_data' =>
					array (
					0 =>  'Dead On Arrival' ,
					1 =>  'Faulty please supply details'  ,
					2 =>  'Order Error' ,
					3 =>  'Other please supply details' ,
					4 =>  'Received Wrong Item' ,
							),
					'checkout/checkout' =>  '4' ,
					'common/contact' =>  '4' ,
					'checkout/cart' =>  '4' ,
					'common/term' =>  '4' ,
					'common/thanks' =>  '4' ,
					'account/account' =>  '4' ,
					'account/affiliate' =>  '4' ,
					'account/register' =>  '4' ,
					'account/whishlist' =>  '4' ,
					'account/order' =>  '4' ,
					'account/download' =>  '4' ,
					'account/return' =>  '4' ,
					'account/transaction' =>  '4' ,
				) ;
		update_option(IMPRESSCART_OPTIONS_NAME, $defaults);
	}
	
}

function activate_impresscart_plugin() {
	
	if ( version_compare( get_bloginfo( 'version' ), '3.1', '<' ) ) {
		deactivate_plugins( basename( __FILE__ ) ); //Deactivate our plugin
	} else {
		require_once IMPRESSCART_INCLUDE . '/install.php';
		if(!get_option('impresscart_installed')) {
			impresscart_install();
			update_option( 'impresscart_installed', 1 );
		} else {
			impresscart_upgrade();
		}
		initDefaultValues();
	}
}

/*
 * Init impresscart plugin
 */

function impresscart_plugin_init() {
	
	//$locale = "";
	$locale = apply_filters( 'plugin_locale', get_locale(), 'impresscart' );
	//echo $locale;
	load_plugin_textdomain('impresscart', false, basename( dirname( __FILE__ ) ) . '/languages');
	
	if (isset($_GET['tracking']) && !isset($_COOKIE['tracking'])) {
		setcookie('tracking', $_GET['tracking'], time() + 3600 * 24 * 1000, '/');
	}
	
	//settings
	impresscart_plugin_settings();
	//post types
	impresscart_plugin_register_post_types();
	//metaboxes
	impresscart_init_metaboxes();
	//frontend
	impresscart_frontend_init();
	//framework
	impresscart_fakepage::init();	

	is_user_logged_in() ? impresscart_login() : 'This functions is defined in impresscart-hooks.php'; 
}

/**
 * installing widgets
 */
add_action('init', 'impresscart_plugin_init');

impresscart_init_widgets();