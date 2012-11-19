<?php
class impresscart_checkout_voucher_model extends impresscart_model {
	
	public function addVoucher($order_id, $data) {
            $this->db->query("INSERT INTO " . DB_PREFIX . "voucher SET order_id = '" . (int)$order_id . "', code = '" . $this->db->escape(substr(md5(rand()), 0, 7)) . "', from_name = '" . $this->db->escape($data['from_name']) . "', from_email = '" . $this->db->escape($data['from_email']) . "', to_name = '" . $this->db->escape($data['to_name']) . "', to_email = '" . $this->db->escape($data['to_email']) . "', message = '" . $this->db->escape($data['message']) . "', amount = '" . (float)$data['amount'] . "', voucher_theme_id = '" . (int)$data['voucher_theme_id'] . "', status = '1', date_added = NOW()");
	}
	
	function getAllVoucherPosts() {
		global $wpdb;
		$voucher_posts = $wpdb->get_results("
	      SELECT post_id
	      FROM $wpdb->postmeta
	      WHERE $wpdb->postmeta.meta_key LIKE 'voucher_code'
	     ");
		return $voucher_posts;
	}
	
	public function getVoucher($voucher_code) {
		//$voucher_code = $code[0]['code'];
		
		$voucher_posts = $this->getAllVoucherPosts();
		foreach( $voucher_posts as $voucher_post ) {
			$temp_voucher_code = get_post_meta($voucher_post->post_id, 'coupon_code',true);
			if( $temp_voucher_code == $temp_voucher_code ) {
				$voucher_data = get_post_meta($voucher_post->post_id, 'data',true);
				return $voucher_data;
			}
		}
		return null;
		
	}
	
	function getVoucherPostId( $voucher_code ) {
	    global $wpdb;
	    $voucher_post = $wpdb->get_results("
	      SELECT post_id
	      FROM $wpdb->postmeta
	      WHERE $wpdb->postmeta.meta_key LIKE 'voucher_code'
	      AND $wpdb->postmeta.meta_value LIKE '" . $voucher_code . "'"
	     );
	    return $voucher_post;
	}
	
	/*
	  
	 */
	
	
	public function confirm($order_id) {
		
		$order_info = $this->model_checkout_order->getOrder($order_id);
		
		if ($order_info) {
			
			//$voucher_query = $this->db->query("SELECT *, vtd.name AS theme FROM `" . DB_PREFIX . "voucher` v LEFT JOIN " . DB_PREFIX . "voucher_theme vt ON (v.voucher_theme_id = vt.voucher_theme_id) LEFT JOIN " . DB_PREFIX . "voucher_theme_description vtd ON (vt.voucher_theme_id = vtd.voucher_theme_id) AND vtd.language_id = '" . (int)$order_info['language_id'] . "' WHERE order_id = '" . (int)$order_id . "'");
                        $rows = get_post_meta($order_id, '');
			
			foreach ($rows as $voucher) {
				// HTML Mail
                               ob_start();
                                    impresscart_framework::getInstance()->dispatch('/template/mail/voucher');
                                    $html .= ob_get_contents();
                               ob_end_clean();
					
				//$this->mail = new Mail(); 
				$this->mail->protocol = $this->config->get('mail_protocol');
				$this->mail->parameter = $this->config->get('mail_parameter');
				$this->mail->hostname = $this->config->get('smtp_host');
				$this->mail->username = $this->config->get('smtp_username');
				$this->mail->password = $this->config->get('smtp_password');
				$this->mail->port = $this->config->get('smtp_port');
				$this->mail->timeout = $this->config->get('smtp_timeout');			
				$this->mail->setTo($voucher['to_email']);
				$this->mail->setFrom($this->config->get('sender_email'));
				$this->mail->setSender(get_bloginfo('name'));
				$this->mail->setSubject(sprintf(__('text_subject'), $voucher['from_name']));
				$this->mail->setHtml($html);
				
//				if (file_exists(DIR_IMAGE . $voucher['image'])) {
//					$this->mail->addAttachment(DIR_IMAGE . $voucher['image'], md5(basename($voucher['image'])));
//				}
				
				$this->mail->send();		
			}
		}
	}
	
	public function redeem($voucher_id, $order_id, $amount) {
		//$this->db->query("INSERT INTO `" . DB_PREFIX . "voucher_history` SET voucher_id = '" . (int)$voucher_id . "', order_id = '" . (int)$order_id . "', amount = '" . (float)$amount . "', date_added = NOW()");
                 $voucher_data = array(
                        'voucher_id' => $voucher_id,                        
                        'amount' => $amount,  
                        'date' => time(),
                    );

                    add_post_meta($order_id, 'coupon', $voucher_data);
            
	}
        
        
        
  public function updateHistory(){
    //add vouchers (if exists) from cart to voucher history in database
    if( @$this->session->data['voucher'] ){
      $voucher_model = impresscart_framework::model('sale/voucher');
      foreach( $this->session->data['voucher'] as $voucher ){
        $voucher_post_id = $voucher_model->getVoucherPostId($voucher['code']);
        //$firephp->log($voucher_post_id, 'voucher post id');
        // assumption: once a voucher is in cart, it certainly exists in the database
        $voucher_history = get_post_meta($voucher_post_id[0]->post_id, 'voucher_history');
        //$firephp->log($voucher_history, 'voucher history');
        $new_voucher_history_entry = array(
            'order_id' => $this->session->data['order_id'],
            'customer' => $this->session->data['customer_id'],
            'amount' => $voucher['amount'],
            'date_added' => date("Y-m-d")
        );
        // if voucher_history postmeta have not existed, add new to db 
        if( !$voucher_history ){
          $voucher_history = array();
          $voucher_history[] = $new_voucher_history_entry;
          update_post_meta($voucher_post_id[0]->post_id, 'voucher_history', $voucher_history);
        } else { // if voucher_history postmeta have already existed, add new history entry, update postmeta
          $voucher_history = get_post_meta($voucher_post_id[0]->post_id, 'voucher_history');
          $voucher_history =  $voucher_history[0]; // get the first row of the result set (usually return in an array of results)
          $new_voucher_history = array();
          foreach( $voucher_history as $voucher_history_entry ){
            $new_voucher_history[] = $voucher_history_entry; 
          }
          $new_voucher_history[] = $new_voucher_history_entry;
          update_post_meta($voucher_post_id[0]->post_id, 'voucher_history', $new_voucher_history);
        }
//          $firephp->log($voucher_history, 'voucher history');
      }
    }    
  }
        
        
}
?>