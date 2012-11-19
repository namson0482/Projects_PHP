<?php 
class impresscart_account_account_controller extends impresscart_framework_controller {
	 
	public function index() {
		
		$this->autoRender = true;
		if (!$this->customer->isLogged()) {	  
	  		$this->redirect($this->url->link('account/login', '', 'SSL'));
	  		return;
    	} 
		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
    		unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}
    	$this->data['heading_title'] = __('My Account');
    	$this->data['text_my_account'] = __('My Account');
		$this->data['text_my_orders'] = __('My Orders');
		$this->data['text_my_newsletter'] = __('Newsletter');
    	$this->data['text_edit'] = __('Edit your account information');
    	$this->data['text_password'] = __('Change your password');
    	$this->data['text_address'] = __('Modify your address book entries');
		$this->data['text_wishlist'] = __('Modify your wish list');
    	$this->data['text_order'] = __('View your order history');
    	$this->data['text_download'] = __('Downloads');
		$this->data['text_reward'] = __('Your Reward Points');
		$this->data['text_return'] = __('View your return requests');
		$this->data['text_transaction'] = __('Your Transactions');
		$this->data['text_newsletter'] = __('Subscribe / unsubscribe to newsletter');
    	$this->data['edit'] = $this->url->link('account/edit', '', 'SSL');
    	$this->data['password'] = $this->url->link('account/password', '', 'SSL');
		$this->data['address'] = $this->url->link('account/address', '', 'SSL');
		$this->data['wishlist'] = $this->url->link('account/wishlist');
    	$this->data['order'] = $this->url->link('account/order', '', 'SSL');
    	$this->data['download'] = $this->url->link('account/download', '', 'SSL');
		$this->data['reward'] = $this->url->link('account/reward', '', 'SSL');
		$this->data['return'] = $this->url->link('account/return', '', 'SSL');
		$this->data['transaction'] = '#';//$this->url->link('account/transaction', '', 'SSL');
		$this->data['newsletter'] = '#'; //$this->url->link('account/newsletter', '', 'SSL');	
		
  	}
}
?>