<?php
class impresscart_account_forgotten_controller extends impresscart_framework_controller {
	
	private $error = array();

	public function index() {
		if ($this->customer->isLogged()) {
			$this->redirect($this->url->link('account/account', '', 'SSL'));
			return;
		}
		
		
		if (($_SERVER['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			
			//$this->language->load('mail/forgotten');
			
			$password = substr(md5(rand()), 0, 7);
			
			$this->model_account_customer->editPassword($_POST['email'], $password);
			
			$subject = sprintf(__('text_subject'), $this->config->get('config_name'));
			
			$message  = sprintf(__('text_greeting'), $this->config->get('config_name')) . "\n\n";
			$message .= __('text_password') . "\n\n";
			$message .= $password;

			$this->mail->protocol = $this->config->get('mail_method');
			$this->mail->parameter = $this->config->get('mail_parameter');
			$this->mail->hostname = $this->config->get('smtp_host');
			$this->mail->username = $this->config->get('smtp_username');
			$this->mail->password = $this->config->get('smtp_password');
			$this->mail->port = $this->config->get('smtp_port');
			$this->mail->timeout = $this->config->get('smtp_timeout');				
			$this->mail->setTo($data['email']);
			$this->mail->setFrom($this->config->get('sender_email'));
			$this->mail->setSender(get_bloginfo('name'));
			$this->mail->setSubject($subject);
			$this->mail->setText($message);
			                
			$this->mail->send();
			
			$this->session->data['success'] = __('text_success');

			$this->redirect($this->url->link('account/login', '', 'SSL'));
		}

      	$this->data['breadcrumbs'] = array();

      	$this->data['breadcrumbs'][] = array(
        	'text'      => __('Home'),
			'href'      => $this->url->link('common/home'),        	
        	'separator' => false
      	); 

      	$this->data['breadcrumbs'][] = array(
        	'text'      => __('text_account'),
			'href'      => $this->url->link('account/account', '', 'SSL'),     	
        	'separator' => __('»')
      	);
		
      	$this->data['breadcrumbs'][] = array(
        	'text'      => __('text_forgotten'),
			'href'      => $this->url->link('account/forgotten', '', 'SSL'),       	
        	'separator' => __('»')
      	);
		
		$this->data['heading_title'] = __('Forgot Your Password?');

		$this->data['text_your_email'] = __('Your E-Mail Address');
		$this->data['text_email'] = __('Enter the e-mail address associated with your account. Click submit to have your password e-mailed to you.');

		$this->data['entry_email'] = __('E-Mail Address:');

		$this->data['button_continue'] = __('Continue');
		$this->data['button_back'] = __('Back');

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
		$this->data['action'] = $this->url->link('account/forgotten', '', 'SSL');
		$this->data['back'] = $this->url->link('account/login', '', 'SSL');
		
						
	}

	private function validate() {
		if (!isset($_POST['email'])) {
			$this->error['warning'] = __('Warning: The E-Mail Address was not found in our records, please try again!');
		} elseif (!$this->model_account_customer->getTotalCustomersByEmail($_POST['email'])) {
			$this->error['warning'] = __('Warning: The E-Mail Address was not found in our records, please try again!');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
}
?>