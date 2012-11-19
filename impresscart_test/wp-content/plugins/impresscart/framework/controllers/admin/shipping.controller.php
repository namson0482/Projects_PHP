<?php

class impresscart_admin_shipping_controller extends impresscart_framework_controller {	
	public function index() {       
		$shipping_methods = apply_filters('impresscart_shipping_methods', array());	
		$this->data['shipping_methods'] = $shipping_methods;
		$this->data['pages'] = apply_filters('impresscart_administration_pages', array());
	}
}