<?php

class impresscart_encryption_service extends impresscart_service {
	private $key;
	
	function __construct() {
        
	}
	
	function encrypt($value) {
		if (!$this->key) { 
			return $value;
		}
		
		$output = '';
		
		for ($i = 0; $i < strlen($value); $i++) {
			$char = substr($value, $i, 1);
			$keychar = substr($this->key, ($i % strlen($this->key)) - 1, 1);
			$char = chr(ord($char) + ord($keychar));
			
			$output .= $char;
		} 
		
        return base64_encode($output); 
	}
	
	function decrypt($value) {
		if (!$this->key) { 
			return $value;
		}
		
		$output = '';
		
		$value = base64_decode($value);
		
		for ($i = 0; $i < strlen($value); $i++) {
			$char = substr($value, $i, 1);
			$keychar = substr($this->key, ($i % strlen($this->key)) - 1, 1);
			$char = chr(ord($char) - ord($keychar));
			
			$output .= $char;
		}
		
		return $output;
	}
}
?>