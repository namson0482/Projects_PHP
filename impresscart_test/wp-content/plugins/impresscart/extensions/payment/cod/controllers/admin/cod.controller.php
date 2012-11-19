<?php

class impresscart_admin_cod_controller extends impresscart_framework_controller {
	
	function setting()	{
		$this->data['heading'] = __('Cash on delivery payment method setting');
		
		if($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			$this->model_payment_cod->update_setting($_POST['impresscart']['payment_method']);
			$this->data['message'] = __('Payment cod setting updated successfully');
		} 
		
		$current_setting = $this->model_payment_cod->get_setting();	
				
		$table = impresscart_framework::table('order_status');
	    $rows = $table->fetchAll();
	    
	    $order_statuses_html = "<select name=\"impresscart[payment_method][payment_cod][order_status]\">";
	    
	    foreach ($rows as $row) {
	    	
	    	if($row->order_status_id == @$current_setting['order_status'])
	      	{
	      		$order_statuses_html .= "<option selected='selected' value='".$row->order_status_id."'>".$row->name."</option>";
	      		
	      	} else {
	      		
	     		$order_statuses_html .= "<option value='".$row->order_status_id."'>".$row->name."</option>";
	     			
	     	}
	      
	    }
	    
	    $order_statuses_html .= '</select>';
    
		$table = impresscart_framework::table('geo_zone');
	    $rows = $table->fetchAll();
	    $geo_zones = array();
	    $geo_zones[] = array('name' => 'All', 'value' => '');
	    $geo_zones_html = "<select name=\"impresscart[payment_method][payment_cod][geo_zone]\">";
	    foreach ($rows as $row) {
	      if($row->geo_zone_id == @$current_setting['geo_zone'])
	      {
	      	$geo_zones_html .= "<option selected='selected' value='".$row->geo_zone_id."'>".$row->name."</option>";
	      } else {
	      	$geo_zones_html .= "<option value='".$row->geo_zone_id."'>".$row->name."</option>";	
	      }
	      
	    }
	    
	    $geo_zones_html .= '</select>';
	    
	    
	    $this->data['setting'] = $current_setting;
	    $this->data['order_statuses'] = $order_statuses_html;
	    $this->data['geo_zones'] = $geo_zones_html;	    
	    
	    $this->data['pages'] = apply_filters('impresscart_administration_pages', array());
	}
}