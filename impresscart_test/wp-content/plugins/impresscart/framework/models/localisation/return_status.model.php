<?php
class impresscart_localisation_return_status_model extends impresscart_model {
	function fetchAll()
	{
		$status = $this->config->get('return_status_data');
	}
	
	function getReturnStatusOptions()
	{
		$status = $this->config->get('return_status_data');
		$data = array();
		foreach ($status as $id => $value)
		{
			$data[] = array(
				'return_status_id' => $id,
				'name' => $value
			);
		}
		return $data;
		
	}
	
	function getReturnStatus($return_status_id)
	{
		$status = $this->config->get('return_status_data');
		
		$data = array();
		foreach ($status as $id => $value)
		{
			if($id == $return_status_id)
			{
				$data = array(
					'return_status_id' => $id,
					'name' => $value				
				);
				return $data;
			}
			
		}
		return $data;
	}
}
?>