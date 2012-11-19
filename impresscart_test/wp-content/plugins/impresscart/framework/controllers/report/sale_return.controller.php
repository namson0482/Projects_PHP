<?php
class impresscart_report_sale_return_controller extends impresscart_framework_controller {
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
		
		if (isset($_GET['filter_return_status_id'])) {
			$filter_return_status_id = $_GET['filter_return_status_id'];
		} else {
			$filter_return_status_id = 0;
		}	
		
		$url = get_bloginfo('url') . '/wp-admin/admin.php?page=catalog&fwurl=/report/sale_return/';
		
		if (isset($_GET['filter_date_start'])) {
			$url .= '&filter_date_start=' . $_GET['filter_date_start'];
		}
		
		if (isset($_GET['filter_date_end'])) {
			$url .= '&filter_date_end=' . $_GET['filter_date_end'];
		}
		
		if (isset($_GET['filter_group'])) {
			$url .= '&filter_group=' . $_GET['filter_group'];
		}		

		if (isset($_GET['filter_return_status_id'])) {
			$url .= '&filter_return_status_id=' . $_GET['filter_return_status_id'];
		}
				
		if (isset($_GET['page'])) {
			$url .= '&page=' . $_GET['page'];
		}
						
		
		$data = array(
			'filter_date_start'	      => $filter_date_start, 
			'filter_date_end'	      => $filter_date_end, 
			'filter_group'            => $filter_group,
			'filter_return_status_id' => $filter_return_status_id,
			'start'                   => 0,
			'limit'                   => $this->config->get('config_admin_limit')
		);
        
        $this->data= $data;
		
		$results = $this->model_report_return->getReturns($data);
		
		foreach ($results as $result) {
			$this->data['returns'][] = array(
				'date_start' => date(__('d-m-y'), strtotime($result['date_start'])),
				'date_end'   => date(__('d-m-y'), strtotime($result['date_end'])),
				'returns'    => $result['returns']
			);
		}
				 
 		$this->data['heading'] = __('Sale return report');
		 
		$this->data['text_no_results'] = __('no results');
		$this->data['text_all_status'] = __('All Status');
		
		$this->data['column_date_start'] = __('Date start');
		$this->data['column_date_end'] = __('Date end');
    	$this->data['column_returns'] = __('Num of returns');
		$this->data['column_total'] = __('Total');
		
		$this->data['entry_date_start'] = __('Date start');
		$this->data['entry_date_end'] = __('Date end');
		$this->data['entry_group'] = __('Group');	
		$this->data['entry_status'] = __('Status');
				
		$this->data['button_filter'] = __('Filter');
		
        $return_status_data = $this->config->get('return_status_data');
        foreach($return_status_data as $key => $value)
        {
            $this->data['return_statuses'][] = array(
                'return_status_id' => $key,
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

		if (isset($_GET['filter_return_status_id'])) {
			$url .= '&filter_return_status_id=' . $_GET['filter_return_status_id'];
		}
        
        $this->data['url'] = $url;
        
        $this->data['pages'] = apply_filters('impresscart_administration_pages', array());
        
	}
}
?>