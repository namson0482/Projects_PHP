<?php

class impresscart_report_sale_tax_controller extends impresscart_framework_controller {

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

		if (isset($_GET['filter_group'])) {
			$filter_group = $_GET['filter_group'];
		} else {
			$filter_group = 'week';
		}

		if (isset($_GET['filter_order_status_id'])) {
			$filter_order_status_id = $_GET['filter_order_status_id'];
		} else {
			$filter_order_status_id = 0;
		}

		$url = get_bloginfo('url') . '/wp-admin/admin.php?page=catalog&fwurl=/report/sale_tax/';

		if (isset($_GET['filter_date_start'])) {
			$url .= '&filter_date_start=' . $_GET['filter_date_start'];
		}

		if (isset($_GET['filter_date_end'])) {
			$url .= '&filter_date_end=' . $_GET['filter_date_end'];
		}

		if (isset($_GET['filter_group'])) {
			$url .= '&filter_group=' . $_GET['filter_group'];
		}

		if (isset($_GET['filter_order_status_id'])) {
			$url .= '&filter_order_status_id=' . $_GET['filter_order_status_id'];
		}

		$this->data['orders'] = array();
		$data = array(
			'filter_date_start'	     => $filter_date_start, 
			'filter_date_end'	     => $filter_date_end, 
			'filter_group'           => $filter_group,
			'filter_order_status_id' => $filter_order_status_id,
			'start'                  => 0,
			'limit'                  => $this->config->get('admin_limit')
		);

		$this->data = $data;

		$this->data['orders'] = array();

		$results = $this->model_report_sale->getTaxes($data);
		if(count($results))
		foreach ($results as $result) {
			$this->data['orders'][] = array(
				'date_start' => date(__('d-m-y'), strtotime($result['date_start'])),
				'date_end'   => date(__('d-m-y'), strtotime($result['date_end'])),
				'title'      => $result['title'],
				'orders'     => $result['orders'],
				'total'      => $this->currency->format($result['total'], $this->config->get('config_currency'))
			);
		}
		$this->data['heading'] = __('Impress Cart Order Tax Total Report');

		$this->data['text_no_results'] = __('no results');
		$this->data['text_all_status'] = __('All Statues');
		$this->data['column_date_start'] = __('Date start');
		$this->data['column_date_end'] = __('Date end');
		$this->data['column_title'] = __('Tax Title');
		$this->data['column_orders'] = __('Num of Orders');
		$this->data['column_total'] = __('Tax Total');
		$this->data['entry_date_start'] = __('Date Start');
		$this->data['entry_date_end'] = __('Date end');
		$this->data['entry_group'] = __('Group By');
		$this->data['entry_status'] = __('Order Status');
		$this->data['button_filter'] = __('Filter');
		$order_status_data = $this->config->get('order_status_data');
		foreach($order_status_data as $key => $value)
		{
			$this->data['order_statuses'][] = array(
                'order_status_id' => $key,
                'name' => $value,
			);
		}

		$this->data['groups'] = array();

		$this->data['groups'][] = array(
			'text'  => __('Year'),
			'value' => 'year',
		);

		$this->data['groups'][] = array(
			'text'  => __('Month'),
			'value' => 'month',
		);

		$this->data['groups'][] = array(
			'text'  => __('Week'),
			'value' => 'week',
		);

		$this->data['groups'][] = array(
			'text'  => __('Day'),
			'value' => 'day',
		);

		$this->data['url'] = $url;

		if (isset($_GET['filter_date_start'])) {
			$url .= '&filter_date_start=' . $_GET['filter_date_start'];
		}

		if (isset($_GET['filter_date_end'])) {
			$url .= '&filter_date_end=' . $_GET['filter_date_end'];
		}

		if (isset($_GET['filter_group'])) {
			$url .= '&filter_group=' . $_GET['filter_group'];
		}

		if (isset($_GET['filter_order_status_id'])) {
			$url .= '&filter_order_status_id=' . $_GET['filter_order_status_id'];
		}
		
		$this->data['pages'] = apply_filters('impresscart_administration_pages', array());
		
	}
}
?>