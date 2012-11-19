<?php
class impresscart_customer_service extends impresscart_service {

	private $user;

	public function __construct() {
		
		global $wpdb;
		$this->config = impresscart_framework::service('config');
		$this->session = impresscart_framework::service('session');
		if (isset($this->session->data['customer_id'])) {
			$this->user = get_userdata($this->session->data['customer_id']);
			impresscart_framework::service('log')->write($this->session->data['customer_id']);
			if(!$this->user) {
				impresscart_framework::service('log')->write('customer service error');
			}
			update_user_meta( $this->session->data['customer_id'], 'customer_id', $_SERVER['REMOTE_ADDR']);
		}
	} 

	public function login($email, $password, $override = false) {
		
		if(!$override) {
			$creds = array();
			$creds['user_login'] = $email;
			$creds['user_password'] = $password;
			$creds['remember'] = true;
			$user = wp_signon( $creds, true );
			if ( is_wp_error($user) || current_user_can('administrator')) {
				return false;
			} else {
				$this->user = $user;
				$this->session->data['customer_id'] = $user->ID;
				return true;
			}	
		} 
		global $userdata;
		$this->user = $userdata;
		$this->session->data['customer_id'] = $userdata->ID;
		return true;
	}
	
	public function logout() {
		$this->session->data = array();
		unset($this->session->data['customer_id']);
		$this->user = null;
	}
	
	public function getUserRole() {
		$user_roles = $this->user->roles;
		return $user_roles[0]; 		
	}

	/**
	 * @return Integer This function check user that is logged 
	 * and is not administrator of system  
	 * and initilize properties of impresscart then return value is ID of user
	 * else return value is null
	 */
	public function isLogged() {
		return (is_user_logged_in() && !current_user_can('administrator') && $this->user) ? wp_get_current_user()->ID : null;
	}
	
	/**
	 * @return Integer :: This function check user is logged and administrator then return valus is 1, else is 0 or -1
	 */
	public function isUserLogged() {
		//If user is login and user is administrator then don't allow change password in GUI of goscom plugin
		return is_user_logged_in() ? (current_user_can('administrator') ? 1 : 0) : -1;
	}
	
	public function checkPassword($password) {
		$result = wp_check_password($password, self::getPassword(), self::getId());
		return $result; 
	}
	
	public function isCustomer() {
		return true;
	}

	public function getId() {
		if($this->user)
			return $this->user->ID;
		else return 0;
	}
	
	public function getPassword() {
		if($this->user)
			return $this->user->user_pass;
		else return null;
	}

	public function getFirstName() {
		if($this->user)
			return $this->user->first_name;
		return '';
	}

	public function getLastName() {
		return $this->user->last_name;
	}

	public function getEmail() {
		if($this->user)
		return $this->user->user_email;
		return '';
	}

	public function getTelephone() {
		return $this->user->telephone;
	}

	public function getFax() {
		return $this->user->fax;
	}

	public function getNewsletter() {
		return $this->user->newsletter;
	}

	public function getCustomerGroupId() {
		return $this->user->user_level;
	}
	
	public function getAddress()
	{
		return @$this->user->address;
	}

	public function getAddressId() {
		if(isset($this->user)) $addresses = $this->user->address;
		if(isset($addresses) && is_array($addresses))
		foreach ($addresses as $key => $address) {
			return $key;
		}
		
		return 0;
	}

	public function getStoreCreditAvaiables() {
		if($this->isLogged()) {
			$checkout_order_model = impresscart_framework::model('checkout/order');
			return $checkout_order_model->getStoreCredit($this->user->ID);	
		}
		return 0;
	}

	public function getRewardPoints() {
		
		//get all current reward points of a customer
		$checkout_order_model = impresscart_framework::model('checkout/order');
		return ($checkout_order_model->getTotalRewardPointsCustomer(0) - $checkout_order_model->getTotalRewardPointsCustomer(1));
		//$points = get_post_meta($this->getId(), 'points', true)	;
		//return $points ? 0 : $points;
	}
}
?>