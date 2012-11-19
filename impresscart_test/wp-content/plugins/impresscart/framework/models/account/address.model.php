<?php
class impresscart_account_address_model extends impresscart_model {
	
	public function getAddressFromPostData($address_id, $postdata) {
		$address = array();
		$address['id'] = $address_id;
		$address['firstname'] = $postdata['firstname'];
		$address['lastname'] = $postdata['lastname'];
		$address['company'] = $postdata['company'];
		$address['address_1'] = $postdata['address_1'];
		$address['address_2'] = $postdata['address_2'];
		$address['city'] = $postdata['city'];
		$address['postcode'] = $postdata['postcode'];
		$address['country_id'] = $postdata['country_id'];
		$address['zone_id'] = $postdata['zone_id'];
		//$address = array( $address_id => $address);
		return $address;
		 
	}
	
	public function addAddress($data) {
		$user_id = $this->customer->getId();
		$current_address = get_user_meta($user_id, 'address', true);
		$address_id = strval(count($current_address) + 1);
		$address = $this->getAddressFromPostData($address_id, $data);
		
		$current_address[$address_id] = $address;
		update_user_meta($user_id, 'address', $current_address);
		return $address_id;
	}
	
	public function editAddress($address_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "address SET company = '" . $this->db->escape($data['company']) . "', firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['lastname']) . "', address_1 = '" . $this->db->escape($data['address_1']) . "', address_2 = '" . $this->db->escape($data['address_2']) . "', postcode = '" . $this->db->escape($data['postcode']) . "', city = '" . $this->db->escape($data['city']) . "', zone_id = '" . (int)$data['zone_id'] . "', country_id = '" . (int)$data['country_id'] . "' WHERE address_id  = '" . (int)$address_id . "' AND customer_id = '" . (int)$this->customer->getId() . "'");
	
		if (isset($data['default']) && $data['default'] == '1') {
			$this->db->query("UPDATE " . DB_PREFIX . "customer SET address_id = '" . (int)$address_id . "' WHERE customer_id = '" . (int)$this->customer->getId() . "'");
		}
	}
	
	public function deleteAddress($address_id) {
		$user_id = $this->customer->getId();
		$current_address = get_user_meta($user_id, 'address');
		unset($current_address[$address_id]);	
			
		update_user_meta($user_id, 'address', $current_address);
	}	
	
	public function getAddress($address_id) {
		
		$user_id = (int)$this->customer->getId();
				
		$user = get_userdata($user_id);		
		$current_address = get_user_meta($user_id, 'address');
				
		if(is_array($current_address)) {
			$current_address = $current_address[0];
		}
		
		
		
		$address = $current_address[$address_id];
		
		$zone = impresscart_framework::table('zone')->fetchOne(array('conditions' => array('zone_id' => $address['zone_id'])));
		$country = impresscart_framework::table('country')->fetchOne(array('conditions' => array('country_id' => $address['country_id'])));
		
		$address["zone"] = $zone->name;
		$address['country'] = $country->name;
		
		
		$address['address_format'] = $country->address_format;
		
		return $address;
		
	}
	
	public function test1() {
		
		$address = array();
		$address['id'] = 1;
		$address['firstname'] = 'Goscom';
		$address['lastname'] = '1';
		$address['company'] = '';
		$address['address_1'] = '428';
		$address['address_2'] = '';
		$address['city'] = 'HCM';
		$address['postcode'] = '70000';
		$address['country_id'] = '4201';
		$address['zone_id'] = '5251';
		
		$address1 = array();
		$address1['id'] = 2131;
		$address1['firstname'] = 'Goscom2';
		$address1['lastname'] = '1';
		$address1['company'] = '';
		$address1['address_1'] = '428';
		$address1['address_2'] = '';
		$address1['city'] = 'HCM';
		$address1['postcode'] = '70000';
		$address1['country_id'] = '4201';
		$address1['zone_id'] = '5251';
		
		$address = array( '1' => $address, 
						'2' => $address1);
		
		
	}
	
	public function getAddresses() {
		$user_id = (int)$this->customer->getId();
		$address = get_user_meta($user_id, 'address', true);
						
		$address_data = array();
		$zone = impresscart_framework::table('zone');
		$country = impresscart_framework::table('country');
		
		if(isset($address) && is_array($address))

		foreach($address as $key => $result) {
			
			$zone_data = $zone->fetchOne(array( 'conditions' => array(
				'zone_id' => $result['zone_id']
			)) );
			
			$country_data = $country->fetchOne(array( 'conditions' => array(
				'country_id' => $result['country_id']
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
				'iso_code_2'     => $country_data->iso_code_2,
				'iso_code_3'     => $country_data->iso_code_3,
				'address_format' => $country_data->address_format
			);	
		}

		return $address_data;
	
	}	
	
	public function getTotalAddresses() {
		$user_id = $this->customer->getId();
		$current_address = get_user_meta($user_id, 'address');		
		return count($current_address);
	}
}
?>