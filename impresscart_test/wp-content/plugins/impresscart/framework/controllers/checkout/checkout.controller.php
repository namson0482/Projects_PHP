<?php

class impresscart_checkout_checkout_controller extends impresscart_framework_controller {

	public function index() {
		
		//$this->cart		class 	impresscart_cart_service
		// Validate cart has products and has stock.
		if ((!$this->cart->hasProducts() && !empty($this->session->data['vouchers'])) 
			|| (!$this->cart->hasStock() && !$this->config->get('stock_checkout'))) {
			$this->redirect($this->url->link('checkout/cart'));
		}
			
		$products = $this->cart->getProducts();
		foreach ($products as $product) {
			$product_total = 0;
			foreach ($products as $product_2) {
				if ($product_2['product_id'] == $product['product_id']) {
					$product_total += $product_2['quantity'];
				}
			}
				
			if ($product['minimum'] > $product_total) {
				$this->redirect($this->url->link('checkout/cart'));
			}
		}
			
		$this->data['heading_title'] = __('Checkout');
		$this->data['text_checkout_option'] = __('Step 1: Checkout Options');
		$this->data['text_checkout_account'] = __('Step 2: Account &amp; Billing Details');
		$this->data['text_checkout_payment_address'] = __('Step 2: Billing Details');
		$this->data['text_checkout_shipping_address'] = __('Step 3: Delivery Details');
		$this->data['text_checkout_shipping_method'] = __('Step 4: Delivery Method');
		$this->data['text_checkout_payment_method'] = __('Step 5: Payment Method');
		$this->data['text_checkout_confirm'] = __('Step 6: Confirm Order');
		$this->data['text_modify'] = __('Modify &raquo;');		
		$this->data['logged'] = $this->customer->isLogged();
		$this->data['shipping_required'] =  $this->cart->hasShipping();

	}
}
?>