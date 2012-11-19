<?php 
class impresscart_checkout_shipping_controller extends impresscart_framework_controller {
	
  	public function index() {
	
  		$this->autoRender = false;
  		
		$json = array();

		$address_model = impresscart_framework::model('account/address');
		
		if ($this->customer->isLogged()) {					
			$shipping_address = $address_model->getAddress($this->session->data['shipping_address_id']);		
		} elseif (isset($this->session->data['guest'])) {
			$shipping_address = $this->session->data['guest']['shipping'];
		}	
		
		if (empty($shipping_address)) {								
			//$json['redirect'] = $this->url->link('checkout/checkout', '', 'SSL');
		}
				
		if ((!$this->cart->hasProducts() && (!isset($this->session->data['vouchers']) || !$this->session->data['vouchers'])) || (!$this->cart->hasStock() && !$this->config->get('stock_checkout'))) {
			$json['redirect'] = $this->url->link('checkout/cart');				
		}	
		
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		
			if (!$json) {
				if (!isset($_POST['shipping_method'])) {
					$json['error']['warning'] = __('You have not selected shipping method!!!');
				} else {
					$shipping = $_POST['shipping_method'];
					if (!isset($this->session->data['shipping_methods'][$shipping]['quote'][$shipping])) {			
						$json['error']['warning'] = __('Shipping method error');
					}
				}			
			}
			
			if (!$json) {
				$shipping = explode('.', $_POST['shipping_method']);

				$this->session->data['shipping_method'] = $this->session->data['shipping_methods'][$shipping[0]]['quote'][$shipping[0]];
				
				$this->session->data['comment'] = strip_tags($_POST['comment']);
			}			
		} else {
			
			if (isset($shipping_address)) {
				
				if (!isset($this->session->data['shipping_methods'])) {
					$quote_data = array();
					
					// Shipping Methods
					$method_data = array();				
					$methods = impresscart_shipping_methods::get_enabled_shipping_methods();
					
					foreach ($methods as $method) {
											
						$shipping_model = impresscart_framework::model('shipping/' . $method['code']);												
						$quote = $shipping_model->getQuote($shipping_address); 		
							
						if ($quote) {
							$quote_data[$method['code']] = array( 
								'title'      => $quote['title'],
								'quote'      => $quote['quote'], 
								'sort_order' => $quote['sort_order'],
								'error'      => $quote['error']
							);
						}						 
					}
					
					$sort_order = array();
				  
					foreach ($quote_data as $key => $value) {
						$sort_order[$key] = $value['sort_order'];
					}
			
					array_multisort($sort_order, SORT_ASC, $quote_data);
					
					$this->session->data['shipping_methods'] = $quote_data;
				}
				
				
				
			}
						
			$this->data['text_shipping_method'] = __('Select shipping method:');
			$this->data['text_comments'] = __('Comments');
		
			$this->data['button_continue'] = __('Continue');
			
			if (isset($this->session->data['shipping_methods']) && !$this->session->data['shipping_methods']) {
				$this->data['error_warning'] = sprintf(__('Warning: No Shipping options are available. Please <a href="%s">contact us</a> for assistance!'), get_permalink($this->config->get('contact')));
			} else {
				$this->data['error_warning'] = '';
			}	
						
			if (isset($this->session->data['shipping_methods'])) {
				$this->data['shipping_methods'] = $this->session->data['shipping_methods']; 
			} else {
				$this->data['shipping_methods'] = array();
			}
			
			if (isset($this->session->data['shipping_method']['code'])) {
				$this->data['code'] = $this->session->data['shipping_method']['code'];
			} else {
				$this->data['code'] = '';
			}
			
			if (isset($this->session->data['comment'])) {
				$this->data['comment'] = $this->session->data['comment'];
			} else {
				$this->data['comment'] = '';
			}
			
	        $json['output'] = $this->render();
		}	
		echo json_encode($json);
        exit(0);
  	}
}
?>