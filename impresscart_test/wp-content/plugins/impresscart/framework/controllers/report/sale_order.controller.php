<?php
class impresscart_report_sale_order_controller extends impresscart_framework_controller {
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

		if( isset($filter_date_start) ) {
			$this->data['filter_date_start'] = $filter_date_start;
		}
		if( isset($filter_date_end) ) {
			$this->data['filter_date_end'] = $filter_date_end;
		}
		if( isset($filter_group) ) {
			$this->data['filter_group'] = $filter_group;
		}
		if( isset($filter_order_status_id) ) {
			$this->data['filter_order_status_id'] = $filter_order_status_id;
		}


		$data = array(
                        'filter_date_start'	     => $filter_date_start, 
                        'filter_date_end'        => $filter_date_end, 
                        'filter_group'           => $filter_group,
                        'filter_order_status_id' => $filter_order_status_id,
                        'start'                  => 0,
                        'limit'                  => $this->config->get('config_admin_limit')
		);

		$this->data = $data;

		$this->data['orders'] = array();

		$results = $this->model_report_sale->getOrders($data);
		if(count($results))
		foreach ($results as $result) {
			$this->data['orders'][] = array(
	                                'date_start' => date(__('d-m-y'), strtotime($result['date_start'])),
	                                'date_end'   => date(__('d-m-y'), strtotime($result['date_end'])),
	                                'orders'     => $result['orders'],
	                                'products'   => $result['products'],
	                                'tax'        => $this->currency->format($result['tax'], $this->config->get('config_currency')),
	                                'total'      => $this->currency->format($result['total'], $this->config->get('config_currency'))
			);
		}

		$this->data['heading'] = __('Sale Order Report');

		$this->data['text_no_results'] = __('No results');
		$this->data['text_all_status'] = __('All Status');

		$this->data['column_date_start'] = __('Date start');
		$this->data['column_date_end'] = __('Date end');
		$this->data['column_orders'] = __('Num of orders');
		$this->data['column_products'] = __('Num of products');
		$this->data['column_tax'] = __('Tax');
		$this->data['column_total'] = __('Total');

		$this->data['entry_date_start'] = __('Date start:');
		$this->data['entry_date_end'] = __('Date end:');
		$this->data['entry_group'] = __('Group by:');
		$this->data['entry_status'] = __('Status');

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

		$url = get_bloginfo('url') . '/wp-admin/admin.php?page=catalog&fwurl=/report/sale_order/';
		$this->data['url'] = $url;
			
		$this->data['pages'] = apply_filters('impresscart_administration_pages', array());
		
	}


}
?>