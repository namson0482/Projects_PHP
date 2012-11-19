<?php
class impresscart_localisation_zone_model extends impresscart_model {
	
	public function getZone($zone_id) {
		#$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone WHERE zone_id = '" . (int)$zone_id . "' AND status = '1'");
		return impresscart_framework::table('zone')
				->fetchOne(array(
					'conditions' => array(
						'zone_id' 	=> $zone_id,
						'status' 	=> 1,
					)
				));
	}

	public function getZonesByCountryId($country_id) {
		
		$zone_data = $this->cache->get('zone.' . (int)$country_id);

		if (!$zone_data) {
			$zone_data = impresscart_framework::table('zone')
				->fetchAll(array(
					'conditions' => array(
						'country_id' 	=> $country_id,
						'status' 		=> 1,
					)
				));

			$this->cache->set('zone.' . (int)$country_id, $zone_data);
		}
		
		return $zone_data;
	}
    
    function add($data)
    {
        global $wpdb;
        $zone = str_replace("'", "\'", $data[3]);
        $post = array(        
            'post_title' => $zone,
            'post_type' => 'zone',
            'post_status' => 'publish',
        );
        
        $country_model = impresscart_framework::model('localisation/country');
        $query = new WP_Query();
        $post_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts p WHERE p.post_title LIKE  '". $zone . "' AND p.post_type = 'zone'");
        
        if(!$post_id)
        {
            $post_id = wp_insert_post($post);
            if($post_id)
            {
                update_post_meta($post_id, 'code', $data[2]);                  
                update_post_meta($post_id, 'country', $country_model->get_country_by_code($data[1]) ) ;         
            }
        }      
    }
}
?>