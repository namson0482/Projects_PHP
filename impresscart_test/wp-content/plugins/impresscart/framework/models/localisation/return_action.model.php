<?php
class impresscart_localisation_return_action_model extends impresscart_model {
	
	public function getReturnAction($return_action_id) {
		
		$rows = $this->config->get('return_action_data');
		foreach ($rows as $key => $value)
		{
			if((int)$key == (int)$return_action_id)
			{
				return array(
					'return_reason_id' => $return_action_id,
					'name' => $value
				);
			}
		}
		
		return false;

	}

	public function getReturnActions($data = array()) {
		
		$rows = $this->config->get('return_action_data');
		$return_action_data = array();
		foreach ($rows as $key => $value)
		{
			$return_action_data[] = array(
				'return_action_id' => $key,
				'name' => $value,
			);
		}
		
		return $return_action_data;
	}

}
?>