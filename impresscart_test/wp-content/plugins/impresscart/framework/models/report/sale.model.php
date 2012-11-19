<?php
class impresscart_report_sale_model extends impresscart_model {

	public function getOrders($data = array()) {
		global $wpdb;
		$query = "SELECT ID, post_date FROM `$wpdb->posts`
            INNER JOIN `$wpdb->postmeta` ON $wpdb->posts.ID = $wpdb->postmeta.post_id
            WHERE `post_type` LIKE '" . Goscom::GOSCOM_ORDER_POSTTYPE . "'"; 

		if( $data['filter_order_status_id'] != 100 ){
			$query .= "AND `meta_key` LIKE 'order_status'
                     AND `meta_value` = " . $data['filter_order_status_id'];
		}

		if( $data['filter_date_start'] != '' ){
			$query .= " AND `post_date` >= '" . $data['filter_date_start'] . " 00 00 00' ";
			$date_start = strtotime($data['filter_date_start']);
		} else {
			$date_start = null;
		}

		if($data['filter_date_end'] != '' ){
			$query .= "AND `post_date` <= '" . $data['filter_date_end'] . " 23 59 59' ";
			$date_end = strtotime($data['filter_date_end']);
		} else {
			$date_end = null;
		}

		$query .= " ORDER BY post_date DESC";

		$results = $wpdb->get_results($query);

		$group = $data['filter_group'];

		switch($group) {
			case 'day';
			$interval = " -1 day";
			break;
			default:
			case 'week':
				$interval = " -7 days";
				break;
			case 'month':
				$interval = " -30 days";
				break;
			case 'year':
				$interval = " -365 days";
				break;
		}

		$final_results = array();
		if( count($results) > 0 ) {

			$count_results = 0;
			if( $date_end == null ){
				$date_end = strtotime($results[0]->post_date);
			}
			if( $date_start == null ){
				$last = count($results) -1;
				$date_start = strtotime($results[$last]->post_date);
			}
			
			while( count($final_results) < count($results) && $date_end >= $date_start ){
				
				$number_of_products = 0;
				$number_of_orders = 0;
				$tax_total = 0;
				$total = 0;
				foreach( $results as $result ) {
					$post_date = strtotime($result->post_date);
					
					if( $post_date <= $date_end && $post_date > strtotime(date("Y-m-d", $date_end) . $interval) ){
						
						$order_quantity = get_post_meta($result->ID, 'order_quantity');
						$number_of_products += $order_quantity[0];
						$number_of_orders ++;
						$order_tax = get_post_meta($result->ID, 'order_tax');
						$tax_total += $order_tax[0];

						$order_total = get_post_meta($result->ID, 'order_total');
						$total += $order_total[0];

					}
				}

				if( $number_of_orders > 0 ){
					$final_results[] = array(
                          'date_start' => date("Y-m-d",strtotime(date("Y-m-d", $date_end) . $interval)),
                          'date_end' => date("Y-m-d",$date_end),
                          'orders' => $number_of_orders,
                          'products' => $number_of_products,
                          'tax' => $tax_total,
                          'total' => $total
					);
					$count_results ++;
				}
				if( $count_results > count($results) ) { // if all of results are added to final results, break
					break;
				}

				if( $date_end != null && $date_start != null ){
					$date_end = strtotime(date("Y-m-d", $date_end) . $interval);
				}
			}
		}
		return $final_results;
	}

	public function getTotalOrders($data = array()) {
		if (!empty($data['filter_group'])) {
			$group = $data['filter_group'];
		} else {
			$group = 'week';
		}

		switch($group) {
			case 'day';
			$sql = "SELECT COUNT(DISTINCT DAY(date_added)) AS total FROM `" . DB_PREFIX . "order`";
			break;
			default:
			case 'week':
				$sql = "SELECT COUNT(DISTINCT WEEK(date_added)) AS total FROM `" . DB_PREFIX . "order`";
				break;
			case 'month':
				$sql = "SELECT COUNT(DISTINCT MONTH(date_added)) AS total FROM `" . DB_PREFIX . "order`";
				break;
			case 'year':
				$sql = "SELECT COUNT(DISTINCT YEAR(date_added)) AS total FROM `" . DB_PREFIX . "order`";
				break;
		}

		if (!empty($data['filter_order_status_id'])) {
			$sql .= " WHERE order_status_id = '" . (int)$data['filter_order_status_id'] . "'";
		} else {
			$sql .= " WHERE order_status_id > '0'";
		}

		if (!empty($data['filter_date_start'])) {
			$sql .= " AND DATE(date_added) >= '" . $this->db->escape($data['filter_date_start']) . "'";
		}

		if (!empty($data['filter_date_end'])) {
			$sql .= " AND DATE(date_added) <= '" . $this->db->escape($data['filter_date_end']) . "'";
		}

		//$query = $this->db->query($sql);

		//return $query->row['total'];
	}

	public function getTaxes($data = array()) {

		global $wpdb;
		$query = "SELECT ID, post_date FROM `$wpdb->posts`
	        INNER JOIN `$wpdb->postmeta` ON $wpdb->posts.ID = $wpdb->postmeta.post_id
	        WHERE `post_type` LIKE 'order' ";

		if( $data['filter_order_status_id'] != 100 ){
			$query .= "AND `meta_key` LIKE 'order_status'
                         AND `meta_value` = " . $data['filter_order_status_id'];
		}

		if( $data['filter_date_start'] != '' ){
			$query .= " AND `post_date` >= '" . $data['filter_date_start'] . " 00 00 00' ";
			$date_start = strtotime($data['filter_date_start']);
		} else {
			$date_start = null;
		}

		if($data['filter_date_end'] != '' ){
			$query .= "AND `post_date` <= '" . $data['filter_date_end'] . " 23 59 59' ";
			$date_end = strtotime($data['filter_date_end']);
		} else {
			$date_end = null;
		}

		$query .= " ORDER BY post_date DESC";

		$results = $wpdb->get_results($query);

		$group = $data['filter_group'];

		switch($group) {
			case 'day';
			$interval = " -1 day";
			break;
			default:
			case 'week':
				$interval = " -7 days";
				break;
			case 'month':
				$interval = " -30 days";
				break;
			case 'year':
				$interval = " -365 days";
				break;
		}



		if( count($results) > 0 ){
			$final_results = array();
			$count_results = 0;
			if( $date_end == null ){
				$date_end = strtotime($results[0]->post_date);
			}
			if( $date_start == null ){
				$last = count($results) -1;
				$date_start = strtotime($results[$last]->post_date);
			}
			while( count($final_results) < count($results) && $date_end > $date_start ){
				$number_of_products = 0;
				$number_of_orders = 0;
				$tax_total = 0;
				$total = 0;

				$temp = array();

				foreach( $results as $result ){

					$post_date = strtotime($result->post_date);
					if( $post_date <= $date_end && $post_date > strtotime(date("Y-m-d", $date_end) . $interval) ){

						$number_of_orders ++;
						$totals = get_post_meta($result->ID, 'totals', true);
							
						foreach($totals as $t)
						{
							if($t['code'] == 'tax')
							{
								if(!isset($temp[$t['title']]))
								{
									@$temp[@$t['title']] = 0;
								}

								$temp[$t['title']] += $t['value'];
							}
						}
					}
				}

				if( $number_of_orders > 0 ){
					foreach($temp as $key=>$value)
					{
						$final_results[] = array(
                              'date_start' => date("Y-m-d",strtotime(date("Y-m-d", $date_end) . $interval)),
                              'date_end' => date("Y-m-d",$date_end),
                              'orders' => $number_of_orders,                          
                              'total' => $value,
                              'title' => $key,
						);
					}
					$count_results ++;
				}
				if( $count_results > count($results) ) { // if all of results are added to final results, break
					break;
				}

				if( $date_end != null && $date_start != null ){
					$date_end = strtotime(date("Y-m-d", $date_end) . $interval);
				}
			}
		}

		return @$final_results;
	}

	public function getTotalTaxes($data = array()) {
		$sql = "SELECT COUNT(*) AS total FROM (SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order_total` ot LEFT JOIN `" . DB_PREFIX . "order` o ON (ot.order_id = o.order_id) WHERE ot.code = 'tax'";

		if (!is_null($data['filter_order_status_id'])) {
			$sql .= " AND order_status_id = '" . (int)$data['filter_order_status_id'] . "'";
		} else {
			$sql .= " AND order_status_id > '0'";
		}

		if (!empty($data['filter_date_start'])) {
			$sql .= " AND DATE(date_added) >= '" . $this->db->escape($data['filter_date_start']) . "'";
		}

		if (!empty($data['filter_date_end'])) {
			$sql .= " AND DATE(date_added) <= '" . $this->db->escape($data['filter_date_end']) . "'";
		}

		if (!empty($data['filter_group'])) {
			$group = $data['filter_group'];
		} else {
			$group = 'week';
		}

		switch($group) {
			case 'day';
			$sql .= " GROUP BY DAY(o.date_added), ot.title";
			break;
			default:
			case 'week':
				$sql .= " GROUP BY WEEK(o.date_added), ot.title";
				break;
			case 'month':
				$sql .= " GROUP BY MONTH(o.date_added), ot.title";
				break;
			case 'year':
				$sql .= " GROUP BY YEAR(o.date_added), ot.title";
				break;
		}

		$sql .= ") tmp";

		$query = $this->db->query($sql);

		return $query->row['total'];
	}

	public function getShipping($data = array()) {
		global $wpdb;
		$query = "SELECT ID, post_date FROM `$wpdb->posts`
        INNER JOIN `$wpdb->postmeta` ON $wpdb->posts.ID = $wpdb->postmeta.post_id
        WHERE `post_type` LIKE 'order' ";

		if( $data['filter_order_status_id'] != 100 ){
			$query .= "AND `meta_key` LIKE 'order_status'
                         AND `meta_value` = " . $data['filter_order_status_id'];
		}

		if( $data['filter_date_start'] != '' ){
			$query .= " AND `post_date` >= '" . $data['filter_date_start'] . " 00 00 00' ";
			$date_start = strtotime($data['filter_date_start']);
		} else {
			$date_start = null;
		}

		if($data['filter_date_end'] != '' ){
			$query .= "AND `post_date` <= '" . $data['filter_date_end'] . " 23 59 59' ";
			$date_end = strtotime($data['filter_date_end']);
		} else {
			$date_end = null;
		}

		$query .= " ORDER BY post_date DESC";

		$results = $wpdb->get_results($query);

		$group = $data['filter_group'];

		switch($group) {
			case 'day';
			$interval = " -1 day";
			break;
			default:
			case 'week':
				$interval = " -7 days";
				break;
			case 'month':
				$interval = " -30 days";
				break;
			case 'year':
				$interval = " -365 days";
				break;
		}

		$final_results = array();
		if( count($results) > 0 ){
			
			$count_results = 0;
			if( $date_end == null ){
				$date_end = strtotime($results[0]->post_date);
			}
			if( $date_start == null ){
				$last = count($results) -1;
				$date_start = strtotime($results[$last]->post_date);
			}
			while( count($final_results) < count($results) && $date_end > $date_start ){
				$number_of_products = 0;
				$number_of_orders = 0;
				$tax_total = 0;
				$total = 0;

				$temp = array();

				foreach( $results as $result ){

					$post_date = strtotime($result->post_date);
					if( $post_date <= $date_end && $post_date > strtotime(date("Y-m-d", $date_end) . $interval) ){

						$number_of_orders ++;
						$totals = get_post_meta($result->ID, 'totals', true);
						foreach($totals as $t)
						{
							if($t['code'] == 'shipping')
							{
								$temp[$t['title']] += $t['value'];
							}
						}

					}
				}

				if( $number_of_orders > 0 ){
					foreach($temp as $key=>$value)
					{
						$final_results[] = array(
                              'date_start' => date("Y-m-d",strtotime(date("Y-m-d", $date_end) . $interval)),
                              'date_end' => date("Y-m-d",$date_end),
                              'orders' => $number_of_orders,                          
                              'total' => $value,
                              'title' => $key,
						);
					}
					$count_results ++;
				}
				if( $count_results > count($results) ) { // if all of results are added to final results, break
					break;
				}

				if( $date_end != null && $date_start != null ){
					$date_end = strtotime(date("Y-m-d", $date_end) . $interval);
				}
			}
		}

		return $final_results;
	}

	public function getTotalShipping($data = array()) {
		$sql = "SELECT COUNT(*) AS total FROM (SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order_total` ot LEFT JOIN `" . DB_PREFIX . "order` o ON (ot.order_id = o.order_id) WHERE ot.code = 'shipping'";

		if (!is_null($data['filter_order_status_id'])) {
			$sql .= " AND order_status_id = '" . (int)$data['filter_order_status_id'] . "'";
		} else {
			$sql .= " AND order_status_id > '0'";
		}

		if (!empty($data['filter_date_start'])) {
			$sql .= " AND DATE(date_added) >= '" . $this->db->escape($data['filter_date_start']) . "'";
		}

		if (!empty($data['filter_date_end'])) {
			$sql .= " AND DATE(date_added) <= '" . $this->db->escape($data['filter_date_end']) . "'";
		}

		if (!empty($data['filter_group'])) {
			$group = $data['filter_group'];
		} else {
			$group = 'week';
		}

		switch($group) {
			case 'day';
			$sql .= " GROUP BY DAY(o.date_added), ot.title";
			break;
			default:
			case 'week':
				$sql .= " GROUP BY WEEK(o.date_added), ot.title";
				break;
			case 'month':
				$sql .= " GROUP BY MONTH(o.date_added), ot.title";
				break;
			case 'year':
				$sql .= " GROUP BY YEAR(o.date_added), ot.title";
				break;
		}

		$sql .= ") tmp";

		$query = $this->db->query($sql);

		return $query->row['total'];
	}
}
?>