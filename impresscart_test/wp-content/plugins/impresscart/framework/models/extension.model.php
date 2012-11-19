<?php

class impresscart_extension_model extends impresscart_model {
	
	function getExtensions($type)
	{
		if(!is_null($type))
		{ 
			$args = array (
				'numberposts' => '100',
				'post_type' => 'extension',
				'meta_key' => 'type',
				'meta_value' => $type				
			);
		} else {
			$args = array (
				'post_type' => 'extension'
			);
		}
		
		return get_posts($args);		
	}
}
