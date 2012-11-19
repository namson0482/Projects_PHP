<?php
class impresscart_localisation_return_reason_model extends impresscart_model {
	
	public function getReturnReason($return_reason_id) {
		
		$rows = $this->config->get('return_reason_data');
		foreach ($rows as $key => $value)
		{
			if((int)$key == (int)$return_reason_id)
			{
				return array(
					'return_reason_id' => $return_reason_id,
					'name' => $value
				);
			}
		}
		
		return false;

	}

	public function getReturnReasons($data = array()) {
		
		$rows = $this->config->get('return_reason_data');
		$return_reason_data = array();
		foreach ($rows as $key => $value)
		{
			$return_reason_data[] = array(
				'return_reason_id' => $key,
				'name' => $value,
			);
		}
		
		return $return_reason_data;
	}

}
?>