<?php 
class impresscart_account_logout_controller extends impresscart_framework_controller {
	
	public function index() {
		
		$this->autoRender = false;
		
    	if ($this->customer->isLogged()) {
    		
      		$this->customer->logout();
	  		$this->cart->clear();
			
			unset($this->session->data['wishlist']);
			unset($this->session->data['shipping_address_id']);
			unset($this->session->data['shipping_method']);
			unset($this->session->data['shipping_methods']);
			unset($this->session->data['payment_address_id']);
			unset($this->session->data['payment_method']);
			unset($this->session->data['payment_methods']);
			unset($this->session->data['comment']);
			unset($this->session->data['order_id']);
			unset($this->session->data['coupon']);
			unset($this->session->data['reward']);			
			unset($this->session->data['voucher']);
			unset($this->session->data['vouchers']);
			
      		$this->redirect($this->url->link('account/logout', '', 'SSL'));
    	}
 
    	$this->data['breadcrumbs'] = array();

      	$this->data['breadcrumbs'][] = array(
        	'text'      => __('text_home'),
			'href'      => $this->url->link('common/home'),        	
        	'separator' => false
      	);
      	
		$this->data['breadcrumbs'][] = array(
        	'text'      => __('text_account'),
			'href'      => $this->url->link('account/account', '', 'SSL'),       	
        	'separator' => __('text_separator')
      	);
		
      	$this->data['breadcrumbs'][] = array(
        	'text'      => __('text_logout'),
			'href'      => $this->url->link('account/logout', '', 'SSL'),
        	'separator' => __('text_separator')
      	);	
		
    	$this->data['heading_title'] = __('heading_title');

    	$this->data['text_message'] = __('text_message');

    	$this->data['button_continue'] = __('button_continue');

    	$this->data['continue'] = $this->url->link('common/home');

    	echo __('You have logged out successfully');			
  	}
}
?>