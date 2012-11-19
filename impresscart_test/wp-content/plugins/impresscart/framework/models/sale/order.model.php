<?php
class impresscart_sale_order_model extends impresscart_model {

	function notifyOrderHistoryStatus($history)
	{
		if ($history['notify']) {
				
				
			$subject = sprintf(__('text_subject'), get_bloginfo('name'), $history['order_id']);

			$message  = __('text_order') . ' ' . $history['order_id'] . "\n";
			$message .= __('text_date_added') . ' ' . date(__('date_format_short'), strtotime($history['date_added'])) . "\n\n";
				
			$message .= __('text_order_status') . "\n";
			$message .= $history['order_status'] . "\n\n";
				
			if ($history['customer_id']) {
				$message .= __('text_link') . "\n";
				$message .= html_entity_decode( get_permalink($history['order_id']), ENT_QUOTES, 'UTF-8') . "\n\n";
			}
				
			if ($history['comment']) {
				$message .= __('text_comment') . "\n\n";
				$message .= strip_tags(html_entity_decode($history['comment'], ENT_QUOTES, 'UTF-8')) . "\n\n";
			}

			$message .= __('text_footer');

			$this->mail->protocol = $this->config->get('config_mail_protocol');
			$this->mail->parameter = $this->config->get('config_mail_parameter');
			$this->mail->hostname = $this->config->get('config_smtp_host');
			$this->mail->username = $this->config->get('config_smtp_username');
			$this->mail->password = $this->config->get('config_smtp_password');
			$this->mail->port = $this->config->get('config_smtp_port');
			$this->mail->timeout = $this->config->get('config_smtp_timeout');
			$this->mail->setTo($history['email']);
			$this->mail->setFrom($this->config->get('config_email'));
			$this->mail->setSender(get_bloginfo('name'));
			$this->mail->setSubject(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));
			$this->mail->setText(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
			$this->mail->send();
		}
	}
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

	
	public function getOrderProducts($order_id) {
		$products = get_post_meta($order_id, 'products' , true);
		return $products; 			
	}

}
?>