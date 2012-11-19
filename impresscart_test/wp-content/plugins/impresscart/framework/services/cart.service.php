<?php

class impresscart_cart_service extends impresscart_service {

	public function __construct() {

		$this->config = impresscart_framework::service('config');
		$this->session = impresscart_framework::service('session');

		$this->customer = impresscart_framework::service('customer');
		$this->tax = impresscart_framework::service('tax');
		$this->weight = impresscart_framework::service('weight');

		if (!isset($this->session->data['cart']) || !is_array($this->session->data['cart'])) {
			$this->session->data['cart'] = array();
		}
	}

	function getProductPrice($product_id) {
		$resultPrice = -1;
		$currentPriority = -1;
		$product_model = impresscart_framework::model('catalog/product');
		$product_info = $product_model->getProduct($product_id);
		$resultPrice = floatval($product_info->PRICE);
		if($this->customer->isLogged()) {
			$user_role = $this->customer->getUserRole();
			$dataes = get_post_meta($product_id, 'impresscart_product_discounts', true);
			$now = strtotime("now");
			if(count($dataes) > 0 && $dataes != '') {
				foreach ($dataes as $key => $data) {
					$startdate = strtotime($data['start_date']);
					$enddate = strtotime($data['end_date']);
					if($data['customer'] ==  $user_role 
						&& (($now <= $enddate && $now >= $startdate) || ($enddate == 0 && $startdate == 0))
					) {
						if($currentPriority == -1) {
							$resultPrice = floatval($data['price']);
							$currentPriority = intval($data['priority']);
						} else {
							$tempPriority = intval($data['priority']);
							if($tempPriority < $currentPriority) {
								$resultPrice = floatval($data['price']);
								$currentPriority = intval($data['priority']);
							}						
						}
					}
				}
			}
		} 
		return $resultPrice;
	}
	
	public function getProducts() {
		
		$product_data = array();
		$product_model = impresscart_framework::model('catalog/product');
		foreach ($this->session->data['cart'] as $key => $quantity) {
			
			$product = explode(':', $key);
			$product_id = $product[0];
			$stock = true;

			// Options
			if (isset($product[1])) {
				$options = unserialize(base64_decode($product[1]));
			} else {
				$options = array();
			}

			$product_info = $product_model->getProduct($product_id);
			
			if (!is_null($product_info)) {
				
				$option_price = 0;
				$option_points = 0;
				$option_weight = 0;

				$option_data = array();
				$productOptions = $product_model->getProductOptions($product_id);
				
				foreach($productOptions as $productOption) {
					$optionID				= $productOption['option_id'];
					$optionType				= $productOption['type'];
					//there might be a bug here
					$buyValue				= @$options[$optionID];
					$productOptionValue 	= $productOption['option_value'];


					switch ($optionType) {
						case 'select':
						case 'radio' :
							$buyValue = array($buyValue);
						case 'checkbox':
							foreach($productOptionValue as $poVal) {
								//print_r ($poVal);
								 
								if(is_array($buyValue))
								{
									if(in_array($poVal['option_value_id'], $buyValue)) {

										if ($poVal['price_prefix'] == '+') {
											$option_price += $poVal['price'];
										} elseif ($poVal['price_prefix'] == '-') {
											$option_price -= $poVal['price'];
										}

										if ($poVal['weight_prefix'] == '+') {
											$option_weight += $poVal['weight'];
										} elseif ($poVal['weight_prefix'] == '-') {
											$option_weight -= $poVal['weight'];
										}

										if ($poVal['subtract'] && (!$poVal['quantity'] || ($poVal['quantity'] < $quantity))) {
											$stock = false;
										}
										$t=0;
										$option_data[] = array(
                                        'product_option_id'       => $product_id . '_' . $optionID,
                                        'product_option_value_id' => $poVal['product_option_value_id'],
                                        'option_id'               => $optionID,
                                        'option_value_id'         => $poVal['option_value_id'],
                                        'name'                    => $productOption['name'],
                                        'option_value'            => $poVal['option_value_id'],
                                        'type'                    => $optionType,
                                        'quantity'                => $poVal['quantity'],
                                        'subtract'                => $poVal['subtract'],
                                        'price'                   => $poVal['price'],
                                        'price_prefix'            => $poVal['price_prefix'],
                                        'points'                  => @$poVal['points'], // TODO
                                        'points_prefix'           => @$poVal['points_prefix'], // TODO:
                                        'weight'                  => $poVal['weight'],
                                        'weight_prefix'           => $poVal['weight_prefix']
										);
									}
								}
							}
							break;
						default:
							$option_data[] = array(
                            'product_option_id'       => $product_id . '_' . $optionID,
                            'product_option_value_id' => '',
                            'option_id'               => $optionID,
                            'option_value_id'         => '',
                            'name'                    => $productOption['name'],
                            'option_value'            => $buyValue,
                            'type'                    => $optionType,
                            'quantity'                => '',
                            'subtract'                => '',
                            'price'                   => '',
                            'price_prefix'            => '',
                            'points'                  => '',
                            'points_prefix'           => '',
                            'weight'                  => '',
                            'weight_prefix'           => ''
                            );
					}
				}

				if ($this->customer->isLogged()) {
					$customer_group_id = $this->customer->getCustomerGroupId();
				} else {
					$customer_group_id = $this->config->get('config_customer_group_id');
				}

				//$price = $product_model->getPrice($product_id);

				// Product Discounts
				$discount_quantity = 0;

				foreach ($this->session->data['cart'] as $key_2 => $quantity_2) {
					$product_2 = explode(':', $key_2);
					if ($product_2[0] == $product_id) {
						$discount_quantity += $quantity_2;
					}
				}
				
				$price = $this->getProductPrice($product_id);
				$reward = $product_model->getRewardPointsCustomerRole($product_id);
				// Downloads
				$download_data = array();
				$downloadIDs = get_post_meta($product_id, 'impresscart_product_downloads', true);

				if(!empty($downloadIDs)) {

					$downloads = $this->table_download->fetchAll(array(
                    'conditions' => array(
                    'download_id IN (' .implode(',', $downloadIDs) . ')' 
                    )
                    ));

                    foreach ($downloads as $download) {
                    	$download_data[] = (array)$download;
                    }
				}

				// Stock
				if (!$product_info->quantity || ($product_info->quantity < $quantity)) {
					$stock = false;
				}

				$product_data[$key] = array(
                'key'             => $key,
                'product_id'      => $product_info->product_id,
                'name'            => $product_info->name,
                'model'           => $product_info->model,
                'shipping'        => $product_info->shipping,
                'image'           => $product_info->image,
                'option'          => $option_data,
                'download'        => $download_data,
                'quantity'        => $quantity,
                'minimum'         => $product_info->minimum,
                'subtract'        => @$product_info->subtract,
                'stock'           => $stock,
                'price'           => ($price + $option_price),
                'total'           => ($price + $option_price) * $quantity,
                'reward'          => $reward * $quantity,
                'points'          => ($product_info->points + $option_points) * $quantity,
				'points_to_buy'   => $product_model->getRewardPoints($product_info->product_id),
                'tax_class_id'    => $product_info->tax_class_id,
                'weight'          => ($product_info->weight + $option_weight) * $quantity,
                'weight_class_id' => $product_info->weight_class_id,
                'length'          => $product_info->length,
                'width'           => $product_info->width,
                'height'          => $product_info->height,
                'length_class_id' => $product_info->length_class_id
				);
			} else {
				$this->remove($key);
			}
		}

		return $product_data;
	}

	public function add($product_id, $qty = 1, $options = array()) {

		if (!$options) {
			$key = (int)$product_id;
		} else {

			$key = (int)$product_id . ':' . base64_encode(serialize($options));
		}

		if ((int)$qty && ((int)$qty > 0)) {
			if (!isset($this->session->data['cart'][$key])) {

				$this->session->data['cart'][$key] = (int)$qty;

			} else {

				$this->session->data['cart'][$key] += (int)$qty;

			}
		}
	}

	public function update($key, $qty) {
		if ((int)$qty && ((int)$qty > 0)) {
			$this->session->data['cart'][$key] = (int)$qty;
		} else {
			$this->remove($key);
		}
	}

	public function remove($key) {
		if (isset($this->session->data['cart'][$key])) {
			unset($this->session->data['cart'][$key]);
		}

	}

	// remove coupons along with their product
	// $product_id : product that is removed
	public function removeCouponsByProduct( $product_id ) {
		if( isset($this->session->data['coupon'] ) ){
			$new_coupons = array();
			// reset coupons array in cart, exclude a coupon if its product is removed
			foreach( $this->session->data['coupon'] as $coupon ){
				if( $coupon['product_id'] != $product_id ){
					$new_coupons[] = $coupon;
				}
			}
			if( count($new_coupons) > 0 ){
				$this->session->data['coupon'] = $new_coupons;
			} else {
				unset($this->session->data['coupon']);
			}
		}
	}

	public function clear() {
		$this->session->data['cart'] = array();
	}

	public function getWeight() {
		$weight = 0;
		foreach ($this->getProducts() as $product) {
			if ($product['shipping']) {
				$weight += $this->weight->convert($product['weight'], $product['weight_class_id'], $this->config->get('config_weight_class_id'));
			}
		}

		return $weight;
	}
	
	public function getSubTotal() {
		$total = 0;
		foreach ($this->getProducts() as $product) {
			$total += $product['total'];
		}
		return $total;
		
	}
	public function cartTotal(){
		$json = array();
		$product_model = impresscart_framework::model('catalog/product');
		$cart = impresscart_framework::service('cart');
		$customer = impresscart_framework::service('customer');
		$currency = impresscart_framework::service('currency');
		$taxes = $cart->getTaxes();
		$is_logged = $customer->isLogged();
		$total = 0;
		$total_data = array();
		if( (get_option('impresscart_config_customer_price') && $is_logged ) || !get_option('impresscart_config_customer_price')) {

			$results = impresscart_totals::get_enabled_totals();

			foreach ($results as $result) {
				$model = impresscart_framework::model('total/' . $result['code']);
				$setting =$model->get_setting();

				if ($setting['status'] == 'yes') {

					$model->getTotal($total_data, $total, $taxes);
				}

				$sort_order = array();

				foreach ($total_data as $key => $value) {
					$sort_order[$key] = $value['sort_order'];
				}

				array_multisort($sort_order, SORT_ASC, $total_data);
			}
		}

		$this->data['text_cart'] = 'Shopping Cart';
		$count_products = $cart->countProducts();

		$vouchers = @$_SESSION['vouchers'] ? count( $_SESSION['vouchers'] ) : 0;
		if($count_products==0){
			$this->data['text_items'] =  sprintf("Cart is Empty");
		}else{
			return $total;
		}
		/////   $session = impresscart_framework::service('session');


	}
	public function getTaxes() {
		$tax_data = array();
		foreach ($this->getProducts() as $product) {
			if ($product['tax_class_id']) {
				$tax_rates = $this->tax->getRates($product['total'], $product['tax_class_id']);
				foreach ($tax_rates as $tax_rate) {
					$amount = 0;
					if ($tax_rate['type'] == 'F') {
						$amount = ($tax_rate['amount'] * $product['quantity']);
					} elseif ($tax_rate['type'] == 'P') {
						$amount = $tax_rate['amount'];
					}
						
					if (!isset($tax_data[$tax_rate['tax_rate_id']])) {
						$tax_data[$tax_rate['tax_rate_id']] = $amount;
					} else {
						$tax_data[$tax_rate['tax_rate_id']] += $amount;
					}
				}
			}
		}

		return $tax_data;
		 
	}

	public function getTotal() {
		
		$total = 0;
		foreach ($this->getProducts() as $product) {
			if( @$this->session->data['coupon'] ){
				foreach( $this->session->data['coupon'] as $coupon ){
					if( $product['product_id'] == $coupon['product_id'] ){
						$product['total'] = ($product['price'] + $coupon['coupon_discount']) * $product['quantity'];
					}
				}
			}
			$total += $this->tax->calculate($product['total'], $product['tax_class_id'], $this->config->get('tax'));
		}
		return $total;
	}
	
	public function addRewardToCart($reward) {
		$this->session->data['reward'] = $reward; 	
	}

	public function addCouponToCart( $product_id, $coupon_code, $coupon_discount ) {
		$this->session->data['coupon'] = array();
		$this->session->data['coupon'][] = array(
            'code' => $coupon_code,
            'product_id' => $product_id,
            'coupon_discount' => $coupon_discount['coupon_discount']
		);
	}

	public function addVoucherToCart( $voucher_code, $voucher_amount) {
		$this->session->data['voucher'] = array();
			$this->session->data['voucher'][] = array(
            'code' => $voucher_code,
            'amount' => $voucher_amount
			);
	}

	public function getTotalRewardPoints() {
		$total = 0;
		foreach ($this->getProducts() as $product) {
			$total += $product['reward'];
		}	
		return $total;
	}

	public function countProducts() {
		$product_total = 0;

		$products = $this->getProducts();

		foreach ($products as $product) {
			$product_total += $product['quantity'];
		}

		return $product_total;
	}

	public function hasProducts() {
		return count($this->session->data['cart']);
	}

	public function hasStock() {
		return true;
		$stock = true;

		foreach ($this->getProducts() as $product) {
			if (!$product['stock']) {
				$stock = false;
			}
		}

		return $stock;
	}

	public function hasShipping() {
		$shipping = false;

		foreach ($this->getProducts() as $product) {
				
			if ($product['shipping']) {
				$shipping = true;
				break;
			}
		}
		return $shipping;
	}

	public function hasDownload() {
		$download = false;

		foreach ($this->getProducts() as $product) {
			if ($product['download']) {
				$download = true;

				break;
			}
		}

		return $download;
	}
}