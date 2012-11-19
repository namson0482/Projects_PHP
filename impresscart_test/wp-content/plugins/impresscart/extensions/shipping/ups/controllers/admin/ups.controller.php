<?php

class impresscart_admin_ups_controller extends impresscart_framework_controller {
	
	function setting()
	{
		$current_setting = $this->model_shipping_ups->get_setting();
		
		if($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			$this->model_shipping_ups->update_setting($_POST['impresscart']['shipping_method']);
			$this->data['message'] = __('ups shipping method setting updated successfully');
		} 
		
		$this->data['text_enabled'] = __('Enabled');
		$this->data['text_disabled'] = __('Disabled');
		$this->data['text_yes'] = __('Yes');
		$this->data['text_no'] = __('No');		
		$this->data['text_select_all'] = __('Select all');
		$this->data['text_unselect_all'] = __('Unselect all');		
		$this->data['text_all_zones'] = __('All Zones');
		$this->data['text_none'] = __('None');
		$this->data['text_next_day_air'] = __('UPS Next Day Air');
		$this->data['text_2nd_day_air'] = __('UPS Second Day Air');
		$this->data['text_ground'] = __('UPS Ground');
		$this->data['text_worldwide_express'] = __('UPS Worldwide Express');
		$this->data['text_worldwide_express_plus'] = __('UPS Worldwide Express Plus');
		$this->data['text_worldwide_expedited'] = __('UPS Worldwide Expedited');
		$this->data['text_express'] = __('UPS Express');
		$this->data['text_standard'] = __('UPS Standard');
		$this->data['text_3_day_select'] = __('UPS Three-Day Select');
		$this->data['text_next_day_air_saver'] = __('UPS Next Day Air Saver');
		$this->data['text_next_day_air_early_am'] = __('UPS Next Day Air Early A.M.');
		$this->data['text_expedited'] = __('UPS Expedited');
		$this->data['text_2nd_day_air_am'] = __('UPS Second Day Air A.M.');
		$this->data['text_saver'] = __('UPS Saver');
		$this->data['text_express_early_am'] = __('UPS Express Early A.M.');
		$this->data['text_express_plus'] = __('UPS Express Plus');
		$this->data['text_today_standard'] = __('UPS Today Standard');
		$this->data['text_today_dedicated_courier'] = __('UPS Today Dedicated Courier');
		$this->data['text_today_intercity'] = __('UPS Today Intercity');
		$this->data['text_today_express'] = __('UPS Today Express');
		$this->data['text_today_express_saver'] = __('UPS Today Express Saver');
		 
		$this->data['entry_key'] = __('Access Key:<span class="help">Enter the XML rates access key assigned to you by UPS.</span>');
		$this->data['entry_username'] = __('Username:<span class="help">Enter your UPS Services account username.</span>');
		$this->data['entry_password'] = __('Password:<span class="help">Enter your UPS Services account password.</span>');
		$this->data['entry_pickup'] = __('Pickup Method:<span class="help">How do you give packages to UPS (only used when origin is US)?</span>');
		$this->data['entry_packaging'] = __('Packaging Type:<span class="help">What kind of packaging do you use?</span>');
		$this->data['entry_classification'] = __('Customer Classification Code:<span class="help">01 - If you are billing to a UPS account and have a daily UPS pickup, 03 - If you do not have a UPS account or you are billing to a UPS account but do not have a daily pickup, 04 - If you are shipping from a retail outlet (only used when origin is US)</span>');
		$this->data['entry_origin'] = __('Shipping Origin Code:<span class="help">What origin point should be used (this setting affects only what UPS product names are shown to the user)</span>');
		$this->data['entry_city'] = __('Origin City:<span class="help">Enter the name of the origin city.</span>');
		$this->data['entry_state'] = __('Origin State/Province:<span class="help">Enter the two-letter code for your origin state/province.</span>');
		$this->data['entry_country'] = __('Origin Country:<span class="help">Enter the two-letter code for your origin country.</span>');
		$this->data['entry_postcode'] = __('Origin Zip/Postal Code:<span class="help">Enter your origin zip/postalcode.</span>');
		$this->data['entry_test'] = __('Test Mode:<span class="help">Use this module in Test (YES) or Production mode (NO)?</span>');
		$this->data['entry_quote_type'] = __('Quote Type:<span class="help">Quote for Residential or Commercial Delivery.</span>');
		$this->data['entry_service'] = __('Services:<span class="help">Select the UPS services to be offered.</span>');
		$this->data['entry_insurance'] = __('Enable Insurance:<span class="help">Enables insurance with product total as the value</span>');
		$this->data['entry_display_weight'] = __('Display Delivery Weight:<br /><span class="help">Do you want to display the shipping weight? (e.g. Delivery Weight : 2.7674 Kg\'s)</span>');
		$this->data['entry_weight_class'] = __('Weight Class:<span class="help">Set to kilograms or pounds.</span>');
		$this->data['entry_length_code'] = __('Length Class:<span class="help">Set to centimeters or inches.</span>');
		$this->data['entry_length_class'] = __('Length Class:<span class="help">Set to centimeters or inches.</span>');
		$this->data['entry_dimension'] = __('Dimensions (L x W x H):<br /><span class="help">This is assumed to be your average packing box size. Individual item dimensions are not supported at this time so you must enter average dimensions like 5x5x5.</span>');
		$this->data['entry_tax_class'] = __('Tax Class:');
		$this->data['entry_geo_zone'] = __('Geo Zone:');
		$this->data['entry_status'] = __('Status:');
		$this->data['entry_sort_order'] = __('Sort Order:');
		$this->data['entry_debug'] = __('Debug Mode:<br /><span class="help">Saves send/recv data to the system log</span>');
		
		$this->data['button_save'] = __('Save');
		$this->data['button_cancel'] = __('Cancel');
		

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->error['key'])) {
			$this->data['error_key'] = $this->error['key'];
		} else {
			$this->data['error_key'] = '';
		}

		if (isset($this->error['username'])) {
			$this->data['error_username'] = $this->error['username'];
		} else {
			$this->data['error_username'] = '';
		}

		if (isset($this->error['password'])) {
			$this->data['error_password'] = $this->error['password'];
		} else {
			$this->data['error_password'] = '';
		}
		
		if (isset($this->error['city'])) {
			$this->data['error_city'] = $this->error['city'];
		} else {
			$this->data['error_city'] = '';
		}

		if (isset($this->error['state'])) {
			$this->data['error_state'] = $this->error['state'];
		} else {
			$this->data['error_state'] = '';
		}

		if (isset($this->error['country'])) {
			$this->data['error_country'] = $this->error['country'];
		} else {
			$this->data['error_country'] = '';
		}
		
		if (isset($this->error['dimension'])) {
			$this->data['error_dimension'] = $this->error['dimension'];
		} else {
			$this->data['error_dimension'] = '';
		}

		$this->data['ups_key'] = @$current_setting['ups_key'];		
		$this->data['ups_username'] = @$current_setting['ups_username'];
		$this->data['ups_password'] = @$current_setting['ups_password'];
		$this->data['ups_pickup'] = @$current_setting['ups_pickup'];
		
		$this->data['pickups'] = array();
		  
		$this->data['pickups'][] = array(
			'value' => '01',
			'text'  => __('Daily Pickup')
		);

		$this->data['pickups'][] = array(
			'value' => '03',
			'text'  => __('Customer Counter')
		);

		$this->data['pickups'][] = array(
			'value' => '06',
			'text'  => __('One Time Pickup')
		);

		$this->data['pickups'][] = array(
			'value' => '07',
			'text'  => __('On Call Air Pickup')
		);

		$this->data['pickups'][] = array(
			'value' => '19',
			'text'  => __('Letter Center')
		);		
		
		$this->data['pickups'][] = array(
			'value' => '20',
			'text'  => __('Air Service Center')
		);	
		
		$this->data['pickups'][] = array(
			'value' => '11',
			'text'  => __('Suggested Retail Rates (UPS Store)')
		);	
		
		$this->data['ups_packaging'] = @$current_setting['ups_packaging'];
						
		$this->data['packages'] = array();
		  
		$this->data['packages'][] = array(
			'value' => '02',
			'text'  => __('Package')
		);

		$this->data['packages'][] = array(
			'value' => '01',
			'text'  => __('UPS Letter')
		);

		$this->data['packages'][] = array(
			'value' => '03',
			'text'  => __('UPS Tube')
		);

		$this->data['packages'][] = array(
			'value' => '04',
			'text'  => __('UPS Pak')
		);

		$this->data['packages'][] = array(
			'value' => '21',
			'text'  => __('UPS Express Box')
		);		
		
		$this->data['packages'][] = array(
			'value' => '24',
			'text'  => __('UPS 25kg box')
		);	
		
		$this->data['packages'][] = array(
			'value' => '25',
			'text'  => __('UPS 10kg box')
		);	
		
		$this->data['ups_classification'] = @$current_setting['ups_classification'];
						
		$this->data['classifications'][] = array(
			'value' => '01',
			'text'  => '01'
		);		
		
		$this->data['classifications'][] = array(
			'value' => '03',
			'text'  => '03'
		);	
		
		$this->data['classifications'][] = array(
			'value' => '04',
			'text'  => '04'
		);			
		
		$this->data['ups_origin'] = @$current_setting['ups_origin'];
				
		$this->data['origins'] = array();
		  
		$this->data['origins'][] = array(
			'value' => 'US',
			'text'  => __('US Origin')
		);

		$this->data['origins'][] = array(
			'value' => 'CA',
			'text'  => __('Canada Origin')
		);

		$this->data['origins'][] = array(
			'value' => 'EU',
			'text'  => __('European Union Origin')
		);

		$this->data['origins'][] = array(
			'value' => 'PR',
			'text'  => __('Puerto Rico Origin')
		);

		$this->data['origins'][] = array(
			'value' => 'MX',
			'text'  => __('Mexico Origin')
		);		

		$this->data['origins'][] = array(
			'value' => 'other',
			'text'  => __('All Other Origins')
		);	
		
		$this->data['ups_city'] = @$current_setting['ups_city'];
		$this->data['ups_state'] = @$current_setting['ups_state'];
		$this->data['ups_country'] = @$current_setting['ups_country'];
		$this->data['ups_postcode'] = @$current_setting['ups_postcode'];
		$this->data['ups_test'] = @$current_setting['ups_test'];
		$this->data['ups_quote_type'] = @$current_setting['ups_quote_type'];
		
		$this->data['quote_types'] = array();
		  
		$this->data['quote_types'][] = array(
			'value' => 'residential',
			'text'  => __('Residential')
		);

		$this->data['quote_types'][] = array(
			'value' => 'commercial',
			'text'  => __('Commercial')
		);
		
		// US
		$this->data['ups_us_01'] = @$current_setting['ups_us_01'];
		$this->data['ups_us_02'] = @$current_setting['ups_us_02'];
		$this->data['ups_us_03'] = @$current_setting['ups_us_03'];
		$this->data['ups_us_07'] = @$current_setting['ups_us_07'];
		$this->data['ups_us_08'] = @$current_setting['ups_us_08'];
		$this->data['ups_us_11'] = @$current_setting['ups_us_11'];
		$this->data['ups_us_12'] = @$current_setting['ups_us_12'];
		$this->data['ups_us_13'] = @$current_setting['ups_us_13'];
		$this->data['ups_us_14'] = @$current_setting['ups_us_14'];
		$this->data['ups_us_54'] = @$current_setting['ups_us_54'];
		$this->data['ups_us_59'] = @$current_setting['ups_us_59'];
		$this->data['ups_us_65'] = @$current_setting['ups_us_65'];
		$this->data['ups_pr_01'] = @$current_setting['ups_pr_01'];
		$this->data['ups_pr_02'] = @$current_setting['ups_pr_02'];
		$this->data['ups_pr_03'] = @$current_setting['ups_pr_03'];
		$this->data['ups_pr_07'] = @$current_setting['ups_pr_07'];
		$this->data['ups_pr_08'] = @$current_setting['ups_pr_08'];
		$this->data['ups_pr_14'] = @$current_setting['ups_pr_14'];
		$this->data['ups_pr_54'] = @$current_setting['ups_pr_54'];
		$this->data['ups_pr_65'] = @$current_setting['ups_pr_65'];
		$this->data['ups_ca_01'] = @$current_setting['ups_ca_01'];
		$this->data['ups_ca_02'] = @$current_setting['ups_ca_02'];
		$this->data['ups_ca_07'] = @$current_setting['ups_ca_07'];
		$this->data['ups_ca_08'] = @$current_setting['ups_ca_08'];
		$this->data['ups_ca_11'] = @$current_setting['ups_ca_11'];
		$this->data['ups_ca_12'] = @$current_setting['ups_ca_12'];
		$this->data['ups_ca_13'] = @$current_setting['ups_ca_13'];
		$this->data['ups_ca_14'] = @$current_setting['ups_ca_14'];
		$this->data['ups_ca_54'] = @$current_setting['ups_ca_54'];
		$this->data['ups_ca_65'] = @$current_setting['ups_ca_65'];
		$this->data['ups_mx_07'] = @$current_setting['ups_mx_07'];
		$this->data['ups_mx_08'] = @$current_setting['ups_mx_08'];
		$this->data['ups_mx_54'] = @$current_setting['ups_mx_54'];
		$this->data['ups_mx_65'] = @$current_setting['ups_mx_65'];
		$this->data['ups_eu_07'] = @$current_setting['ups_eu_07'];
		$this->data['ups_eu_08'] = @$current_setting['ups_eu_08'];
		$this->data['ups_eu_11'] = @$current_setting['ups_eu_11'];
		$this->data['ups_eu_54'] = @$current_setting['ups_eu_54'];
		$this->data['ups_eu_65'] = @$current_setting['ups_eu_65'];
		$this->data['ups_eu_82'] = @$current_setting['ups_eu_82'];
		$this->data['ups_eu_83'] = @$current_setting['ups_eu_83'];
		$this->data['ups_eu_84'] = @$current_setting['ups_eu_84'];
		$this->data['ups_eu_85'] = @$current_setting['ups_eu_85'];
		$this->data['ups_eu_86'] = @$current_setting['ups_eu_86'];
		$this->data['ups_other_07'] = @$current_setting['ups_other_07'];
		$this->data['ups_other_08'] = @$current_setting['ups_other_08'];
		$this->data['ups_other_11'] = @$current_setting['ups_other_11'];
		$this->data['ups_other_54'] = @$current_setting['ups_other_54'];
		$this->data['ups_other_65'] = @$current_setting['ups_other_65'];
		$this->data['ups_display_weight'] = @$current_setting['ups_display_weight'];
		$this->data['ups_insurance'] = @$current_setting['ups_insurance'];
		$this->data['ups_weight_class_id'] = @$current_setting['ups_weight_class_id'];
		$this->data['ups_length_code'] = @$current_setting['ups_length_code'];
		$this->data['ups_length_class_id'] = @$current_setting['ups_length_class_id'];
		$this->data['ups_length'] = @$current_setting['ups_length'];
		$this->data['ups_width'] = @$current_setting['ups_width'];
		$this->data['ups_height'] = @$current_setting['ups_height'];
		$this->data['ups_tax_class_id'] = @$current_setting['ups_tax_class_id'];
		$this->data['ups_geo_zone_id'] = @$current_setting['ups_geo_zone_id'];
		$this->data['ups_status'] = @$current_setting['enabled'];
		$this->data['ups_sort_order'] = @$current_setting['ups_sort_order'];
		$this->data['ups_debug'] = @$current_setting['ups_debug'];
		
		$this->data['heading'] = __('UPS shipping method setting');
				
		$table = impresscart_framework::table('tax_class');
	    $rows = $table->fetchAll();
	    
	    $tax_classes_html = "<select name=\"impresscart[shipping_method][ups][ups_tax_class_id]\"><option option='0'>Select</option>";
	    
	    foreach ($rows as $row) {
	    	
	    	if($row->tax_class_id == @$current_setting['ups_tax_class_id'])
	      	{
	      		$tax_classes_html .= "<option selected='selected' value='".$row->tax_class_id."'>".$row->title."</option>";
	      		
	      	} else {
	      		
	     		$tax_classes_html .= "<option value='".$row->tax_class_id."'>".$row->title."</option>";
	     			
	     	}
	      
	    }
	    
	    $tax_classes_html .= '</select>';
    
	    /* geozone html */
	    
		$table = impresscart_framework::table('geo_zone');
	    $rows = $table->fetchAll();
	    $geo_zones = array();
	    $geo_zones[] = array('name' => 'All', 'value' => '');
	    $geo_zones_html = "<select name=\"impresscart[shipping_method][ups][ups_geo_zone_id]\"><option value='0'>Select</option>";
	    foreach ($rows as $row) {
	      if($row->geo_zone_id == @$current_setting['ups_geo_zone_id'])
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
	    
	    /* length class html */
	    
	    /* weight class html */
	    $table = impresscart_framework::table('unit');
	    
	    $length_classes = $table->fetchAll(array('conditions' => array('type' => 'length' )));
	    
	    //var_dump($length_classes);die();
	    
	    $length_class_html = "<select name=\"impresscart[shipping_method][ups][ups_length_class_id]\">";

	    foreach($length_classes as $item)
	    {
	    	if($item->unit_id == @$current_setting['ups_length_class_id'])
	    	{
	    		$length_class_html .= "<option select='selected' value='" . $item->unit_id . "'>" . $item->title . "</option>";
	    	} else {
	    		$length_class_html .= "<option value='" . $item->unit_id . "'>" . $item->title . "</option>";
	    	}
	    }
	    
	    
	    $this->data['length_class_html'] = $length_class_html;
	   	
		$weight_classes = $table->fetchAll(array('conditions' => array('type' => 'weight' )));
	    
	    $weight_class_html = "<select name=\"impresscart[shipping_method][ups][ups_weight_class_id]\">";

	    foreach($weight_classes as $item)
	    {
	    	if($item->unit_id == @$current_setting['ups_weight_class_id'])
	    	{
	    		$weight_class_html .= "<option select='selected' value='" . $item->unit_id . "'>" . $item->title . "</option>";
	    	} else {
	    		$weight_class_html .= "<option value='" . $item->unit_id . "'>" . $item->title . "</option>";
	    	}
	    }
	    
	    $this->data['weight_class_html'] = $weight_class_html;	   
	    $this->data['pages'] = apply_filters('impresscart_administration_pages', array());
	}
}

