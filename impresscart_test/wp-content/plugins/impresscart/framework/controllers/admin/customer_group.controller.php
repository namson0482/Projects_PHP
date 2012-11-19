<?php

class impresscart_admin_customer_group_controller extends impresscart_framework_controller {
	function index()
	{
		$this->autoRender = false;		
		global $wp_roles;	
		$defaul_roles = array(
			'administrator', 'editor', 'contributor','author','subscriber'
		);	
		foreach($wp_roles->roles as $key => $role)
		{
			if(!in_array($key, $defaul_roles))
			{
				$this->data['roles'][] = $role;
			}
		}
	}
}