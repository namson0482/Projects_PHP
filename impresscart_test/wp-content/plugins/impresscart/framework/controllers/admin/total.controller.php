<?php

class impresscart_admin_total_controller extends impresscart_framework_controller {

	public function index() {
			
		$this->data['heading_title'] = __('Impresscart -> Order Total Settings');
		$this->data['breadcrumbs'] = array();
		$this->data['breadcrumbs'][] = array(
       		'text'      => __('Home'),
			'href'      => 'admin.php?page=itmarket-admin.php',
      		'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
       	'text'      => __('Order Totals'),
		'href'      => 'admin.php?page=total', 
      	'separator' => ' :: '
      	);

      	$this->data['heading_title'] = __('Order Totals');
      	$this->data['text_no_results'] = __('No results');
      	$this->data['text_confirm'] = __('Confirm');
      	$this->data['column_name'] = __('Order Totals');
      	$this->data['column_status'] = __('Status');
      	$this->data['column_sort_order'] = __('Sort Order');
      	$this->data['column_action'] = __('Action');

      	if (isset($this->session->data['success'])) {
      		$this->data['success'] = $this->session->data['success'];

      		unset($this->session->data['success']);
      	} else {
      		$this->data['success'] = '';
      	}

      	if (isset($this->session->data['error'])) {
      		$this->data['error'] = $this->session->data['error'];

      		unset($this->session->data['error']);
      	} else {
      		$this->data['error'] = '';
      	}
      	$impresscart_totals = get_option('impresscart_totals', true);
      	$totals = apply_filters('impresscart_totals', array());
      	$all_extentions = impresscart_totals::get_all_totals();
      	$result = array();
      	foreach ($totals as $total => $value) {
      		$code = $value['code'];
      		$value = Goscom::arrayPutLastPosition($value, 'no', 'status');
      		$action = array(
      			'href' => 'admin.php?page=total&fwurl=/admin/'.$value['code']. '/setting',
      			'text' => 'Edit',
      		);
      		$value = Goscom::arrayPutLastPosition($value, $action, 'action');
      		foreach ($all_extentions as $extension) {

      		 if($code == $extension['code']) {

      		 	$value['status'] = $extension['status'];//'yes';

      		 	$value['order'] = $extension['order'];

      		 	break;
      		 }
      		}
      		array_push($result, $value);
      	}
      	$this->data['totals'] = $result;
      	 
      	$this->data['pages'] = apply_filters('impresscart_administration_pages', array());
	}

}