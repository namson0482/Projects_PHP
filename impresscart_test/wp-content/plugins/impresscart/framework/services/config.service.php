<?php
class impresscart_config_service extends impresscart_service {

  	public function get($key) {  		
  		global $impresscart_admin;
  		return $impresscart_admin->get_option($key, false);   		
  	}

	public function set($key, $value) {
		global $impresscart_admin;
		$impresscart_admin->set_option($key, $value);
  	}

	public function has($key) {

  	}
}
?>