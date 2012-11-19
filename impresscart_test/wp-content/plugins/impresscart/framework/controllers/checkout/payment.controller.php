<?php  
class impresscart_checkout_payment_controller extends impresscart_framework_controller {
	
	
  	public function index() {
  		
		$this->autoRender = false;
				
		$json = array();
		
		$model_account_address = impresscart_framework::model('account/address');		
		
		if ($this->customer->isLogged()) {
			$payment_address = $model_account_address->getAddress($this->session->data['payment_address_id']);		
		} elseif (isset($this->session->data['guest'])) {
			$payment_address = $this->session->data['guest']['payment'];
		}	
	
			
		if ((!$this->cart->hasProducts() && (!isset($this->session->data['vouchers']) || !$this->session->data['vouchers'])) || (!$this->cart->hasStock() && !$this->config->get('stock_checkout'))) {
			$json['redirect'] = $this->url->link('checkout/cart');				
		}	
									
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			
			if (!$json) {
				if (!isset($_POST['payment_method'])) {
					$json['error']['warning'] = __('error_payment');
				} else {
					
					$payment_methods = $this->session->data['payment_methods'];
					
					if (!isset($payment_methods[$_POST['payment_method']])) {
						$json['error']['warning'] = __('error_payment');
					}
				}			
			}
			
			if (!$json) {
				$this->session->data['payment_method'] = $this->session->data['payment_methods'][$_POST['payment_method']];
			  
				$this->session->data['comment'] = strip_tags($_POST['comment']);
			}
		} else {
			
			if (!isset($this->session->data['payment_methods'])) {
				// Calculate Totals
				$total_data = array();					
				$total = 0;
				$taxes = $this->cart->getTaxes();
				// Payment Methods
				$method_data = array();			
				$method_data = impresscart_payment_methods::get_enabled_payment_methods();
				$sort_order = array(); 
			  
				if($method_data)
				{
					foreach ($method_data as $key => $value) {
						$sort_order[$key] = $value['sort_order'];
					}
				}
		
				array_multisort($sort_order, SORT_ASC, $method_data);			
				
				$this->session->data['payment_methods'] = $method_data;			
			}			
			
			$this->data['text_payment_method'] = __('Select payment method:');
			$this->data['text_comments'] = __('Comments');
	
			$this->data['button_continue'] = __('Continue:');
	   
			if (isset($this->session->data['payment_methods']) && !$this->session->data['payment_methods']) {
				$this->data['error_warning'] = sprintf(__('error_no_payment'), $this->url->link('information/contact'));
			} else {
				$this->data['error_warning'] = '';
			}	
	
			if (isset($this->session->data['payment_methods'])) {
				$this->data['payment_methods'] = $this->session->data['payment_methods']; 
			} else {
				$this->data['payment_methods'] = array();
			}
		  
			if (isset($this->session->data['payment_method']['code'])) {
				$this->data['code'] = $this->session->data['payment_method']['code'];
			} else {
				$this->data['code'] = '';
			}
			
			if (isset($this->session->data['comment'])) {
				$this->data['comment'] = $this->session->data['comment'];
			} else {
				$this->data['comment'] = '';
			}
			
			if ($this->config->get('checkout_id')) {
				$agree_post = get_post($this->config->get('checkout_id'));
				$this->data['text_agree'] = $agree_post->post_content;
			} else {
				$this->data['text_agree'] = '';
			}
			
			if (isset($this->session->data['agree'])) { 
				$this->data['agree'] = $this->session->data['agree'];
			} else {
				$this->data['agree'] = '';
			}
			
	        $json['output'] = $this->render();
		}
	    echo json_encode($json);
        exit(0);
  	}
}
?>