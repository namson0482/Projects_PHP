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

function activate_impresscart_plugin() {
	
	//var_dump(get_option('impresscart_installed'));
	
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