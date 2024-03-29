<?php 
class impresscart_account_newsletter_controller extends impresscart_framework_controller {  
	public function index() {
		if (!$this->customer->isLogged()) {
	  		$this->session->data['redirect'] = $this->url->link('account/newsletter', '', 'SSL');
	  
	  		$this->redirect($this->url->link('account/login', '', 'SSL'));
    	} 
		
		$this->language->load('account/newsletter');
    	
		$this->document->setTitle(__('Newsletter Subscription'));
				
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$this->load->model('account/customer');
			
			$this->model_account_customer->editNewsletter($this->request->post['newsletter']);
			
			$this->session->data['success'] = __('text_success');
			
			$this->redirect($this->url->link('account/account', '', 'SSL'));
		}

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
        	'text'      => __('Newsletter'),
			'href'      => $this->url->link('account/newsletter', '', 'SSL'),
        	'separator' => __('text_separator')
      	);
		
    	$this->data['heading_title'] = __('heading_title');

    	$this->data['text_yes'] = __('text_yes');
		$this->data['text_no'] = __('text_no');
		
		$this->data['entry_newsletter'] = __('Subscribe');
		
		$this->data['button_continue'] = __('button_continue');
		$this->data['button_back'] = __('button_back');

    	$this->data['action'] = $this->url->link('account/newsletter', '', 'SSL');
		
		$this->data['newsletter'] = $this->customer->getNewsletter();
		
		$this->data['back'] = $this->url->link('account/account', '', 'SSL');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/newsletter.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/account/newsletter.tpl';
		} else {
			$this->template = 'default/template/account/newsletter.tpl';
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