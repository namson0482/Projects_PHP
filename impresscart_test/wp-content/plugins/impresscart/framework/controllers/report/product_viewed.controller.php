<?php
class impresscart_report_product_viewed_controller extends impresscart_framework_controller {
	public function index() {     
	
		
		$data = array(
			'start' => 0,
			'limit' => $this->config->get('config_admin_limit')
		);
				
		$product_viewed_total = $this->model_report_product->getTotalProductsViewed($data); 
		
		$product_views_total = $this->model_report_product->getTotalProductViews(); 
		
		$this->data['products'] = array();
		
		$results = $this->model_report_product->getProductsViewed($data);
		
		foreach ($results as $result) {
			if ($result['viewed']) {
				$percent = round($result['viewed'] / $product_views_total * 100, 2);
			} else {
				$percent = 0;
			}
			
            $product = $this->model_catalog_product->getProduct($result['ID']);
			$this->data['products'][] = array(
				'name'    => $product->name,
				'model'   => $product->model,
				'viewed'  => $result['viewed'],
				'percent' => $percent . '%'			
			);
		}
 		
		$this->data['heading'] = __('Product views report');
		 
		$this->data['text_no_results'] = __('no results');
		
		$this->data['column_name'] = __('Product Name');
		$this->data['column_model'] = __('Product Model');
		$this->data['column_viewed'] = __('Views');
		$this->data['column_percent'] = __('Percent');
		
		$this->data['pages'] = apply_filters('impresscart_administration_pages', array());
		
	}
	
	public function reset() {
		$this->load->language('report/product_viewed');
		
		$this->load->model('report/product');
		
		$this->model_report_product->reset();
		
		$this->session->data['success'] = __('text_success');
		
		$this->redirect($this->url->link('report/product_viewed', 'token=' . $this->session->data['token'], 'SSL'));
	}
}
?>