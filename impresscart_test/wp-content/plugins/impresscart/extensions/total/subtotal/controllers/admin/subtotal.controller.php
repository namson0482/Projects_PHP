<?php

class impresscart_admin_subtotal_controller extends impresscart_framework_controller {
	
function getNewSetting($data) {

		return (array(
				'name' =>  'Sub_Total',
				'order' => $data['order'],
				'status' => $data['status'] == 1 ? 'yes' : 'no',
				'code' => 'subtotal',
		));
	}
	
	function setting() {
		
		$this->data['heading'] = __('Sub Total setting');
		
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			
			$result = $this->getNewSetting($_POST);
			$this->model_total_subtotal->update_setting($result);
			$this->session->data['success'] = __('Total Sub_Total setting updated successfully');
			$this->redirect('admin.php?page=total');
		} 
		
		$current_setting = $this->model_total_subtotal->get_setting();
		
		$this->data['heading_title'] = __('Sub_Total');

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
      		$this->data['subtotal_status'] = true;
      	} else {
      		$this->data['subtotal_status'] = false;
      	}
      	
      	
      	$this->data['subtotal_order'] = $current_setting['order'];
      	$this->data['pages'] = apply_filters('impresscart_administration_pages', array());
	}
}