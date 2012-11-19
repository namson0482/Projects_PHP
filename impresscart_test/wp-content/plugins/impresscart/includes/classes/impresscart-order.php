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
class impresscart_order extends impresscart_posttype {

	/**
	 * Loads all order data from custom fields
	 * @param  int	$id
	 */
	function impresscart_order($id) {

		$this->metaboxes = array(
        'data' => array(
            'id' => 'order-data-meta-box',
            'title' => __('Order Data'),
            'page' => 'post',
            'context' => 'normal',
            'priority' => 'high',
            'fields' => array(
		array(
                    'name' => '',
                    'desc' => 'order data box',
                    'id' => @$prefix . 'order_data',
                    'type' => 'order_data',
                    'std' => ''
                    ),
                    ),
            'tabs' => '',
                    ),
        'shipping' => array(
            'id' => 'order-shipping-meta-box',
            'title' => __('Shipping Address'),
            'page' => 'post',
            'context' => 'normal',
            'priority' => 'high',
            'fields' => array(
                    array(
                    'name' => '',
                    'desc' => 'order shipping box',
                    'id' => @$prefix . 'order_shipping',
                    'type' => 'order_shipping',
                    'std' => ''
                    ),
                    ),
            'tabs' => '',
                    ),
        'payment' => array(
            'id' => 'order-payment-meta-box',
            'title' => __('Payment Address'),
            'page' => 'post',
            'context' => 'normal',
            'priority' => 'high',
            'fields' => array(
                    array(
                    'name' => '',
                    'desc' => 'order shipping box',
                    'id' => @$prefix . 'order_payment',
                    'type' => 'order_payment',
                    'std' => ''
                    ),
                    ),
            'tabs' => '',
                    ),
        'items' => array(
            'id' => 'order-items-meta-box',
            'title' => __('Order Items'),
            'page' => 'post',
            'context' => 'normal',
            'priority' => 'high',
            'fields' => array(
                    array(
                    'name' => '',
                    'desc' => 'order shipping box',
                    'id' => @$prefix . 'order_items',
                    'type' => 'order_items',
                    'std' => ''
                    ),
                    ),
            'tabs' => '',
                    ),
        'history' => array(
            'id' => 'order-data-meta-box',
            'title' => __('Order History'),
            'page' => 'post',
            'context' => 'normal',
            'priority' => 'high',
            'fields' => array(
                    array(
                    'name' => '',
                    'desc' => 'order shipping box',
                    'id' => @$prefix . 'order_history',
                    'type' => 'order_history',
                    'std' => ''
                    ),
                    ),
            'tabs' => '',
                    ),
                    );
	}
	
	function saveOrderData() {
		global $post;
		
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname']; 
		
		$data = $_POST['data'];
		
		$email = $data['email']; 
		$telephone = $data['telephone'];
		
		$data = get_post_meta($post->ID, 'data', true);
		$data['firstname'] = $firstname;
		$data['lastname'] = $lastname;
		$data['email'] = $email;
		$data['telephone'] = $telephone;
				
		update_post_meta($post->ID, 'data', $data);
	}
	
	function saveOrderShippingAddress() {
		
		
		global $post;
		
		$data = get_post_meta($post->ID, 'data', true);

		$shipping = $_POST['shipping'];
		
		$data['shipping_firstname'] = $shipping['firstname'];
		$data['shipping_lastname'] = $shipping['lastname'];
		$data['shipping_address_1'] = $shipping['address_1'];
		$data['shipping_city'] = $shipping['city'];
		$data['shipping_postcode'] = $shipping['postcode'];
		$data['shipping_country_id'] = $shipping['country'];
		
		
		
		$country_model = impresscart_framework::model('localisation/country');
    	$results = $country_model->getCountry($data['shipping_country_id']);
    	$data['shipping_country' ] = $results->name;
    	
    	$data['shipping_zone_id'] = $shipping['zone'];

    	$zone_model = impresscart_framework::model('localisation/zone');
    	$results = $zone_model->getZone($data['shipping_zone_id']);
    	
    	$data['shipping_zone' ] = $results->name;
    	
    	update_post_meta($post->ID, 'data', $data);
	}
	
	function saveOrderPaymentAddress() {
		
		global $post;
		
		$data = get_post_meta($post->ID, 'data', true);

		
				
		$payment = $_POST['payment'];
		
		$data['payment_firstname'] = $_POST['payment_firstname'];
		$data['payment_lastname'] = $_POST['payment_lastname'];
		$data['payment_address_1'] = $_POST['payment_address_1'];
		$data['payment_city'] = $_POST['payment_city'];
		$data['payment_postcode'] = $_POST['payment_postcode'];
		$data['payment_country_id'] = $payment['country'];
		
		
		
		$country_model = impresscart_framework::model('localisation/country');
    	$results = $country_model->getCountry($data['payment_country_id']);
    	$data['payment_country' ] = $results->name;
    	
    	$data['payment_zone_id'] = $payment['zone'];

    	$zone_model = impresscart_framework::model('localisation/zone');
    	$results = $zone_model->getZone($data['payment_zone_id']);
    	
    	$data['payment_zone' ] = $results->name;
    	
    	update_post_meta($post->ID, 'data', $data);
    	
	}

	public function save() {
		global $post;
		//Save order data 
		$this->saveOrderData();
		$this->saveOrderShippingAddress();
		$this->saveOrderPaymentAddress();
	}

}

add_filter('impresscart_post_types', 'impresscart_order_post_type');
function impresscart_order_post_type($posttypes) {
	$posttypes[Goscom::GOSCOM_ORDER_POSTTYPE] = array(

            'public' => true,    			    			
            'show_ui' => true,
                    'show_in_menu' => false, 	
                    'exclude_from_search' => true,	
            'labels' => array(
                    'name' => 'Orders',
                    'singular_name' => 'order',
                    'add_new' => 'Add order',
                    'add_new_item' => 'Add order',
                    'new_item' => 'New order',
                    
	),
            'supports' => array('')
	);

	return $posttypes;
}

add_action('restrict_manage_posts', 'restrict_order');
function restrict_order() {
	
	global $typenow;
	global $wp_query;

	//$criterial_default = array('key' => 'order_status', 'value' => -1, 'compare' => '!=');
	if ($typenow == Goscom::GOSCOM_ORDER_POSTTYPE) {
		$haveFilter = false;
		$status = @$_REQUEST['order_status'];
		$meta_query = array();
		if(!empty($status)) {
			if($status != 'all') {
				$criterial_1 = array(
	          		'key' => 'order_status',
	          		'value' => $status,
				);
				$meta_query = array($criterial_1);
			} else {
				$meta_query = array();
			}
			$haveFilter = true;
		} else {
			$meta_query = array();
		}
		
		$meta_query = Goscom::arrayPutCustomPosition($meta_query, 'AND' , 0, 'relation');
		$args = $wp_query->query;
		$args = Goscom::arrayPutLastPosition($args, $meta_query, 'meta_query');
		
		$order_status = impresscart_framework::service('config')->get('order_status_data');
		
		$order_status_dropdown = '<select name="order_status">';
		
		if($haveFilter == false) {
			$order_status_dropdown .= '<option value="all" selected="selected">' . __('All Statuses') . '</option>';
			$order_status_dropdown .= '<option value="-1">' . __('Not Confirmed') . '</option>';
		} else {
			
			
			if($status == 'all') {
				$order_status_dropdown .= '<option value="all" selected="selected">' . __('All Statuses') . '</option>';
				$order_status_dropdown .= '<option value="-1">' . __('Not Confirmed') . '</option>';	
			} else if($status == '-1') {
				$order_status_dropdown .= '<option value="all" >' . __('All Statuses') . '</option>';
				$order_status_dropdown .= '<option value="-1" selected="selected">' . __('Not Confirmed') . '</option>';
			} else {
				$order_status_dropdown .= '<option value="all" >' . __('All Statuses') . '</option>';
				$order_status_dropdown .= '<option value="-1">' . __('Not Confirmed') . '</option>';
			}
		
		}
	
		if(is_array($order_status)) {
			foreach ($order_status as $key => $value) {
				$key = $key . '';
				if ($key == $status)  {
					$order_status_dropdown .= '<option selected="selected" value="' . $key . '">' . $value . '</option>';	
				}
				else { 
					$order_status_dropdown .= '<option value="' . $key . '">' . $value . '</option>';	
				}
			}
		}
		$order_status_dropdown .= '</select>';
		echo $order_status_dropdown;
		$wp_query->query($args);
	}
}



/**
 * order_data
 */
add_filter('impresscart_order_data', 'impresscart_order_data_metabox');

function impresscart_order_data_metabox() {
	$html = '';
	ob_start();
	impresscart_framework::getInstance()->dispatch('/admin/order/data');
	$html .= ob_get_contents();
	ob_end_clean();
	return $html;
}

/**
 * order_shipping
 */
add_filter('impresscart_order_shipping', 'impresscart_order_shipping_metabox');

function impresscart_order_shipping_metabox() {
	$html = '';
	ob_start();
	impresscart_framework::getInstance()->dispatch('/admin/order/shipping');
	$html .= ob_get_contents();
	ob_end_clean();
	return $html;
}

/**
 * order_payment
 */
add_filter('impresscart_order_payment', 'impresscart_order_payment_metabox');
function impresscart_order_payment_metabox() {
	$html = '';
	ob_start();
	impresscart_framework::getInstance()->dispatch('/admin/order/payment');
	$html .= ob_get_contents();
	ob_end_clean();
	return $html;
}

/**
 * order_items
 */
add_filter('impresscart_order_items', 'impresscart_order_items_metabox');

function impresscart_order_items_metabox() {
	ob_start();
	impresscart_framework::getInstance()->dispatch('/admin/order/items');
	$html .= ob_get_contents();
	ob_end_clean();
	return $html;
}



/**
 * order_history
 */
add_filter('impresscart_order_history', 'impresscart_order_history_metabox');

function impresscart_order_history_metabox() {
	$html = '';
	ob_start();
	impresscart_framework::getInstance()->dispatch('/admin/order/history');
	$html .= ob_get_contents();
	ob_end_clean();
	return $html;
}







