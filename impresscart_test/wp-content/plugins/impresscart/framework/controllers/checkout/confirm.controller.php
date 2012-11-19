<?php
class impresscart_checkout_confirm_controller extends impresscart_framework_controller {
	
	
	function initData(&$data) {
		$address_model = impresscart_framework::model('account/address');
		$data['invoice_prefix'] = $this->config->get('invoice_prefix');
		$data['store_id'] = $this->config->get('store_id');
		$data['store_name'] = get_bloginfo('name');
		$data['store_url'] = get_bloginfo('url');
		$data['store_credit_can_use'] = 0;

		if ($this->customer->isLogged()) {
			$data['customer_id'] = $this->customer->getId();
			$data['customer_group_id'] = $this->customer->getCustomerGroupId();
			$data['firstname'] = $this->customer->getFirstName();
			$data['lastname'] = $this->customer->getLastName();
			$data['email'] = $this->customer->getEmail();
			$data['telephone'] = $this->customer->getTelephone();
			$data['fax'] = $this->customer->getFax();
			$payment_address = $address_model->getAddress($this->session->data['payment_address_id']);
		} elseif (isset($this->session->data['guest'])) {
			$data['customer_id'] = 0;
			$data['customer_group_id'] = $this->config->get('customer_group_id');
			$data['firstname'] = $this->session->data['guest']['firstname'];
			$data['lastname'] = $this->session->data['guest']['lastname'];
			$data['email'] = $this->session->data['guest']['email'];
			$data['telephone'] = $this->session->data['guest']['telephone'];
			$data['fax'] = $this->session->data['guest']['fax'];
			$payment_address = $this->session->data['guest']['payment'];
		}
		
		$data['payment_firstname'] = $payment_address['firstname'];
		$data['payment_lastname'] = $payment_address['lastname'];
		$data['payment_company'] = $payment_address['company'];
		$data['payment_address_1'] = $payment_address['address_1'];
		$data['payment_address_2'] = $payment_address['address_2'];
		$data['payment_city'] = $payment_address['city'];
		$data['payment_postcode'] = $payment_address['postcode'];
		$data['payment_zone'] = $payment_address['zone'];
		$data['payment_zone_id'] = $payment_address['zone_id'];
		$data['payment_country'] = $payment_address['country'];
		$data['payment_country_id'] = $payment_address['country_id'];
		$data['payment_address_format'] = @$payment_address['address_format'];

		if (isset($this->session->data['payment_method']['title'])) {
			$data['payment_method'] = $this->session->data['payment_method']['title'];
		} else {
			$data['payment_method'] = '';
		}
		
		
		if ($this->cart->hasShipping()) {
			if ($this->customer->isLogged()) {
				$shipping_address = $address_model->getAddress($this->session->data['shipping_address_id']);
			} elseif (isset($this->session->data['guest'])) {
				$shipping_address = $this->session->data['guest']['shipping'];
			}
			$data['shipping_firstname'] = $shipping_address['firstname'];
			$data['shipping_lastname'] = $shipping_address['lastname'];
			$data['shipping_company'] = $shipping_address['company'];
			$data['shipping_address_1'] = $shipping_address['address_1'];
			$data['shipping_address_2'] = $shipping_address['address_2'];
			$data['shipping_city'] = $shipping_address['city'];
			$data['shipping_postcode'] = $shipping_address['postcode'];
			$data['shipping_zone'] = $shipping_address['zone'];
			$data['shipping_zone_id'] = $shipping_address['zone_id'];
			$data['shipping_country'] = $shipping_address['country'];
			$data['shipping_country_id'] = $shipping_address['country_id'];
			$data['shipping_address_format'] = $shipping_address['address_format'];
				
			if (isset($this->session->data['shipping_method']['title'])) {
				$data['shipping_method'] = $this->session->data['shipping_method']['title'];
			} else {
				$data['shipping_method'] = '';
			}
		} else {
			$data['shipping_firstname'] = '';
			$data['shipping_lastname'] = '';
			$data['shipping_company'] = '';
			$data['shipping_address_1'] = '';
			$data['shipping_address_2'] = '';
			$data['shipping_city'] = '';
			$data['shipping_postcode'] = '';
			$data['shipping_zone'] = '';
			$data['shipping_zone_id'] = '';
			$data['shipping_country'] = '';
			$data['shipping_country_id'] = '';
			$data['shipping_address_format'] = '';
			$data['shipping_method'] = '';
		}
		
	}
	
	function validate(&$json) {
		if ((!$this->cart->hasProducts() && (!isset($this->session->data['vouchers']) 
			|| !$this->session->data['vouchers'])) || (!$this->cart->hasStock() && !$this->config->get('stock_checkout'))) {
				$json['redirect'] = $this->url->link('checkout/cart');
			}
		
		$address_model = impresscart_framework::model('account/address');
		if ($this->customer->isLogged()) {
			$payment_address = $address_model->getAddress($this->session->data['payment_address_id']);
		} elseif (isset($this->session->data['guest'])) {
			$payment_address = $this->session->data['guest']['payment'];
		}

		if (!isset($payment_address) || !isset($this->session->data['payment_method'])) {
			$json['redirect'] = $this->url->link('checkout/checkout', '', 'SSL');
		}
			
		if ($this->cart->hasShipping()) {
			if ($this->customer->isLogged()) {
				$shipping_address = $address_model->getAddress($this->session->data['shipping_address_id']);
			} elseif (isset($this->session->data['guest'])) {
				$shipping_address = $this->session->data['guest']['shipping'];
			}

			if (!isset($shipping_address)) {
				$json['redirect'] = $this->url->link('checkout/checkout', '', 'SSL');
			}

			if (!isset($this->session->data['shipping_method'])) {
				$json['redirect'] = $this->url->link('checkout/checkout', '', 'SSL');
			}
		} else {
			unset($this->session->data['guest']['shipping']);
			unset($this->session->data['shipping_address_id']);
			unset($this->session->data['shipping_method']);
			unset($this->session->data['shipping_methods']);
		}
	}
	
	public function index() {

		$json = array();
		self::validate($json);
		if (!$json) {
			$total_data = array();
			$total = 0; 
			$total_credit_used = 0;
			$taxes = $this->cart->getTaxes();
			$results = impresscart_totals::get_enabled_totals();
			foreach ($results as $result) {
				$setting = $this->{'model_total_' . $result['code']}->get_setting();
				if ($setting['status'] == 'yes') {
					//var_dump($result['code']);
					$this->{'model_total_' . $result['code']}->getTotal($total_data, $total, $taxes);
					if($result['code'] == 'credit' ) {
						$total_credit_used = $total_data[count($total_data) - 1]['value'];
					}
				}
				$sort_order = array();
				foreach ($total_data as $key => $value) {
					$sort_order[$key] = $value['sort_order'];
				}
				array_multisort($sort_order, SORT_ASC, $total_data);
			}
			$data = array();
			self::initData($data);
			//////////////////////////////////////////////
			$product_data = $this->getProductsData();
			$data['products'] = $product_data;
			//calculate total discount by coupon
			$coupon_total = 0;
			if(@$this->session->data['coupon']) {
				$data['coupons'] = $this->session->data['coupon'];
				foreach( $this->session->data['coupon'] as $coupon ){
					foreach( $product_data as $product ){
						if( $product['product_id'] == $coupon['product_id'] ){
							$coupon_total += $coupon['coupon_discount'] * $product['quantity'];
						}
					}
				}
			}
			
			// calculate discount by vouchers
			$voucher_total = 0;
			if(@$this->session->data['voucher']) {
				$data['vouchers'] = $this->session->data['voucher'];
				foreach( $this->session->data['voucher'] as $voucher ){
					$voucher_total += $voucher['amount'];
				}
			}

			$total_data_review = array();
			// get total discount for current user role (if exists)
			$product_model = impresscart_framework::model('catalog/product');
			$total_discount = 0;
			foreach( $this->cart->getProducts() as $product ){
				$discounts_by_userrole = $product_model->getDiscountsByUserRole($product['product_id']);
				$product_discounts = $product_model->getProductDiscounts($product['product_id']);
				$new_product_discounts = array();
				if( count($discounts_by_userrole) > 0 ){
					foreach( $discounts_by_userrole as $discount_by_userrole ){
						// update discount used_times
						$discount_by_userrole['used_times'] = $discount_by_userrole['used_times'] + 1;
						$new_product_discounts[] = $discount_by_userrole;
						$total_discount += $discount_by_userrole['price'];
					}
				}
				// update discount used_times
				if(count(@$product_discounts))
				{
					if(is_array($product_discounts))
					{
						foreach( $product_discounts as $product_discount ){
							if( !in_array($product_discount, $discounts_by_userrole) ){
								$new_product_discounts[] = $product_discount;
							}
						}
					}
					$product_model->setProductDiscounts($product['product_id'], $new_product_discounts);
				}
			}
			$data['total_discount_for_products'] = $total_discount;
			$data['totals'] = $total_data;
			$data['comment'] = $this->session->data['comment'];
			$data['total'] = $total;
			$data['reward'] = $this->getTotalRewardPoints($product_data);
			if (isset($_COOKIE['tracking'])) {
				$affiliate_info = $this->model_affiliate_account->getAffiliateByCode($_COOKIE['tracking']);
				if ($affiliate_info) {
					$data['affiliate_id'] = $affiliate_info['affiliate_id'];
					$data['commission'] = ($total / 100) * $affiliate_info['commission'];
				} else {
					$data['affiliate_id'] = 0;
					$data['commission'] = 0;
				}
			} else {
				$data['affiliate_id'] = 0;
				$data['commission'] = 0;
			}

			$data['language_id'] = $this->config->get('language_id');
			$data['currency_id'] = $this->currency->getId();
			$data['currency_code'] = $this->currency->getCode();
			$data['currency_value'] = $this->currency->getValue($this->currency->getCode());
			$data['ip'] = $_SERVER['REMOTE_ADDR'];
			$order_model = impresscart_framework::model('checkout/order');
			
			//create new order post from $data//
			///////////////////////////////////
			$data['store_credit_can_use'] = $total_credit_used; 
			$this->session->data['order_id'] = $order_model->create($data);
			///////////////////////////////////
			//add vouchers (if exists) from cart to voucher history in database
			$voucher_model = impresscart_framework::model('checkout/voucher');
			$voucher_model->updateHistory();

			//add coupons (if exists) from cart to coupon history in database
			$coupon_model = impresscart_framework::model('checkout/coupon');
			$coupon_model->updateHistory();

			$this->data['column_name'] = __('Product Name');
			$this->data['column_model'] = __('Model');
			$this->data['column_quantity'] = __('Quantity');
			$this->data['column_price'] = __('Price');
			$this->data['column_total'] = __('Total');
			$this->data['products'] = array();
			
			foreach ($this->cart->getProducts() as $product) {
				$option_data = array();
				foreach ($product['option'] as $option) {
					if ($option['type'] != 'file') {
						$option_data[] = array(
                                    'name'  => $option['name'],
                                    'value' => (strlen($option['option_value']) > 20 ? substr($option['option_value'], 0, 20) . '..' : $option['option_value'])
						);
					} else {
						$encryption = impresscart_framework::service('encryption');
						$encryption->setKey($this->config->get('encryption'));
						$file = substr($encryption->decrypt($option['option_value']), 0, strrpos($encryption->decrypt($option['option_value']), '.'));
						$option_data[] = array(
                                    'name'  => $option['name'],
                                    'value' => (strlen($file) > 20 ? substr($file, 0, 20) . '..' : $file)
						);
					}
				}

				$this->data['products'][] = array(
                    'product_id' => $product['product_id'],
                    'name'       => $product['name'],
                    'model'      => $product['model'],
                    'option'     => $option_data,
                    'quantity'   => $product['quantity'],
                    'subtract'   => $product['subtract'],
                    'tax'        => $this->tax->getTax($product['total'], $product['tax_class_id']),
                    'price'      => $this->currency->format($product['price']),
                    'total'      => $this->currency->format($product['total']),
                    'href'       => $this->url->link('product/product', 'product_id=' . $product['product_id'])
				);
			}

			$this->data['totals'] = $total_data;
			$this->data['payment_code'] = $this->session->data['payment_method']['code'];
			ob_start();
			$this->render();
			$json['output'] = ob_get_contents();
			ob_end_clean();
		}
		echo json_encode($json);
		exit(0);
	}
	
	
	private function getTotalRewardPoints($product_data) {
		$reward = 0; 
		foreach($product_data as $product) {
			$reward += $product['reward']; 				
		}
		return $reward; 
	}

	private function getProductsData() {
		
		$product_data = array();
		
		
		foreach ($this->cart->getProducts() as $product) {
			$option_data = array();
			foreach ($product['option'] as $option) {
				if ($option['type'] != 'file') {
					$option_data[] = array(
							'product_option_id'       => $option['product_option_id'],
							'product_option_value_id' => $option['product_option_value_id'],
							'product_option_id'       => $option['product_option_id'],
							'product_option_value_id' => $option['product_option_value_id'],
							'option_id'               => $option['option_id'],
							'option_value_id'         => $option['option_value_id'],								   
							'name'                    => $option['name'],
							'value'                   => $option['option_value'],
							'type'                    => $option['type']
					);
				} else {
					$encryption = new Encryption($this->config->get('encryption'));
					$option_data[] = array(
							'product_option_id'       => $option['product_option_id'],
							'product_option_value_id' => $option['product_option_value_id'],
							'product_option_id'       => $option['product_option_id'],
							'product_option_value_id' => $option['product_option_value_id'],
							'option_id'               => $option['option_id'],
							'option_value_id'         => $option['option_value_id'],								   
							'name'                    => $option['name'],
							'value'                   => $encryption->decrypt($option['option_value']),
							'type'                    => $option['type']
					);
				}
			}

			$product_data[] = array(
					'product_id' => $product['product_id'],
					'name'       => $product['name'],
					'model'      => $product['model'],
					'option'     => $option_data,
					'download'   => $product['download'],
					'quantity'   => $product['quantity'],
					'subtract'   => $product['subtract'],
					'price'      => $product['price'],
					'reward'	 =>	$product['reward'],
					'total'      => $product['total'],
					'tax'        => $this->tax->getTax($product['total'], $product['tax_class_id'])
			);
		} //

		// Gift Voucher
		if (isset($this->session->data['vouchers']) && $this->session->data['vouchers']) {
			foreach ($this->session->data['vouchers'] as $voucher) {
				$product_data[] = array(
						'product_id' => 0,
						'name'       => $voucher['description'],
						'model'      => '',
						'option'     => array(),
						'download'   => array(),
						'quantity'   => 1,
						'subtract'   => false,
						'price'      => $voucher['amount'],
						'total'      => $voucher['amount'],
						'tax'        => 0
				);
			}
		}
		return $product_data;
	}
}
?>