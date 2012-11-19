<?php
/*
Copyright 2010-2011 Impress Dev LLC. This software is distributed under the GNU General Public License version 2. 

Contact: support@impressdev.com
*/
class impresscart_options {
	
	static $stock_statuses;
	static $return_statuses;
	static $order_statuses;
	static $length_class;
	static $weight_class;
	static $curencies;
	static $zones;
	static $countries;
    static $pages;
	
	static function set_default_data( $data = array())
	{
		self::$stock_statuses = $data['stock_statuses'];
		self::$order_statuses = $data['order_statuses'];
		self::$return_statuses = $data['return_statuses'];
		
		foreach ($data['countries'] as $item)
		{
			self::$countries[$item->country_id] = $item->name; 
		}
		
		foreach ($data['zones'] as $item)
		{
			self::$zones[$item->zone_id] = $item->name;
		}
		
		foreach ($data['curencies'] as $item)
		{
			self::$curencies[$item->code] = $item->title;
		}
		
		foreach ($data['weight_class'] as $item)
		{
			self::$weight_class[$item->unit_id] = $item->title;
		}
		
		foreach ($data['length_class'] as $item)
		{
			self::$length_class[$item->unit_id] = $item->title;
		}
                
        foreach($data['pages'] as $item)
		{
        	self::$pages[$item->ID] = $item->name;
        }		
	}
	
    static function get_impresscart_settings() {
    	
    	$settings = apply_filters('impresscart_settings', array());
    	
        return $settings;
        
    }

    static function apply_filters() {
        
    }
}
