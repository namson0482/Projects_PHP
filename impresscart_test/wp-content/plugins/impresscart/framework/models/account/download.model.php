<?php
class impresscart_account_download_model extends impresscart_model {
	
	public function getDownload($order_id, $download_id) {
		
		$post = get_post($order_id);
		$products = get_post_meta($order_id, 'products', true);
		
		foreach($products as $product)
		{
			if(isset($product['download']))
			{
				foreach($product['download'] as $download)
				{
					if($download['download_id'] == $download_id)
					{
						if((int)$download['remaining'] > 0)
						return $download;
					}
				}
			}
		}
	}
	
	public function getDownloads($start = 0, $limit = 20) {

		$args = array(
			'meta_key'        => 'customer_id',
		    'meta_value'      => $this->customer->getId(),
		    'post_type'       => Goscom::GOSCOM_ORDER_POSTTYPE,
		    'post_status'     => 'publish' 		
		);
		$downloads = array();
		$posts = get_posts($args);
				
		foreach($posts as $post)
		{
			$products = get_post_meta($post->ID, 'products', true);
						
			foreach($products as $product)
			{
				if(isset($product['download']))
				{
					foreach($product['download'] as $download)
					{
						$download['order_id'] = $post->ID;
						$downloads[] = $download;
					}	
				}				
			}
		}
		
		return $downloads;
	}
	
	public function updateRemaining($order_id, $download_id) {
		$post = get_post($order_id);
		$products = get_post_meta($order_id, 'products', true);
		$update_products = array();
		foreach($products as $product)
		{
			if(isset($product['download']))
			{
				$downloads = array();
				foreach($product['download'] as $download)
				{
					if($download['download_id'] == $download_id)
					{
						$download['remaining'] = (int)$download['remaining'] - 1;
						
					}
					$downloads[] = $download;
				}
				
				$product['download'] = $downloads;
			}
			$update_products[] = $product;
		}
		update_post_meta($order_id, 'products', $update_products);
	}
	
	public function getTotalDownloads() {
		
		$args = array(
			'meta_key'        => 'customer_id',
		    'meta_value'      => $this->customer->getId(),
		    'post_type'       => Goscom::GOSCOM_ORDER_POSTTYPE,
		    'post_status'     => 'publish' 		
		);
		$total = 0;
		$posts = get_posts($args);
		foreach($posts as $post)
		{
			$products = get_post_meta($post->ID, 'products', true);
			
			foreach($products as $product)
			{
				if(isset($product['download']))
				{
					$total += count($product['download']);	
				}				
			}
		}		
		return $total;
	}	
}
?>