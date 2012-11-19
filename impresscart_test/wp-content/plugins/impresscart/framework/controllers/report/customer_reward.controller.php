<?php
class impresscart_report_customer_reward_controller extends impresscart_framework_controller {
	public function index() {

		if (isset($_GET['filter_date_start'])) {
			$filter_date_start = $_GET['filter_date_start'];
		} else {
			$filter_date_start = '';
		}

		if (isset($_GET['filter_date_end'])) {
			$filter_date_end = $_GET['filter_date_end'];
		} else {
			$filter_date_end = '';
		}

		$url = '';

		if (isset($_GET['filter_date_start'])) {
			$url .= '&filter_date_start=' . $_GET['filter_date_start'];
		}

		if (isset($_GET['filter_date_end'])) {
			$url .= '&filter_date_end=' . $_GET['filter_date_end'];
		}

		$data = array(
			'filter_date_start'	=> $filter_date_start, 
			'filter_date_end'	=> $filter_date_end, 
			'start'             => 0,
			'limit'             => $this->config->get('config_admin_limit')
		);

		$this->data = $data;
		$this->data['customers'] = array();
		//$customer_total = $this->model_report_customer->getTotalRewardPoints($data);
		$results = $this->model_report_customer->getRewardPoints($data);
		if(count($results)) {
			foreach ($results as $result) {
				$action = array();
				$action[] = array(
				'text' => __('Edit'),
				'href' => '' //$this->url->link('sale/customer/update', 'token=' . $this->session->data['token'] . '&customer_id=' . $result['customer_id'] . $url, 'SSL')
				);

				$this->data['customers'][] = array(
				'customer'       => $result['customer'],
				'email'          => $result['email'],
				'customer_group' => $result['customer_group'],
				'status'         => ($result['status'] ? __('Enable') : __('Disabled')),
				'points'         => $result['points'],
				'orders'         => $result['orders'],
				'total'          => $this->currency->format($result['totals']),
				'action'         => $action
				);
			}
		}
			
		$this->data['heading'] = __('Customer Reward Report');
		$this->data['text_no_results'] = __('No Results');
		$this->data['column_customer'] = __('Customer');
		$this->data['column_email'] = __('Email');
		$this->data['column_customer_group'] = __('Group');
		$this->data['column_status'] = __('Status');
		$this->data['column_points'] = __('Reward Points');
		$this->data['column_orders'] = __('Orders');
		$this->data['column_total'] = __('Total');
		$this->data['entry_date_start'] = __('Date start');
		$this->data['entry_date_end'] = __('Date end');
		$this->data['button_filter'] = __('Filter');

		$url = '';
		if (isset($_GET['filter_date_start'])) {
			$url .= '&filter_date_start=' . $_GET['filter_date_start'];
		}

		if (isset($_GET['filter_date_end'])) {
			$url .= '&filter_date_end=' . $_GET['filter_date_end'];
		}
		
		$this->data['pages'] = apply_filters('impresscart_administration_pages', array());
		
	}
}
?>