<?php

class impresscart_admin_coupontotal_controller extends impresscart_framework_controller {
	
	public function index() {
		
	}
	
	function getNewSetting($data) {
		return (array(
				'name' =>  'coupon',
				'order' => $data['order'],
				'status' => $data['status'] == 1 ? 'yes' : 'no',
				'code' => 'coupontotal',
				));
	}
	
	function setting()	{
		
		$this->data['heading'] = __('Total coupon setting');
		
		if (($_SERVER['REQUEST_METHOD'] == 'POST')) {
			
			$result = $this->getNewSetting($_POST);
			
			$this->model_total_coupontotal->update_setting($result);
			
			$this->session->data['success'] = __('Total coupon setting updated successfully');
			
			$url = get_bloginfo('url') . '/wp-admin/' . 'admin.php?page=total';		
			$this->redirect($url);			
			exit();
		}
		
		
		$current_setting = $this->model_total_coupontotal->get_setting();
		
		$this->data['heading_title'] = __('Coupon');
		$this->data['text_enabled'] = __('Enabled');
		$this->data['text_disabled'] = __('Disabled');
		
		$this->data['entry_status'] = __('Status');
		$this->data['entry_order'] = __('Sort Order');
					
		$this->data['button_save'] = __('Save');
		$this->data['button_cancel'] = __('Cancel');

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['Warning'];
		} else {
			$this->data['error_warning'] = '';
		}

   		$this->data['cancel'] = 'admin.php?page=total';
		
		if ($current_setting['status'] == 'yes') {
			$this->data['coupon_status'] = true;
		} else {
			$this->data['coupon_status'] = false;
		}
		$this->data['coupon_order'] = $current_setting['order'];
		
		$this->data['pages'] = apply_filters('impresscart_administration_pages', array());
	}
}