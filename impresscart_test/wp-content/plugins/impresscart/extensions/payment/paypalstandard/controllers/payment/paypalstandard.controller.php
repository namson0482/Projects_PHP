<?php
class impresscart_payment_paypalstandard_controller extends impresscart_framework_controller {	
	
	function index() {
			
		$this->autoRender = true;
		
		$setting = $this->model_payment_paypalstandard->get_setting();
		
		
		$this->data['text_testmode'] = __('Testing Mode');		
    	
		$this->data['button_confirm'] = __('Confirm');

		$this->data['testmode'] = $setting['sandbox'];
		
		if (!$setting['sandbox']) {
    		$this->data['action'] = 'https://www.paypal.com/cgi-bin/webscr';
  		} else {
			$this->data['action'] = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
		}

		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);

		if (@$order_info) {
			
			$this->data['business'] = $setting['email'];
			$this->data['item_name'] = html_entity_decode(get_bloginfo('name'), ENT_QUOTES, 'UTF-8');				
			
			$this->data['products'] = array();
			
			foreach ($this->cart->getProducts() as $product) {
				$option_data = array();
	
				foreach ($product['option'] as $option) {
					if ($option['type'] != 'file') {
						$value = $option['option_value'];	
					} else {
					
						$filename = $this->encryption->decrypt($option['option_value']);						
						$value = utf8_substr($filename, 0, utf8_strrpos($filename, '.'));
					}
										
					$option_data[] = array(
						'name'  => $option['name'],
						'value' => (utf8_strlen($value) > 20 ? utf8_substr($value, 0, 20) . '..' : $value)
					);
				}
				
				$this->data['products'][] = array(
					'name'     => $product['name'],
					'model'    => $product['model'],
					'price'    => $this->currency->format($product['price'], $order_info['currency_code'], false, false),
					'quantity' => $product['quantity'],
					'option'   => $option_data,
					'weight'   => $product['weight']
				);
			}	
			
			$this->data['discount_amount_cart'] = 0;
			
			$total = $this->currency->format($order_info['total'] - $this->cart->getSubTotal(), $order_info['currency_code'], false, false);

			if ($total > 0) {
				$this->data['products'][] = array(
					'name'     => __('Tax??'),
					'model'    => '',
					'price'    => $total,
					'quantity' => 1,
					'option'   => array(),
					'weight'   => 0
				);	
			} else {
				$this->data['discount_amount_cart'] -= $total;
			}
			
			$this->data['currency_code'] = $order_info['currency_code'];
			$this->data['first_name'] = html_entity_decode($order_info['payment_firstname'], ENT_QUOTES, 'UTF-8');	
			$this->data['last_name'] = html_entity_decode($order_info['payment_lastname'], ENT_QUOTES, 'UTF-8');	
			$this->data['address1'] = html_entity_decode($order_info['payment_address_1'], ENT_QUOTES, 'UTF-8');	
			$this->data['address2'] = html_entity_decode($order_info['payment_address_2'], ENT_QUOTES, 'UTF-8');	
			$this->data['city'] = html_entity_decode($order_info['payment_city'], ENT_QUOTES, 'UTF-8');	
			$this->data['zip'] = html_entity_decode($order_info['payment_postcode'], ENT_QUOTES, 'UTF-8');	
			$this->data['country'] = $order_info['payment_iso_code_2'];
			$this->data['email'] = $order_info['email'];
			$this->data['invoice'] = $this->session->data['order_id'] . ' - ' . html_entity_decode($order_info['payment_firstname'], ENT_QUOTES, 'UTF-8') . ' ' . html_entity_decode($order_info['payment_lastname'], ENT_QUOTES, 'UTF-8');
			$this->data['lc'] = 'en';
			
			//commented to test update order at localhost
			$this->data['return_url'] = $this->url->link('checkout/success');
			//$this->data['return_url'] = $this->url->link('payment/paypalstandard/callback');
			$this->data['notify_url'] = $this->url->link('payment/paypalstandard/callback');
			$this->data['cancel_return_url'] = $this->url->link('checkout/checkout');
			
			if (!$setting['method']) {
				$this->data['paymentaction'] = 'authorization';
			} else {
				$this->data['paymentaction'] = 'sale';
			}
			
			$this->data['custom'] = $this->encryption->encrypt($this->session->data['order_id']);
				
		}
		
	}
	
	
	//how to test callback with local
	function callback() {
		
		$this->log->write('it goes to callback already');
		
		$this->autoRender = false;
		
		$setting = $this->model_payment_paypalstandard->get_setting();
		
		if (isset($_REQUEST['custom'])) {
			$order_id = $this->encryption->decrypt($_REQUEST['custom']);
		} else {
			$order_id = 0;
		}
				
		$order_info = $this->model_checkout_order->getOrder($order_id);
		
		if ($order_info) {
			$request = 'cmd=_notify-validate';
		
			foreach ($_REQUEST as $key => $value) {
				$request .= '&' . $key . '=' . urlencode(html_entity_decode($value, ENT_QUOTES, 'UTF-8'));
			}
			
			if (!$setting['test']) {
				$curl = curl_init('https://www.paypal.com/cgi-bin/webscr');
			} else {
				$curl = curl_init('https://www.sandbox.paypal.com/cgi-bin/webscr');
			}

			curl_setopt($curl, CURLOPT_POST, true);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $request);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_HEADER, false);
			curl_setopt($curl, CURLOPT_TIMEOUT, 30);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
					
			$response = curl_exec($curl);
			
			if (!$response) {
				$this->log->write('PP_STANDARD :: CURL failed ' . curl_error($curl) . '(' . curl_errno($curl) . ')');
			}
					
			if ($setting['debug']) {
				$this->log->write('PP_STANDARD :: IPN REQUEST: ' . $request);
				$this->log->write('PP_STANDARD :: IPN RESPONSE: ' . $response);
			}
						
			if ((strcmp($response, 'VERIFIED') == 0 || strcmp($response, 'UNVERIFIED') == 0) && isset($_REQUEST['payment_status'])) {
				
				$order_status_id = Goscom::GOSCOM_ORDER_STATUS_ID_AFTER_CONFIRM;
				
				switch($_REQUEST['payment_status']) {
					case 'Canceled_Reversal':
						$order_status_id = $setting['canceled_reversal_status_id'];
						break;
					case 'Completed':
						if ((strtolower($_REQUEST['receiver_email']) == strtolower($setting['email'])) && ((float)$_REQUEST['mc_gross'] == $this->currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value'], false))) {
							$order_status_id = $setting['completed_status_id'];
						} else {
							$this->log->write('PP_STANDARD :: RECEIVER EMAIL MISMATCH! ' . strtolower($_REQUEST['receiver_email']));
						}
						break;
					case 'Denied':
						$order_status_id = $setting['denied_status_id'];
						break;
					case 'Expired':
						$order_status_id = $setting['expired_status_id'];
						break;
					case 'Failed':
						$order_status_id = $setting['failed_status_id'];
						break;
					case 'Pending':
						$order_status_id = $setting['pending_status_id'];
						break;
					case 'Processed':
						$order_status_id = $setting['processed_status_id'];
						break;
					case 'Refunded':
						$order_status_id = $setting['refunded_status_id'];
						break;
					case 'Reversed':
						$order_status_id = $setting['reversed_status_id'];
						break;	 
					case 'Voided':
						$order_status_id = $setting['voided_status_id'];
						break;								
				}
				
				if (!$order_info['order_status_id']) {
					$this->model_checkout_order->confirm($order_id, $order_status_id);
				} else {
					$this->model_checkout_order->update($order_id, $order_status_id);
				}
			} else {
				$this->model_checkout_order->confirm($order_id, GOSCOM::GOSCOM_ORDER_STATUS_ID_AFTER_CONFIRM);
			}
			
			curl_close($curl);
		}	
	}
}
?>