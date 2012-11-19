<?php

class impresscart_admin_free_controller extends impresscart_framework_controller {
	

	private $error = array(); 
	
	public function index() {   
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('free', $_POST);		
					
			$this->session->data['success'] = __('text_success');
						
			$this->redirect($this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL'));
		}
				
		$this->data['heading_title'] = __('Free Shipping Method');

		$this->data['text_enabled'] = __('Enabled');
		$this->data['text_disabled'] = __('Disabled');
		$this->data['text_all_zones'] = __('All zones');
		$this->data['text_none'] = __('None');
		
		$this->data['entry_total'] = __('Total');
		$this->data['entry_geo_zone'] = __('Geo Zone');
		$this->data['entry_status'] = __('Status');
		$this->data['entry_sort_order'] = __('Sort Order');
		
		$this->data['button_save'] = __('Save');
		$this->data['button_cancel'] = __('Cancel');

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => __('Home'),
			'href'      => get_home_url(),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => __('Shipping'),
			'href'      => '#',
      		'separator' => ' :: '
   		);
		
   		$this->data['breadcrumbs'][] = array(
       		'text'      => __('Free Shipping'),
			'href'      => '#',
      		'separator' => ' :: '
   		);
		
		$this->data['action'] = '';
		
		$this->data['cancel'] = '';
	
		if (isset($_POST['free_total'])) {
			$this->data['free_total'] = $_POST['free_total'];
		} else {
			$this->data['free_total'] = $this->config->get('free_total');
		}

		if (isset($_POST['free_geo_zone_id'])) {
			$this->data['free_geo_zone_id'] = $_POST['free_geo_zone_id'];
		} else {
			$this->data['free_geo_zone_id'] = $this->config->get('free_geo_zone_id');
		}
		
		if (isset($_POST['free_status'])) {
			$this->data['free_status'] = $_POST['free_status'];
		} else {
			$this->data['free_status'] = $this->config->get('free_status');
		}
		
		if (isset($_POST['free_sort_order'])) {
			$this->data['free_sort_order'] = $_POST['free_sort_order'];
		} else {
			$this->data['free_sort_order'] = $this->config->get('free_sort_order');
		}				
		
		$this->load->model('localisation/geo_zone');
		
		$this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();
								
		$this->template = 'shipping/free.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	}
	
	private function validate() {
		if (!$this->user->hasPermission('modify', 'shipping/free')) {
			$this->error['warning'] = __('error_permission');
		}
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
}