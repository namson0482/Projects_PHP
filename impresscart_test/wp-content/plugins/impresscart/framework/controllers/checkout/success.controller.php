<?php 
class impresscart_checkout_success_controller extends impresscart_framework_controller { 
	
	public function index() { 

		if (isset($this->session->data['order_id'])) {
			$this->cart->clear();
			
			unset($this->session->data['shipping_method']);
			unset($this->session->data['shipping_methods']);
			unset($this->session->data['payment_method']);
			unset($this->session->data['payment_methods']);
			unset($this->session->data['guest']);
			unset($this->session->data['comment']);
			unset($this->session->data['order_id']);	
			unset($this->session->data['coupon']);
			unset($this->session->data['reward']);
			unset($this->session->data['voucher']);
			unset($this->session->data['vouchers']);
		}	
		
    	$this->data['heading_title'] = __('Your Order Has Been Processed!');

		if ($this->customer->isLogged()) {
    		$this->data['text_message'] = sprintf(__('<p>Your order has been successfully processed!</p><p>You can view your order history by going to the <a href="%s">my account</a> page and by clicking on <a href="%s">history</a>.</p>If your purchase has an associated download, you can goto the account <a href="%s">downloads</a> page to view them.</p><p>Please direct any questions you have to the <a href="%s">store owner</a>.</p><p>Thanks for shopping with us online!</p>'), $this->url->link('account/account', '', 'SSL'), $this->url->link('account/order', '', 'SSL'), $this->url->link('account/download', '', 'SSL'), $this->url->link('information/contact'));
		} else {
    		$this->data['text_message'] = sprintf(__('<p>Your order has been successfully processed!</p><p>Please direct any questions you have to the <a href="%s">store owner</a>.</p><p>Thanks for shopping with us online!'), $this->url->link('information/contact'));
		}
		
    	$this->data['button_continue'] = __('Continue');

    	$this->data['continue'] = $this->url->link('common/home');		
  	}
}
?>