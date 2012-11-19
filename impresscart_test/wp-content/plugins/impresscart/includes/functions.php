<?php
/*
 Copyright 2010-2011 Impress Dev LLC. This software is distributed under the GNU General Public License version 2.

 Contact: support@impressdev.com
 */

/**
 * Initialize admin
 */
include IMPRESSCART_CLASSES . '/impresscart-admin.php';
include IMPRESSCART_CLASSES . '/impresscart-post-types.php';
include IMPRESSCART_CLASSES . '/impresscart-post-type-columns.php';
include IMPRESSCART_CLASSES . '/impresscart-posttype.php';
include IMPRESSCART_CLASSES . '/impresscart-product.php';
include IMPRESSCART_CLASSES . '/impresscart-metaboxes.php';
include IMPRESSCART_CLASSES . '/impresscart-extension.php';
include IMPRESSCART_CLASSES . '/impresscart-order.php';
include IMPRESSCART_CLASSES . '/impresscart-return.php';
include IMPRESSCART_CLASSES . '/impresscart-coupon.php';
include IMPRESSCART_CLASSES . '/impresscart-voucher.php';
include IMPRESSCART_CLASSES . '/impresscart-user.php';
include 'utf8.php';

/**
 * Initialize Goscom
 */
include IMPRESSCART_CLASSES . '/lib/goscom.php';

/**
 * add payment methods
 */
include IMPRESSCART_EXTENSION . '/payment/impresscart_payment_methods.php';
include IMPRESSCART_EXTENSION . '/payment/cod/impresscart_cod_payment_method.php';
include IMPRESSCART_EXTENSION . '/payment/paypalstandard/impresscart_paypalstandard_payment_method.php';

/**
 * add shipping methods
 */

include IMPRESSCART_EXTENSION . '/shipping/impresscart_shipping_methods.php';
include IMPRESSCART_EXTENSION . '/shipping/citylink/impresscart_citylink_shipping_method.php';
include IMPRESSCART_EXTENSION . '/shipping/flatrate/impresscart_flatrate_shipping_method.php';
include IMPRESSCART_EXTENSION . '/shipping/ups/impresscart_ups_shipping_method.php';

//include IMPRESSCART_EXTENSION . '/shipping/free/impresscart_free_shipping_method.php';


/**
 * add totals
 */

include IMPRESSCART_EXTENSION . '/total/impresscart_totals.php';
include IMPRESSCART_EXTENSION . '/total/coupontotal/impresscart_coupontotal_total.php';
include IMPRESSCART_EXTENSION . '/total/credit/impresscart_credit_total.php';
include IMPRESSCART_EXTENSION . '/total/handling/impresscart_handling_total.php';
include IMPRESSCART_EXTENSION . '/total/loworderfee/impresscart_loworderfee_total.php';
include IMPRESSCART_EXTENSION . '/total/reward/impresscart_reward_total.php';
include IMPRESSCART_EXTENSION . '/total/shippingtotal/impresscart_shippingtotal_total.php';
include IMPRESSCART_EXTENSION . '/total/subtotal/impresscart_subtotal_total.php';
include IMPRESSCART_EXTENSION . '/total/tax/impresscart_tax_total.php';
include IMPRESSCART_EXTENSION . '/total/ordertotal/impresscart_ordertotal_total.php';
include IMPRESSCART_EXTENSION . '/total/vouchertotal/impresscart_vouchertotal_total.php';



/**
 * setting plugin
 * @return unknown_type
 */

function impresscart_plugin_settings() {
	
	global $impresscart_admin;
	if(is_null($impresscart_admin))
		$impresscart_admin = new impresscart_admin();
}

function impresscart_plugin_register_post_types() {
	$impresscart_post_types = new impresscart_post_types();
	$impresscart_post_types->register_post_types();
	$impresscart_post_types->register_taxonomies();
	$impresscart_post_type_columns = new impresscart_post_type_columns();
	$impresscart_post_type_columns->init_columns();
}

function impresscart_init_metaboxes()
{
	$impresscart_metaboxes = new impresscart_metaboxes();
}

function impresscart_product_options()
{
	$baseParams = array(
		'post_type' => $_GET['post_type'],
		'page' => $_GET['page'],
	);
	impresscart_framework::getInstance()
	->setDefaultUrl('/admin/options/index')
	->setBaseParams($baseParams)
	->dispatch();
}

function impresscart_product_attributes()
{
	$baseParams = array(
		'post_type' => $_GET['post_type'],
		'page' => $_GET['page'],
	);
	impresscart_framework::getInstance()
	->setDefaultUrl('/admin/attributes/index')
	->setBaseParams($baseParams)
	->dispatch();
}

function impresscart_localization(){
	$baseParams = array(
		'page' => $_GET['page'],
	);
	if($baseParams['page'] == 'impresscart_localization') {
		$default = '/admin/localization/countries_index';
	} else {
		$default = '/' . $baseParams['page'];
	}
	impresscart_framework::getInstance()
	->setDefaultUrl($default)
	->setBaseParams($baseParams)
	->dispatch();
}

function impresscart_catalog_downloads(){
	$baseParams = array(
		'post_type' => $_GET['post_type'],
		'page' => $_GET['page'],
	);
	impresscart_framework::getInstance()
	->setDefaultUrl('/admin/catalog/download_index')
	->setBaseParams($baseParams)
	->dispatch();
}

/**
 * Load all define widget in widgets folder
 * widget name must be concatnate(filename, '_widget')
 * Enter description here ...
 */
function impresscart_init_widgets()
{
	$widgets = glob(IMPRESSCART_WIDGETS . '/*.php');
	if ($widgets) 
		foreach ($widgets as $widget) {
			$filename = basename($widget, '.php');
			if(!class_exists($filename . '_widget'))
				include_once IMPRESSCART_WIDGETS . '/' . $filename . '.php';
		}
}


/**
 * initialize javascripts and style
 */
function impresscart_frontend_init() {

	if(!is_admin())	{

		impresscart_frontend_enqueue_styles();

		impresscart_frontend_enqueue_javascripts();

	}

}

function impresscart_frontend_enqueue_styles() {
	wp_enqueue_style('jquery-ui-all', IMPRESSCART_URL . '/assets/js/ui/jquery.ui.all.css');
	wp_enqueue_style('impresscart_frontend_style', IMPRESSCART_CSS . '/site/style.css' );
	wp_enqueue_style('jquery-fancybox', IMPRESSCART_URL . '/assets/js/fancybox/jquery.fancybox-1.3.4.css');
	//wp_enqueue_style('showLoading', IMPRESSCART_CSS . '/showLoading.css', array(), "1.0");
}

function impresscart_frontend_enqueue_javascripts() {

	wp_enqueue_script('jquery-ui-core');

	wp_enqueue_script('jquery-ui-tabs');

	wp_enqueue_script('jquery-ui-datepicker');

	wp_enqueue_script('jquery-ui-autocomplete');

	wp_register_script('jquery-fancybox', IMPRESSCART_URL . '/assets/js/fancybox/jquery.fancybox-1.3.4.pack.js');

	wp_enqueue_script('jquery-fancybox');

	wp_register_script('impresscart-common', IMPRESSCART_URL  . '/assets/js/common.js');

	wp_enqueue_script('impresscart-common');
	
	wp_register_script('jquery-blockUI', IMPRESSCART_URL . '/assets/js/jquery.blockUI.js');
	
	wp_enqueue_script('jquery-blockUI');
	
	wp_enqueue_script('goscom-lib', IMPRESSCART_URL . '/assets/js/goscom-library.js', '', '1.0', true);

	//Get current page protocol
	$protocol = isset( $_SERVER["HTTPS"] ) ? 'https://' : 'http://';
	//Output admin-ajax.php URL with same protocol as current page
	$params = array(
		'ajaxurl' =>  admin_url( 'admin-ajax.php', $protocol )
	);
	wp_localize_script( 'impresscart-common', 'impresscart', $params );
	

}