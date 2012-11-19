<?php

class impresscart_admin_payment_controller extends impresscart_framework_controller {	
	public function index()	{       
		$payment_methods = apply_filters('impresscart_payment_methods', array());	
		$this->data['payment_methods'] = $payment_methods;
		
		$this->data['pages'] = apply_filters('impresscart_administration_pages', array());
	}
}