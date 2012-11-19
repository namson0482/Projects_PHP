<?php
class impresscart_checkout_coupon_model extends impresscart_model {


	function getAllCouponPosts() {
		global $wpdb;
		$coupon_posts = $wpdb->get_results("
	      SELECT post_id
	      FROM $wpdb->postmeta
	      WHERE $wpdb->postmeta.meta_key LIKE 'coupon_code'
	     ");
		return $coupon_posts;
	}
	 
	function getCoupon($coupon_code) {
	
		//$coupon_code =  $code[0]['code'];

		$coupon_posts = $this->getAllCouponPosts();
		foreach( $coupon_posts as $coupon_post ) {
			$temp_coupon_code = get_post_meta($coupon_post->post_id, 'coupon_code',true);
			if( $coupon_code == $temp_coupon_code ) {
				$coupon_data = get_post_meta($coupon_post->post_id, 'data',true);
				return $coupon_data;
			}
		}
		return null;


	}

	public function redeem($coupon_id, $order_id, $customer_id, $amount) {
		$coupon_data = array(
         'coupon_id' => $coupon_id,
         'customer_id' => $this->customer->getId(),
         'amount' => $amount,  
         'date' => time(),
		);
			
		add_post_meta($order_id, 'coupon', $coupon_data);
	}



	function updateHistory(){
		if( @$this->session->data['coupon'] ){
			$coupon_model = impresscart_framework::model('sale/coupon');
			foreach( $this->session->data['coupon'] as $coupon ){
				$coupon_post_id = $coupon_model->getCouponPostId($coupon['code']);
				//          $firephp->log($coupon_post_id, 'coupon post id');
				// assumption: once a coupon is in cart, it certainly exists in the database
				$coupon_history = get_post_meta($coupon_post_id[0]->post_id, 'coupon_history');
				//          $firephp->log($coupon_history, 'coupon history');
				$new_coupon_history_entry = array(
            'order_id' => $this->session->data['order_id'],
            'customer' => $this->session->data['customer_id'],
            'amount' => $coupon['coupon_discount'],
            'date_added' => date("Y-m-d")
				);
				// if coupon_history postmeta have not existed, add new to db
				if( !$coupon_history ){
					$coupon_history = array();
					$coupon_history[] = $new_coupon_history_entry;
					update_post_meta($coupon_post_id[0]->post_id, 'coupon_history', $coupon_history);
				} else { // if voucher_history postmeta have already existed, add new history entry, update postmeta
					$coupon_history = get_post_meta($coupon_post_id[0]->post_id, 'coupon_history');
					$coupon_history =  $coupon_history[0]; // get the first row of the result set (usually return in an array of results)
					$new_coupon_history = array();
					foreach( $coupon_history as $coupon_history_entry ){
						$new_coupon_history[] = $coupon_history_entry;
					}
					$new_coupon_history[] = $new_coupon_history_entry;
					update_post_meta($coupon_post_id[0]->post_id, 'coupon_history', $new_coupon_history);
				}
				//          $firephp->log($coupon_history, 'coupon history');
			}
		}
	}
}
?>