<?php
class impresscart_report_sale_coupon_controller extends impresscart_framework_controller {
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

		if (isset($_GET['page'])) {
			$page = $_GET['page'];
		} else {
			$page = 1;
		}

		$url = get_bloginfo('url') . '/wp-admin/admin.php?page=catalog&fwurl=/report/sale_coupon/';

		if (isset($_GET['filter_date_start'])) {
			$url .= '&filter_date_start=' . $_GET['filter_date_start'];
		}

		if (isset($_GET['filter_date_end'])) {
			$url .= '&filter_date_end=' . $_GET['filter_date_end'];
		}

		$this->data['coupons'] = array();

		$data = array(
			'filter_date_start'	=> $filter_date_start, 
			'filter_date_end'	=> $filter_date_end, 
			'start'             => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit'             => $this->config->get('config_admin_limit')
		);


		$this->data = $data;
		$results = $this->model_report_coupon->getCoupons($data);

		foreach ($results as $result) {
			$action = array();
			$action[] = array(
				'text' => __('Edit'),
				'href' =>  get_edit_post_link($result['id'])
			);

			$this->data['coupons'][] = array(
				'name'   => $result['name'],
				'code'   => $result['code'],
				'orders' => $result['orders'],
				'total'  => $this->currency->format($result['total'], $this->config->get('config_currency')),
				'action' => $action
			);
		}
			
		$this->data['heading'] = __('Sale Coupon Report');
			
		$this->data['text_no_results'] = __('no results');

		$this->data['column_name'] = __('Coupon Name');
		$this->data['column_code'] = __('Coupon Code');
		$this->data['column_orders'] = __('Num of orders');
		$this->data['column_total'] = __('Total coupon');
		$this->data['column_action'] = __('Action');

		$this->data['entry_date_start'] = __('Date start');
		$this->data['entry_date_end'] = __('Date end');

		$this->data['button_filter'] = __('Filter');

		$url = get_bloginfo('url') . '/wp-admin/admin.php?page=catalog&fwurl=/report/sale_coupon/';

		if (isset($_GET['filter_date_start'])) {
			$url .= '&filter_date_start=' . $_GET['filter_date_start'];
		}

		if (isset($_GET['filter_date_end'])) {
			$url .= '&filter_date_end=' . $_GET['filter_date_end'];
		}

		$this->data['url'] = $url;
		$this->data['pages'] = apply_filters('impresscart_administration_pages', array());
		
	}
}
?>