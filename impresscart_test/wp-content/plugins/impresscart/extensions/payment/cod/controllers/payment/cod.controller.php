<?php
class impresscart_payment_cod_controller extends impresscart_framework_controller {	
	
	function index() {
			
		    $this->data['button_confirm'] = __('Confirm');
		    
			$this->data['continue'] = $this->url->link('checkout/success');	
			
	}
	
	function confirm() {
		
		$setting = $this->model_payment_cod->get_setting();
		$this->model_checkout_order->confirm($this->session->data['order_id'], Goscom::GOSCOM_ORDER_STATUS_ID_AFTER_CONFIRM);
		$this->autoRender = false;
		
	}
}
?>