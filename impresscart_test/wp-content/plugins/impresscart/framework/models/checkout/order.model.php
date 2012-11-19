<?php

class impresscart_checkout_order_model extends impresscart_model {

	public function create($data) {
		$products = $data['products'];
		$totals = $data['totals'];
		$quantity = 0;
		$tax = 0;
		$sub_total = 0;
		foreach($products as $p) {
			$quantity += (int)$p['quantity'];
			$tax += $p['tax'];
			$sub_total += $p['total'];
		}

		$total = $tax + $sub_total;
			
		unset($data['products']);
		unset($data['totals']);

		$post = array(

		'post_title' => 'order',
		'post_content' => 'order',
		'post_type' => Goscom::GOSCOM_ORDER_POSTTYPE,
		'post_status' => 'publish'
		
		);

		$post_id = wp_insert_post( $post, true );
		$data['date_added'] = date( 'Y-m-d H:i:s' );
		//When user checkout if user don't confirm its bill then value of confirm is 0, if user confirm bill then value is 1
		$data['order_status_id'] = Goscom::GOSCOM_ORDER_STATUS_ID_BEFORE_CONFIRM;
		
		if($post_id) {
			
			//add basic data for order
			add_post_meta($post_id, 'data', $data);
			add_post_meta($post_id, 'order_status', $data['order_status_id']);
			add_post_meta($post_id, 'commission', $data['commission']);
			add_post_meta($post_id, 'affiliate_id', $data['affiliate_id']);
			
			//Total reward is all of products in bill
			add_post_meta($post_id, 'reward', $data['reward']);
			//Total reward is award for customer when admin create link 'add reward point'
			add_post_meta($post_id, 'reward_point', 0);
			//reward is used for this order
			add_post_meta($post_id, 'reward_point_used', 0);
			add_post_meta($post_id, 'store_credit', 0);
			
			add_post_meta($post_id, 'order_tax', $tax);
			add_post_meta($post_id, 'order_quantity', $quantity);
			add_post_meta($post_id, 'order_total', $total);
			add_post_meta($post_id, 'order_sub_total', $sub_total);
			
			add_post_meta($post_id, 'customer_id', $this->customer->getId());
			add_post_meta($post_id, 'customer_role', $this->customer->getUserRole());
			
			
			//add products data for order
			if(isset($products)) add_post_meta($post_id, 'products', $products);
			if(isset($totals)) add_post_meta($post_id, 'totals', $totals);
		}
		return $post_id;
	}
	
	
	public function updateRewardData($post_id, $result_reward_point) {
		add_post_meta( $post_id, 'reward_point', $result_reward_point, true ) or update_post_meta( $post_id, 'reward_point', $result_reward_point );
	}

	//If the $invoice_no variable is supplied,
	//add a new key named 'invoice_no', containing that value.
	//If the 'invoice_no' key already exists on this post,
	//this command will update it to the new value
	public function updateInvoiceData($post_id, $invoice_no) {

		/*$result = add_post_meta( $post_id, 'invoice_no', $invoice_no, true );
		if(!$result) {
			update_post_meta( $post_id, 'invoice_no', $invoice_no );
		} */	
		add_post_meta( $post_id, 'invoice_no', $invoice_no, true ) or update_post_meta( $post_id, 'invoice_no', $invoice_no );
	}

	public function getOrder($order_id) {

		$order_table = impresscart_framework::table('order');

		$order_status_table = impresscart_framework::table('order_status');

		$country_table = impresscart_framework::table('country');

		$zone_table = impresscart_framework::table('zone');

		$order = get_post_meta($order_id, 'data', true);
		
		$object = get_post($order_id);

		if($order) {
			if($order['order_status_id'] != -1) {
				$order_status = $order_status_table->fetchOne (
				array (
						'conditions' => array(
							'order_status_id' => $order['order_status_id'] 
				)
				)
				);

				$order['order_status'] = $order_status->name;
			} else {
				$order['order_status'] = '';
			}
				
			$country = $country_table->fetchOne(
			array('conditions' =>
			array(
						'country_id' => $order['shipping_country_id']
			)
			)
			);
			if($country) {
				$shipping_iso_code_2 = $country->iso_code_2;
				$shipping_iso_code_3 = $country->iso_code_3;
			} else {
				$shipping_iso_code_2 = '';
				$shipping_iso_code_3 = '';
			}
				
			$zone = $zone_table->fetchOne(
			array(
					'conditions' => array(
						'zone_id' => $order['shipping_zone_id']
			)
			)
			);

			if($zone)
			{
				$shipping_zone_code = $zone->code;
			} else {
				$shipping_zone_code = '';
			}

			$country = $country_table->fetchOne(
			array('conditions' =>
			array(
						'country_id' => $order['payment_country_id']
			)
			)
			);
			if($country)
			{
				$payment_iso_code_2 = $country->iso_code_2;
				$payment_iso_code_3 = $country->iso_code_3;
			} else {
				$payment_iso_code_2 = '';
				$payment_iso_code_3 = '';
			}

			$zone = $zone_table->fetchOne(
			array(
					'conditions' => array(
						'zone_id' => $order['payment_zone_id']
			)
			)
			);

			if($zone)
			{
				$payment_zone_code = $zone->code;
			} else {
				$payment_zone_code = '';
			}

			return array(
				'order_id'                => $order_id,
				'invoice_no'              => @$order['invoice_no'],
				'invoice_prefix'          => @$order['invoice_prefix'],
				'store_id'                => @$order['store_id'],
				'store_name'              => get_bloginfo('name'),
				'store_url'               => get_bloginfo('url'),				
				'customer_id'             => $order['customer_id'],
				'firstname'               => $order['firstname'],
				'lastname'                => $order['lastname'],
				'telephone'               => $order['telephone'],
				'fax'                     => $order['fax'],
				'email'                   => $order['email'],
				'shipping_firstname'      => $order['shipping_firstname'],
				'shipping_lastname'       => $order['shipping_lastname'],				
				'shipping_company'        => $order['shipping_company'],
				'shipping_address_1'      => $order['shipping_address_1'],
				'shipping_address_2'      => $order['shipping_address_2'],
				'shipping_postcode'       => $order['shipping_postcode'],
				'shipping_city'           => $order['shipping_city'],
				'shipping_zone_id'        => $order['shipping_zone_id'],
				'shipping_zone'           => $order['shipping_zone'],
				'shipping_zone_code'      => $shipping_zone_code,
				'shipping_country_id'     => $order['shipping_country_id'],
				'shipping_country'        => $order['shipping_country'],	
				'shipping_iso_code_2'     => $shipping_iso_code_2,
				'shipping_iso_code_3'     => $shipping_iso_code_3,
				'shipping_address_format' => $order['shipping_address_format'],
				'shipping_method'         => $order['shipping_method'],
				'payment_firstname'       => $order['payment_firstname'],
				'payment_lastname'        => $order['payment_lastname'],				
				'payment_company'         => $order['payment_company'],
				'payment_address_1'       => $order['payment_address_1'],
				'payment_address_2'       => $order['payment_address_2'],
				'payment_postcode'        => $order['payment_postcode'],
				'payment_city'            => $order['payment_city'],
				'payment_zone_id'         => $order['payment_zone_id'],
				'payment_zone'            => $order['payment_zone'],
				'payment_zone_code'       => $payment_zone_code,
				'payment_country_id'      => $order['payment_country_id'],
				'payment_country'         => $order['payment_country'],	
				'payment_iso_code_2'      => $payment_iso_code_2,
				'payment_iso_code_3'      => $payment_iso_code_3,
				'payment_address_format'  => $order['payment_address_format'],
				'payment_method'          => $order['payment_method'],
				'comment'                 => $order['comment'],
				'total'                   => $order['total'],
				'reward'                  => $order['reward'],
				'order_status_id'         => $order['order_status_id'],
				'order_status'            => $order['order_status'],				
				'currency_id'             => $order['currency_id'],
				'currency_code'           => $order['currency_code'],
				'currency_value'          => $order['currency_value'],
				'date_modified'           => @$object->post_modified,
				'date_added'              => @$object->post_date,
				'ip'                      => $order['ip'],
				'reward_point'			  => '0',
				'store_credit_can_use'	  => $order['store_credit_can_use']
			);
		} else {
			return false;
		}
	}

	public function confirm($order_id, $order_status_id, $comment = '', $notify = false) {
		
		$order_info = $this->getOrder($order_id);
		if ($order_info) {
			
			$order_info['order_status_id'] = $order_status_id;
			$order_info['date_modified'] = date( 'Y-m-d H:i:s' );
			
			update_post_meta($order_id, 'data', $order_info);
			update_post_meta($order_id, 'order_status', $order_status_id);
			
			if(isset($this->session->data['reward']))  {
				update_post_meta($order_id, 'reward_point_used', $this->session->data['reward']);	
			}
			update_post_meta($order_id, 'store_credit', floatval($order_info['store_credit_can_use']));
			$order_info = $this->getOrder($order_id);
			$order_history = array();
			$order_history[] = array(
				'order_status_id' => $order_status_id,
				'notify' => $notify,
				'comment' => $comment,
				'date_added' => date( 'Y-m-d H:i:s' )
			);
			update_post_meta($order_id, 'histories', $order_history);
			$products = get_post_meta($order_id, 'products', true);
			foreach ($products as $order_product) {
				$product_model = impresscart_framework::model('catalog/product');
				$quantity = $product_model->getGeneralAttributes($order_product['product_id'], 'QUANTITY');
				$product_model->saveGeneralAttribute($order_product['product_id'], 'QUANTITY', (int)$quantity['value'] - (int)$order_product['quantity'] );

			}
			$rows = get_post_meta($order_id, 'totals', true);
			foreach ($rows as $order_total) {
				if(!class_exists($order_total['code'])) {
					require_once impresscart_EXTENSION . '/total/' . $order_total['code'] . '.php';
				}
				$ext = new $order_total['code'];
				if (method_exists($ext, 'confirm')) {
					$ext->confirm($order_info, $order_total);
				}
			}

			// Send out any gift voucher mails
			if ($this->config->get('complete_order_status') == $order_status_id) {
				$this->model_checkout_voucher->confirm($order_id);
			}
			$order_status_table = impresscart_framework::table('order_status');
			$row = $order_status_table->fetchOne(
			array('conditions' => array(
					'order_status_id' => $order_status_id
			))
			);

			if($row) {
				$order_status = $row->name;
			} else {
				$order_status = '';
			}
			
			foreach ($products as $product) {
				$option_data = array();
				$options = $product['option'];
				if(count($options)) {
					foreach ($options as $option) {
						$option = (array)$option;
						if ($option['type'] != 'file') {
							$option_data[] = array(
								'name'  => $option['name'],
								'value' => (strlen($option['value']) > 20 ? substr($option['value'], 0, 20) . '..' : $option['value'])
							);
						} else {
							$filename = substr($option['value'], 0, strrpos($option['value'], '.'));
							$option_data[] = array(
								'name'  => $option['name'],
								'value' => (strlen($filename) > 20 ? substr($filename, 0, 20) . '..' : $filename)
							);
						}
					}
				}
			}

			//sending order information to the client.
			ob_start();
			impresscart_framework::getInstance()->dispatch('/template/mail/order');
			$html .= ob_get_contents();
			ob_end_clean();
			// Text Mail
			$text  = sprintf(__('Thank you for your interest in %s products. Your order has been received and will be processed once payment has been confirmed.'), html_entity_decode($order_info['store_name'], ENT_QUOTES, 'UTF-8')) . "\n\n";
			$text .= __('Order ID:') . ' ' . $order_id . "\n";
			$text .= __('Date Added:') . ' ' . date(__('y-m-d'), strtotime($order_info['date_added'])) . "\n";
			$text .= __('Order Status:') . ' ' . $order_status . "\n\n";

			if ($comment && $notify) {
				$text .= __('Instructions') . "\n\n";
				$text .= $comment . "\n\n";
			}

			$text .= __('Products:') . "\n";
			$products = get_post_meta($order_id, 'products',true);
			foreach($products as $result) {
				$text .= $result['quantity'] . 'x ' . $result['name'] . ' (' . $result['model'] . ') ' . html_entity_decode($this->currency->format($result['total'], $order_info['currency_code'], $order_info['currency_value']), ENT_NOQUOTES, 'UTF-8') . "\n";
				if(count($result['option']))
				{
					foreach($result['option'] as $option)
					{
						$text .= chr(9) . '-' . $option['name'] . ' ' . (strlen($option['value']) > 20 ? substr($option['value'], 0, 20) . '..' : $option['value']) . "\n";
					}
				}
			}

			$text .= "\n";

			$text .= __('Total:') . "\n";

			$totals = get_post_meta($order_id, 'totals', true);

			foreach($totals as $result) {
				$text .= $result['title'] . ' ' . html_entity_decode($result['text'], ENT_NOQUOTES, 'UTF-8') . "\n";
			}

			$text .= "\n";

			if ($order_info['customer_id']) {
				$text .= __('To view your order click on the link below:') . "\n";
				$text .= get_bloginfo('url') . '?pagename=shop&route=account/order/info&order_id=' . $order_id . "\n\n";
			}


			if ($order_info['comment']) {
				$text .= __('The comments for your order are:') . "\n\n";
				$text .= $order_info['comment'] . "\n\n";
			}
				
				
				
			$text .= __('Please reply to this email if you have any questions.') . "\n\n";
			$this->mail->protocol = $this->config->get('mail_method');
			$this->mail->parameter = $this->config->get('mail_parameter');
			$this->mail->hostname = $this->config->get('smtp_host');
			$this->mail->username = $this->config->get('smtp_username');
			$this->mail->password = $this->config->get('smtp_password');
			$this->mail->port = $this->config->get('smtp_port');
			$this->mail->timeout = $this->config->get('smtp_timeout');
			$this->mail->setTo($order_info['email']);
			$this->mail->setFrom(get_option('admin_email',true));
			$this->mail->setSender(get_bloginfo('name'));
			$this->mail->setSubject($subject);
			$this->mail->setHtml($html);
			$this->mail->setText(html_entity_decode($text, ENT_QUOTES, 'UTF-8'));
			$this->mail->send();
				
			//Admin Alert Mail
				
			if ($this->config->get('alert_mail')) {
				$subject = sprintf(__('text_new_subject'), html_entity_decode($this->config->get('name'), ENT_QUOTES, 'UTF-8'), $order_id);

				// Text
				$text  = __('text_new_received') . "\n\n";
				$text .= __('text_new_order_id') . ' ' . $order_id . "\n";
				$text .= __('text_new_date_added') . ' ' . date(__('date_format_short'), strtotime($order_info['date_added'])) . "\n";
				$text .= __('text_new_order_status') . ' ' . $order_status . "\n\n";
				$text .= __('text_new_products') . "\n";

				foreach($products as $result)
				{
					$text .= $result['quantity'] . 'x ' . $result['name'] . ' (' . $result['model'] . ') ' . html_entity_decode($this->currency->format($result['total'], $order_info['currency_code'], $order_info['currency_value']), ENT_NOQUOTES, 'UTF-8') . "\n";
					if(count($result['option']))
					{
						foreach($result['option'] as $option)
						{
							$text .= chr(9) . '-' . $option['name'] . ' ' . (strlen($option['value']) > 20 ? substr($option['value'], 0, 20) . '..' : $option['value']) . "\n";
						}
					}
				}

				$text .= "\n";

				$text .= __('text_new_order_total') . "\n";


				foreach($totals as $result)
				{
					$text .= $result['title'] . ' ' . html_entity_decode($result['text'], ENT_NOQUOTES, 'UTF-8') . "\n";
				}

				$text .= "\n";

				if ($order_info['comment'] != '') {
					$comment = ($order_info['comment'] .  "\n\n" . $comment);
				}

				if ($comment) {
					$text .= __('text_new_comment') . "\n\n";
					$text .= $comment . "\n\n";
				}

				$this->mail->protocol = $this->config->get('mail_method');
				$this->mail->parameter = $this->config->get('mail_parameter');
				$this->mail->hostname = $this->config->get('smtp_host');
				$this->mail->username = $this->config->get('smtp_username');
				$this->mail->password = $this->config->get('smtp_password');
				$this->mail->port = $this->config->get('smtp_port');
				$this->mail->timeout = $this->config->get('smtp_timeout');
				$this->mail->setTo($this->config->get('sender_email'));
				$this->mail->setFrom($this->config->get('sender_email'));
				$this->mail->setSender(get_bloginfo('name'));
				$this->mail->setSubject($subject);
				$this->mail->setText($text);
				$this->mail->send();

				$emails = explode(',', $this->config->get('alert_emails'));

				foreach ($emails as $email) {
					if ($email && preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $email)) {
						$this->mail->setTo($email);
						$this->mail->send();
					}
				}
			}
				
		}

	}

	public function update($order_id, $order_status_id, $comment = '', $notify = false) {

		$order_info = $this->getOrder($order_id);

		if ($order_info && $order_info['order_status_id']) {

			$order_table = impresscart_framework::table('order');

			$order_history_table = impresscart_framework::table('order_history');

			$order_info['order_status_id'] = $order_status_id;
			
			$order_info['date_modified'] = date( 'Y-m-d H:i:s' );

			update_post_meta($order_id, 'data', $order_info);

			$order_history = array(
			array(
					'order_status_id' => $order_status_id,
					'notify' => $notify,
					'comment' => $comment,
					'date_added' => 'NOW()'
					)
					);

					add_post_meta($order_id, 'histories', $order_history);
					/*
					 $order_history = array(
					 'order_id' => $order_id,
					 'order_status_id' => $order_status_id,
					 'notify' => $notify,
					 'comment' => $comment,
					 'date_added' => 'NOW()'
					 );
					 */
					//$order_history_table->save($order_history);
					// Send out any gift voucher mails
					if ($this->config->get('complete_status_id') == $order_status_id) {
						$this->model_checkout_voucher->confirm($order_id);
					}

					if ($notify) {

						$subject = sprintf(__('text_update_subject'), html_entity_decode($order_info['store_name'], ENT_QUOTES, 'UTF-8'), $order_id);

						$message  = __('text_update_order') . ' ' . $order_id . "\n";
						$message .= __('text_update_date_added') . ' ' . date(__('date_format_short'), strtotime($order_info['date_added'])) . "\n\n";

						$order_status_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_status WHERE order_status_id = '" . (int)$order_status_id . "' AND language_id = '" . (int)$order_info['language_id'] . "'");

						if ($order_status_query->num_rows) {
							$message .= __('text_update_order_status') . "\n\n";
							$message .= $order_status_query->row['name'] . "\n\n";
						}

						if ($order_info['customer_id']) {
							$message .= __('text_update_link') . "\n";
							$message .= $order_info['store_url'] . 'index.php?route=account/order/info&order_id=' . $order_id . "\n\n";
						}

						if ($comment) {
							$message .= __('text_update_comment') . "\n\n";
							$message .= $comment . "\n\n";
						}

						$message .= __('text_update_footer');

						$this->mail->protocol = $this->config->get('mail_method');
						$this->mail->parameter = $this->config->get('mail_parameter');
						$this->mail->hostname = $this->config->get('smtp_host');
						$this->mail->username = $this->config->get('smtp_username');
						$this->mail->password = $this->config->get('smtp_password');
						$this->mail->port = $this->config->get('smtp_port');
						$this->mail->timeout = $this->config->get('smtp_timeout');
						$this->mail->setTo($order_info['email']);
						$this->mail->setFrom($this->config->get('sender_email'));
						$this->mail->setSender(get_bloginfo('name'));
						$this->mail->setSubject($subject);
						$this->mail->setText(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
						$this->mail->send();
					}
		}
	}
	
	public function getStoreCredit($user_id) {
		$transactions = get_user_meta($user_id, 'transactions', true);
		$total_transaction_amount = 0;
		if($transactions != '') {
			$transactions_amounts = $transactions['amount'];
			for($i=0;$i<count($transactions_amounts);$i++) {
				$total_transaction_amount += floatval($transactions_amounts[$i]);
			}	
		}
		
		$query = new WP_Query( array(   'meta_key' => 'customer_id', 
										'meta_value' => $user_id, 
										'meta_compare' => '=', 'post_type' => Goscom::GOSCOM_ORDER_POSTTYPE ) );
		
		
		$meta_type = 'store_credit';
		$total_store_credit_used = 0;
		while($query->have_posts()):
		     $query->next_post();
		     $id = $query->post->ID;
		     $data = get_post_meta($id, $meta_type);
		     if(empty($data)) {
		     	$temp = 0;
		     } else {
		     	$temp = floatval($data[0]);
		     }
		     
		     $total_store_credit_used += $temp;
		endwhile;
		
		
		return ($total_transaction_amount + $total_store_credit_used);
	}
	
	public function getTotalRewardPointsCustomer($type = 0) {
		$query = new WP_Query( array(   'meta_key' => 'customer_id', 
										'meta_value' => $this->customer->getId(), 
										'meta_compare' => '=', 'post_type' => Goscom::GOSCOM_ORDER_POSTTYPE ) );
		$meta_type = 'reward_point';
		if($type == 1) $meta_type = 'reward_point_used';
			
		$total_1 = 0;
		while($query->have_posts()):
		     $query->next_post();
		     $id = $query->post->ID;
		     $data = get_post_meta($id, $meta_type);
		     if(empty($data)) {
		     	$temp = 0;
		     } else {
		     	$temp = floatval($data[0]);
		     }
		     
		     $total_1 += $temp;
		endwhile;
		return $total_1;
	}
	
}
?>