<?php

class impresscart_admin_tax_controller extends impresscart_framework_controller {
	
function getNewSetting($data) {

		return (array(
				'name' =>  'Tax',
				'order' => $data['order'],
				'status' => $data['status'] == 1 ? 'yes' : 'no',
				'code' => 'tax',
		));
	}
	
	function setting() {
		
		$this->data['heading'] = __('Total Tax setting');
		
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			
			$result = $this->getNewSetting($_POST);
			//var_dump($result);
			
			$this->model_total_tax->update_setting($result);
			//impresscart_totals::dumpAllExtensionTotals();
			//die('aaaa');
			$this->session->data['success'] = __('Total Tax setting updated successfully');
			$this->redirect('admin.php?page=total');
		} 
		
		$current_setting = $this->model_total_tax->get_setting();
		//var_dump($current_setting);
		$this->data['heading_title'] = __('Tax');

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


		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
       		'text'      => __('Home'),
			'href'      => 'admin.php?page=itmarket-admin.php',
      		'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
       	'text'      => __('Tax Totals'),
		'href'      => 'admin.php?page=total', 
      	'separator' => ' :: '
      	);

      	$this->data['breadcrumbs'][] = array(
       		'text'      => __('Tax'),
			'href'      => '#',
      		'separator' => ' :: '
      		);

      	$this->data['cancel'] = 'admin.php?page=total';

      	if ($current_setting['status'] == 'yes') {
      		$this->data['tax_status'] = true;
      	} else {
      		$this->data['tax_status'] = false;
      	}
      	
      	
      	$this->data['tax_order'] = $current_setting['order'];

      	$this->data['pages'] = apply_filters('impresscart_administration_pages', array());
	}
}