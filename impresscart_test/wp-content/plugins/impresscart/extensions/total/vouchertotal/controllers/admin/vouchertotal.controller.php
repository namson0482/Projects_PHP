<?php

class impresscart_admin_vouchertotal_controller extends impresscart_framework_controller {

	function getNewSetting($data) {

		return (array(
				'name' =>  'Voucher',
				'order' => $data['order'],
				'status' => $data['status'] == 1 ? 'yes' : 'no',
				'code' => 'vouchertotal',
		));
	}

	function setting() {

		$this->data['heading'] = __('Total Voucher setting');

		if($_SERVER['REQUEST_METHOD'] == 'POST') {
				
			$result = $this->getNewSetting($_POST);
			$this->model_total_vouchertotal->update_setting($result);
			$this->session->data['success'] = __('Total Voucher setting updated successfully');
			$this->redirect('admin.php?page=total');
		}
		
		//model_total_coupontotal
		$current_setting = $this->model_total_vouchertotal->get_setting();

		$this->data['heading_title'] = __('Voucher');

		$this->data['text_enabled'] = __('Enabled');
		$this->data['text_disabled'] = __('Disabled');

		$this->data['entry_status'] = __('Status');
		$this->data['entry_order'] = __('Sort Order');
			
		$this->data['button_save'] = __('Save');
		$this->data['button_cancel'] = __('Cancel');
	
		
		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = __('Warning');
		} else {
			$this->data['error_warning'] = '';
		}


		$this->data['cancel'] = 'admin.php?page=total';

		if ($current_setting['status'] == 'yes') {
			$this->data['voucher_status'] = true;
		} else {
			$this->data['voucher_status'] = false;
		}
		 
		$this->data['entry_status'] = __('Status');
		$this->data['voucher_order'] = $current_setting['order'];
		
		$this->data['pages'] = apply_filters('impresscart_administration_pages', array());
	}
}