<?php
class impresscart_checkout_address_controller extends impresscart_framework_controller {


	public function payment() {

		$this->autoRender = false;

		$address_model = impresscart_framework::model('account/address');

		$json = array();
		
		if (!$this->customer->isLogged()) {
			$json['redirect'] = $this->url->link('checkout/checkout', '', 'SSL');
		}

		if ((!$this->cart->hasProducts() && (!isset($this->session->data['vouchers']) || !$this->session->data['vouchers'])) || (!$this->cart->hasStock() && !$this->config->get('config_stock_checkout'))) {
			$json['redirect'] = $this->url->link('checkout/cart');
		}

		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			
			$this->data['text_address_existing'] = __('I want to use an existing address');
			$this->data['text_address_new'] = __('I want to use a new address');
			$this->data['text_select'] = __('Select');

			$this->data['entry_firstname'] = __('First Name:');
			$this->data['entry_lastname'] = __('Last Name:');
			$this->data['entry_company'] = __('Company:');
			$this->data['entry_address_1'] = __('Address 1:');
			$this->data['entry_address_2'] = __('Address 2:');
			$this->data['entry_postcode'] = __('Post Code:');
			$this->data['entry_city'] = __('City:');
			$this->data['entry_country'] = __('Country:');
			$this->data['entry_zone'] = __('Zone:');

			$this->data['button_continue'] = __('Continue');

			$this->data['type'] = 'payment';

			if (isset($this->session->data['payment_address_id'])) {
				$this->data['address_id'] = $this->session->data['payment_address_id'];
			} else {
				$this->data['address_id'] = $this->customer->getAddressId();
			}

			$this->data['addresses'] = $address_model->getAddresses();
			

			$this->data['country_id'] = $this->config->get('country');

			$model_country = impresscart_framework::model('localisation/country');
			$this->data['countries'] = $model_country->getCountries();

			
			$json['output'] = $this->render();
		}
		echo json_encode($json);
		exit(0);
	}

	public function shipping() {

		$this->autoRender = false;

		$address_model = impresscart_framework::model('account/address');

		$json = array();

		if (!$this->customer->isLogged()) {
			$json['redirect'] = $this->url->link('checkout/checkout', '', 'SSL');
		}

		if (!$this->cart->hasShipping()) {
			$json['redirect'] = $this->url->link('checkout/checkout', '', 'SSL');
		}
			
		if ((!$this->cart->hasProducts() && (!isset($this->session->data['vouchers']) || !$this->session->data['vouchers'])) || (!$this->cart->hasStock() && !$this->config->get('stock_checkout'))) {
			$json['redirect'] = $this->url->link('checkout/cart');
		}
		
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {

			$this->data['text_address_existing'] = __('I want to use an existing address');
			$this->data['text_address_new'] = __('I want to use a new address');
			$this->data['text_select'] = __('-- Please Select --');

			$this->data['entry_firstname'] = __('First name:');
			$this->data['entry_lastname'] = __('Last name:');
			$this->data['entry_company'] = __('Company:');
			$this->data['entry_address_1'] = __('Address 1:');
			$this->data['entry_address_2'] = __('Address 2:');
			$this->data['entry_postcode'] = __('Postcode:');
			$this->data['entry_city'] = __('City:');
			$this->data['entry_country'] = __('Country');
			$this->data['entry_zone'] = __('Region / State:');
			$this->data['button_continue'] = __('Continue');
			$this->data['type'] = 'shipping';
			if (isset($this->session->data['shipping_address_id'])) {
				$this->data['address_id'] = $this->session->data['shipping_address_id'];
			} else {
				$this->data['address_id'] = $this->customer->getAddressId();
			}

			$this->data['addresses'] = $address_model->getAddresses();

			$this->data['country_id'] = $this->config->get('country');

			$model_country = impresscart_framework::model('localisation/country');

			$this->data['countries'] = $model_country->getCountries();

			$json['output'] = $this->render();
		}

		echo json_encode($json);
		exit(0);
	}

	public function validatePaymentAddress() {
		
		$this->autoRender = false;

		$address_model = impresscart_framework::model('account/address');

		$json = array();
		// Validate if customer is logged in.
		if (!$this->customer->isLogged()) {
			$json['redirect'] = $this->url->link('checkout/checkout', '', 'SSL');
		}
		// Validate cart has products and has stock.
		if ((!$this->cart->hasProducts() && (!isset($this->session->data['vouchers']) || !$this->session->data['vouchers'])) || (!$this->cart->hasStock() && !$this->config->get('config_stock_checkout'))) {
			$json['redirect'] = $this->url->link('checkout/cart');
		}

		// Validate minimum quantity requirments.
		$products = $this->cart->getProducts();
		foreach ($products as $product) {
			$product_total = 0;
			foreach ($products as $product_2) {
				if ($product_2['product_id'] == $product['product_id']) {
					$product_total += $product_2['quantity'];
				}
			}
				
			if ($product['minimum'] > $product_total) {
				$this->redirect($this->url->link('checkout/cart'));
			}
		}

		if (!$json) {
			if ($_POST['payment_address'] == 'existing') {
				if (empty($_POST['address_id'])) {
					$json['error']['warning'] = __('error_address');
				}

				if (!$json) {
					$this->session->data['payment_address_id'] = $_POST['address_id'];
					unset($this->session->data['payment_method']);
					unset($this->session->data['payment_methods']);
				}
			}
				
			if ($_POST['payment_address'] == 'new') {
				
				if ((utf8_strlen($_POST['firstname']) < 1) || (utf8_strlen($_POST['firstname']) > 32)) {
					$json['error']['firstname'] = __('First Name must be between 1 and 32 characters!');
				}

				if ((utf8_strlen($_POST['lastname']) < 1) || (utf8_strlen($_POST['lastname']) > 32)) {
					$json['error']['lastname'] = __('Last Name must be between 1 and 32 characters!');
				}

				if ((utf8_strlen($_POST['address_1']) < 3) || (utf8_strlen($_POST['address_1']) > 128)) {
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

				if (!$json) {
					$this->session->data['payment_address_id'] = $address_model->addAddress($_POST);	
					unset($this->session->data['payment_method']);
					unset($this->session->data['payment_methods']);
				}
			}
		}
		
		echo json_encode($json);
		exit(0);
	}

	
	public function validateShippingAddress() {
		
		
		$this->autoRender = false;

		$address_model = impresscart_framework::model('account/address');

		$json = array();
		// Validate if customer is logged in.
		if (!$this->customer->isLogged()) {
			$json['redirect'] = $this->url->link('checkout/checkout', '', 'SSL');
		}
		// Validate cart has products and has stock.
		if ((!$this->cart->hasProducts() && (!isset($this->session->data['vouchers']) || !$this->session->data['vouchers'])) || (!$this->cart->hasStock() && !$this->config->get('stock_checkout'))) {
			$json['redirect'] = $this->url->link('checkout/cart');
		}

		// Validate minimum quantity requirments.
		$products = $this->cart->getProducts();
		foreach ($products as $product) {
			$product_total = 0;
			foreach ($products as $product_2) {
				if ($product_2['product_id'] == $product['product_id']) {
					$product_total += $product_2['quantity'];
				}
			}
				
			if ($product['minimum'] > $product_total) {
				$this->redirect($this->url->link('checkout/cart'));
			}
		}
		
								
		if (!$json) {
			if ($_POST['shipping_address'] == 'existing') {
				if (empty($_POST['address_id'])) {
					$json['error']['warning'] = __('error_address');
				}
				
				if (!$json) {			
					$this->session->data['shipping_address_id'] = $_POST['address_id'];
					
					unset($this->session->data['shipping_method']);							
					unset($this->session->data['shipping_methods']);
				}
			} 
			
			if ($_POST['shipping_address'] == 'new') {
				
				if ((utf8_strlen($_POST['firstname']) < 1) || (utf8_strlen($_POST['firstname']) > 32)) {
					$json['error']['firstname'] = __('First Name must be between 1 and 32 characters!');
				}
		
				if ((utf8_strlen($_POST['lastname']) < 1) || (utf8_strlen($_POST['lastname']) > 32)) {
					$json['error']['lastname'] = __('Last Name must be between 1 and 32 characters!');
				}
		
				if ((utf8_strlen($_POST['address_1']) < 3) || (utf8_strlen($_POST['address_1']) > 128)) {
					$json['error']['address_1'] = __('Address 1 must be between 3 and 128 characters!');
				}
		
				if ((utf8_strlen($_POST['city']) < 2) || (utf8_strlen($_POST['city']) > 128)) {
					$json['error']['city'] = __('City must be between 2 and 128 characters!');
				}
				
				$model_country = impresscart_framework::model('localisation/country');
				$country_info = $model_country->getCountry($_POST['country_id']);
				
				/*
				if ($country_info && $country_info->name && (utf8_strlen($_POST['postcode']) < 2) || (utf8_strlen($_POST['postcode']) > 10)) {
					$this->error['postcode'] = __('Postcode must be between 2 and 10 characters!');
				}
				*/
				
				if ( utf8_strlen($_POST['postcode']) < 2 || utf8_strlen($_POST['postcode']) > 10 ) {
					$json['error']['postcode'] = __('Postcode must be between 2 and 10 characters!');
				}

				if ($_POST['country_id'] == '') {
					$json['error']['country'] = __('Please select a country');
				}

				if ($_POST['zone_id'] == '') {
					$json['error']['zone'] = __('Please select a zone');
				}
				
				if (!$json) {

					$this->session->data['shipping_address_id'] = $address_model->addAddress($_POST);
					
					unset($this->session->data['shipping_method']);						
					unset($this->session->data['shipping_methods']);
				}
			}
		}
		echo json_encode($json);
		exit(0);
		
	}
	
	public function zone() {
		
  		$country_id_from_client = $_REQUEST['country_id'];
  		$output = '<option value="">' . __('-- Please Select --') . '</option>';
		$zone_model = impresscart_framework::model('localisation/zone');
    	$results = $zone_model->getZonesByCountryId($country_id_from_client);
      	foreach ($results as $result) {
      		
      		$result = (array)$result;
        	$output .= '<option value="' . $result['zone_id'] . '"';
	    	if (isset($_REQUEST['zone_id']) && ($_REQUEST['zone_id'] == $result['zone_id'])) {
	      		$output .= ' selected="selected"';
	    	}
	
	    	$output .= '>' . $result['name'] . '</option>';
	    	
	    	
    	} 
		
		if (!$results) {
		  	$output .= '<option value="0">' . __('No Zone') . '</option>';
		}
		$this->autoRender = false;
		echo $output;
  		
  	}  
}
?>