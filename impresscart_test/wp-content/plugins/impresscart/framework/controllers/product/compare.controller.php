<?php  

class impresscart_product_compare_controller extends impresscart_framework_controller {
	
	
	public function index() { 
				
		if (!isset($this->session->data['compare'])) {
			$this->session->data['compare'] = array();
		}	
				
		if (isset($_GET['remove'])) {
			$key = array_search($_GET['remove'], $this->session->data['compare']);
				
			if ($key !== false) {
				unset($this->session->data['compare'][$key]);
			}
		
			$this->session->data['success'] = __('Success: You have modified your product comparison!');
		
			$this->redirect($this->url->link('product/compare'));
		}
		
		$this->data['heading'] = __('Product Comparison');

		$this->data['text_product'] = __('Product Details');
		$this->data['text_name'] = __('Product');
		$this->data['text_image'] = __('Image');
		$this->data['text_price'] = __('Price');
		$this->data['text_model'] = __('Model');
		$this->data['text_manufacturer'] = __('Brand');
		$this->data['text_availability'] = __('Availability');
		$this->data['text_rating'] = __('Rating');
		$this->data['text_summary'] = __('Summary');
		$this->data['text_weight'] = __('Weight');
		$this->data['text_dimension'] = __('Dimensions (L x W x H)');
		$this->data['text_empty'] = __('You have not chosen any products to compare.');
		
		$this->data['button_continue'] = __('Continue');
		$this->data['button_cart'] = __('Add To Cart');
		$this->data['button_remove'] = __('Remove');
		$this->data['continue'] = get_bloginfo('url');
		
		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
			
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}
								
		$this->data['products'] = array();
		
		$this->data['attribute_groups'] = array();
		
		$productModel = impresscart_framework::model('catalog/product');

		foreach ($this->session->data['compare'] as $key => $product_id) {

			$product_info = $productModel->getProduct($product_id);
			
			if ($product_info) {
				
				$post = $product_info->post;
				
				$gattributes = get_post_meta($post->ID, 'impresscart_product_general_attributes', true);
				
				$price_value = @$gattributes['PRICE']['value'];
				$tax_class_id = @$gattributes['tax_class_id'];
				$special_value = @$gattributes['SPECIAL']['value'];
				
								
				if (($this->config->get('customer_price') && $this->customer->isLogged()) || !$this->config->get('customer_price')) {
					$price = $this->currency->format($this->tax->calculate($price_value, $tax_class_id, $this->config->get('tax')));
				} else {
					$price = false;
				}
				
			
				if ($product_info->quantity <= 0) {
					$availability = $product_info->stock_status;
				} elseif ($this->config->get('stock_display')) {
					$availability = $product_info->quantity;
				} else {
					$availability = __('In Stock');
				}				
				
				/* $attribute_data = array();
				
				$attribute_groups = $this->model_catalog_product->getProductAttributes($product_id);
				
				foreach ($attribute_groups as $attribute_group) {
					foreach ($attribute_group['attribute'] as $attribute) {
						$attribute_data[$attribute['attribute_id']] = $attribute['text'];
					}
				} */
				
				$attribute_data = array();
																			
				$this->data['products'][$product_id] = array(
					'product_id'   => $product_id,
					'name'         => $post->post_title,
					'thumb'        => '',
					'price'        => $price,
					'special'      => $productModel->getSpecialsByUserRole($post->ID),
					'description'  => $post->post_content,
					'model'        => $product_info->model,
					'manufacturer' => $productModel->getBrand($post->ID),
					'availability' => $availability,
					'rating'       => 0, //TODO
					'reviews'      => sprintf(__('Based on %s reviews.'), (int)$product_info->reviews),
					'weight'       => $this->weight->format($product_info->weight, @$gattributes['weight_class_id']),
					'length'       => $this->length->format($product_info->length, @$gattributes['length_class_id']),
					'width'        => $this->length->format($product_info->width, @$gattributes['length_class_id']),
					'height'       => $this->length->format($product_info->height, @$gattributes['length_class_id']),
					'attribute'    => $attribute_data,
					'href'         => get_permalink($product_id),
					'remove'       => $this->url->link('product/compare', 'remove=' . $product_id)
				);
				
				/* foreach ($attribute_groups as $attribute_group) {
					$this->data['attribute_groups'][$attribute_group['attribute_group_id']]['name'] = $attribute_group['name'];
					
					foreach ($attribute_group['attribute'] as $attribute) {
						$this->data['attribute_groups'][$attribute_group['attribute_group_id']]['attribute'][$attribute['attribute_id']]['name'] = $attribute['name'];
					}
				}*/
			} else {
				unset($this->session->data['compare'][$key]);
			}
		}
  	}
	
	public function add() {
		
		$this->autoRender = false;
		
		$json = array();

		if (!isset($this->session->data['compare'])) {
			$this->session->data['compare'] = array();
		}
				
		if (isset($_POST['product_id'])) {
			$product_id = $_POST['product_id'];
		} else {
			$product_id = 0;
		}
				
		$product_info = $this->model_catalog_product->getProduct($product_id);
		
		if ($product_info) {
			if (!in_array($_POST['product_id'], $this->session->data['compare'])) {	
				if (count($this->session->data['compare']) >= 4) {
					array_shift($this->session->data['compare']);
				}
				
				$this->session->data['compare'][] = $_POST['product_id'];
			}
			 
			$json['success'] = sprintf(__('Success: You have added <a href="%s">%s</a> to your <a href="%s">product comparison</a>!'), $this->url->link('product/product', 'product_id=' . $product_id), $product_info->post->post_name, $this->url->link('product/compare'));				
		
			$json['total'] = sprintf(__('Product Compare (%s)'), (isset($this->session->data['compare']) ? count($this->session->data['compare']) : 0));
		}	

		echo json_encode($json);
	}
}
?>