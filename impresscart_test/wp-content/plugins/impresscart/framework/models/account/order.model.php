<?php
class impresscart_account_order_model extends impresscart_model {
	
	public function getOrder($order_id) {
		$order = get_post_meta($order_id, 'data', true);
		if (!empty($order)) {

			$country 	= $this->table('country')->fetchOne(
				array('conditions' => array(
					'country_id' 				=> (int)$order["shipping_country_id"],
				)
			));

			if (!empty($country)) {
				$shipping_iso_code_2 = $country->iso_code_2;
				$shipping_iso_code_3 = $country->iso_code_3;
			} else {
				$shipping_iso_code_2 = '';
				$shipping_iso_code_3 = '';
			}

			$zone 		= $this->table('zone')->fetchOne(
				array('conditions' => array(
					'zone_id' 				=> (int)$order["shipping_zone_id"],
				)
			));

			if (!empty($zone)) {
				$shipping_zone_code = $zone->code;
			} else {
				$shipping_zone_code = '';
			}

			$country 	= $this->table('country')->fetchOne(
				array('conditions' => array(
					'country_id' 				=> (int)$order["payment_country_id"],
				)
			));

			if (!empty($country)) {
				$payment_iso_code_2 = $country->iso_code_2;
				$payment_iso_code_3 = $country->iso_code_3;
			} else {
				$payment_iso_code_2 = '';
				$payment_iso_code_3 = '';
			}

			$zone 		= $this->table('zone')->fetchOne(
				array('conditions' => array(
					'zone_id' 				=> (int)$order["payment_zone_id"],
				)
			));

			if (!empty($zone)) {
				$payment_zone_code = $zone->code;
			} else {
				$payment_zone_code = '';
			}

			$order['shipping_zone_code'] = $shipping_zone_code;
			$order['shipping_iso_code_2'] = $shipping_iso_code_2;
			$order['shipping_iso_code_3'] = $shipping_iso_code_3;
			$order['payment_zone_code'] = $payment_zone_code;
			$order['payment_iso_code_2'] = $payment_iso_code_2;
			$order['payment_iso_code_3'] = $payment_iso_code_3;
			return $order;
			
		} else {
			return false;
		}
	}

	public function getOrders() {

		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;		
		$args = array(
		    'numberposts'     => 5,
		    'offset'          => 0,
		    'meta_key'        => 'customer_id',
		    'meta_value'      => $this->customer->getId(),
		    'post_type'       => Goscom::GOSCOM_ORDER_POSTTYPE,
		    'post_status'     => 'publish',
            'order_by'        => 'date_added DESC',
			'paged' => $paged,
		);		
		
		$posts = get_posts($args);		
		return $posts;	
	}

	public function getOrderProducts($order_id) {
		return get_post_meta($order_id, 'products', true);
	}

	public function getOrderOptions($order_id, $order_product_id) {
		$products = $this->getOrderProducts($order_id);
		
		$order_options = array();
		foreach($products as $product)
		{
			if($product['product_id'] == $order_product_id)
			{
				$order_options = $product['option'];
				break;
			}	
		}
		return $order_options;
	}

	public function getOrderTotals($order_id) {
		$rows = get_post_meta($order_id, 'totals', true);
		return $rows;
	}

	public function getOrderHistories($order_id) {
		
		$rows = get_post_meta($order_id, 'histories', true);
		
		if(!is_array($rows)) return array();
		
		return $rows;
	}

	public function getOrderDownloads($order_id) {
		$products = $this->getOrderProducts($order_id);
		
		$order_downloads = array();
		foreach($products as $product)
		{
			if(isset($product['download']))
			{
				$order_downloads[] = $product['download'];				
			}	
		}
		return $order_downloads;
	}

	public function getTotalOrders() {
		
		$args = array(
			'post_type' => 'impresscart_order',
			'meta_key' => 'customer_id',
			'meta_value' => $this->customer->getId()		
		);
		
		$posts = get_posts($args);
		return count($posts);		
	}

	public function getTotalOrderProductsByOrderId($order_id) {
		
		$products = get_post_meta($order_id, 'products', true);
		return count($products);

	}
	
}
?>