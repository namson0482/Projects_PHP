<?php
class impresscart_report_customer_order_controller extends impresscart_framework_controller {
	
	public function index() {
		
		if (isset($_GET['filter_date_start'])) {
			$filter_date_start = $_GET['filter_date_start'];
		} else {
			$filter_date_start = '';
		}

		if (isset($_GET['filter_date_end'])) {
			$filter_date_end = $_GET['filter_date_end'];
		} else {
			$filter_date_end = '';
		}
		
		if (isset($_GET['filter_order_status_id'])) {
			$filter_order_status_id = $_GET['filter_order_status_id'];
		} else {
			$filter_order_status_id = 0;
		}

		if (isset($_GET['page'])) {
			$page = $_GET['page'];
		} else {
			$page = 1;
		}
		
		$url = '';
		if (isset($_GET['filter_date_start'])) {
			$url .= '&filter_date_start=' . $_GET['filter_date_start'];
		}

		if (isset($_GET['filter_date_end'])) {
			$url .= '&filter_date_end=' . $_GET['filter_date_end'];
		}

		if (isset($_GET['filter_order_status_id'])) {
			$url .= '&filter_order_status_id=' . $_GET['filter_order_status_id'];
		}

		if (isset($_GET['page'])) {
			$url .= '&page=' . $_GET['page'];
		}

		$data = array(
			'filter_date_start'	     => $filter_date_start, 
			'filter_date_end'	     => $filter_date_end, 
			'filter_order_status_id' => $filter_order_status_id == -1 ? null : $filter_order_status_id,
			'start'                  => 0,
			'limit'                  => $this->config->get('config_admin_limit')
		);

		$this->data = $data;
		$this->data['customers'] = array();

		$results = $this->model_report_customer->getOrders($data);		
		$this->data['filter_order_status_id'] = $filter_order_status_id;
		
		foreach ($results as $result) {
			$action = array();

			$action[] = array(
				'text' => __('Edit'),
			//'href' => $this->url->link('sale/customer/update', 'token=' . $this->session->data['token'] . '&customer_id=' . $result['customer_id'] . $url, 'SSL')
			);

			$this->data['customers'][] = array(
				'customer'       => $result['customer'],
				'email'          => $result['email'],
				'customer_group' => $result['customer_group'],
				'status'         => ($result['status'] == 0? __('Enabled') : __('Disabled')),
				'orders'         => $result['orders'],
				'products'       => $result['products'],
				'total'          => $this->currency->format($result['total'], $this->config->get('config_currency')),
				'action'         => $action
			);
		}
			
		$this->data['heading'] = __('Customer Order Report');
		$this->data['text_no_results'] = __('No Results');
		$this->data['text_all_status'] = __('All Statues');
		$this->data['column_customer'] = __('Customer');
		$this->data['column_email'] = __('Email');
		$this->data['column_customer_group'] = __('Customer Group');
		$this->data['column_status'] = __('Order Status');
		$this->data['column_orders'] = __('No Of Orders');
		$this->data['column_products'] = __('No of Products');
		$this->data['column_total'] = __('Total');
		$this->data['column_action'] = __('Action');
		$this->data['entry_date_start'] = __('Date start');
		$this->data['entry_date_end'] = __('Date end');
		$this->data['entry_status'] = __('Status');
		$this->data['button_filter'] = __('Filter');
		
		$order_status_data = $this->config->get('order_status_data');
		foreach($order_status_data as $key => $value) {
			$this->data['order_statuses'][] = array(
                        'order_status_id' => $key,
                        'name' => $value,
			);
		}
		
		$url = get_bloginfo('url') . '/wp-admin/admin.php?page=catalog&fwurl=/report/customer_order/';
		if (isset($_GET['filter_date_start'])) {
			$url .= '&filter_date_start=' . $_GET['filter_date_start'];
		}

		if (isset($_GET['filter_date_end'])) {
			$url .= '&filter_date_end=' . $_GET['filter_date_end'];
		}

		if (isset($_GET['filter_order_status_id'])) {
			$url .= '&filter_order_status_id=' . $_GET['filter_order_status_id'];
		}
		$this->data['url'] = $url;
		$this->data['pages'] = apply_filters('impresscart_administration_pages', array());
		
		$this->data['pages'] = apply_filters('impresscart_administration_pages', array());
	}
	
	function invoice() {

		$this->data['title'] = __('Invoice');

		
		$this->data['base'] = site_url();
		
		$this->data['direction'] = '';//$this->language->get('direction');
		$this->data['language'] = '';//$this->language->get('code');

		$this->data['text_invoice'] = __('Invoice');

		$this->data['text_order_id'] = __('Order Id');
		$this->data['text_invoice_no'] = __('Invoice No');
		$this->data['text_invoice_date'] = __('Invoice Date');
		$this->data['text_date_added'] = __('Date Added');
		$this->data['text_telephone'] = __('Telephone');
		$this->data['text_fax'] = __('Fax');
		$this->data['text_to'] = __('To');
		$this->data['text_company_id'] = __('Company Id');
		$this->data['text_tax_id'] = __('Tax Id');		
		$this->data['text_ship_to'] = __('Ship To');
		$this->data['text_payment_method'] = __('Payment Method');
		$this->data['text_shipping_method'] = __('Shipping Method');

		$this->data['column_product'] = __('Product');
		$this->data['column_model'] = __('Model');
		$this->data['column_quantity'] = __('Quantity');
		$this->data['column_price'] = __('Price');
		$this->data['column_total'] = __('Total');
		$this->data['column_comment'] = __('Comment');


		$this->data['orders'] = array();

		$orders = array();
		if(isset($_REQUEST['post'])) {
			$orders = $_REQUEST['post'];
		} elseif (isset($_REQUEST['order_id'])) {
			$orders[] = $_REQUEST['order_id'];
		}		
		
		$order_model = impresscart_framework::model('sale/order');

		foreach ($orders as $order_id) {
			
			$order_info = $order_model->getOrder($order_id);
			
			if ($order_info) {
				//var_dump($order_info); die();
				$store_address = __('Address');
				$store_email = $order_info['email'];
				$store_telephone = $order_info['telephone'];
				$store_fax = $order_info['fax'];
				
				if ($order_info['invoice_no'] != '') {
					$invoice_no = $order_info['invoice_prefix'] . $order_info['invoice_no'];
				} else {
					$invoice_no = '';
				}
				
				$format = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';

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

				$shipping_address = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));
			
				//$format = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';
			

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

				$payment_address = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));
				//var_dump($shipping_address);
				//var_dump($payment_address);
				//die();
				
				$product_data = array();
				$products = $order_model->getOrderProducts($order_id);
				foreach ($products as $product) {
					
					$option_data = array();
					$options = $this->model_sale_order->getOrderOptions($order_id, $product['order_product_id']);
					foreach ($options as $option) {
						if ($option['type'] != 'file') {
							$value = $option['value'];
						} else {
							$value = utf8_substr($option['value'], 0, utf8_strrpos($option['value'], '.'));
						}
						
						$option_data[] = array(
							'name'  => $option['name'],
							'value' => $value
						);								
					}
					$product_data[] = array(
						'name'     => $product['name'],
						'model'    => $product['model'],
						'option'   => $option_data,
						'quantity' => $product['quantity'],
						'price'    => $this->currency->format($product['price'] + ($this->config->get('config_tax') ? $product['tax'] : 0), $order_info['currency_code'], $order_info['currency_value']),
						'total'    => $this->currency->format($product['total'] + ($this->config->get('config_tax') ? ($product['tax'] * $product['quantity']) : 0), $order_info['currency_code'], $order_info['currency_value'])
					);
				}
				
				$voucher_data = array();
				
				$vouchers = $this->model_sale_order->getOrderVouchers($order_id);

				foreach ($vouchers as $voucher) {
					$voucher_data[] = array(
						'description' => $voucher['description'],
						'amount'      => $this->currency->format($voucher['amount'], $order_info['currency_code'], $order_info['currency_value'])			
					);
				}
					
				$total_data = $this->model_sale_order->getOrderTotals($order_id);

				$this->data['orders'][] = array(
					'order_id'	         => $order_id,
					'invoice_no'         => $invoice_no,
					'date_added'         => date($this->language->get('date_format_short'), strtotime($order_info['date_added'])),
					'store_name'         => $order_info['store_name'],
					'store_url'          => rtrim($order_info['store_url'], '/'),
					'store_address'      => nl2br($store_address),
					'store_email'        => $store_email,
					'store_telephone'    => $store_telephone,
					'store_fax'          => $store_fax,
					'email'              => $order_info['email'],
					'telephone'          => $order_info['telephone'],
					'shipping_address'   => $shipping_address,
					'shipping_method'    => $order_info['shipping_method'],
					'payment_address'    => $payment_address,
					'payment_company_id' => $order_info['payment_company_id'],
					'payment_tax_id'     => $order_info['payment_tax_id'],
					'payment_method'     => $order_info['payment_method'],
					'product'            => $product_data,
					'voucher'            => $voucher_data,
					'total'              => $total_data,
					'comment'            => nl2br($order_info['comment'])
				);
			}
		}

		//$this->template = 'sale/order_invoice.tpl';

		//$this->response->setOutput($this->render());
	}
	
}
?>