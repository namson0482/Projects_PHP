<?php
class impresscart_account_return_model extends impresscart_model {
	
	public function addReturn($data) {			      	
		$postarr = array(
			'post_title' => __('Return for order #') . $data['order_id'],
			'post_content' => $data['comment'],
			'post_type' => 'return',
			'post_status' => 'publish',
		);
		$post_id = wp_insert_post($postarr);
		if($post_id)
		{
			update_post_meta($post_id, 'data', $data);
			update_post_meta($post_id, 'customer', $this->customer->getId());
			update_post_meta($post_id, 'order',$data['order_id']);
			
		} else {
			return false;
		}
		return $post_id;
	}
	
	public function getReturn($return_id) {
		$post = get_post($return_id);
		if($post->post_type == 'return')
		{
			$data = get_post_meta($post->ID, 'data', true);
			$data['return_id'] = $post->ID;
			$data['status'] = $this->table_order_status->fetchOne(
				array(
					'conditions' => array(
						'order_status_id' => $data['status_id']
					)
				)
			);
			$data['date_added'] = $post->post_date;
			return $data;
		}
		return false;
	}
	
	public function getReturns($start = 0, $limit = 20) {
		$args = array(
			'numberposts' => $limit,
			'offset' => $start,
			'post_type' => 'return',
			'meta_key' => 'customer',
			'meta_value' => $this->customer->getId(),
		);
		
		
		$posts = get_posts($args);
		
		
		$returns = array();		
		foreach ($posts as $post)
		{
			$data = get_post_meta($post->ID, 'data', true);
			$data['return_id'] = $post->ID;
			$data['status'] = $this->table_order_status->fetchOne(
				array(
					'conditions' => array(
						'order_status_id' => $data['status_id']
					)
				)
			);
			$data['date_added'] = $post->post_date;
			$returns[] = $data; 
		}

		return $returns;
	}
			
	public function getTotalReturns() {
		$args = array(
			'post_type' => 'return',
			'meta_key' => 'customer',
			'meta_value' => $this->customer->getId(),
		);
		
		$results = get_posts($args);
		if(($results))
		{
			return count($results);
		}
		return 0;
	}
	
	public function getTotalReturnProductsByReturnId($return_id) {
		$post = get_post($return_id);
		if($post->post_type == 'return')
		{
			$data = get_post_meta($post->ID, 'data', true);
			return count($data['return_product']);
		}
		return 0;
	}	
	
	public function getReturnProducts($return_id) {
		$post = get_post($return_id);
		if($post->post_type == 'return')
		{
			$data = get_post_meta($post->ID, 'data', true);
			return ($data['return_product']);
		}
		return array();
	}	
	
	public function getReturnHistories($return_id) {
		return array();
	}			
	
	public function notify()
	{
		//sending email to the customer
	}
}
?>