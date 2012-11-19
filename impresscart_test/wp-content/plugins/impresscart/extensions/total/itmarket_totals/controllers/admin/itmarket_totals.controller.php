<?php

class impresscart_admin_impresscart_totals_controller extends impresscart_framework_controller {
	
	function setting()
	{
		if($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			$this->model_total_impresscart_totals->update_setting($_POST['itmarket']['total']);
			$this->data['message'] = __('Total impresscart_totals setting updated successfully');
		} 
		
		$current_setting = $this->model_total_impresscart_totals->get_setting();		
	    $this->data['setting'] = $current_setting;	    	    
	}
}