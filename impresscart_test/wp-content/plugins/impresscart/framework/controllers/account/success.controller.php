<?php 
class impresscart_account_success_controller extends impresscart_framework_controller {	
	
	public function index() {
    	
		$this->data['breadcrumbs'] = array();
      	$this->data['breadcrumbs'][] = array(
        	'text'      => __('Your Account Has Been Created!'),
			'href'      => $this->url->link('common/home'),       	
        	'separator' => false
      	); 

      	$this->data['breadcrumbs'][] = array(
        	'text'      => __('Account'),
			'href'      => $this->url->link('account/account', '', 'SSL'),
        	'separator' => __('text_separator')
      	);

      	$this->data['breadcrumbs'][] = array(
        	'text'      => __('Success'),
			'href'      => $this->url->link('account/success'),
        	'separator' => __('text_separator')
      	);

    	$this->data['heading_title'] = __('Your Account Has Been Created!');

		if (!$this->config->get('config_customer_approval')) {
    		$this->data['text_message'] = sprintf(__('<p>Congratulations! Your new account has been successfully created!</p> <p>You can now take advantage of member privileges to enhance your online shopping experience with us.</p> <p>If you have ANY questions about the operation of this online shop, please email the store owner.</p> <p>A confirmation has been sent to the provided email address. If you have not received it within the hour, please <a href="%s">contact us</a>.</p>'), $this->url->link('information/contact'));
		} else {
			$this->data['text_message'] = sprintf(__('<p>Thank you for registering with %s!</p><p>You will be notified by email once your account has been activated by the store owner.</p><p>If you have ANY questions about the operation of this online shop, please <a href="%s">contact the store owner</a>.</p>'), $this->config->get('config_name'), $this->url->link('information/contact'));
		}
		
    	$this->data['button_continue'] = __('button_continue');
		
		if ($this->cart->hasProducts()) {
			$this->data['continue'] = $this->url->link('checkout/cart', '', 'SSL');
		} else {
			$this->data['continue'] = $this->url->link('account/account', '', 'SSL');
		}

		$this->autoRender = false;
		echo _(" You have registered successfully");
  	}
}
?>