<?php
class impresscart_sale_affiliate_model extends impresscart_model {
	
	function genAffiliateCode()
	{
		$v_code = substr(md5($_SERVER['REMOTE_ADDR'].microtime().rand(1,999999)),0,10);
		return $v_code;		
	}
	
	function updateAffiliate($post_id, $data)
	{
		//get current affiliate id
		$user_id = get_post_meta($post_id,'affiliate', true);
		$userdata = get_userdata($user_id);
		if(!$userdata)
		{		
			die('here');
			$userdata  = array();
			$userdata['user_pass'] = $data['password'];
			$userdata['user_login'] = $data['email'];
			$userdata['user_nicename'] = $data['firstname'] . " " . $data['last_name'];
			$userdata['first_name']  = $data['firstname'];
			$userdata['last_name']  = $data['lastname'];
			$userdata['user_email']  = $data['email'];
			$userdata['role'] = 'affiliate';
			
			$user_id = wp_insert_user( $userdata );
			if($user_id)
			{
				add_user_meta($user_id, 'telephone', $data['telephone']);
				add_user_meta($user_id, 'fax', $data['fax']);
				add_user_meta($user_id, 'newsletter', $data['newsletter']);
				
				$address = array();
				$address['id'] = 1;
				$address['firstname'] = $data['firstname'];
				$address['lastname'] = $data['lastname'];
				$address['company'] = $data['company'];
				$address['address_1'] = $data['address_1'];
				$address['address_2'] = $data['address_2'];
				$address['city'] = $data['city'];
				$address['postcode'] = $data['postcode'];
				$address['country_id'] = $data['country_id'];
				$address['zone_id'] = $data['zone_id'];
				$address = array( '1' => $address);
				add_user_meta($user_id, 'address', $address);
				
				update_post_meta($post_id, 'affiliate', $user_id);
			} else {
				var_dump($user_id);die();
			}
			
		} else {
		
			$userdata->user_pass = $data['password'];
			$userdata->user_login = $data['email'];
			$userdata->user_nicename = $data['firstname'] . " " . $data['last_name'];
			$userdata->first_name  = $data['firstname'];
			$userdata->last_name  = $data['lastname'];
			$userdata->user_email  = $data['email'];
			
			wp_update_user((array)$userdata);
			
			update_user_meta($user_id, 'telephone', $data['telephone']);
			update_user_meta($user_id, 'fax', $data['fax']);
			update_user_meta($user_id, 'newsletter', $data['newsletter']);
			
			$address = array();
			$address['id'] = 1;
			$address['firstname'] = $data['firstname'];
			$address['lastname'] = $data['lastname'];
			$address['company'] = $data['company'];
			$address['address_1'] = $data['address_1'];
			$address['address_2'] = $data['address_2'];
			$address['city'] = $data['city'];
			$address['postcode'] = $data['postcode'];
			$address['country_id'] = $data['country_id'];
			$address['zone_id'] = $data['zone_id'];
			$address = array( '1' => $address);
			update_user_meta($user_id, 'address', $address);
		}
	}	
	
	function getAffiliate($post_id)
	{
		$user_id = get_post_meta($post_id, 'affiliate', true);
		
		if($user_id)
		{
			$user = get_userdata($user_id);
			return (array)$user;
		}
		return false;
	}
	
	function getAffiliateAddress($post_id)
	{
		
		$user_id = get_post_meta($post_id, 'affiliate', true);
		$address = get_user_meta($user_id, 'address', true);				
		$address_data = array();
		$zone = impresscart_framework::table('zone');		
		$country = impresscart_framework::table('country');		
		foreach($address as $key => $result)
		{
			$zone_data = $zone->fetchOne(array( 'conditions' => array(
				'zone_id' => $result['zone_id']
			)) );
			
			$country_data = $country->fetchOne(array( 'conditions' => array(
				'ID' => $result['country_id']
			)));
			
			
			$address_data[] = array(
				'address_id'     => $result['id'],
				'firstname'      => $result['firstname'],
				'lastname'       => $result['lastname'],
				'company'        => $result['company'],
				'address_1'      => $result['address_1'],
				'address_2'      => $result['address_2'],
				'postcode'       => $result['postcode'],
				'city'           => $result['city'],
				'zone_id'        => $result['zone_id'],
				'zone'           => $zone_data->name,
				'zone_code'      => $zone_data->code,
				'country_id'     => $result['country_id'],
				'country'        => $country_data->name,	
				'iso_code_2'     => $country_data->iso2,
				'iso_code_3'     => $country_data->iso3,
				'address_format' => $country_data->address_format
			);
		}
		
		return $address_data;
	}
	function saveTransaction($post_id)
	{
		
	}
}
?>