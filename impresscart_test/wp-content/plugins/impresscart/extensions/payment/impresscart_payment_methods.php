<?php

class impresscart_payment_methods
{
		static function get_enabled_payment_methods() {
			
			$impresscart_payment_methods = get_option('impresscart_payment_methods', true);
			
			$enabled_payment_methods = array();

			if(isset($impresscart_payment_methods) && is_array($impresscart_payment_methods['impresscart']['payment_method']) && count($impresscart_payment_methods['impresscart']['payment_method']))
			{
				foreach($impresscart_payment_methods['impresscart']['payment_method'] as $key => $setting)
				{
					if(@$setting['enabled'] == 'yes')
					{
						$enabled_payment_methods[$key] = array(
							'code' => $setting['code'],
							'title' => $setting['name'],
							'sort_order' => $setting['order'],
						);
					}
				}			
			}
			return $enabled_payment_methods;
		}
		
}
