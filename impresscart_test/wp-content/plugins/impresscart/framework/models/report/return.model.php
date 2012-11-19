<?php
class impresscart_report_return_model extends impresscart_model {
	public function getReturns($data = array()) {
	   
        global $wpdb;
        $sql = "SELECT min( p.post_date ) AS date_start, max( p.post_date ) AS date_end, count(p.ID) as returns
                    FROM $wpdb->posts p WHERE p.post_type = 'return' 
                    ";
                    
        if (!empty($data['filter_date_start'])) {
 		     $sql .= " AND DATE(p.post_date) >= '" . $wpdb->escape($data['filter_date_start']) . "'";
  		}

  		if (!empty($data['filter_date_end'])) {
  			$sql .= " AND DATE(p.post_date) <= '" . $wpdb->escape($data['filter_date_end']) . "'";
  		}
        
        if (!empty($data['filter_group'])) {
  			$group = $data['filter_group'];
  		} else {
  			$group = 'week';
  		}
        
        $sql .= " GROUP BY ";
        
        switch($group) {
  			case 'day';
  				$sql .= " DAY(p.post_date)";               
  				break;
  			default:
  			case 'week':
  				$sql .= " WEEK(p.post_date)";              
  				break;	
  			case 'month':
  				$sql .= " MONTH(p.post_date)";               
  				break;
  			case 'year':
  				$sql .= " YEAR(p.post_date)";
  				break;									
  		}
                
        $sql .= " ORDER BY p.post_date DESC";
        
        $results = $wpdb->get_results($sql, ARRAY_A );
        return $results;
	}	
	
	public function getTotalReturns($data = array()) {
		
	}	
}
?>