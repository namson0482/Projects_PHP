<?php

class impresscart_checkout_register_controller extends impresscart_framework_controller {

	public function index() {

		$this->autoRender = false;

		$model_customer = impresscart_framework::model('account/customer');

		$json = array();
		if ($this->customer->isLogged()) {
			$json['redirect'] = $this->url->link('checkout/checkout', '', 'SSL');
			echo json_encode($json);
			exit(0);
		} else {
			if(is_user_logged_in() && current_user_can('administrator')) {
				$json['error']['warning'] = __('You are loggin with administrator, please logout first, then login with normal user to checkout your cart. ');
				echo json_encode($json);
				exit(0);	
			}
		}

		if ((!$this->cart->hasProducts() && 
					(!isset($this->session->data['vouchers']) 
					|| !$this->session->data['vouchers'])) 
					|| (!$this->cart->hasStock() && !$this->config->get('stock_checkout'))) {
			$json['redirect'] = $this->url->link('checkout/cart');
		}
			
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {

			if (!$json) {

				if ((utf8_strlen($_POST['firstname']) < 1) || (utf8_strlen($_POST['firstname']) > 32)) {
					$json['error']['firstname'] = __('Please enter your first name');
				}

				if ((utf8_strlen($_POST['lastname']) < 1) || (utf8_strlen($_POST['lastname']) > 32)) {
					$json['error']['lastname'] = __('Please enter your last name');
				}

				if ((utf8_strlen($_POST['email']) > 96) || !preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $_POST['email'])) {
					$json['error']['email'] = __('Please enter your email');
				}

				if ($model_customer->getTotalCustomersByEmail($_POST['email'])) {
					$json['error']['warning'] = __('email exit please choose orther email');
				}

				if ((utf8_strlen($_POST['telephone']) < 3) || (utf8_strlen($_POST['telephone']) > 32)) {
					$json['error']['telephone'] = __('please telephone must number');
				}

				if ((utf8_strlen($_POST['address_1']) < 3) || (utf8_strlen($_POST['address_1']) > 128)) {
					$json['error']['address_1'] = __('please enter your address');
				}

				if ((utf8_strlen($_POST['city']) < 2) || (utf8_strlen($_POST['city']) > 128)) {
					$json['error']['city'] = __('Please enter your city');
				}

				$country_model = impresscart_framework::model('localisation/country');

				$country_info = (array)$country_model->getCountry($_POST['country_id']);

				if ($country_info && $country_info['postcode_required'] && (utf8_strlen($_POST['postcode']) < 2) || (utf8_strlen($_POST['postcode']) > 10)) {
					$json['error']['postcode'] = __('Please enter your postcode');
				}

				if ($_POST['country_id'] == '') {
					$json['error']['country'] = __('Please enter your country');
				}

				if ($_POST['zone_id'] == '') {
					$json['error']['zone'] = __('Please enter your zone');
				}

				if ((utf8_strlen($_POST['password']) < 4) || (utf8_strlen($_POST['password']) > 20)) {
					$json['error']['password'] = __('password is error');
				}

				if ($_POST['confirm'] != $_POST['password']) {
					$json['error']['confirm'] = __('password confirm is not match');
				}

				if ($this->config->get('account_id')) {
					$information_info = $this->model_catalog_information->getInformation($this->config->get('account_id'));
						
					if ($information_info && !isset($_POST['agree'])) {
						$json['error']['warning'] = sprintf(__('error_agree'), $information_info['title']);
					}
				}
			}
				
			if (!$json) {
				$model_customer->addCustomer($_POST);
				if (!$this->config->get('customer_approval')) {
					$this->customer->login($_POST['email'], $_POST['password']);
				} else {
					$json['redirect'] = $this->url->link('account/success');
				}
				unset($this->session->data['guest']);
				unset($this->session->data['shipping_methods']);
				unset($this->session->data['shipping_method']);
				unset($this->session->data['payment_methods']);
				unset($this->session->data['payment_method']);
			}
				



		} else {

			$this->data['text_select'] = __('Select');
			$this->data['text_your_details'] = __('Your details');
			$this->data['text_your_address'] = __('Your address');
			$this->data['text_your_password'] = __('Your password');

			$this->data['entry_firstname'] = __('First name');
			$this->data['entry_lastname'] = __('Last name');
			$this->data['entry_email'] = __('Email');
			$this->data['entry_telephone'] = __('Telephone');
			$this->data['entry_fax'] = __('Fax');
			$this->data['entry_company'] = __('Company');
			$this->data['entry_address_1'] = __('Address 1');
			$this->data['entry_address_2'] = __('Address 2');
			$this->data['entry_postcode'] = __('Postcode');
			$this->data['entry_city'] = __('City');
			$this->data['entry_country'] = __('Country');
			$this->data['entry_zone'] = __('Zone');
			$this->data['entry_newsletter'] = sprintf(__('Newsletter'), $this->config->get('name'));
			$this->data['entry_password'] = __('Password');
			$this->data['entry_confirm'] = __('Confirm');
			$this->data['entry_shipping'] = __('Shipping');

			$this->data['button_continue'] = __('Continue');

			$this->data['country_id'] = $this->config->get('country');

			$country_model = impresscart_framework::model('localisation/country');

			$this->data['countries'] = $country_model->getCountries();

			if ($this->config->get('account_id')) {
				$this->load->model('catalog/information');

				$information_info = $this->model_catalog_information->getInformation($this->config->get('account_id'));

				if ($information_info) {
					$this->data['text_agree'] = sprintf(__('I have read and agree to the <a class="colorbox" href="%s" alt="%s"><b>%s</b></a>'), $this->url->link('information/information/info', 'information_id=' . $this->config->get('account_id'), 'SSL'), $information_info['title'], $information_info['title']);
				} else {
					$this->data['text_agree'] = '';
				}
			} else {
				$this->data['text_agree'] = '';
			}

			$this->data['shipping_required'] = $this->cart->hasShipping();

			$json['output'] = $this->render();
		}
		//$this->response->setOutput(json_encode($json));
		echo json_encode($json);
		exit(0);
	}

}
?>