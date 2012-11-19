<?php
class impresscart_report_coupon_model extends impresscart_model {
	public function getCoupons($data = array()) {
            
            global $wpdb;
            $sql = "SELECT * 
            FROM $wpdb->posts p WHERE p.post_type = 'coupon' 
            ";
            
            $posts = $wpdb->get_results($sql);
         
            $arr_results = array();
            
            if (!empty($data['filter_date_start'])) {
 			$implode[] = "DATE(c.date_added) >= '" . $this->db->escape($data['filter_date_start']) . "'";
            }

            if (!empty($data['filter_date_end'])) {
                    $implode[] = "DATE(c.date_added) <= '" . $this->db->escape($data['filter_date_end']) . "'";
            }
            
            if(count($posts)) {
                for($i=0;$i<count($posts);$i++) {
                	$post = $posts[$i];
                    $order_count = 0;
                    $coupon_amount = 0;
                    $coupon_history = get_post_meta($post->ID, 'coupon_history', true);
                    $coupon_code = get_post_meta($post->ID, 'coupon_code', true);
                    if($coupon_history != '') {
                    	foreach($coupon_history as $item) {
	                        $order_count++;
	                        $coupon_amount += $item['amount'];    
	                    } 	
                    }
                    $arr_results[] = array(  
                    	'id'   => $post->ID,
                        'name' => $post->post_title,
                        'code' => $coupon_code,
                        'total' => $coupon_amount,
                        'orders' => $order_count,                            
                    );
                }
            }
            
            return $arr_results;

	}	
	
	public function getTotalCoupons($data = array()) {
		$sql = "SELECT COUNT(DISTINCT coupon_id) AS total FROM `" . DB_PREFIX . "coupon_history`";
		
		$implode = array();
		
		if (!empty($data['filter_date_start'])) {
			$implode[] = "DATE(date_added) >= '" . $this->db->escape($data['filter_date_start']) . "'";
		}

		if (!empty($data['filter_date_end'])) {
			$implode[] = "DATE(date_added) <= '" . $this->db->escape($data['filter_date_end']) . "'";
		}

		if ($implode) {
			$sql .= " WHERE " . implode(" AND ", $implode);
		}

		$query = $this->db->query($sql);

		return $query->row['total'];	
	}		
}
?>