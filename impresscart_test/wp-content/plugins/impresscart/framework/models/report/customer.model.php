<?php
class impresscart_report_customer_model extends impresscart_model {

	public function getOrders($data = array()) {

		global $wpdb;
		$sql = "SELECT DISTINCT m.meta_value as user_id FROM $wpdb->postmeta m WHERE m.meta_key='customer_id'";
		$customers = $wpdb->get_results($sql);
		$results = array();
		if(count($customers) > 0) {
			//foreach($customers as $obj) {
			for($i=0;$i<count($customers);$i++) {
				$obj = $customers[$i];
				$sql = "SELECT p.ID as ID from $wpdb->posts p ";
				$sql .= "INNER JOIN $wpdb->postmeta m ON p.ID = m.post_id";
				$sql .= " WHERE p.post_type = '". Goscom::GOSCOM_ORDER_POSTTYPE . "' AND m.meta_key='customer_id' AND m.meta_value='" .$obj->user_id ."'";

				if(!empty($data['filter_date_start'])) {
					$sql .= " AND DATE(p.post_date) >= '" . $wpdb->escape($data['filter_date_start']) . "'";
				}
				if (!empty($data['filter_date_end'])) {
					$sql .= " AND DATE(p.post_date) <= '" . $wpdb->escape($data['filter_date_end']) . "'";
				}
				$rows = $wpdb->get_results($sql);
				$orders = 0;
				$total = 0;
				$products = 0;
				foreach($rows as $item ) {
					$order_status_id = get_post_meta($item->ID, 'order_status', true);
					if (!is_null($data['filter_order_status_id'])) {
						if($order_status_id == (int)$data['filter_order_status_id'])
						{
							$total += get_post_meta($item->ID, 'order_total', true);
							$orders += 1;
							$products += (get_post_meta($item->ID, 'order_quantity', true));

						} else {
							if($order_status_id > 0)
							{
								$total += get_post_meta($item->ID, 'order_total', true);
								$orders += 1;
								$products += (get_post_meta($item->ID, 'order_quantity', true));
							}
						}
					}
				}
				$user_data = get_userdata($obj->user_id);
				$results[] = array(
                            'customer' => $user_data->user_nicename,
                            'email'  => $user_data->user_email,
                            'customer_group'  => $user_data->roles[0],
                            'orders' => $orders,
                            'products' => $products,
                            'total' => $total,      
                            'status' => $user_data->user_status,
				);
			}
		}
		usort($results, array(&$this,'sort_order_by_total'));
		return $results;
	}

	public function getTotalOrders($data = array()) {
		$sql = "SELECT COUNT(DISTINCT o.customer_id) AS total FROM `" . DB_PREFIX . "order` o WHERE o.customer_id > '0'";

		if (!is_null($data['filter_order_status_id'])) {
			$sql .= " AND o.order_status_id = '" . (int)$data['filter_order_status_id'] . "'";
		} else {
			$sql .= " AND o.order_status_id > '0'";
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

	public function getRewardPoints($data = array()) {
		/*
		//Customer 	Email 	Group 	Status 	Reward Points 	Orders 	Total
		$wp_user_search = $wpdb->get_results("SELECT ID, display_name FROM $wpdb->users ORDER BY ID");
		 foreach ( $wp_user_search as $userid ) {
			$user_id       = (int) $userid->ID;
            $display_name  = stripslashes($userid->display_name);
            //var_dump($display_name );
		 }
		 */
		$result = array();
		global $wpdb;
		$blogusers = get_users('role=Basic');
		$meta_type_1 = 'reward_point';
		$meta_type_2 = 'reward_point_used';
		$meta_type_3 = 'totals';
		foreach ($blogusers as $user) {
	    	$querystr = "
			    SELECT $wpdb->posts.* 
			    FROM $wpdb->posts, $wpdb->postmeta
			    WHERE $wpdb->posts.ID = $wpdb->postmeta.post_id 
			    AND $wpdb->postmeta.meta_key = 'customer_id' 
			    AND $wpdb->postmeta.meta_value = $user->ID 
			    AND $wpdb->posts.post_type = '" .  Goscom::GOSCOM_ORDER_POSTTYPE  . "'"; 
	    		/*
			    AND $wpdb->posts.post_date < NOW()
			    ORDER BY $wpdb->posts.post_date DESC
			 	";
			 	*/
			if(!empty($data['filter_date_start'])) {
				$querystr .= " AND DATE($wpdb->posts.post_date) >= '" . $wpdb->escape($data['filter_date_start']) . "'";
			}
			if (!empty($data['filter_date_end'])) {
				$querystr .= " AND DATE($wpdb->posts.post_date) <= '" . $wpdb->escape($data['filter_date_end']) . "'";
			}
	    	
		 	$items = $wpdb->get_results($querystr);
		 	$totalRewardPoints = 0;
		 	$totalRewardPointsUsed = 0;
		 	$totalOrder = 0 ;
		 	$totals = 0; 
		 	foreach($items as $item) {
		 		
				$id = $item->ID;
		 		$data_1 = get_post_meta($id, $meta_type_1);
		 		$data_2 = get_post_meta($id, $meta_type_2);
		 		$data_3 = get_post_meta($id, $meta_type_3);
		 		
		 		if(!empty($data_1)) {
		 			$totalRewardPoints += floatval($data_1[0]);	
		 		}
		 		if(!empty($data_2)) {
		 			$totalRewardPointsUsed += floatval($data_2[0]);	
		 		}
		 		if(!empty($data_3)) {
		 			$totals += floatval($data_3[0]);	
		 		}
		 		$totalOrder ++;
		 		
		 	}
		 	
		 	$resultTemp = array(
		 			'customer'	=> $user->user_nicename,
		 			'email'		=> $user->user_login,
		 			'customer_group'		=> 'Basic',
		 			'points' => $totalRewardPoints - $totalRewardPointsUsed,
		 			'orders'		=> $totalOrder,
		 			'totals'		=> $totals
		 			) ;
		 	$result[] = $resultTemp;
	    }

	}

	public function getTotalRewardPoints() {
		/*
		$sql = "SELECT COUNT(DISTINCT customer_id) AS total FROM `" . DB_PREFIX . "customer_reward`";
		$implode = array();
		if (!empty($data['filter_date_start'])) {
			$implode[] = "DATE(cr.date_added) >= '" . $this->db->escape($data['filter_date_start']) . "'";
		}

		if (!empty($data['filter_date_end'])) {
			$implode[] = "DATE(cr.date_added) <= '" . $this->db->escape($data['filter_date_end']) . "'";
		}

		if ($implode) {
			$sql .= " WHERE " . implode(" AND ", $implode);
		}

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

		return $query->row['total'];
		*/
	}

	public function getTotalCredit() {

		global $wpdb;
		$customer = array();
		$wp_user_search = $wpdb->get_results("SELECT ID, display_name FROM $wpdb->users ORDER BY ID");
		foreach ( $wp_user_search as $userid ) {
			$user_id = (int) $userid->ID;
			$user = get_userdata($user_id);
			$user_roles = $user->roles;
			$tempTotalStoreCredit = 0;
			if($user_roles[0] == 'basic') {
				$transactions = get_user_meta($user_id, 'transactions', true);
				if($transactions != '') {
					$transactions_amounts = $transactions['amount'];
					for($i=0; $i<count($transactions_amounts);$i++) {
						$tempTotalStoreCredit += floatval($transactions_amounts[$i]);
					}
				}

				$customer[] = array(
							'id'					=> $user_id,
							'customer'				=> $user->user_nicename,
							'email'					=> $user->user_email,
							'customer_group'		=> _('Basic'),
							'status'				=> _('Enable'),
							'total'					=> $tempTotalStoreCredit
					
				);
			}
		}


		return $customer;

	}

	function sort_order_by_total($a, $b){
			
		if ($a['total'] == $b['total']) {
			return 0;
		}
		return ($a['total'] > $b['total']) ? -1 : +1;
	}
}
?>