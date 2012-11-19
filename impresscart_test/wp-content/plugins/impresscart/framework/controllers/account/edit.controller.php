<?php
class impresscart_account_edit_controller extends impresscart_framework_controller {
	private $error = array();

	public function index() {
		
		//var_dump($this->customer->isLogged());
		//
		
		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/edit', '', 'SSL');
			$this->redirect($this->url->link('account/login', '', 'SSL'));
			return;
		}		
		
		if (($_SERVER['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			
			$this->model_account_customer->editCustomer($_POST);
			
			$this->session->data['success'] = __('Update successfully');

			$this->redirect($this->url->link('account/account', '', 'SSL'));
		}

      	$this->data['heading_title'] = __('My Account Information');

		$this->data['text_your_details'] = __('Your Personal Details');

		$this->data['entry_firstname'] = __('First name:');
		$this->data['entry_lastname'] = __('Last name:');
		$this->data['entry_email'] = __('Email:');
		$this->data['entry_telephone'] = __('Telephone:');
		$this->data['entry_fax'] = __('Fax:');

		$this->data['button_continue'] = __('Continue');
		$this->data['button_back'] = __('Back');

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

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
		
		if (isset($this->error['email'])) {
			$this->data['error_email'] = $this->error['email'];
		} else {
			$this->data['error_email'] = '';
		}	
		
		if (isset($this->error['telephone'])) {
			$this->data['error_telephone'] = $this->error['telephone'];
		} else {
			$this->data['error_telephone'] = '';
		}	

		$this->data['action'] = $this->url->link('account/edit', '', 'SSL');

		if ($_SERVER['REQUEST_METHOD'] != 'POST') {
			$customer_info = $this->model_account_customer->getCustomer($this->customer->getId());
			$customer_addresses = $this->customer->getAddress();	
			
			if(count($customer_addresses))		
			{
				$customer_address = $customer_addresses[1];
			}
		}
				
		if (isset($_POST['firstname'])) {
			$this->data['firstname'] = $_POST['firstname'];
		} elseif (isset($customer_info)) {
			$this->data['firstname'] = @$customer_address['firstname'];
		} else {
			$this->data['firstname'] = '';
		}

		if (isset($_POST['lastname'])) {
			$this->data['lastname'] = $_POST['lastname'];
		} elseif (isset($customer_info)) {
			$this->data['lastname'] = $customer_address['lastname'];
		} else {
			$this->data['lastname'] = '';
		}

		if (isset($_POST['email'])) {
			$this->data['email'] = $_POST['email'];
		} elseif (isset($customer_info)) {
			$this->data['email'] = $customer_info['user_email'];
		} else {
			$this->data['email'] = '';
		}

		if (isset($_POST['telephone'])) {
			$this->data['telephone'] = $_POST['telephone'];
		} elseif (isset($customer_info)) {
			$this->data['telephone'] = $customer_info['telephone'];
		} else {
			$this->data['telephone'] = '';
		}

		if (isset($_POST['fax'])) {
			$this->data['fax'] = $_POST['fax'];
		} elseif (isset($customer_info)) {
			$this->data['fax'] = $customer_info['fax'];
		} else {
			$this->data['fax'] = '';
		}

		$this->data['back'] = $this->url->link('account/account', '', 'SSL');
	}

	private function validate() {
		if ((utf8_strlen($_POST['firstname']) < 1) || (utf8_strlen($_POST['firstname']) > 32)) {
			$this->error['firstname'] = __('error_firstname');
		}

		if ((utf8_strlen($_POST['lastname']) < 1) || (utf8_strlen($_POST['lastname']) > 32)) {
			$this->error['lastname'] = __('error_lastname');
		}

		if ((utf8_strlen($_POST['email']) > 96) || !preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $_POST['email'])) {
			$this->error['email'] = __('error_email');
		}
		
		if (($this->customer->getEmail() != $_POST['email']) && $this->model_account_customer->getTotalCustomersByEmail($_POST['email'])) {
			$this->error['warning'] = __('error_exists');
		}

		if ((utf8_strlen($_POST['telephone']) < 3) || (utf8_strlen($_POST['telephone']) > 32)) {
			$this->error['telephone'] = __('error_telephone');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
}
?>