<?php

class impresscart_order_status_table extends impresscart_table {
	
	var $table = 'impresscart_order_status';
	
	var $primaryKey = 'order_status_id';
	
	function fetchOne($options)	{
		
		$config = impresscart_framework::service('config');
		
		$order_statuses = $config->get('order_status_data');
		
		foreach ($order_statuses as $key => $value)
		{
			if($key == $options['conditions']['order_status_id'])
			{
				$obj = new stdClass();
				$obj->order_status_id = $key;
				$obj->name = $value;
				return $obj;
			}
		}
		return false;
	}
	
	function fetchAll($options = array(), $output = OBJECT)
	{
		$config = impresscart_framework::service('config');		
		$order_statuses = $config->get('order_status_data');
				
		$data = array();
		foreach ($order_statuses as $key => $value)
		{
			$obj = new stdClass();
			$obj->order_status_id = $key;
			$obj->name = $value;
			$data[] = $obj;
			
		}
		return $data;
	}
}