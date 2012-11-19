<?php

class impresscart_checkout_cart_controller extends impresscart_framework_controller {
	
	function getProductionOptionData($product) {
		$option_data = array();
		foreach ($product['option'] as $option) {
			if ($option['type'] != 'file') {
				$option_data[] = array(
					'name'  => $option['name'],
					'value' => (strlen($option['option_value']) > 20 ? substr($option['option_value'], 0, 20) . '..' : $option['option_value'])
				);
			} else {
				$encryption = new Encryption($this->config->get('encryption'));
				$file = substr($encryption->decrypt($option['option_value']), 0, strrpos($encryption->decrypt($option['option_value']), '.'));
				$option_data[] = array(
					'name'  => $option['name'],
					'value' => (strlen($file) > 20 ? substr($file, 0, 20) . '..' : $file)
				);
			}
		}
		return $option_data;
	}
	
	private function calculateProductPrice($product) {
		$totalOptionPrice = 0;		
		$options = $product['option'];
		for($i=0;$i<count($options);$i++) {
			$option = $options[$i];
			$totalOptionPrice += floatval($option['price']);
		}
		return ($this->cart->getProductPrice($product['key']) + $totalOptionPrice);
	}
	
	private function initProductData() {
		$this->data['products'] = array();
		$products = $this->cart->getProducts();
		
		foreach ($products as $product) {
			
			$product_total = 0;
			foreach ($products as $product_2) {
				if ($product_2['product_id'] == $product['product_id']) {
					$product_total += $product_2['quantity'];
				}
			}
			if ($product['minimum'] > $product_total) {
				$this->data['error_warning'] = sprintf(__('error_minimum'), $product['name'], $product['minimum']);
			}
				
			if ($product['image']) {
				$image = $this->model_tool_image->resize($product['image'], $this->config->get('image_cart_width'), $this->config->get('image_cart_height'));
			} else {
				$image = '';
			}
			
			$option_data = $this->getProductionOptionData($product);
			$price = $this->calculateProductPrice($product);
			//$total = $this->currency->format($this->tax->calculate($total_with_coupon, $product['tax_class_id'], $this->config->get('tax')));
			$total = $price * $product['quantity'];
			$price = $this->currency->format($this->tax->calculate($price, $product['tax_class_id'], true));
			$total = $this->currency->format($this->tax->calculate($total, $product['tax_class_id'], true));
			
			$this->data['products'][] = array(
          		'key'      => $product['key'],
          		'thumb'    => $image,
				'name'     => $product['name'],
          		'model'    => $product['model'],
          		'option'   => $option_data,
          		'quantity' => $product['quantity'],
          		'stock'    => $product['stock'],
				'points_to_buy'   =>  __('Reward Points: ') . $product['points_to_buy'],
				'price'    => $price,
				'total'    => $total,
				'href'     => get_permalink($product['product_id']),
			);
		}
	}

	function index() {
		
		$this->updateQuantity();
		if ($this->cart->hasProducts()) {
			
			self::initDataValues();
			self::initProductData();
			// Display prices
			$total_data = $this->calculateTotalData();
			// get total discount for current user role (if exists)
			//$total_discount = $this->getTotalDiscountByUser();

			$this->data['totals'] = $total_data;
			// Modules
			$this->data['modules'] = array();
			$results = impresscart_totals::get_enabled_totals();
			
			if (isset($results)) {
				foreach ($results as $result) {
					$result = (array)$result;
					if ($this->config->get($result['code'] . '_status') && file_exists(DIR_APPLICATION . 'controller/total/' . $result['code'] . '.php')) {
						$this->data['modules'][] = $this->getChild('total/' . $result['code']);
					}
				}
			}

			if (isset($this->session->data['redirect'])) {
				$this->data['continue'] = $this->session->data['redirect'];
				unset($this->session->data['redirect']);
			} else {
				$this->data['continue'] = get_bloginfo('url');
			}

			$this->data['checkout'] = $this->url->link('checkout/checkout', '', 'SSL');
			$sale_order_model = impresscart_framework::model('checkout/order');
			$this->data['reward_points_avaliable'] = $this->customer->getRewardPoints(); 			
		} else {
			$this->autoRender  = false;
			echo __('Your cart is empty');
		}
	}
	
	// Display Prices
	function calculateTotalData() {
		$total_data = array();
		$total = 0;
		$taxes = $this->cart->getTaxes();
		if (($this->config->get('customer_price') && $this->customer->isLogged()) || !$this->config->get('customer_price')) {
			$results = impresscart_totals::get_enabled_totals();
			$sort_order = array();
			foreach ($results as $result) {
				$setting = $this->{'model_total_' . $result['code']}->get_setting();
				if ($setting['status'] == 'yes') {
					$this->{'model_total_' . $result['code']}->getTotal($total_data, $total, $taxes);
				}
				//call_user_func_array('array_multisort', $total_data);
				/*
				$sort_order = array();
				foreach ($total_data as $key => $value) {
					$sort_order[$key] = $value['sort_order'];
				}
				array_multisort($sort_order, SORT_ASC, $total_data);
				*/
			}
		}
		
		return $total_data;
	}

	function initDataValues() {

		$this->data['heading_title'] = __('Your cart');
		$this->data['text_select'] = __('Select');
		$this->data['text_weight'] = __('Weight');
		$this->data['column_remove'] = __('Remove');
		$this->data['column_image'] = __('Image');
		$this->data['column_name'] = __('Name');
		$this->data['column_model'] = __('Model');
		$this->data['column_quantity'] = __('Quantity');
		$this->data['column_price'] = __('Price');
		$this->data['column_total'] = __('Total');
		$this->data['button_update'] = __('Update');
		$this->data['button_shopping'] = __('Shopping');
		$this->data['button_checkout'] = __('Checkout');
		$this->data['button_coupon'] = __('Apply Coupon');
		$this->data['button_voucher'] = __('Apply Voucher');

		$extensions = impresscart_totals::get_all_totals();
		foreach ($extensions as $extension) {
			if($extension['code'] == 'coupontotal') {
				$setting = $this->{'model_total_' . $extension['code']}->get_setting();
				$this->data['coupon_enable'] = ($setting['status'] == 'yes' ? true : false);
			} else if($extension['code'] == 'vouchertotal') {
				$setting = $this->{'model_total_' . $extension['code']}->get_setting();
				$this->data['voucher_enable'] = ($setting['status'] == 'yes' ? true : false);
			}
		}

		if ($this->config->get('customer_price') && !$this->customer->isLogged()) {
			$this->data['attention'] = sprintf(__('text_login'), $this->url->link('account/login'), $this->url->link('account/register'));
		} else {
			$this->data['attention'] = '';
		}


		if (!$this->cart->hasStock() && (!$this->config->get('out_of_stock_checkout') || $this->config->get('show_out_of_stock'))) {
			$this->data['error_warning'] = __('Error Stock');
		} elseif (isset($this->session->data['error'])) {
			$this->data['error_warning'] = $this->session->data['error'];

			unset($this->session->data['error']);
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

		$this->data['action'] = $this->url->link('checkout/cart');

		if ($this->config->get('cart_weight')) {
			$this->data['weight'] = $this->weight->format($this->cart->getWeight(), $this->config->get('weight_class_id'), __('decimal_point'), __('thousand_point'));
		} else {
			$this->data['weight'] = false;
		}

	}

	function updateQuantity() {
		
		// Update
		if (!empty($_POST['quantity'])) {
			foreach ($_POST['quantity'] as $key => $value) {
				$this->cart->update($key, $value);
			}
			unset($this->session->data['shipping_method']);
			unset($this->session->data['shipping_methods']);
			unset($this->session->data['payment_method']);
			unset($this->session->data['payment_methods']);
			unset($this->session->data['reward']);
			$this->redirect($this->url->link('checkout/cart'));
		}
	}
	
	function calculateRewardTotal() {
		$products = $this->cart->getProducts();
		$reward_total = 0 ;
		if( @$this->session->data['reward'] ){
			foreach( $products as $product ) {
				$reward_total += $product['quantity'] * $product['points_to_buy']; 
				//if( $product['product_id'] == $coupon['product_id'] ){
					//$coupon_total += $coupon['coupon_discount'] * $product['quantity'];
				//}
			}
			
		}
		return $reward_total;
	}
	
	
	//ajax call
	function show()	{

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
					
				$setting = $this->{'model_total_' . $result['code']}->get_setting();
					
				if ($setting['status'] == 'yes') {

					$this->{'model_total_' . $result['code']}->getTotal($total_data, $total, $taxes);
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
		$total = $currency->format($total);
		$vouchers = @$_SESSION['vouchers'] ? count( $_SESSION['vouchers'] ) : 0;
		if($count_products==0){
			$this->data['text_items'] =  sprintf("Cart is Empty");
		}else{
			$this->data['text_items'] =  sprintf( '%s ' . __('item(s)') . ' %s' , $count_products + $vouchers, $total);
		}
	}


	/**
	 *
	 * @return unknown_type
	 */
	private function updateNotAjax() {
		//This function run when update quantity but is not ajax. Ex : url : shop-cart-2 update quantity
		//die('cart.controller.php :: Run to function updateNotAjax()');
		//Goscom::debug($this, 'Run to function updateNotAjax()', true);

		if (isset($_POST['quantity'])) {
			if (!is_array($_POST['quantity'])) {
				if (isset($_POST['option'])) {
					$option = $_POST['option'];
				} else {
					$option = array();
				}
				$this->cart->add($_POST['product_id'], $_POST['quantity'], $option);
			} else {
				foreach ($_POST['quantity'] as $key => $value) {
					$this->cart->update($key, $value);
				}
			}
		} // End isset($_POST['quantity']

		if (isset($_POST['remove'])) {
			foreach ($_POST['remove'] as $key) {
				$this->cart->remove($key);
				$this->cart->removeCouponsByProduct($key);
			}
		}
		if (isset($_POST['voucher']) && $_POST['voucher']) {
			foreach ($_POST['voucher'] as $key) {
				if (isset($this->session->data['vouchers'][$key])) {
					unset($this->session->data['vouchers'][$key]);
				}
			}
		}

		if (isset($_POST['redirect'])) $this->session->data['redirect'] = $_POST['redirect'];

		if (isset($_POST['quantity']) || isset($_POST['remove']) || isset($_POST['voucher'])) {
			unset($this->session->data['shipping_methods']);
			unset($this->session->data['shipping_method']);
			unset($this->session->data['payment_methods']);
			unset($this->session->data['payment_method']);
			//unset($this->session->data['reward']);
			$this->redirect($this->url->link('checkout/cart'));
			return false;
		}
		return true;
	}

	private function addNewProductToCart(&$json, &$cart, &$session, $url) {

		$product_model = impresscart_framework::model('catalog/product');
		if (isset($_POST['product_id']) ) {
			$product_id = $_POST['product_id'];
			$product_info = $product_model->getProduct($product_id);
			if($product_info) {
				if(isset($_POST['quantity'])) {
					$quantity = abs($_POST['quantity']);
				} else {
					$quantity = 1;
				}
				$product_total = 0;
				$products = $cart->getProducts();
				foreach ($products as $product_2) {
					if ($product_2['product_id'] == $product_id) {
						$product_total += $product_2['quantity'];
					}
				}
				if ($product_info->minimum > ($product_total + $quantity)) {
					$json['error']['warning'] = sprintf( __('Minimum order amount for %s is %s!'), $product_info->name, $product_info->minimum);
				}
				if (isset($_POST['buyoptions'])) {
					$option = array_filter($_POST['buyoptions']);
				} else {
					$option = array();
				}
				$product_options = $product_model->getProductOptions($product_id);
				foreach ($product_options as $product_option) {
					if ($product_option['required'] && empty($option[$product_option['option_id']]))  {
						$json['error'][$product_option['option_id']] = sprintf(__('%s required!'), $product_option['name']);
					}
				}
			}
			if (!isset($json['error'])) {
				$cart->add($product_id, $quantity, $option);
				$json['success'] = sprintf('Success: You have added <a href="%s">%s</a> to your <a href="%s">shopping cart</a>!', $url->link('product/product', 'product_id=' . $product_id), $product_info->name, $url->link('checkout/cart'));
				unset($session->data['shipping_methods']); unset($session->data['shipping_method']);
				unset($session->data['payment_methods']); unset($session->data['payment_method']);
			} else {
				$json['redirect'] = str_replace('&amp;', '&', get_permalink($product_id));
			}
		}
	}
	
	private function unsetSession($cart, $session) {
		if (isset($_POST['remove'])) {
			$cart->remove($_POST['remove']);
			unset($session->data['shipping_methods']);
			unset($session->data['shipping_method']);
			unset($session->data['payment_methods']);
			unset($session->data['payment_method']);
		}
		
		if (isset($_POST['voucher'])) {
			if ($session->data['vouchers'][$_POST['voucher']]) {
				unset($session->data['vouchers'][$_POST['voucher']]);
			}
		}
	}

	public function update() {
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			if(!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) { // If not ajax
				if(!$this->updateNotAjax()) return;
			} // End $_SERVER['HTTP_X_REQUESTED_WITH']
		}
		$json = array();
		$cart = impresscart_framework::service('cart');
		$session = impresscart_framework::service('session');
		$customer = impresscart_framework::service('customer');
		$config = impresscart_framework::service('config');
		$currency = impresscart_framework::service('currency');
		$url = impresscart_framework::service('url');
		$tax = impresscart_framework::service('tax');
		$tool_image = impresscart_framework::model('tool/image');

		self::addNewProductToCart($json, $cart, $session, $url);
		self::unsetSession($cart, $session);

		$this->data['text_empty'] = __('Your shopping cart is empty!');
		$this->data['button_checkout'] = __('Checkout');
		$this->data['button_remove'] = __('Remove');
		$this->data['products'] = array();

		foreach ($cart->getProducts() as $result) {
			if ($result['image']) {
				$image = $tool_image->resize($result['image'], 40, 40);
			} else {
				$image = '';
			}

			$option_data = array();
			foreach ($result['option'] as $option) {
				if ($option['type'] != 'file') {
					if(is_array($option['option_value']))
					{
						$str = "";
						foreach( $option['option_value'] as $value)
						{
							$str .= $value . ",";
						}
						$str = substr($str, 0, -1);
						$option_data[] = array(
							'name'  => $option['name'],
							'value' => (strlen($str) > 20 ? substr($str, 0, 20) . '..' : $str)
						);

					} else {
						$option_data[] = array(
							'name'  => $option['name'],
							'value' => (strlen($option['option_value']) > 20 ? substr($option['option_value'], 0, 20) . '..' : $option['option_value'])
						);
					}
				} else {

					$encryption = impresscart_framework::service('encryption');
					$encryption = new Encryption($config->get('encryption'));

					$file = substr($encryption->decrypt($option['option_value']), 0, strrpos($encryption->decrypt($option['option_value']), '.'));

					$option_data[] = array(
						'name'  => $option['name'],
						'value' => (strlen($file) > 20 ? substr($file, 0, 20) . '..' : $file)
					);
				}
			}

			if (($config->get('customer_price') && $customer->isLogged()) || !$config->get('customer_price')) {
				$price = $currency->format($tax->calculate($result['price'], $result['tax_class_id'], $config->get('tax')));
			} else {
				$price = false;
			}

			if (($config->get('customer_price') && $customer->isLogged()) || !$config->get('customer_price')) {
				$total = $currency->format($tax->calculate($result['total'], $result['tax_class_id'], $config->get('tax')));
			} else {
				$total = false;
			}

			$this->data['products'][] = array(
				'key'        => $result['key'],
				'product_id' => $result['product_id'],
				'thumb'      => $image,
				'name'       => $result['name'],
				'model'      => $result['model'],
				'option'     => $option_data,
				'quantity'   => $result['quantity'],
				'stock'      => $result['stock'],
				'price'      => $price,
				'total'      => $total,
				'href'       => $url->link('product/product', 'product_id=' . $result['product_id'])
			);
		}

		// Gift Voucher
		$this->data['vouchers'] = array();
		if (isset($session->data['vouchers']) && $session->data['vouchers']) {
			foreach ($session->data['vouchers'] as $key => $voucher) {
				$this->data['vouchers'][] = array(
					'key'         => $key,
					'description' => $voucher['description'],
					'amount'      => $currency->format($voucher['amount'])
				);
			}
		}
		$total_data = array();
		$total = 0;
		$taxes = $cart->getTaxes();
		if (($config->get('customer_price') && $customer->isLogged()) || !$config->get('customer_price')) {
			$results = impresscart_totals::get_enabled_totals();
			foreach ($results as $result) {
				$setting = $this->{'model_total_' . $result['code']}->get_setting();
				if ($setting['status'] == 'yes') {
					$this->{'model_total_' . $result['code']}->getTotal($total_data, $total, $taxes);
				}
				$sort_order = array();
				foreach ($total_data as $key => $value) {
					$sort_order[$key] = $value['sort_order'];
				}
				array_multisort($sort_order, SORT_ASC, $total_data);
			}
		}

		$json['total'] = sprintf(__('%s item(s) - %s'), $cart->countProducts() + (isset($session->data['vouchers']) ? count($session->data['vouchers']) : 0), $currency->format($total));
		$this->data['totals'] = $total_data;
		$this->data['checkout'] = $url->link('checkout/checkout', '', 'SSL');

		$this->autoRender = false;
		$json['output'] = $this->render();
		echo json_encode($json);
		exit(0);
	}


	// return discount by coupon
	function _applyCouponForProduct( $coupon_post_id, $coupon_data, $product_in_cart ) {
		$result = array();
		// if coupon has not started or has expired, do not apply coupon
		$todays_date = date("Y-m-d");
		$today = strtotime($todays_date);
		$expiration_date = strtotime($coupon_data['date_end']);
		$start_date = strtotime($coupon_data['date_start']);
		if( $expiration_date < $today || $start_date > $today ) {
			$result['is_applied'] = false;
			$result['error'] = 'Coupon has either not started or expired.';
			return $result;
		}

		// does coupon require user to login and is user logged in
		if( $coupon_data['logged'] == 1 && !is_user_logged_in() ){
			$result['is_applied'] = false;
			$result['error'] = 'User must log in to use this coupon';
			return $result;
		}

		// is product passed coupon's price floor
		if( $product_in_cart['price'] < $coupon_data['total'] ){
			$result['is_applied'] = false;
			$result['error'] = 'Product does not pass this coupon\'s price floor';
			return $result;
		}

		// did user use all coupon personal amount limit (how many times coupon was used by this user)
		global $user_ID;
		if( is_user_logged_in() ){ // if logged in user, save coupon used times in user metadata
			if( !get_user_meta( $user_ID, 'coupon_used_times' ) ){ //create new if not exists
				update_user_meta( $user_ID, 'coupon_used_times', 0 );
			} else {
				$coupon_used_times = get_user_meta( $user_ID, 'coupon_used_times' );
				if( $coupon_used_times[0] > $coupon_data['uses_customer'] && $coupon_data['uses_customer'] != '' ) {
					$result['is_applied'] = false;
					$result['error'] = 'User already used all of this coupon\'s available amount';
					return $result;
				}
			}
		} else { // if guest user, save coupon used times in user session
			if( !$this->session->data['user_coupon_used_times'] ){ //create new if not exists
				$this->session->data['user_coupon_used_times'] = 0;
			} elseif( $this->session->data['user_coupon_used_times'] > $coupon_data['uses_customer']
			&& $coupon_data['uses_customer'] != '' ) {
				$result['is_applied'] = false;
				$result['error'] = 'User already used all of this coupon\'s available amount';
				return $result;
			}
		}
		// did coupon reach its amount limit  (how many times coupon was used by any user)
		if( !get_post_meta($coupon_post_id, 'coupon_used_times') ){
			update_post_meta($coupon_post_id, 'coupon_used_times', 0);
		} else {
			$coupon_used_times = get_post_meta($coupon_post_id, 'coupon_used_times');
			if( $coupon_used_times[0] > $coupon_data['uses_total'] && $coupon_data['uses_total'] != '' ) {
				$result['is_applied'] = false;
				$result['error'] = 'The available amount for this coupon has already used all.';
				return $result;
			}
		}

		// update used time counter
		if( is_user_logged_in() ){
			$user_used_times = get_user_meta( $user_ID, 'coupon_used_times');
			update_user_meta( $user_ID, 'coupon_used_times', $user_used_times[0] +1 );
		} else {
			$user_used_times = $this->session->data['user_coupon_used_times'];
			$this->session->data['user_coupon_used_times'] = $user_used_times +1;
		}
		$coupon_used_times = get_post_meta($coupon_post_id, 'coupon_used_times');
		update_post_meta($coupon_post_id, 'coupon_used_times', $coupon_used_times[0] + 1);

		// if coupon type is percentage
		if( $coupon_data['type'] == 'P' ){
			// calculate discount by coupon
			$discount = $product_in_cart['price']*$coupon_data['discount']/100;
			$result['is_applied'] = true;
			$result['coupon_discount'] = $discount;
			return $result;
		} elseif( $coupon_data['type'] == 'F' ){  // if coupon type is fixed amount
			$discount = $coupon_data['discount'];
			$result['is_applied'] = true;
			$result['coupon_discount'] = $discount;
			return $result;
		}

		$result['is_applied'] = false;
		$result['error'] = 'Unknown error.';
		return $result;
	}
	
	function validateCoupon() {
		
		$coupon_code = $_POST['coupon_code'];
		
		$coupon_model = impresscart_framework::model('checkout/coupon');
		
		$coupon_info = $coupon_model->getCoupon($coupon_code);
		
		return ($coupon_info ? true : false); 
			
	}

	public function applycoupon() {

		$json = array();

		if(isset($_POST['coupon_code']) ){
			$products_in_cart = $this->cart->getProducts();
			// return fail if no product in cart
			if( count($products_in_cart) == 0 ){
				$json['fail'] = 'Cart Empty';
				echo json_encode($json);
				exit(0);
			}
				
			$coupon_model = impresscart_framework::model('sale/coupon');
				
			$coupon_posts = $coupon_model->getAllCouponPosts();

			// return fail if there is no coupon in the database
			if( count($coupon_posts) == 0 ){
				$json['fail'] = 'No coupon';
				echo json_encode($json);
				exit(0);
			}
			// check validation of input coupon code
			$coupon_fails = array();
			$coupon_match = false;
			$is_in_categry = false;
			$is_for_whole_category = false;
			foreach( $coupon_posts as $coupon_post ) {
				//      $firephp->log($coupon_post->post_id, 'coupon post id');
				$coupon_code = get_post_meta($coupon_post->post_id, 'coupon_code',true);

				// if coupon code is in the coupon lists
				if( $coupon_code == $_POST['coupon_code'] ) {
					$coupon_match = true;

					// get meta value of coupon
					$coupon_data = get_post_meta($coupon_post->post_id, 'data',true);
						
						
					// $firephp->log($coupon_data, 'coupon data');
					// foreach product in cart, check if the product belongs to any coupon categories
					// using bubble sort(search), do not expect there are so many items in cart
					foreach( $products_in_cart as $product_in_cart ){

						// if coupon belongs to any categories
						if( count($coupon_data['category']) > 0 ) {

							// foreach coupon category, check if the product belongs to that category
							$belong_check = in_array($product_in_cart['product_id'], $coupon_data['coupon_product']);
							if( $belong_check ) {
								$coupon_discount = $this->_applyCouponForProduct( $coupon_post->post_id,  $coupon_data, $product_in_cart );
								if( $coupon_discount['is_applied'] == false ){
									$coupon_fails = $coupon_discount;
								} else { // if successfully applied, add coupon to cart
									$this->cart->addCouponToCart($product_in_cart['product_id'], $coupon_code, $coupon_discount);
									$is_for_whole_category = true;
									$json['success'] = 'Coupon Applied';
								}
							}
								
						} else { // if not, the coupon is not available
							$json['fail'] = 'coupon applied to no category.';
							echo json_encode($json);
							exit(0);
						}
					}
				}
			}

			if( !$is_in_categry && !$is_for_whole_category ){
				$json['fail'] = __('None of the product is the specific product in coupon category.');
			}

			if( !$coupon_match ){
				$json['fail'] = __('Coupon not matched!');
			}
		}

		if( count($coupon_fails) > 0 ){
			foreach( $coupon_fails as $key => $coupon_fail ) {
				$json['fail'] = $coupon_fail;
			}
		}
		echo json_encode($json);
		exit(0);
	}
	
	function validateVoucher() {
		
		$voucher_code = $_POST['voucher_code'];
		
		$voucher_model = impresscart_framework::model('checkout/voucher');
		
		$voucher_info = $voucher_model->getVoucher($voucher_code);
		
		return ($voucher_info ? true : false); 
			
	}

	
	public function applyvoucher() {

		$json = array();
		if(isset($_POST['voucher_code']) && $this->validateVoucher()) {
			$products_in_cart = $this->cart->getProducts();
			//return fail if no product in cart
			if( count($products_in_cart) == 0 ){
				$json['fail'] = 'Cart Empty';
				echo json_encode($json);
				exit(0);
			}
			$voucher_model = impresscart_framework::model('sale/voucher');
			$voucher_posts = $voucher_model->getAllVoucherPosts();
			//return fail if there is no voucher in the database
			if( count($voucher_posts) == 0 ){
				$json['fail'] = 'No voucher in database.';
				echo json_encode($json);
				exit(0);
			}
			// check validation of input voucher code
			$voucher_match = false;
			foreach( $voucher_posts as $voucher_post ) {
				$voucher_code = get_post_meta($voucher_post->post_id, 'voucher_code',true);
				$voucher_data = get_post_meta($voucher_post->post_id, 'data',true);
				//if voucher code is in the voucher lists, apply voucher for cart
				if( $voucher_code == $_POST['voucher_code'] ) {
					$voucher_match = true;
					$json['success'] = 'Voucher Applied';
					$this->cart->addVoucherToCart($voucher_code, $voucher_data['amount']);
				}
			}
			if( !$voucher_match ){
				$json['fail'] = 'Voucher not matched!';
			}
		} else {
			$json['fail'] = 'Voucher not matched!';
		}


		echo json_encode($json);
		exit(0);
	}
	
	public function applyrewardpoints() {
		$json = array();
		$this->autoRender  = false;
		$points_avaiable = $this->customer->getRewardPoints();   //points avaiable
		$json = array();
		if(isset($_POST['reward_points'])) {
			$value = floatval($_POST['reward_points']);
			if($value > $points_avaiable) {
				$json['fail'] = 'Reward points must be smaller than points avaiable and total reward points buying products in cart!';
			} else {
				$this->cart->addRewardToCart($value);
				$json['success'] = 'Reward Applied';
			}	
			
		}

		echo json_encode($json);
		exit(0);
	}
	
}