<?php

class impresscart_admin_reward_controller extends impresscart_framework_controller {
	
	
	function getNewSetting($data) {

		return (array(
				'name' =>  'Reward',
				'order' => $data['order'],
				'status' => $data['status'] == 1 ? 'yes' : 'no',
				'code' => 'reward',
		));
	}
	
	function setting() {
		
		$this->data['heading'] = __('Total reward setting');
		
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			
			$result = $this->getNewSetting($_POST);
			$this->model_total_reward->update_setting($result);
			$this->session->data['success'] = __('Total reward setting updated successfully');
			$this->redirect('admin.php?page=total');
		} 
		
		$current_setting = $this->model_total_reward->get_setting();
		
		$this->data['heading_title'] = __('Reward');

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
       	'text'      => __('Reward Totals'),
		'href'      => 'admin.php?page=total', 
      	'separator' => ' :: '
      	);

      	$this->data['breadcrumbs'][] = array(
       		'text'      => __('Reward'),
			'href'      => '#',
      		'separator' => ' :: '
      		);

      	$this->data['cancel'] = 'admin.php?page=total';

      	if ($current_setting['status'] == 'yes') {
      		$this->data['reward_status'] = true;
      	} else {
      		$this->data['reward_status'] = false;
      	}
      	
      	
      	$this->data['reward_order'] = $current_setting['order'];	
      	$this->data['pages'] = apply_filters('impresscart_administration_pages', array());	
	}
}