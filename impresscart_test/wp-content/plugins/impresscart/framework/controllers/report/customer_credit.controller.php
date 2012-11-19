<?php
class impresscart_report_customer_credit_controller extends impresscart_framework_controller {
	public function index() {     

		if (isset($_GET['page'])) {
			$page = $_GET['page'];
		} else {
			$page = 1;
		}
		$url = '';
		$this->data['customers'] = array();
		$customers_total = $this->model_report_customer->getTotalCredit(); 
		foreach ($customers_total as $customer) {
			$action = array();
			$action[] = array(
				'text' => _('Edit'),
				'href' => admin_url( 'user-edit.php?user_id=' . $customer['id'], 'http' )
			);
			$this->data['customers'][] = array(
				'customer'       => $customer['customer'],
				'email'          => $customer['email'],
				'customer_group' => $customer['customer_group'],
				'status'         => $customer['status'],
				'total'          => $this->currency->format($customer['total'], $this->config->get('config_currency')),
				'action'         => $action
			);
		}
		 
 		$this->data['heading'] = _('Customer Credit');
		 
		$this->data['text_no_results'] = _('No Results');
		
		$this->data['column_customer'] = _('Customer');
		$this->data['column_email'] = _('Email');
		$this->data['column_customer_group'] = _('Customer Group');
		$this->data['column_status'] = _('Status');
		$this->data['column_total'] = _('Total');
		$this->data['column_action'] = _('Action');
		
		$this->data['pages'] = apply_filters('impresscart_administration_pages', array());

	}
}
?>