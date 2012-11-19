<?php
class impresscart_report_sale_shipping_controller extends impresscart_framework_controller {
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
				
		if (isset($_GET['page'])) {
			$page = $_GET['page'];
		} else {
			$page = 1;
		}

		$url = get_bloginfo('url') . '/wp-admin/admin.php?page=catalog&fwurl=/report/sale_shipping/';
		
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
				
		if (isset($_GET['page'])) {
			$url .= '&page=' . $_GET['page'];
		}
		
		$this->data['orders'] = array();
		
		$data = array(
			'filter_date_start'	     => $filter_date_start, 
			'filter_date_end'	     => $filter_date_end, 
			'filter_group'           => $filter_group,
			'filter_order_status_id' => $filter_order_status_id,
			'start'                  => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit'                  => $this->config->get('config_admin_limit')
		);
        
        $this->data = $data;
				
		$results = $this->model_report_sale->getShipping($data);
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
		 
 		$this->data['heading'] = __('Order Shipping Report');
		 
		$this->data['text_no_results'] = __('No results');
		$this->data['text_all_status'] = __('All status');

		$this->data['column_date_start'] = __('Date start');
		$this->data['column_date_end'] = __('Date end');
		$this->data['column_title'] = __('Title');
		$this->data['column_orders'] = __('Num of orders');
		$this->data['column_total'] = __('Shipping Total');
		
		$this->data['entry_date_start'] = __('Date start');
		$this->data['entry_date_end'] = __('Date end');
		$this->data['entry_group'] = __('Group By:');	
		$this->data['entry_status'] = __('Order status');
		
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
        
        $this->data['url'] = $url;
        
        $this->data['pages'] = apply_filters('impresscart_administration_pages', array());
        
	}
}
?>