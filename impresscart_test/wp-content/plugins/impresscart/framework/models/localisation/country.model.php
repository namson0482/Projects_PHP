<?php
class impresscart_localisation_country_model extends impresscart_model {
	public function getCountry($country_id) {
		return impresscart_framework::table('country')
    		->fetchOne(array(
    			'conditions' => array(
    				'country_id' 		=> $country_id,
    				'status' 			=> 1,
    			)
    		));
	}

	public function getCountries() {
		$country_data = $this->cache->get('country.status');
		if (!$country_data) {
		
			$country_data = impresscart_framework::table('country')
					->fetchAll(array('conditions' => array(
						'status' 			=> 1,
					)));

			$this->cache->set('country.status', $country_data);
		}
		
		return $country_data;
	}
    
    function add($data)
    {
        global $wpdb;
        $country = str_replace("'", "\'", $data[1]);
        $post = array(        
            'post_title' => $country,
            'post_type' => 'country',
            'post_status' => 'publish',
        );
        $query = new WP_Query();
        $post_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts p WHERE p.post_title LIKE  '". $country . "' AND p.post_type = 'country'");
        if(!$post_id)
        {
            $post_id = wp_insert_post($post);
            if($post_id)
            {
                update_post_meta($post_id, 'code', $data[0]);
                update_post_meta($post_id, 'iso_code_2', $data[2]);
                update_post_meta($post_id, 'iso_code_3', $data[3]);
                update_post_meta($post_id, 'address_format', $data[4]);
                update_post_meta($post_id, 'postcode_required', $data[5]); 
            }                       
        }      
    }
    
    function get_country_by_code($code)
    {
        $args = array(
            'numberposts' => 1,
            'post_type' => 'country',
            'meta_key' => 'code',
            'meta_value' => $code
        );
        
        $posts = get_posts($args);
        if(is_array($posts))
        return $posts[0]->ID;
    }
}
?>