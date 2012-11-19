<?php 
class impresscart_account_login_controller extends impresscart_framework_controller {
	
	private $error = array();
		
	public function index() {
		if ($this->customer->isLogged()) {  
      		$this->redirect($this->url->link('account/account', '', 'SSL'));
      		return;
    	}
    	
		if (($_SERVER['REQUEST_METHOD'] == 'POST')) {
			$this->autoRender = false;
			$json = array();
			if($this->validate()) {
				unset($this->session->data['guest']);
				// Added strpos check to pass McAfee PCI compliance test (http://forum.opencart.com/viewtopic.php?f=10&t=12043&p=151494#p151295)
				if (isset($_POST['redirect']) && (strpos($_POST['redirect'], HTTP_SERVER) !== false || strpos($_POST['redirect'], HTTPS_SERVER) !== false)) {
					$json['redirect'] = str_replace('&amp;', '&', $_POST['redirect']); 
					//$this->redirect();
				} else {
					$json['redirect'] = $this->url->link('account/account', '', 'SSL');
				}	
			} else {
				$json['warning'] = __('Warning: No match for E-Mail Address and/or Password.');
				//$this->error['warning'] = 
			}
			
			echo json_encode($json);
			exit(0);
			
    	}  
    	$this->data['heading_title'] = __('Login');
    	$this->data['text_new_customer'] = __('New customer');
    	$this->data['text_register'] = __('Register');
    	$this->data['text_register_account'] = __('By creating an account you will be able to shop faster, be up to date on an order\'s status, and keep track of the orders you have previously made.');
		$this->data['text_returning_customer'] = __('Returning Customer');
		$this->data['text_i_am_returning_customer'] = __('I am a returning customer');
    	$this->data['text_forgotten'] = __('Forgotten Password');

    	$this->data['entry_email'] = __('E-Mail Address:');
    	$this->data['entry_password'] = __('Password');

    	$this->data['button_continue'] = __('Continue');
		$this->data['button_login'] = __('Login');

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
		$this->data['action'] = $this->url->link('account/login', '', 'SSL', true);
		$this->data['register'] = $this->url->link('account/register', '', 'SSL');
		$this->data['forgotten'] = $this->url->link('account/forgotten', '', 'SSL');

    	// Added strpos check to pass McAfee PCI compliance test (http://forum.opencart.com/viewtopic.php?f=10&t=12043&p=151494#p151295)
		if (isset($_POST['redirect']) && (strpos($_POST['redirect'], HTTP_SERVER) !== false || strpos($_POST['redirect'], HTTPS_SERVER) !== false)) {
			$this->data['redirect'] = $_POST['redirect'];
		} elseif (isset($this->session->data['redirect'])) {
      		$this->data['redirect'] = $this->session->data['redirect'];
	  		
			unset($this->session->data['redirect']);		  	
    	} else {
			$this->data['redirect'] = '';
		}

		if (isset($this->session->data['success'])) {
    		$this->data['success'] = $this->session->data['success'];
    
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}
  	}
  
  	private function validate() {
  		
    	if (!$this->customer->login($_POST['email'], $_POST['password'])) {
    		return false;
      		//$this->error['warning'] = __('Warning: No match for E-Mail Address and/or Password.');      	
    	}
    	return true;
    	
    	/*
    	if (!$this->error) {
      		return true;
    	} else {
    		
      		return false;
    	} */ 	
  	}
}
?>