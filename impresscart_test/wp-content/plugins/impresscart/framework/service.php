<?php
/*
Copyright 2010-2011 Impress Dev LLC. This software is distributed under the GNU General Public License version 2. 

Contact: support@impressdev.com
*/

class impresscart_service {
	
	public function __get($key) {
		if(isset($this->{$key})) {
			return $this->{$key};
		}
		try {
			if(strpos($key, 'model_') === 0) {
				$this->{$key} = impresscart_framework::model(str_replace('_', '/', substr($key, 6)));
			} elseif (strpos($key, 'table_') === 0) {
				$this->{$key} = impresscart_framework::table(substr($key, 6));
			} else {
				$this->{$key} = impresscart_framework::service($key);
			}
			return $this->{$key};
		} catch (Exception $e){
			return null;
		}
	}

	public function __set($key, $value) {
		$this->{$key} = $value;
	}
	
	public function isCustomer() {
		return false;
	}
	
	public function isAffiliate() {
		return false;
	}
	
}