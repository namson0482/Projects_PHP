<?php
class impresscart_session_service extends impresscart_service {
	
	public $data = array();
  	public function __construct() {		
  		
		if (!session_id()) {
			ini_set('session.use_cookies', 'On');
			ini_set('session.use_trans_sid', 'Off');
			session_set_cookie_params(0, '/');
			session_start();
		}
		$this->data =& $_SESSION;
	}
}
?>