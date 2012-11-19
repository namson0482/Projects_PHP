<?php
class impresscart_admin_paypalstandard_controller extends impresscart_framework_controller {
	
	function setting()
	{
		$this->data['heading'] = __('Paypal Standard Payment Method Setting');
		
		if($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			$this->model_payment_paypalstandard->update_setting($_POST['impresscart']['payment_method']);
			$this->data['message'] = __('Payment cod setting updated successfully');
		} 
		
		$current_setting = $this->model_payment_paypalstandard->get_setting();
		$table = impresscart_framework::table('order_status');
	    $rows = $table->fetchAll();
		$this->data['items'] = $rows;

		$table = impresscart_framework::table('geo_zone');
	    $rows = $table->fetchAll();
	    $geo_zones = array();
	    $geo_zones[] = array('name' => 'All', 'value' => '');
	    
		$html ='<select name="impresscart[payment_method][paypalstandard][geo_zone]">';
		foreach ($rows as $row) {
			if($row->geo_zone_id == $current_setting['geo_zone']){
				$html .= '<option selected="selected" value='.$row->geo_zone_id.' >'.$row->name.'</option>';
			}
			else{
				$html .= '<option value='.$row->geo_zone_id.' >'.$row->name.'</option>';
			}
		}
		$html .= '</select>';
	    
	    $this->data['setting'] = $current_setting;
	    $this->data['geo_zones'] = $html;	   
	    $this->data['pages'] = apply_filters('impresscart_administration_pages', array()); 
	
	}
}