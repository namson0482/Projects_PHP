<?php
class impresscart_report_product_model extends impresscart_model {
	
	public function getProductsViewed($data = array()) {
        global $wpdb;
        $sql = "SELECT p.ID, p.post_title as name, m.meta_value as viewed
                    FROM $wpdb->posts p
                    INNER JOIN $wpdb->postmeta AS m ON p.ID = m.post_id
                    WHERE p.post_type = 'product' and m.meta_key in ('product_view')                                      
                    ";
        $results = $wpdb->get_results($sql, ARRAY_A);
        return $results;
	}	
	
	public function getTotalProductsViewed() {
        global $wpdb;
        $sql = "SELECT count(p.ID) as total 
                    FROM $wpdb->posts p
                    INNER JOIN $wpdb->postmeta AS m ON p.ID = m.post_id
                    WHERE p.post_type = 'product' AND m.meta_key in ('product_view') AND m.meta_value > 0                                      
                    ";
        $result = $wpdb->get_var($sql);
        return $result;
	}
	
	public function getTotalProductViews() {
      	global $wpdb;
        $sql = "SELECT sum(m.meta_value) as total 
                    FROM $wpdb->posts p
                    INNER JOIN $wpdb->postmeta AS m ON p.ID = m.post_id
                    WHERE p.post_type = 'product' AND m.meta_key in ('product_view')                                      
                    ";
        $result = $wpdb->get_var($sql);
        return $result;
	}
			
	public function reset() {
		$this->db->query("UPDATE " . DB_PREFIX . "product SET viewed = '0'");
	}
	
	public function getPurchased($data = array()) {
		$sql = "SELECT op.name, op.model, SUM(op.quantity) AS quantity, SUM(op.total + op.total * op.tax / 100) AS total FROM " . DB_PREFIX . "order_product op LEFT JOIN `" . DB_PREFIX . "order` o ON (op.order_id = o.order_id)";
		
		if (!is_null($data['filter_order_status_id'])) {
			$sql .= " WHERE o.order_status_id = '" . (int)$data['filter_order_status_id'] . "'";
		} else {
			$sql .= " WHERE o.order_status_id > '0'";
		}
		
		if (!empty($data['filter_date_start'])) {
			$sql .= " AND DATE(o.date_added) >= '" . $this->db->escape($data['filter_date_start']) . "'";
		}

		if (!empty($data['filter_date_end'])) {
			$sql .= " AND DATE(o.date_added) <= '" . $this->db->escape($data['filter_date_end']) . "'";
		}
		
		$sql .= " GROUP BY op.model ORDER BY total DESC";
					
		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}			

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}	
			
			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}
		
		$query = $this->db->query($sql);
	
		return $query->rows;
	}
	
	public function getTotalPurchased($data) {
      	$sql = "SELECT COUNT(DISTINCT op.model) AS total FROM `" . DB_PREFIX . "order_product` op LEFT JOIN `" . DB_PREFIX . "order` o ON (op.order_id = o.order_id)";

		if (!is_null($data['filter_order_status_id'])) {
			$sql .= " WHERE o.order_status_id = '" . (int)$data['filter_order_status_id'] . "'";
		} else {
			$sql .= " WHERE o.order_status_id > '0'";
		}
		
		if (!empty($data['filter_date_start'])) {
			$sql .= " AND DATE(o.date_added) >= '" . $this->db->escape($data['filter_date_start']) . "'";
		}

		if (!empty($data['filter_date_end'])) {
			$sql .= " AND DATE(o.date_added) <= '" . $this->db->escape($data['filter_date_end']) . "'";
		}
		
		$query = $this->db->query($sql);
				
		return $query->row['total'];
	}
    
    function getProductView($ID){
        $count_key = 'product_view';
        $count = get_post_meta($ID, $count_key, true);
        if($count==''){
            delete_post_meta($ID, $count_key);
            add_post_meta($ID, $count_key, '0');
            return 0;
        }
        return $count;
    }
}
?>