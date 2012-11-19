<?php 
class impresscart_account_address_controller extends impresscart_framework_controller {
	private $error = array();
	  
  	public function index() {
  		
    	if (!$this->customer->isLogged()) {
	  		$this->session->data['redirect'] = $this->url->link('account/address', '', 'SSL');

	  		$this->redirect($this->url->link('account/login', '', 'SSL')); 
    	}
		$this->getList();
  	}

  	public function insert() {
  		
    	if (!$this->customer->isLogged()) {
	  		$this->session->data['redirect'] = $this->url->link('account/address', '', 'SSL');

	  		$this->redirect($this->url->link('account/login', '', 'SSL')); 
    	} 

    	if (($_SERVER['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
    		
			$this->model_account_address->addAddress($_POST);
			
      		$this->session->data['success'] = __('text_insert');

	  		$this->redirect($this->url->link('account/address', '', 'SSL'));
    	} 
	  	
		$this->getForm();
  	}

  	public function update() {
  		
    	if (!$this->customer->isLogged()) {
	  		$this->session->data['redirect'] = $this->url->link('account/address', '', 'SSL');

	  		$this->redirect($this->url->link('account/login', '', 'SSL')); 
    	} 
		
    	if (($_SERVER['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
       		$this->model_account_address->editAddress($_GET['address_id'], $_POST);
	  		
			if (isset($this->session->data['shipping_address_id']) && ($_GET['address_id'] == $this->session->data['shipping_address_id'])) {
	  			unset($this->session->data['shipping_methods']);
				unset($this->session->data['shipping_method']);	
			}

			if (isset($this->session->data['payment_address_id']) && ($_GET['address_id'] == $this->session->data['payment_address_id'])) {
	  			unset($this->session->data['payment_methods']);
				unset($this->session->data['payment_method']);
			}
			
			$this->session->data['success'] = __('text_update');
	  
	  		$this->redirect($this->url->link('account/address', '', 'SSL'));
    	} 
	  	
		$this->getForm();
  	}

  	public function delete() {
  		
    	if (!$this->customer->isLogged()) {
	  		$this->session->data['redirect'] = $this->url->link('account/address', '', 'SSL');

	  		$this->redirect($this->url->link('account/login', '', 'SSL')); 
    	} 
		
    	if (isset($_REQUEST['address_id']) && $this->validateDelete()) {
			$this->model_account_address->deleteAddress($_GET['address_id']);	

			if (isset($this->session->data['shipping_address_id']) && ($_GET['address_id'] == $this->session->data['shipping_address_id'])) {
	  			unset($this->session->data['shipping_address_id']);
				unset($this->session->data['shipping_methods']);
				unset($this->session->data['shipping_method']);	
			}

			if (isset($this->session->data['payment_address_id']) && ($_GET['address_id'] == $this->session->data['payment_address_id'])) {
	  			unset($this->session->data['payment_address_id']);
				unset($this->session->data['payment_methods']);
				unset($this->session->data['payment_method']);	
			}
			
			$this->session->data['success'] = __('text_delete');
	  
	  		$this->redirect($this->url->link('account/address', '', 'SSL'));
    	}
	
		$this->getList();
  	}

  	private function getList() {
      	
    	$this->data['heading_title'] = __('Address Book');

    	$this->data['text_address_book'] = __('Entries');
   
    	$this->data['button_new_address'] = __('New Address');
    	$this->data['button_edit'] = __('Edit');
    	$this->data['button_delete'] = __('Delete');
		$this->data['button_back'] = __('Back');

		if (isset($this->error['warning'])) {
    		$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
		
		if (isset($this->session->data['success'])) {
			$this->data['success'] = __('Update Successfully') ; //$this->session->data['success'];
    		unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}
		
    	$this->data['addresses'] = array();
		$results = $this->model_account_address->getAddresses();
		
    	foreach ($results as $result) {
    		
    		if ($result['address_format']) {
      			$format = $result['address_format'];
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
	  			'firstname' => $result['firstname'],
	  			'lastname'  => $result['lastname'],
	  			'company'   => $result['company'],
      			'address_1' => $result['address_1'],
      			'address_2' => $result['address_2'],
      			'city'      => $result['city'],
      			'postcode'  => $result['postcode'],
      			'zone'      => $result['zone'],
				'zone_code' => $result['zone_code'],
      			'country'   => $result['country']  
			);

      		$this->data['addresses'][] = array(
        		'address_id' => $result['address_id'],
        		'address'    => str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format)))),
        		'update'     => $this->url->link('account/address/update', 'address_id=' . $result['address_id'], 'SSL'),
				'delete'     => $this->url->link('account/address/delete', 'address_id=' . $result['address_id'], 'SSL')
      		);
    	}

    	$this->data['insert'] = $this->url->link('account/address/insert', '', 'SSL');
		$this->data['back'] = $this->url->link('account/account', '', 'SSL');
  	}

  	private function getForm() {
      	
		$this->data['heading_title'] = __('Address Book');
    	
		$this->data['text_edit_address'] = __('Edit address');
    	$this->data['text_yes'] = __('Yes');
    	$this->data['text_no'] = __('No');
		$this->data['text_select'] = __('Select');
		
    	$this->data['entry_firstname'] = __('First name:');
    	$this->data['entry_lastname'] = __('Last name');
    	$this->data['entry_company'] = __('Company');
    	$this->data['entry_address_1'] = __('Address 1');
    	$this->data['entry_address_2'] = __('Address 2');
    	$this->data['entry_postcode'] = __('Post code');
    	$this->data['entry_city'] = __('City');
    	$this->data['entry_country'] = __('Country');
    	$this->data['entry_zone'] = __('Region / State:');
    	$this->data['entry_default'] = __('Default Address:');

    	$this->data['button_continue'] = __('Continue');
    	$this->data['button_back'] = __('Back');

		if (isset($this->error['firstname'])) {
    		$this->data['error_firstname'] = $this->error['firstname'];
		} else {
			$this->data['error_firstname'] = '';
		}
		
		if (isset($this->error['lastname'])) {
    		$this->data['error_lastname'] = $this->error['lastname'];
		} else {
			$this->data['error_lastname'] = '';
		}
		
		if (isset($this->error['address_1'])) {
    		$this->data['error_address_1'] = $this->error['address_1'];
		} else {
			$this->data['error_address_1'] = '';
		}
		
		if (isset($this->error['city'])) {
    		$this->data['error_city'] = $this->error['city'];
		} else {
			$this->data['error_city'] = '';
		}
		
		if (isset($this->error['postcode'])) {
    		$this->data['error_postcode'] = $this->error['postcode'];
		} else {
			$this->data['error_postcode'] = '';
		}

		if (isset($this->error['country'])) {
			$this->data['error_country'] = $this->error['country'];
		} else {
			$this->data['error_country'] = '';
		}

		if (isset($this->error['zone'])) {
			$this->data['error_zone'] = $this->error['zone'];
		} else {
			$this->data['error_zone'] = '';
		}
		
		if (!isset($_GET['address_id'])) {
    		$this->data['action'] = $this->url->link('account/address/insert', '', 'SSL');
		} else {
    		$this->data['action'] = $this->url->link('account/address/update', 'address_id=' . $_GET['address_id'], 'SSL');
		}
		
    	if (isset($_GET['address_id']) && ($_SERVER['REQUEST_METHOD'] != 'POST')) {
			$address_info = $this->model_account_address->getAddress($_GET['address_id']);
		}
	
    	if (isset($_POST['firstname'])) {
      		$this->data['firstname'] = $_POST['firstname'];
    	} elseif (isset($address_info)) {
      		$this->data['firstname'] = $address_info['firstname'];
    	} else {
			$this->data['firstname'] = '';
		}

    	if (isset($_POST['lastname'])) {
      		$this->data['lastname'] = $_POST['lastname'];
    	} elseif (isset($address_info)) {
      		$this->data['lastname'] = $address_info['lastname'];
    	} else {
			$this->data['lastname'] = '';
		}

    	if (isset($_POST['company'])) {
      		$this->data['company'] = $_POST['company'];
    	} elseif (isset($address_info)) {
			$this->data['company'] = $address_info['company'];
		} else {
      		$this->data['company'] = '';
    	}

    	if (isset($_POST['address_1'])) {
      		$this->data['address_1'] = $_POST['address_1'];
    	} elseif (isset($address_info)) {
			$this->data['address_1'] = $address_info['address_1'];
		} else {
      		$this->data['address_1'] = '';
    	}

    	if (isset($_POST['address_2'])) {
      		$this->data['address_2'] = $_POST['address_2'];
    	} elseif (isset($address_info)) {
			$this->data['address_2'] = $address_info['address_2'];
		} else {
      		$this->data['address_2'] = '';
    	}	

    	if (isset($_POST['postcode'])) {
      		$this->data['postcode'] = $_POST['postcode'];
    	} elseif (isset($address_info)) {
			$this->data['postcode'] = $address_info['postcode'];			
		} else {
      		$this->data['postcode'] = '';
    	}

    	if (isset($_POST['city'])) {
      		$this->data['city'] = $_POST['city'];
    	} elseif (isset($address_info)) {
			$this->data['city'] = $address_info['city'];
		} else {
      		$this->data['city'] = '';
    	}
    	
    	if (isset($_POST['country_id'])) {
      		$this->data['country_id'] = $_POST['country_id'];
    	}  elseif (isset($address_info)) {
      		$this->data['country_id'] = $address_info['country_id'];			
    	} else {
      		$this->data['country_id'] = $this->config->get('country');
    	}
    	
    	if (isset($_POST['zone_id'])) {
      		$this->data['zone_id'] = $_POST['zone_id'];
    	}  elseif (isset($address_info)) {
      		$this->data['zone_id'] = $address_info['zone_id'];			
    	} else {
      		$this->data['zone_id'] = '';
    	}
		
		$model_country = impresscart_framework::model('localisation/country');
		
    	$this->data['countries'] = $model_country->getCountries();
    	
    	if (isset($_POST['default'])) {
      		$this->data['default'] = $_POST['default'];
    	} elseif (isset($_GET['address_id'])) {
      		$this->data['default'] = $this->customer->getAddressId() == $_GET['address_id'];
    	} else {
			$this->data['default'] = false;
		}

    	$this->data['back'] = $this->url->link('account/address', '', 'SSL');
  	}
	
  	private function validateForm() {
    	if ((utf8_strlen($_POST['firstname']) < 1) || (utf8_strlen($_POST['firstname']) > 32)) {
      		$this->error['firstname'] = __('error_firstname');
    	}

    	if ((utf8_strlen($_POST['lastname']) < 1) || (utf8_strlen($_POST['lastname']) > 32)) {
      		$this->error['lastname'] = __('error_lastname');
    	}

    	if ((utf8_strlen($_POST['address_1']) < 3) || (utf8_strlen($_POST['address_1']) > 128)) {
      		$this->error['address_1'] = __('error_address_1');
    	}

    	if ((utf8_strlen($_POST['city']) < 2) || (utf8_strlen($_POST['city']) > 128)) {
      		$this->error['city'] = __('error_city');
    	}
		
		$model_country = impresscart_framework::model('localisation/country');
		
		$country_info = $model_country->getCountry($_POST['country_id']);
		
		if ($country_info && $country_info['postcode_required'] && (utf8_strlen($_POST['postcode']) < 2) || (utf8_strlen($_POST['postcode']) > 10)) {
			$this->error['postcode'] = __('error_postcode');
		}
		
    	if ($_POST['country_id'] == '') {
      		$this->error['country'] = __('error_country');
    	}
		
    	if ($_POST['zone_id'] == '') {
      		$this->error['zone'] = __('error_zone');
    	}
		
    	if (!$this->error) {
      		return true;
		} else {
      		return false;
    	}
  	}

  	private function validateDelete() {
  		
    	if ($this->model_account_address->getTotalAddresses() == 1) {    		
      		$this->error['warning'] = __('error_delete');
    	}

    	if ($this->customer->getAddressId() == $_GET['address_id']) {
      		$this->error['warning'] = __('error_default');
    	}

    	if (!$this->error) {
      		return true;
    	} else {
      		return false;
    	}
  	}
	
  	public function zone() {	
		$output = '<option value="">' . __('Select') . '</option>';

    	$results = $this->model_localisation_zone->getZonesByCountryId($_REQUEST['country_id']);
        
      	foreach ($results as $result) {
      		$result = (array)$result;
        	$output .= '<option value="' . $result['zone_id'] . '"';
	
	    	if (isset($_GET['zone_id']) && ($_GET['zone_id'] == $result['zone_id'])) {
	      		$output .= ' selected="selected"';
	    	}
	
	    	$output .= '>' . $result['name'] . '</option>';
    	} 
		
		if (!$results) {
		  	$output .= '<option value="0">' . __('None') . '</option>';
    	}
	
    	$this->autoRender = false;
    	echo $output;
  	}  
}
?>