<?php 
class impresscart_account_wishlist_controller extends impresscart_framework_controller {
	
	public function index() {
		
		var_dump('ccccccccccccccccc');
		
    	if (!$this->customer->isLogged()) {
	  		$this->session->data['redirect'] = $this->url->link('account/wishlist', '', 'SSL');
	  		$this->redirect($this->url->link('account/login', '', 'SSL')); 
    	}
		
		if (!isset($this->session->data['wishlist'])) {
			$this->session->data['wishlist'] = array();
		}
		
		if (isset($_POST['remove'])) {
			foreach ($_POST['remove'] as $product_id) {
				$key = array_search($product_id, $this->session->data['wishlist']);
				if ($key !== false) {
					unset($this->session->data['wishlist'][$key]);
				}
			}			
			
			$this->redirect($this->url->link('account/wishlist'));
		}
										
		$this->data['heading_title'] = __('Wishlist');	
		$this->data['text_empty'] = __('Your wish list is empty.');
     		
		$this->data['column_remove'] = __('Remove');
		$this->data['column_image'] = __('Image');
		$this->data['column_name'] = __('Product Name');
		$this->data['column_model'] = __('Model');
		$this->data['column_stock'] = __('In Stock');
		$this->data['column_price'] = __('Price');
		$this->data['column_cart'] = __('Add To Cart');
		$this->data['button_cart'] = __('Add To Cart');
		$this->data['button_update'] = __('Update');
		$this->data['button_continue'] = __('Continue');
		$this->data['button_back'] = __('Back');
		
		$this->data['action'] = $this->url->link('account/wishlist');	
		
		$this->data['products'] = array();
	
		foreach ($this->session->data['wishlist'] as $product_id) {
			$product_info = $this->model_catalog_product->getProduct($product_id);
			$post = $product_info->post;
			
			if ($product_info) { 
				
				$image = $this->model_catalog_product->getProductImage($post->ID);

				if ($product_info->quantity <= 0) {
					$stock = $product_info->stock_status;
				} elseif ($this->config->get('stock_display')) {
					$stock = $product_info->quantity;
				} else {
					$stock = __('In Stock');
				}
							
				if (($this->config->get('customer_price') && $this->customer->isLogged()) || !$this->config->get('customer_price')) {
					$price = $this->currency->format($this->tax->calculate($product_info->price, $product_info->tax_class_id, $this->config->get('tax')));
				} else {
					$price = false;
				}
				
				if ((float)$product_info->special) {
					$special = $this->currency->format($this->tax->calculate($product_info->special, $product_info->tax_class_id, $this->config->get('tax')));
				} else {
					$special = false;
				}
																			
				$this->data['products'][] = array(
					'product_id' => $product_id,
					'thumb'      => $image,
					'name'       => $product_info->name,
					'model'      => $product_info->model,
					'stock'      => $stock,
					'price'      => $price,		
					'special'    => $special,
					'href'       => get_permalink($product_id)
				);
			}
		}	

		$this->data['continue'] = $this->url->link('account/account', '', 'SSL');
		$this->data['back'] = $this->url->link('account/account', '', 'SSL');		
	}
	
	public function update() {
		
		$json = array();

		if (!isset($this->session->data['wishlist'])) {
			$this->session->data['wishlist'] = array();
		}
				
		if (isset($_POST['product_id'])) {
			$product_id = $_POST['product_id'];
		} else {
			$product_id = 0;
		}
		
		$product_info = $this->model_catalog_product->getProduct($product_id);
				
		if ($product_info) {
			if (!in_array($_POST['product_id'], $this->session->data['wishlist'])) {	
				$this->session->data['wishlist'][] = $_POST['product_id'];
			}
			 
			if ($this->customer->isLogged()) {			
				$json['success'] = sprintf(__('Success: You have added <a href="%s">%s</a> to your <a href="%s">wish list</a>!'), get_permalink($product_id), $product_info->post->post_title, $this->url->link('account/wishlist'));				
			} else {
				$json['success'] = sprintf(__('You must <a href="%s">login</a> or <a href="%s">create an account</a> to save <a href="%s">%s</a> to your <a href="%s">wish list</a>!'), $this->url->link('account/login', '', 'SSL'), $this->url->link('account/register', '', 'SSL'), get_permalink($product_id), $product_info->post->post_name, $this->url->link('account/wishlist'));				
			}
			
			$json['total'] = sprintf(__('Wish List (%s)'), (isset($this->session->data['wishlist']) ? count($this->session->data['wishlist']) : 0));
		}
		$this->autoRender = false;
		echo json_encode($json);
	}		
}
?>
