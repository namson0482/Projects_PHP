<?php 
class impresscart_checkout_guestshipping_controller extends impresscart_framework_controller {
	
  	public function index() {	
  		
  		$this->autoRender = false;
  		
		$this->data['text_select'] = __('-- Please Select --');
		$this->data['entry_firstname'] = __('First Name');
		$this->data['entry_lastname'] = __('Last Name');
		$this->data['entry_company'] = __('Company');
		$this->data['entry_address_1'] = __('Address_1');
		$this->data['entry_address_2'] = __('Address_2');
		$this->data['entry_postcode'] = __('Post Code');
		$this->data['entry_city'] = __('City');
		$this->data['entry_country'] = __('Country');
		$this->data['entry_zone'] = __('Zone');
	
		$this->data['button_continue'] = __('Continue');
					
		if (isset($this->session->data['guest']['shipping']['firstname'])) {
			$this->data['firstname'] = $this->session->data['guest']['shipping']['firstname'];
		} else {
			$this->data['firstname'] = '';
		}

		if (isset($this->session->data['guest']['shipping']['lastname'])) {
			$this->data['lastname'] = $this->session->data['guest']['shipping']['lastname'];
		} else {
			$this->data['lastname'] = '';
		}
		
		if (isset($this->session->data['guest']['shipping']['company'])) {
			$this->data['company'] = $this->session->data['guest']['shipping']['company'];			
		} else {
			$this->data['company'] = '';
		}
		
		if (isset($this->session->data['guest']['shipping']['address_1'])) {
			$this->data['address_1'] = $this->session->data['guest']['shipping']['address_1'];			
		} else {
			$this->data['address_1'] = '';
		}

		if (isset($this->session->data['guest']['shipping']['address_2'])) {
			$this->data['address_2'] = $this->session->data['guest']['shipping']['address_2'];			
		} else {
			$this->data['address_2'] = '';
		}

		if (isset($this->session->data['guest']['shipping']['postcode'])) {
			$this->data['postcode'] = $this->session->data['guest']['shipping']['postcode'];					
		} else {
			$this->data['postcode'] = '';
		}
		
		if (isset($this->session->data['guest']['shipping']['city'])) {
			$this->data['city'] = $this->session->data['guest']['shipping']['city'];			
		} else {
			$this->data['city'] = '';
		}

		if (isset($this->session->data['guest']['shipping']['country_id'])) {
			$this->data['country_id'] = $this->session->data['guest']['shipping']['country_id'];			  	
		} else {
			$this->data['country_id'] = '';
		}

		if (isset($this->session->data['guest']['shipping']['zone_id'])) {
			$this->data['zone_id'] = $this->session->data['guest']['shipping']['zone_id'];			
		} else {
			$this->data['zone_id'] = '';
		}
					
		$model_country = impresscart_framework::model('localisation/country');
		
		$this->data['countries'] = $model_country->getCountries();
		
        $json['output'] = $this->render();
		echo json_encode($json);
        exit(0);
	}
	
	public function validateShippingAddress() {
		
		$this->autoRender = false;
		
		$json = array();
		
		if ((utf8_strlen($_POST['firstname']) < 1) || (utf8_strlen($_POST['firstname']) > 32)) {
			$json['error']['firstname'] = __('First Name must be between 1 and 32 characters!');
		}

		if ((utf8_strlen($_POST['lastname']) < 1) || (utf8_strlen($_POST['lastname']) > 32)) {
			$json['error']['lastname'] = __('Last Name must be between 1 and 32 characters!');
		}

		if ((utf8_strlen($_POST['address_1']) < 3) || (utf8_strlen($_POST['address_1']) > 64)) {
			$json['error']['address_1'] = __('Address 1 must be between 3 and 128 characters!');
		}

		if ((utf8_strlen($_POST['city']) < 2) || (utf8_strlen($_POST['city']) > 128)) {
			$json['error']['city'] = __('error_city');
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
			$this->session->data['guest']['shipping']['firstname'] = trim($_POST['firstname']);
			$this->session->data['guest']['shipping']['lastname'] = trim($_POST['lastname']);
			$this->session->data['guest']['shipping']['company'] = trim($_POST['company']);
			$this->session->data['guest']['shipping']['address_1'] = $_POST['address_1'];
			$this->session->data['guest']['shipping']['address_2'] = $_POST['address_2'];
			$this->session->data['guest']['shipping']['postcode'] = $_POST['postcode'];
			$this->session->data['guest']['shipping']['city'] = $_POST['city'];
			$this->session->data['guest']['shipping']['country_id'] = $_POST['country_id'];
			$this->session->data['guest']['shipping']['zone_id'] = $_POST['zone_id'];
			
			$model_country = impresscart_framework::model('localisation/country');
			$country_info = $model_country->getCountry($_POST['country_id']);
			
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
			
			$model_zone = impresscart_framework::model('localisation/zone');
			$zone_info = $model_zone->getZone($_POST['zone_id']);
		
			if ($zone_info) {
				$this->session->data['guest']['shipping']['zone'] = $zone_info->name;
				$this->session->data['guest']['shipping']['zone_code'] = $zone_info->code;
			} else {
				$this->session->data['guest']['shipping']['zone'] = '';
				$this->session->data['guest']['shipping']['zone_code'] = '';
			}
			
			unset($this->session->data['shipping_method']);	
			unset($this->session->data['shipping_methods']);
		}
		
		echo json_encode($json);
		exit(0);
				
	}

}
?>