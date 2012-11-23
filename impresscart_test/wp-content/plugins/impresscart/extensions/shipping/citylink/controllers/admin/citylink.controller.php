<?php

class impresscart_admin_citylink_controller extends impresscart_framework_controller {
	
	function setting()
	{
		$this->data['heading'] = __('CityLink Shipping Method Setting');
		if($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			$this->model_shipping_citylink->update_setting($_POST['impresscart']['shipping_method']);
			$this->data['message'] = __('Citylink shipping method setting updated successfully');
		} 
		
		$current_setting = $this->model_shipping_citylink->get_setting();	
				
		$table = impresscart_framework::table('tax_class');
	    $rows = $table->fetchAll();
	    
	    $tax_classes_html = "<select name=\"impresscart[shipping_method][citylink][citylink_tax_class_id]\">";
	    
	    foreach ($rows as $row) {
	    	
	    	if($row->tax_class_id == $current_setting['citylink_tax_class_id'])
	      	{
	      		$tax_classes_html .= "<option selected='selected' value='".$row->tax_class_id."'>".$row->title."</option>";
	      		
	      	} else {
	      		
	     		$tax_classes_html .= "<option value='".$row->tax_class_id."'>".$row->title."</option>";
	     	}
	      
	    }
	    
	    $tax_classes_html .= '</select>';
    
		$table = impresscart_framework::table('geo_zone');
	    $rows = $table->fetchAll();
	    $geo_zones = array();
	    $geo_zones[] = array('name' => 'All', 'value' => '');
	    $geo_zones_html = "<select name=\"impresscart[shipping_method][citylink][citylink_geo_zone_id]\">";
	    foreach ($rows as $row) {
	      if($row->geo_zone_id == $current_setting['citylink_geo_zone_id'])
	      {
	      	$geo_zones_html .= "<option selected='selected' value='".$row->geo_zone_id."'>".$row->name."</option>";
	      } else {
	      	$geo_zones_html .= "<option value='".$row->geo_zone_id."'>".$row->name."</option>";	
	      }
	      
	    }
	    
	    $geo_zones_html .= '</select>';
	    
	    
	    $this->data['setting'] = $current_setting;
	    $this->data['tax_classes'] = $tax_classes_html;
	    $this->data['geo_zones'] = $geo_zones_html;
	    $this->data['pages'] = apply_filters('impresscart_administration_pages', array());
	}
}