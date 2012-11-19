<?php

class impresscart_product_elements_controller extends impresscart_framework_controller {

	public function product_form_buy() {
		
		// display option to select
		require_once IMPRESSCART_CLASSES . '/impresscart_option.php';
		global $post;
		$productModel = impresscart_framework::model('catalog/product');
		$product = $productModel->getProduct($post->ID);
		$this->data['options'] = $productModel->getUsedOptions($post);		
		$this->data['product_options'] = $productModel->getOptions($post);
		$gattributes = get_post_meta($post->ID, 'impresscart_product_general_attributes', true);
		$this->data['main_image']   = $productModel->getProductImage($post->ID);
		$this->data['thumb_width'] = $this->config->get('product_image_thumb_width');
		$this->data['thumb_height'] = $this->config->get('product_image_thumb_height');		
		$this->data['images'] = $productModel->getProductImages($post->ID);		
		$this->data['price']		= $gattributes['PRICE']['value'];		
		if(isset($gattributes['tax_class_id']))
		{
			$this->data['tax'] = $this->currency->format($this->tax->calculate($this->data['price'], $gattributes['tax_class_id'], $this->config->get('tax')));
		} 		
		$this->data['main_price'] 	= impresscart_framework::service('currency')->format($this->data['price']);
		$this->data['discounts'] =  $productModel->getDiscountsByUserRole($post->ID);
   		$this->data['specials'] =  $productModel->getSpecialsByUserRole($post->ID);
		$this->data['reward_points'] = $productModel->getRewardPoints($post->ID);
		$this->data['point'] = $productModel->getUserRewardPoints($post->ID);
		$this->data['brand'] = $productModel->getBrand($post->ID);
		$this->data['model'] = $product->model;
		$this->data['availability'] = $product->availability;
		$this->data['ID'] = $post->ID;
	}

	public function product_form_buy_listing() {
		// display option to select
		require_once IMPRESSCART_CLASSES . '/impresscart_option.php';
		global $post;
		$productModel = impresscart_framework::model('catalog/product');
		$this->data['options'] = $productModel->getUsedOptions($post);
		$this->data['product_options'] = $productModel->getOptions($post);
		$gattributes = get_post_meta($post->ID, 'impresscart_product_general_attributes', true);
		$this->data['price']		= $gattributes['PRICE']['value'];
		$this->data['main_price'] 	= impresscart_framework::service('currency')->format($this->data['price']);
		$this->data['main_image']   = $productModel->getProductImage($post->ID);
		$this->data['thumb_width'] = $this->config->get('product_image_thumb_width');
		$this->data['thumb_height'] = $this->config->get('product_image_thumb_height');
		$this->data['ID'] = $post->ID;
	}

	public function product_attributes() {
		require_once IMPRESSCART_CLASSES . '/impresscart_attribute.php';
		global $post;
		$this->data['attributes'] = (array)impresscart_attribute::dbGetAllGrouped();
		$this->data['postmeta'] = (array)get_post_meta($post->ID, 'impresscart_product_attributes', true);
	}

	public function product_options() {
		global $post;
	}
	
	public function product_related()
	{
		global $post;
		$this->data['related_products'] = $this->model_catalog_product->getProductRelated($post->ID);
		$this->data['width'] = $this->config->get('product_list_image_width');
		$this->data['height'] = $this->config->get('product_list_image_height');
	}
}
