<?php
class impresscart_account_password_controller extends impresscart_framework_controller {

	private $error = array();

	public function index() {

		if ($this->customer->isUserLogged() == 1) {
			$this->redirect($this->url->link('', '', 'SSL'));
			return;
		}
		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/password', '', 'SSL');
			$this->redirect($this->url->link('account/login', '', 'SSL'));
			return;
		}
			
		if (($_SERVER['REQUEST_METHOD'] == 'POST') && $this->validate()) {
				
			$this->model_account_customer->editPassword($this->customer->getEmail(), $_POST['password']);

			$this->session->data['success'] = __('text_success');
			 
			$this->redirect($this->url->link('account/account', '', 'SSL'));
			return;
		}

		$this->data['heading_title'] = __('Change password:');
		$this->data['text_password'] = __('Enter your new password:');
		$this->data['entry_current_password'] = __('Enter your current password:');
		$this->data['entry_password'] = __('Password:');
		$this->data['entry_confirm'] = __('confirm password:');
		$this->data['button_continue'] = __('Continue');
		$this->data['button_back'] = __('Back');
		 
		if (isset($this->error['current_password'])) {
			$this->data['error_current_password'] = $this->error['current_password'];
		} else {
			$this->data['error_current_password'] = '';
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

		$this->data['action'] = $this->url->link('account/password', '', 'SSL');

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
		
		$this->data['current_password'] = '';

		$this->data['back'] = $this->url->link('account/account', '', 'SSL');
	}

	private function validate() {

		if(!$this->customer->checkPassword($_POST['current_password'])) {
			$this->error['current_password'] = __('Your current password isn\'t match');
		}

		if ((utf8_strlen($_POST['password']) < 6) || (utf8_strlen($_POST['password']) > 20)) {
			$this->error['password'] = __('Your password must be a least 6 characters and less than 20 characters');
		}

		if ($_POST['confirm'] != $_POST['password']) {
			$this->error['confirm'] = __('Your confirm password does not match');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
}
?>
