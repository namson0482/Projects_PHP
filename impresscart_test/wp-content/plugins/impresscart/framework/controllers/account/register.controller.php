<?php
class impresscart_account_register_controller extends impresscart_framework_controller {
	private $error = array();

	public function index() {

		if ($this->customer->isLogged()) {
			$this->redirect($this->url->link('account/account', '', 'SSL'));
			return;
		}
			
		if (($_SERVER['REQUEST_METHOD'] == 'POST') && $this->validate()) {
				
			unset($this->session->data['guest']);

			$this->model_account_customer->addCustomer($_POST);
				
			$this->customer->login($_POST['email'], $_POST['password']);

			$this->redirect($this->url->link('account/success'));
			return;
		}

			
		$this->data['heading_title'] = __('Register Account');

		$this->data['text_yes'] = __('Yes');
		$this->data['text_no'] = __('No');
		$this->data['text_select'] = __('Select');
		$this->data['text_account_already'] = sprintf(__('If you already have an account with us, please login at the <a href="%s">login page</a>.'), $this->url->link('account/login', '', 'SSL'));
		$this->data['text_your_details'] = __('Your Personal Details');
		$this->data['text_your_address'] = __('Your Address');
		$this->data['text_your_password'] = __('Your Password');
		$this->data['text_newsletter'] = __('Newsletter');

		$this->data['entry_firstname'] = __('First Name:');
		$this->data['entry_lastname'] = __('Last Name:');
		$this->data['entry_email'] = __('E-Mail:');
		$this->data['entry_telephone'] = __('Telephone:');
		$this->data['entry_fax'] = __('Fax:');
		$this->data['entry_company'] = __('Company:');
		$this->data['entry_address_1'] = __('Address 1:');
		$this->data['entry_address_2'] = __('Address 2:');
		$this->data['entry_postcode'] = __('Post Code:');
		$this->data['entry_city'] = __('City:');
		$this->data['entry_country'] = __('Country:');
		$this->data['entry_zone'] = __('Region / State:');
		$this->data['entry_newsletter'] = __('Subscribe:');
		$this->data['entry_password'] = __('Password:');
		$this->data['entry_confirm'] = __('Password Confirm:');

		$this->data['button_continue'] = __('Continue');

		$this->init();
		
	}

	private function init() {

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

		if (isset($this->error['password'])) {
			$this->data['error_password'] = $this->error['password'];
		} else {
			$this->data['error_password'] = '';
		}

		if (isset($this->error['confirm'])) {
			$this->data['error_confirm'] = $this->error['confirm'];
		} else {
			$this->data['error_confirm'] = '';
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

		$this->data['action'] = $this->url->link('account/register', '', 'SSL');

		if (isset($_POST['firstname'])) {
			$this->data['firstname'] = $_POST['firstname'];
		} else {
			$this->data['firstname'] = '';
		}

		if (isset($_POST['lastname'])) {
			$this->data['lastname'] = $_POST['lastname'];
		} else {
			$this->data['lastname'] = '';
		}

		if (isset($_POST['email'])) {
			$this->data['email'] = $_POST['email'];
		} else {
			$this->data['email'] = '';
		}

		if (isset($_POST['telephone'])) {
			$this->data['telephone'] = $_POST['telephone'];
		} else {
			$this->data['telephone'] = '';
		}

		if (isset($_POST['fax'])) {
			$this->data['fax'] = $_POST['fax'];
		} else {
			$this->data['fax'] = '';
		}

		if (isset($_POST['company'])) {
			$this->data['company'] = $_POST['company'];
		} else {
			$this->data['company'] = '';
		}

		if (isset($_POST['address_1'])) {
			$this->data['address_1'] = $_POST['address_1'];
		} else {
			$this->data['address_1'] = '';
		}

		if (isset($_POST['address_2'])) {
			$this->data['address_2'] = $_POST['address_2'];
		} else {
			$this->data['address_2'] = '';
		}

		if (isset($_POST['postcode'])) {
			$this->data['postcode'] = $_POST['postcode'];
		} else {
			$this->data['postcode'] = '';
		}

		if (isset($_POST['city'])) {
			$this->data['city'] = $_POST['city'];
		} else {
			$this->data['city'] = '';
		}

		if (isset($_POST['country_id'])) {
			$this->data['country_id'] = $_POST['country_id'];
		} else {
			$this->data['country_id'] = $this->config->get('country');
		}

		if (isset($_POST['zone_id'])) {
			$this->data['zone_id'] = $_POST['zone_id'];
		} else {
			$this->data['zone_id'] = '';
		}

		$model_country = impresscart_framework::model('localisation/country');

		$this->data['countries'] = $model_country->getCountries();

		if (isset($_POST['password'])) {
			$this->data['password'] = $_POST['password'];
		} else {
			$this->data['password'] = '';
		}

		if (isset($_POST['confirm'])) {
			$this->data['confirm'] = $_POST['confirm'];
		} else {
			$this->data['confirm'] = '';
		}

		if (isset($_POST['newsletter'])) {
			$this->data['newsletter'] = $_POST['newsletter'];
		} else {
			$this->data['newsletter'] = '';
		}

		if (isset($_POST['agree'])) {
			$this->data['agree'] = $_POST['agree'];
		} else {
			$this->data['agree'] = false;
		}
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

		if ($this->model_account_customer->getTotalCustomersByEmail($_POST['email'])) {
			$this->error['warning'] = __('error_exists');
		}

		if ((utf8_strlen($_POST['telephone']) < 3) || (utf8_strlen($_POST['telephone']) > 32)) {
			$this->error['telephone'] = __('error_telephone');
		}

		if ((utf8_strlen($_POST['address_1']) < 3) || (utf8_strlen($_POST['address_1']) > 128)) {
			$this->error['address_1'] = __('error_address_1');
		}

		if ((utf8_strlen($_POST['city']) < 2) || (utf8_strlen($_POST['city']) > 128)) {
			$this->error['city'] = __('error_city');
		}

		$model_country = impresscart_framework::model('localisation/country');

		$country_info = $model_country->getCountry($_POST['country_id']);

		if ($country_info && $country_info->name && (utf8_strlen($_POST['postcode']) < 2) || (utf8_strlen($_POST['postcode']) > 10)) {
			$this->error['postcode'] = __('Postcode must be between 2 and 10 characters!');
		}

		if ($_POST['country_id'] == '') {
			$this->error['country'] = __('Please select a country!');
		}

		if ($_POST['zone_id'] == '') {
			$this->error['zone'] = __('Please select a zone');
		}

		if ((utf8_strlen($_POST['password']) < 4) || (utf8_strlen($_POST['password']) > 20)) {
			$this->error['password'] = __('Password must be between 4 and 20 characters!');
		}

		if ($_POST['confirm'] != $_POST['password']) {
			$this->error['confirm'] = __('Password confirmation does not match password!');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}


	public function zone() {

		$output = '<option value="">' . __('-- Please select --') . '</option>';

		$country_id_from_client = $_REQUEST['country_id'];

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
			$output .= '<option value="0">' . __('No_Zone') . '</option>';
		}

		$this->autoRender = false;
		echo $output;

	}

}
?>