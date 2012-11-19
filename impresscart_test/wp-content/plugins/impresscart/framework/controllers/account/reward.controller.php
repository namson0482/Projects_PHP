<?php
class impresscart_account_reward_controller extends impresscart_framework_controller {	public function index() {
		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/reward', '', 'SSL');
			
	  		$this->redirect($this->url->link('account/login', '', 'SSL'));
	  		return;
    	}		
		
		$this->language->load('account/reward');

		$this->document->setTitle(__('Your Reward Points'));

      	$this->data['breadcrumbs'] = array();

      	$this->data['breadcrumbs'][] = array(
        	'text'      => __('text_home'),
			'href'      => $this->url->link('common/home'),
        	'separator' => false
      	); 

      	$this->data['breadcrumbs'][] = array(       	
        	'text'      => __('Account'),
			'href'      => $this->url->link('account/account', '', 'SSL'),
        	'separator' => __('text_separator')
      	);
		
      	$this->data['breadcrumbs'][] = array(       	
        	'text'      => __('Reward Points'),
			'href'      => $this->url->link('account/reward', '', 'SSL'),
        	'separator' => __('text_separator')
      	);
		
		$this->load->model('account/reward');

    	$this->data['heading_title'] = __('Your Reward Points');
		
		$this->data['column_date_added'] = __('Date Added');
		$this->data['column_description'] = __('Description');
		$this->data['column_points'] = __('Points');
		
		$this->data['text_total'] = __('Your total number of reward points is:');
		$this->data['text_empty'] = __('You do not have any reward points!');
		
		$this->data['button_continue'] = __('button_continue');
				
		if (isset($_GET['page'])) {
			$page = $_GET['page'];
		} else {
			$page = 1;
		}		
		
		$this->data['rewards'] = array();
		
		$data = array(				  
			'sort'  => 'date_added',
			'order' => 'DESC',
			'start' => ($page - 1) * 10,
			'limit' => 10
		);
		
		$reward_total = $this->model_account_reward->getTotalRewards($data);
	
		$results = $this->model_account_reward->getRewards($data);
 		
    	foreach ($results as $result) {
			$this->data['rewards'][] = array(
				'order_id'    => $result['order_id'],
				'points'      => $result['points'],
				'description' => $result['description'],
				'date_added'  => date(__('date_format_short'), strtotime($result['date_added'])),
				'href'        => $this->url->link('account/order/info', 'order_id=' . $result['order_id'], 'SSL')
			);
		}	

		$pagination = new Pagination();
		$pagination->total = $reward_total;
		$pagination->page = $page;
		$pagination->limit = 10; 
		$pagination->text = __('text_pagination');
		$pagination->url = $this->url->link('account/reward', 'page={page}', 'SSL');
			
		$this->data['pagination'] = $pagination->render();
		
		$this->data['total'] = (int)$this->customer->getRewardPoints();
		
		$this->data['continue'] = $this->url->link('account/account', '', 'SSL');
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/reward.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/account/reward.tpl';
		} else {
			$this->template = 'default/template/account/reward.tpl';
		}
		
		$this->children = array(
			'common/column_left',
			'common/column_right',
			'common/content_top',
			'common/content_bottom',
			'common/footer',
			'common/header'	
		);
						
		$this->response->setOutput($this->render());		
	} 		
}
?>