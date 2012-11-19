<?php
class impresscart_checkout_login_controller extends impresscart_framework_controller {

	public function index() {

		$this->autoRender = false;

		$json = array();

		if ((!$this->cart->hasProducts() 
			&& (!isset($this->session->data['vouchers']) 
			|| !$this->session->data['vouchers']))
			|| (!$this->cart->hasStock() && !$this->config->get('config_stock_checkout'))) {
			$json['redirect'] = $this->url->link('checkout/cart');
		}
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			if(!current_user_can('administrator')) {
				if (isset($_POST['account'])) {
					$this->session->data['account'] = $_POST['account'];
				}
				if (isset($_POST['email']) && isset($_POST['password'])) {
					//Remove action 		
					remove_action('wp_login', 'impresscart_login');
					if($this->customer->login($_POST['email'], $_POST['password'])) {
						unset($this->session->data['guest']);
						// Calculate Totals
						$total_data = array();
						$total = 0;
						$taxes = $this->cart->getTaxes();
						if (($this->config->get('customer_price') && $this->customer->isLogged()) || !$this->config->get('customer_price')) {
							$results = impresscart_framework::model('extension')->getExtensions('total');
							$exts = array();
							if(is_array($results) && count($results)) {
								foreach ($results as $result) {
										
									$ext = new impresscart_extension($result->ID);
									@$sort_order[$result->post_title] = $ext->get_meta('sort_order');
										
									if($ext->get_meta('status') != 0) {
										$exts[$ext->get_meta('sort_order')] = $ext;
									}
								}
							}
								
							ksort($exts);
							foreach ($exts as $ext){
								$ext->getTotal($total_data, $total, $taxes);
							}
								
							$sort_order = array();
								
							if(is_array($total_data)) {
								foreach ($total_data as $key => $value) {
									$sort_order[$key] = $value['sort_order'];
								}
							}
							array_multisort($sort_order, SORT_ASC, $total_data);
						}
						
						$json['logged'] = sprintf(__('text_logged'), $this->url->link('account/account', '', 'SSL'), $this->customer->getFirstName(), $this->url->link('account/logout', '', 'SSL'));
						$json['total'] = sprintf(__('text_items'), $this->cart->countProducts() + (isset($this->session->data['vouchers']) ? count($this->session->data['vouchers']) : 0), $this->currency->format($total));
						
					} else {
						$json['error']['type'] = 0;
						$json['error']['warning'] = __('Wrong username or password');
					}
				}
			} else {
				$json['error']['type'] = 1;
				$json['error']['warning'] = __('You are loggin with administrator, please logout first, then login with normal user to checkout your cart. ');		
			}
			
			echo json_encode($json);
			exit(0);	
		} else {
			$this->data['text_new_customer'] = __('New Customer');
			$this->data['text_returning_customer'] = __('Return Customer');
			$this->data['text_checkout'] = __('Checkout');
			$this->data['text_register'] = __('Register');
			$this->data['text_guest'] = __('Guest');
			$this->data['text_i_am_returning_customer'] = __('I am returning customer');
			$this->data['text_register_account'] = __('Register new account');
			$this->data['text_forgotten'] = __('Forgotten password');

			$this->data['entry_email'] = __('Email');
			$this->data['entry_password'] = __('Password');
				
			$this->data['button_continue'] = __('Continue');
			$this->data['button_login'] = __('Login');
				
			$this->data['guest_checkout'] = ($this->config->get('guest_checkout') && !$this->config->get('config_customer_price') && !$this->cart->hasDownload());
				
			if (isset($this->session->data['account'])) {
				$this->data['account'] = $this->session->data['account'];
			} else {
				$this->data['account'] = 'register';
			}
				
			$this->data['forgotten'] = $this->url->link('account/forgotten', '', 'SSL');

			//echo $this->render();
			
			$json['output'] = $this->render();
			echo json_encode($json);
			exit(0);
		}
		
	}
}
?>