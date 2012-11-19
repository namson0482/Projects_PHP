<?php 

class impresscart_account_order_controller extends impresscart_framework_controller {
	
	private $error = array();
		
	public function index() {
		
		
		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/order', '', 'SSL');
				$this->redirect($this->url->link('account/login', '', 'SSL'));
				return;
		}
    	
		$this->data['heading_title'] = __('Your order history');
		$this->data['text_order_id'] = __('Order Id');
		$this->data['text_status'] = __('Order Status');
		$this->data['text_date_added'] = __('Date added');
		$this->data['text_customer'] = __('Customer');
		$this->data['text_products'] = __('Products');
		$this->data['text_total'] = __('Total');
		$this->data['text_empty'] = __('You have not made any previous orders!');
		$this->data['button_view'] = __('View');
		$this->data['button_continue'] = __('Continue');
		
		$this->data['action'] = $this->url->link('account/order', '', 'SSL');
		$this->data['orders'] = array();
		/* pagination in wordpress */
		
		$orders = $this->model_account_order->getOrders();
		
		foreach ($orders as $order) {
			
			$result = get_post_meta($order->ID, 'data', true);
	
			$product_total = $this->model_account_order->getTotalOrderProductsByOrderId($order->ID);

			$this->data['orders'][] = array(
				'order_id'   => $order->ID,
				'name'       => $result['firstname'] . ' ' . $result['lastname'],
				'status'     => @$result['status'],
				'date_added' => date(__('D-M-Y'), strtotime($result['date_added'])),
				'products'   => $product_total,
				'total'      => $this->currency->format($result['total'], $result['currency_code'], $result['currency_value']),
				'href' => get_permalink($order->ID),
			);
		}
		$this->data['continue'] = $this->url->link('account/account', '', 'SSL');
	}
	
	public function info() { 
		
		global $post;
		
		if (!$this->customer->isLogged()) {
			//$this->session->data['redirect'] = $this->url->link('account/order/info', 'order_id=' . $order_id, 'SSL');			
			$this->redirect($this->url->link('account/login', '', 'SSL'));
    	}
		
    	$order_info = $this->model_account_order->getOrder($post->ID);
    	if ($order_info) {
    		$order_id = $order_info['order_id'];
			if (($_SERVER['REQUEST_METHOD'] == 'POST') && $this->validate()) {
				if ($_POST['action'] == 'reorder') {					
					$order_products = $this->model_account_order->getOrderProducts($order_id);
										
					foreach ($order_products as $order_product) {
						$order_product = (array)$order_product;
						
						if (in_array($order_product['order_product_id'], $_POST['selected'])) {
							$option_data = array();
							
							$order_options = $this->model_account_order->getOrderOptions($order_id, $order_product['order_product_id']);
							
							foreach ($order_options as $order_option) {
								if ($order_option['type'] == 'select' || $order_option['type'] == 'radio') {
									$option_data[$order_option['product_option_id']] = $order_option['product_option_value_id'];
								} elseif ($order_option['type'] == 'checkbox') {
									$option_data[$order_option['product_option_id']][] = $order_option['product_option_value_id'];
								} elseif ($order_option['type'] == 'input' || $order_option['type'] == 'textarea' || $order_option['type'] == 'file' || $order_option['type'] == 'date' || $order_option['type'] == 'datetime' || $order_option['type'] == 'time') {
									$option_data[$order_option['product_option_id']] = $order_option['value'];	
								}
							}
							
							$this->cart->add($order_product['product_id'], $order_product['quantity'], $option_data);
						}
					}
									
					$this->redirect($this->url->link('checkout/cart', '', 'SSL'));
				}
				if ($_POST['action'] == 'return') {
					$order_product_data = array();
					$order_products = $this->model_account_order->getOrderProducts($order_id);
					foreach ($order_products as $order_product) {
						$order_product = (array)$order_product;
						if (in_array($order_product['order_product_id'], $_POST['selected'])) {
							$order_product_data[] = array(
								'name'  => $order_product['name'],
								'model' => $order_product['model']
							);
						}
					}
					
					$this->session->data['return'] = array(
						'order_id'   => $order_info['order_id'],
						'date_added' => $order_info['date_added'],
						'product'    => $order_product_data
					);
					
					$this->redirect($this->url->link('account/return/insert', '', 'SSL'));
					$this->autoRender = false;
					return;	
				}
			} 
			
					
      		$this->data['heading_title'] = __('Order Information');
			$this->data['text_order_detail'] = __('Order Detail');
			$this->data['text_invoice_no'] = __('Invoice No.:');
    		$this->data['text_order_id'] = __('Order ID:');
			$this->data['text_date_added'] = __('Date Added:');
      		$this->data['text_shipping_method'] = __('Shipping Method:');
			$this->data['text_shipping_address'] = __('Shipping Address');
      		$this->data['text_payment_method'] = __('Payment Method:');
      		$this->data['text_payment_address'] = __('Payment Address');
      		$this->data['text_history'] = __('Order History');
			$this->data['text_comment'] = __('Order Comments');
			$this->data['text_action'] = __('Choose an action:');
			$this->data['text_selected'] = __('With selected..');
			$this->data['text_reorder'] = __('Add to Cart');
			$this->data['text_return'] = __('Return Products');

      		$this->data['column_name'] = __('Product Name');
      		$this->data['column_model'] = __('Model');
      		$this->data['column_quantity'] = __('Quantity');
      		$this->data['column_price'] = __('Price');
      		$this->data['column_total'] = __('Total');
			$this->data['column_date_added'] = __('Date Added');
      		$this->data['column_status'] = __('Status');
      		$this->data['column_comment'] = __('Comment');
			
      		$this->data['button_continue'] = __('Continue');
		
			if (isset($this->error['warning'])) {
				$this->data['error_warning'] = $this->error['warning'];
			} else {
				$this->data['error_warning'] = '';
			}
			
			$this->data['action'] = $this->url->link('account/order/info', 'order_id=' . $post->ID, 'SSL');
			
			if (isset($order_info['invoice_no'])) {
				$this->data['invoice_no'] = $order_info['invoice_prefix'] . $order_info['invoice_no'];
			} else {
				$this->data['invoice_no'] = '';
			}
			
			$this->data['order_id'] = $post->ID;
			$this->data['date_added'] = date(__('D-M-Y'), strtotime($order_info['date_added']));
			
			if ($order_info['shipping_address_format']) {
      			$format = $order_info['shipping_address_format'];
    		} else {
				$format = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';
			}
		
    		$find = array(
	  			'{firstname}',
	  			'{lastname}',
	  			'{company}',
      			'{address_1}',
      			'{address_2}',
     			'{city}',
      			'{postcode}',
      			'{zone}',
				'{zone_code}',
      			'{country}'
			);
	
			$replace = array(
	  			'firstname' => $order_info['shipping_firstname'],
	  			'lastname'  => $order_info['shipping_lastname'],
	  			'company'   => $order_info['shipping_company'],
      			'address_1' => $order_info['shipping_address_1'],
      			'address_2' => $order_info['shipping_address_2'],
      			'city'      => $order_info['shipping_city'],
      			'postcode'  => $order_info['shipping_postcode'],
      			'zone'      => $order_info['shipping_zone'],
				'zone_code' => $order_info['shipping_zone_code'],
      			'country'   => $order_info['shipping_country']  
			);

			$this->data['shipping_address'] = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));

			$this->data['shipping_method'] = $order_info['shipping_method'];

			if ($order_info['payment_address_format']) {
      			$format = $order_info['payment_address_format'];
    		} else {
				$format = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';
			}
		
    		$find = array(
	  			'{firstname}',
	  			'{lastname}',
	  			'{company}',
      			'{address_1}',
      			'{address_2}',
     			'{city}',
      			'{postcode}',
      			'{zone}',
				'{zone_code}',
      			'{country}'
			);
	
			$replace = array(
	  			'firstname' => $order_info['payment_firstname'],
	  			'lastname'  => $order_info['payment_lastname'],
	  			'company'   => $order_info['payment_company'],
      			'address_1' => $order_info['payment_address_1'],
      			'address_2' => $order_info['payment_address_2'],
      			'city'      => $order_info['payment_city'],
      			'postcode'  => $order_info['payment_postcode'],
      			'zone'      => $order_info['payment_zone'],
				'zone_code' => $order_info['payment_zone_code'],
      			'country'   => $order_info['payment_country']  
			);
			
			$this->data['payment_address'] = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));

      		$this->data['payment_method'] = $order_info['payment_method'];
			
			$this->data['products'] = array();
			
			$products = $this->model_account_order->getOrderProducts($post->ID);
			
      		foreach ($products as $product) {
      			$product = (array) $product;
				$option_data = array();
				
				$options = $this->model_account_order->getOrderOptions($post->ID, $product['product_id']);

         		foreach ($options as $option) {
         			$option = (array)$option;
          			if ($option['type'] != 'file') {
						$option_data[] = array(
							'name'  => $option['name'],
							'value' => (strlen($option['value']) > 20 ? substr($option['value'], 0, 20) . '..' : $option['value']),
						);
					} else {
						$filename = substr($option['value'], 0, strrpos($option['value'], '.'));
						
						$option_data[] = array(
							'name'  => $option['name'],
							'value' => (strlen($filename) > 20 ? substr($filename, 0, 20) . '..' : $filename)
						);						
					}
        		}
				
        		$this->data['products'][] = array(
					'order_product_id' => $product['product_id'],
          			'name'             => $product['name'],
          			'model'            => $product['model'],
          			'option'           => $option_data,
          			'quantity'         => $product['quantity'],
          			'price'            => $this->currency->format($product['price'], $order_info['currency_code'], $order_info['currency_value']),
					'total'            => $this->currency->format($product['total'], $order_info['currency_code'], $order_info['currency_value']),
					'selected'         => isset($_POST['selected']) && in_array($result['product_id'], $_POST['selected'])
        		);
      		}
      		
      		$this->data['totals'] = $this->model_account_order->getOrderTotals($post->ID);
			
			$this->data['comment'] = $order_info['comment'];
			
			$this->data['histories'] = array();

			$results = $this->model_account_order->getOrderHistories($post->ID);
			
      		foreach ($results as $result) {
      			
        		$this->data['histories'][] = array(
          			'date_added' => @$result['date_added'],
          			'status'     => $this->table_order_status->fetchOne(array('conditions' => array('order_status_id' => @$result['order_status_id'])))->name,
        			'comment'    => nl2br(@$result['comment'])
        			 
        		);
      		}            		
      		$this->data['continue'] = $this->url->link('account/order', '', 'SSL');
    	} else {
    		$this->autoRender = false;
			echo __('order not found!!!');
    	}
  	}
	
	private function validate() {
		if (!isset($_POST['selected']) || !isset($_POST['action'])) {
			$this->error['warning'] = __('You have not selected any product!!!');
		}
		
		if (!$this->error) {
      		return true;
    	} else {
      		return false;
    	}		
	}
}
?>