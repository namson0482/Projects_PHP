<?php

class impresscart_account_customer_model extends impresscart_model {
	
	public function addCustomer($data) {
		
		$userdata['user_pass'] = @$data['password'];
		$userdata['user_login'] = @$data['email'];
		$userdata['user_nicename'] = @$data['firstname'] . " " . @$data['lastname'];
		$userdata['first_name']  = @$data['firstname'];
		$userdata['last_name']  = @$data['lastname'];
		$userdata['user_email']  = $data['email'];
		$userdata['role'] = 'basic';
		
		$user_id = wp_insert_user( $userdata );
		add_user_meta($user_id, 'telephone', $data['telephone']);
		add_user_meta($user_id, 'fax', $data['fax']);
		add_user_meta($user_id, 'newsletter', @$data['newsletter'] ? @$data['newsletter'] : '0');
		
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
		
		
		$subject = sprintf(__('text_subject'), $this->config->get('name'));
		
		$message = sprintf(__('text_welcome'), $this->config->get('name')) . "\n\n";
		
		if (!$this->config->get('customer_approval')) {
			$message .= __('text_login') . "\n";
		} else {
			$message .= __('text_approval') . "\n";
		}
		
		$message .= $this->url->link('account/login', '', 'SSL') . "\n\n";
		$message .= __('text_services') . "\n\n";
		$message .= __('text_thanks') . "\n";
		$message .= get_bloginfo('name');
		
		
		$this->mail->protocol = $this->config->get('mail_method');
		$this->mail->parameter = $this->config->get('mail_parameter');
		$this->mail->hostname = $this->config->get('smtp_host');
		$this->mail->username = $this->config->get('smtp_username');
		$this->mail->password = $this->config->get('smtp_password');
		$this->mail->port = $this->config->get('smtp_port');
		$this->mail->timeout = $this->config->get('smtp_timeout');				
		$this->mail->setTo($data['email']);
		$this->mail->setFrom($this->config->get('sender_email'));
		$this->mail->setSender(get_bloginfo('name'));
		$this->mail->setSubject($subject);
		$this->mail->setText($message);                
		$this->mail->send();
                	
		// Send to main admin email if new account email is enabled
		if ($this->config->get('account_mail')) {
			//$this->mail->setTo($this->config->get('email'));
			$to = $this->config->get('email');
			wp_mail( $to, $subject, $message, '', '' );
			
			// Send to additional alert emails if new account email is enabled
			$emails = explode(',', $this->config->get('alert_emails'));
			
			foreach ($emails as $email) {
				if (strlen($email) > 0 && preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $email)) {
					wp_mail( $email, $subject, $message, '', '' );
				}
			}
		}
	}

	
	public function editCustomer($data) {
		$userdata = array(
			'ID' => $this->customer->getId(),
			'first_name' => $data['firstname'],
			'last_name' => $data['lastname'],
			'user_email' => $data['email'],			
		);
		wp_update_user($userdata);
		update_user_meta($this->customer->getId(), 'telephone', $data['telephone']);
		update_user_meta($this->customer->getId(), 'fax', $data['fax']);
	}

	public function editPassword($email, $password) {
		$userdata = array(
			'ID' => $this->customer->getId(),
			'user_pass' => $password
		);
		
		wp_update_user($userdata);
	}

	public function editNewsletter($newsletter) {
		//$this->db->query("UPDATE " . DB_PREFIX . "customer SET newsletter = '" . (int)$newsletter . "' WHERE customer_id = '" . (int)$this->customer->getId() . "'");
	}
					
	public function getCustomer($customer_id) {
		$user = get_userdata($customer_id);
		$info = (array)$user->data;		
		$info['fax'] = get_user_meta($customer_id, 'fax', true);
		$info['telephone'] = get_user_meta($customer_id, 'telephone', true);
		$info['newsletter'] = get_user_meta($customer_id, 'newsletter', true);
		return $info;		
	}
	
	public function getCustomerByToken($token) {
		/*
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE token = '" . $this->db->escape($token) . "' AND token != ''");
		$this->db->query("UPDATE " . DB_PREFIX . "customer SET token = ''");
		return $query->row;*/
	}
		
	public function getCustomers($data = array()) {
		
		/* 
		$sql = "SELECT *, CONCAT(c.firstname, ' ', c.lastname) AS name, cg.name AS customer_group FROM " . DB_PREFIX . "customer c LEFT JOIN " . DB_PREFIX . "customer_group cg ON (c.customer_group_id = cg.customer_group_id) ";

		$implode = array();
		
		if (isset($data['filter_name']) && !is_null($data['filter_name'])) {
			$implode[] = "LCASE(CONCAT(c.firstname, ' ', c.lastname)) LIKE '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "%'";
		}
		
		if (isset($data['filter_email']) && !is_null($data['filter_email'])) {
			$implode[] = "c.email = '" . $this->db->escape($data['filter_email']) . "'";
		}
		
		if (isset($data['filter_customer_group_id']) && !is_null($data['filter_customer_group_id'])) {
			$implode[] = "cg.customer_group_id = '" . $this->db->escape($data['filter_customer_group_id']) . "'";
		}	
		
		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$implode[] = "c.status = '" . (int)$data['filter_status'] . "'";
		}	
		
		if (isset($data['filter_approved']) && !is_null($data['filter_approved'])) {
			$implode[] = "c.approved = '" . (int)$data['filter_approved'] . "'";
		}	
			
		if (isset($data['filter_ip']) && !is_null($data['filter_ip'])) {
			$implode[] = "c.customer_id IN (SELECT customer_id FROM " . DB_PREFIX . "customer_ip WHERE ip = '" . $this->db->escape($data['filter_ip']) . "')";
		}	
				
		if (isset($data['filter_date_added']) && !is_null($data['filter_date_added'])) {
			$implode[] = "DATE(c.date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}
		
		if ($implode) {
			$sql .= " WHERE " . implode(" AND ", $implode);
		}
		
		$sort_data = array(
			'name',
			'c.email',
			'customer_group',
			'c.status',
			'c.ip',
			'c.date_added'
		);	
			
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];	
		} else {
			$sql .= " ORDER BY name";	
		}
			
		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
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
		
		return $query->rows;	*/
	}
		
	public function getTotalCustomersByEmail($email) {
		return username_exists($email);
	}
	
	public function getAddress($field)
	{
		$address = get_user_meta($user_id, 'default_address');
		return $address[$field];
	}
  
  
  
}
?>