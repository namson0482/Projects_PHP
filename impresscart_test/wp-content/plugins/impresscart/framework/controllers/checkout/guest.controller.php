<?php 
class impresscart_checkout_guest_controller extends impresscart_framework_controller {
	
  	public function index() {
  		
  		$this->autoRender = false;
  		
  		$json = array();
  		
		if ($this->customer->isLogged()) {
			$json['redirect'] = $this->url->link('checkout/checkout', '', 'SSL');			
		}
		
		if ((!$this->cart->hasProducts() && (!isset($this->session->data['vouchers']) || !$this->session->data['vouchers'])) || (!$this->cart->hasStock() && !$this->config->get('stock_checkout'))) {
			$json['redirect'] = $this->url->link('checkout/cart');				
		}
		
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			
			$this->data['text_select'] = __('Select');
			$this->data['text_your_details'] = __('Your Personal Details');
			$this->data['text_your_address'] = __('Your Address');
			$this->data['entry_firstname'] = __('First Name:');
			$this->data['entry_lastname'] = __('Last Name:');
			$this->data['entry_email'] = __('Email:');
			$this->data['entry_telephone'] = __('Telephone:');
			$this->data['entry_fax'] = __('Fax:');
			$this->data['entry_company'] = __('Company:');
			$this->data['entry_address_1'] = __('Address 1:');
			$this->data['entry_address_2'] = __('Address 2:');
			$this->data['entry_postcode'] = __('Post Code:');
			$this->data['entry_city'] = __('City:');
			$this->data['entry_country'] = __('Country:');
			$this->data['entry_zone'] = __('Zone:');
			$this->data['entry_shipping'] = __('My delivery and billing addresses are the same.');
			$this->data['button_continue'] = __('Continue');
			$this->data['country_id'] = $this->config->get('country');
			$country_model = impresscart_framework::model('localisation/country');
			$this->data['countries'] = $country_model->getCountries();
			
			$this->data['shipping_required'] = $this->cart->hasShipping();
			if (isset($this->session->data['guest']['shipping_address'])) {
				$this->data['shipping_address'] = $this->session->data['guest']['shipping_address'];			
			} else {
				$this->data['shipping_address'] = true;
			}	
			
	        $json['output'] = $this->render();
		}
		echo json_encode($json);
        exit(0);
  		

  	}
	
	public function validatePaymentAddress() {
		
		$this->autoRender = false;
		
		$json = array();
		
		if ($this->customer->isLogged()) {
			$json['redirect'] = $this->url->link('checkout/checkout', '', 'SSL');
			
		} 			
		
		
		if((!$this->cart->hasProducts() && empty($this->session->data['vouchers'])) || (!$this->cart->hasStock())) {
			$json['redirect'] = $this->url->link('checkout/cart');		
		}

		/*
		if (!$this->config->get('config_guest_checkout') || $this->cart->hasDownload()) {
			$json['redirect'] = $this->url->link('checkout/checkout', '', 'SSL');
		} 
		*/
		if ($this->cart->hasDownload()) {
			$json['redirect'] = $this->url->link('checkout/checkout', '', 'SSL');
		}
					
		if (!$json) {
			
			if ((utf8_strlen($_POST['firstname']) < 1) || (utf8_strlen($_POST['firstname']) > 32)) {
				$json['error']['firstname'] = __('First Name must be between 1 and 32 characters!');
			}

			if ((utf8_strlen($_POST['lastname']) < 1) || (utf8_strlen($_POST['lastname']) > 32)) {
				$json['error']['lastname'] = __('Last Name must be between 1 and 32 characters!');
			}
			
			if ((utf8_strlen($_POST['email']) > 96) || !preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $_POST['email'])) {
				$json['error']['email'] = __('E-Mail Address does not appear to be valid!');
			}
			
			if ((utf8_strlen($_POST['telephone']) < 3) || (utf8_strlen($_POST['telephone']) > 32)) {
				$json['error']['telephone'] = __('Telephone must be between 3 and 32 characters!');
			}

			if ((utf8_strlen($_POST['address_1']) < 3) || (utf8_strlen($_POST['address_1']) > 64)) {
				$json['error']['address_1'] = __('Address 1 must be between 3 and 128 characters!');
			}

			if ((utf8_strlen($_POST['city']) < 2) || (utf8_strlen($_POST['city']) > 32)) {
				$json['error']['city'] = __('City must be between 2 and 128 characters!');
			}

			$model_country = impresscart_framework::model('localisation/country');
			$country_info = $model_country->getCountry($_POST['country_id']);
			
			if ( utf8_strlen($_POST['postcode']) < 2 || utf8_strlen($_POST['postcode']) > 10 ) {
				$json['error']['postcode'] = __('Postcode must be between 2 and 10 characters!');
			}
			
			if ($_POST['country_id'] == '') {
				$json['error']['country'] = __('Please select a country');
			}

			if ($_POST['zone_id'] == '') {
				$json['error']['zone'] = __('Please select a zone');
			}
		
		}
			
		if (!$json) {
			
			$this->session->data['guest']['firstname'] = $_POST['firstname'];
			$this->session->data['guest']['lastname'] = $_POST['lastname'];
			$this->session->data['guest']['email'] = $_POST['email'];
			$this->session->data['guest']['telephone'] = $_POST['telephone'];
			$this->session->data['guest']['fax'] = $_POST['fax'];
			
			$this->session->data['guest']['payment']['firstname'] = $_POST['firstname'];
			$this->session->data['guest']['payment']['lastname'] = $_POST['lastname'];				
			$this->session->data['guest']['payment']['company'] = $_POST['company'];
			$this->session->data['guest']['payment']['address_1'] = $_POST['address_1'];
			$this->session->data['guest']['payment']['address_2'] = $_POST['address_2'];
			$this->session->data['guest']['payment']['postcode'] = $_POST['postcode'];
			$this->session->data['guest']['payment']['city'] = $_POST['city'];
			$this->session->data['guest']['payment']['country_id'] = $_POST['country_id'];
			$this->session->data['guest']['payment']['zone_id'] = $_POST['zone_id'];
							
			$model_country = impresscart_framework::model('localisation/country');
			$country_info = $model_country->getCountry($_POST['country_id']);
			
			if ($country_info) {
				$this->session->data['guest']['payment']['country'] = $country_info->name;	
				$this->session->data['guest']['payment']['iso_code_2'] = $country_info->iso_code_2;
				$this->session->data['guest']['payment']['iso_code_3'] = $country_info->iso_code_3;
				$this->session->data['guest']['payment']['address_format'] = $country_info->address_format;
			} else {
				$this->session->data['guest']['payment']['country'] = '';	
				$this->session->data['guest']['payment']['iso_code_2'] = '';
				$this->session->data['guest']['payment']['iso_code_3'] = '';
				$this->session->data['guest']['payment']['address_format'] = '';
			}
						
			$model_zone = impresscart_framework::model('localisation/zone');
			$zone_info = $model_zone->getZone($_POST['zone_id']);
			
			if ($zone_info) {
				$this->session->data['guest']['payment']['zone'] = $zone_info->name;
				$this->session->data['guest']['payment']['zone_code'] = $zone_info->code;
			} else {
				$this->session->data['guest']['payment']['zone'] = '';
				$this->session->data['guest']['payment']['zone_code'] = '';
			}
			
			if (!empty($_POST['shipping_address'])) {
				$this->session->data['guest']['shipping_address'] = true;
			} else {
				$this->session->data['guest']['shipping_address'] = false;
			}
			
			if ($this->session->data['guest']['shipping_address']) {
				$this->session->data['guest']['shipping']['firstname'] = $_POST['firstname'];
				$this->session->data['guest']['shipping']['lastname'] = $_POST['lastname'];
				$this->session->data['guest']['shipping']['company'] = $_POST['company'];
				$this->session->data['guest']['shipping']['address_1'] = $_POST['address_1'];
				$this->session->data['guest']['shipping']['address_2'] = $_POST['address_2'];
				$this->session->data['guest']['shipping']['postcode'] = $_POST['postcode'];
				$this->session->data['guest']['shipping']['city'] = $_POST['city'];
				$this->session->data['guest']['shipping']['country_id'] = $_POST['country_id'];
				$this->session->data['guest']['shipping']['zone_id'] = $_POST['zone_id'];
				
				if ($country_info) {
					$this->session->data['guest']['shipping']['country'] = $country_info->name;	
					$this->session->data['guest']['shipping']['iso_code_2'] = $country_info->iso_code_2;
					$this->session->data['guest']['shipping']['iso_code_3'] = $country_info->iso_code_3;
					$this->session->data['guest']['shipping']['address_format'] = $country_info->address_format;
				} else {
					$this->session->data['guest']['shipping']['country'] = '';	
					$this->session->data['guest']['shipping']['iso_code_2'] = '';
					$this->session->data['guest']['shipping']['iso_code_3'] = '';
					$this->session->data['guest']['shipping']['address_format'] = '';
				}
	
				if ($zone_info) {
					$this->session->data['guest']['shipping']['zone'] = $zone_info->name;
					$this->session->data['guest']['shipping']['zone_code'] = $zone_info->code;
				} else {
					$this->session->data['guest']['shipping']['zone'] = '';
					$this->session->data['guest']['shipping']['zone_code'] = '';
				}
			}
			
			$this->session->data['account'] = 'guest';
			
			unset($this->session->data['shipping_method']);
			unset($this->session->data['shipping_methods']);
			unset($this->session->data['payment_method']);
			unset($this->session->data['payment_methods']);
		}
		
		echo json_encode($json);
		exit(0);
					
	}

}
?>