<?php

class impresscart_shipping_methods
{
		static function get_enabled_shipping_methods()
		{
			
			$impresscart_shipping_methods = get_option('impresscart_shipping_methods', true);
			
			//var_dump($impresscart_shipping_methods);
						
			$enabled_shipping_methods = array();
			
			if(isset($impresscart_shipping_methods) && is_array($impresscart_shipping_methods) && count($impresscart_shipping_methods))
			{
				foreach($impresscart_shipping_methods['impresscart']['shipping_method'] as $key => $setting)
				{
					if($setting['enabled'] == '1')
					{
						$enabled_shipping_methods[$key] = array(
							'code' => @$setting['code'],
							'title' => @$setting['name'],
							'sort_order' => @$setting['order'],
						);
					}
				}
			}
		
			return $enabled_shipping_methods;
		}
		
}
