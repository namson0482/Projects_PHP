<?php
class impresscart_admin_coupon_controller extends impresscart_framework_controller {

	private $error = array();

	public function index() {

		//$this->load->language('sale/coupon');
		$this->document->setTitle(__('Coupon'));
		//$this->load->model('sale/coupon');
		$this->getList();
	}

	public function insert() {

		$this->load->language('sale/coupon');

		$this->document->setTitle(__('Your Transactions'));

		$this->load->model('sale/coupon');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_sale_coupon->addCoupon($_POST);

			$this->session->data['success'] = __('text_success');

			$url = '';

			if (isset($_GET['sort'])) {
				$url .= '&sort=' . $_GET['sort'];
			}

			if (isset($_GET['order'])) {
				$url .= '&order=' . $_GET['order'];
			}

			if (isset($_GET['page'])) {
				$url .= '&page=' . $_GET['page'];
			}

			$this->redirect($this->url->link('sale/coupon', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function update() {

		$this->load->language('sale/coupon');

		$this->document->setTitle(__('Your Transactions'));

		$this->load->model('sale/coupon');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
				
			$this->model_sale_coupon->editCoupon($_GET['coupon_id'], $_POST);

			$this->session->data['success'] = __('text_success');

			$url = '';

			if (isset($_GET['sort'])) {
				$url .= '&sort=' . $_GET['sort'];
			}

			if (isset($_GET['order'])) {
				$url .= '&order=' . $_GET['order'];
			}

			if (isset($_GET['page'])) {
				$url .= '&page=' . $_GET['page'];
			}

			$this->redirect($this->url->link('sale/coupon', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function delete() {

		$this->load->language('sale/coupon');

		$this->document->setTitle(__('Your Transactions'));

		$this->load->model('sale/coupon');

		if (isset($_POST['selected']) && $this->validateDelete()) {
			foreach ($_POST['selected'] as $coupon_id) {
				$this->model_sale_coupon->deleteCoupon($coupon_id);
			}

			$this->session->data['success'] = __('text_success');

			$url = '';

			if (isset($_GET['sort'])) {
				$url .= '&sort=' . $_GET['sort'];
			}

			if (isset($_GET['order'])) {
				$url .= '&order=' . $_GET['order'];
			}

			if (isset($_GET['page'])) {
				$url .= '&page=' . $_GET['page'];
			}

			$this->redirect($this->url->link('sale/coupon', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}

	private function getList() {


		if (isset($_GET['sort'])) {
				
			$sort = $_GET['sort'];
		} else {
			$sort = 'name';
		}

		if (isset($_GET['order'])) {
			$order = $_GET['order'];
		} else {
			$order = 'ASC';
		}

		if (isset($_GET['page'])) {
			$page = $_GET['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($_GET['sort'])) {
			$url .= '&sort=' . $_GET['sort'];
		}

		if (isset($_GET['order'])) {
			$url .= '&order=' . $_GET['order'];
		}
			
		if (isset($_GET['page'])) {
			$url .= '&page=' . $_GET['page'];
		}

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
       		'text'      => __('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
       		'text'      => __('Your Transactions'),
			'href'      => $this->url->link('sale/coupon', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
      		);
      		 
      		$this->data['insert'] = $this->url->link('sale/coupon/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
      		$this->data['delete'] = $this->url->link('sale/coupon/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');

      		$this->data['coupons'] = array();

      		$data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' => $this->config->get('config_admin_limit')
      		);

      		$coupon_total = $this->model_sale_coupon->getTotalCoupons();

      		$results = $this->model_sale_coupon->getCoupons($data);

      		foreach ($results as $result) {
      			$action = array();

      			$action[] = array(
				'text' => __('text_edit'),
				'href' => $this->url->link('sale/coupon/update', 'token=' . $this->session->data['token'] . '&coupon_id=' . $result['coupon_id'] . $url, 'SSL')
      			);

      			$this->data['coupons'][] = array(
				'coupon_id'  => $result['coupon_id'],
				'name'       => $result['name'],
				'code'       => $result['code'],
				'discount'   => $result['discount'],
				'date_start' => date(__('d-m-y'), strtotime($result['date_start'])),
				'date_end'   => date(__('d-m-y'), strtotime($result['date_end'])),
				'status'     => ($result['status'] ? __('text_enabled') : __('text_disabled')),
				'selected'   => isset($_POST['selected']) && in_array($result['coupon_id'], $_POST['selected']),
				'action'     => $action
      			);
      		}
      		 
      		$this->data['heading_title'] = __('Your Transactions');

      		$this->data['text_no_results'] = __('text_no_results');

      		$this->data['column_name'] = __('column_name');
      		$this->data['column_code'] = __('column_code');
      		$this->data['column_discount'] = __('column_discount');
      		$this->data['column_date_start'] = __('column_date_start');
      		$this->data['column_date_end'] = __('column_date_end');
      		$this->data['column_status'] = __('column_status');
      		$this->data['column_action'] = __('column_action');

      		$this->data['button_insert'] = __('button_insert');
      		$this->data['button_delete'] = __('button_delete');

      		if (isset($this->error['warning'])) {
      			$this->data['error_warning'] = $this->error['warning'];
      		} else {
      			$this->data['error_warning'] = '';
      		}

      		if (isset($this->session->data['success'])) {
      			$this->data['success'] = $this->session->data['success'];

      			unset($this->session->data['success']);
      		} else {
      			$this->data['success'] = '';
      		}

      		$url = '';

      		if ($order == 'ASC') {
      			$url .= '&order=DESC';
      		} else {
      			$url .= '&order=ASC';
      		}

      		if (isset($_GET['page'])) {
      			$url .= '&page=' . $_GET['page'];
      		}

      		$this->data['sort_name'] = HTTPS_SERVER . 'index.php?route=sale/coupon&token=' . $this->session->data['token'] . '&sort=name' . $url;
      		$this->data['sort_code'] = HTTPS_SERVER . 'index.php?route=sale/coupon&token=' . $this->session->data['token'] . '&sort=code' . $url;
      		$this->data['sort_discount'] = HTTPS_SERVER . 'index.php?route=sale/coupon&token=' . $this->session->data['token'] . '&sort=discount' . $url;
      		$this->data['sort_date_start'] = HTTPS_SERVER . 'index.php?route=sale/coupon&token=' . $this->session->data['token'] . '&sort=date_start' . $url;
      		$this->data['sort_date_end'] = HTTPS_SERVER . 'index.php?route=sale/coupon&token=' . $this->session->data['token'] . '&sort=date_end' . $url;
      		$this->data['sort_status'] = HTTPS_SERVER . 'index.php?route=sale/coupon&token=' . $this->session->data['token'] . '&sort=status' . $url;

      		$url = '';

      		if (isset($_GET['sort'])) {
      			$url .= '&sort=' . $_GET['sort'];
      		}

      		if (isset($_GET['order'])) {
      			$url .= '&order=' . $_GET['order'];
      		}

      		$pagination = new Pagination();
      		$pagination->total = $coupon_total;
      		$pagination->page = $page;
      		$pagination->limit = $this->config->get('config_admin_limit');
      		$pagination->text = __('text_pagination');
      		$pagination->url = HTTPS_SERVER . 'index.php?route=sale/coupon&token=' . $this->session->data['token'] . $url . '&page={page}';
      		 
      		$this->data['pagination'] = $pagination->render();

      		$this->data['sort'] = $sort;
      		$this->data['order'] = $order;

      		$this->template = 'sale/coupon_list.tpl';
      		$this->children = array(
			'common/header',	
			'common/footer'	
			);

			$this->response->setOutput($this->render());
	}

	private function getForm() {

		$this->data['heading_title'] = __('Your Transactions');
		$this->data['text_enabled'] = __('text_enabled');
		$this->data['text_disabled'] = __('text_disabled');
		$this->data['text_yes'] = __('text_yes');
		$this->data['text_no'] = __('text_no');
		$this->data['text_percent'] = __('text_percent');
		$this->data['text_amount'] = __('text_amount');
		$this->data['entry_name'] = __('entry_name');
		$this->data['entry_description'] = __('entry_description');
		$this->data['entry_code'] = __('entry_code');
		$this->data['entry_discount'] = __('entry_discount');
		$this->data['entry_logged'] = __('entry_logged');
		$this->data['entry_shipping'] = __('entry_shipping');
		$this->data['entry_type'] = __('entry_type');
		$this->data['entry_total'] = __('entry_total');
		$this->data['entry_category'] = __('entry_category');
		$this->data['entry_product'] = __('entry_product');
		$this->data['entry_date_start'] = __('entry_date_start');
		$this->data['entry_date_end'] = __('entry_date_end');
		$this->data['entry_uses_total'] = __('entry_uses_total');
		$this->data['entry_uses_customer'] = __('entry_uses_customer');
		$this->data['entry_status'] = __('entry_status');

		$this->data['button_save'] = __('button_save');
		$this->data['button_cancel'] = __('button_cancel');

		$this->data['tab_general'] = __('tab_general');
		$this->data['tab_coupon_history'] = __('tab_coupon_history');

		$this->data['token'] = $this->session->data['token'];

		if (isset($_GET['coupon_id'])) {
			$this->data['coupon_id'] = $_GET['coupon_id'];
		} else {
			$this->data['coupon_id'] = 0;
		}

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
			
		if (isset($this->error['name'])) {
			$this->data['error_name'] = $this->error['name'];
		} else {
			$this->data['error_name'] = '';
		}

		if (isset($this->error['code'])) {
			$this->data['error_code'] = $this->error['code'];
		} else {
			$this->data['error_code'] = '';
		}

		if (isset($this->error['date_start'])) {
			$this->data['error_date_start'] = $this->error['date_start'];
		} else {
			$this->data['error_date_start'] = '';
		}

		if (isset($this->error['date_end'])) {
			$this->data['error_date_end'] = $this->error['date_end'];
		} else {
			$this->data['error_date_end'] = '';
		}

		$url = '';
			
		if (isset($_GET['page'])) {
			$url .= '&page=' . $_GET['page'];
		}

		if (isset($_GET['sort'])) {
			$url .= '&sort=' . $_GET['sort'];
		}

		if (isset($_GET['order'])) {
			$url .= '&order=' . $_GET['order'];
		}

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
       		'text'      => __('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
       		'text'      => __('heading_title'),
			'href'      => $this->url->link('sale/coupon', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
      		);
      		 
      		if (!isset($_GET['coupon_id'])) {
      			$this->data['action'] = $this->url->link('sale/coupon/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
      		} else {
      			$this->data['action'] = $this->url->link('sale/coupon/update', 'token=' . $this->session->data['token'] . '&coupon_id=' . $_GET['coupon_id'] . $url, 'SSL');
      		}

      		$this->data['cancel'] = $this->url->link('sale/coupon', 'token=' . $this->session->data['token'] . $url, 'SSL');

      		if (isset($_GET['coupon_id']) && (!$this->request->server['REQUEST_METHOD'] != 'POST')) {
      			$coupon_info = $this->model_sale_coupon->getCoupon($_GET['coupon_id']);
      		}

      		if (isset($_POST['name'])) {
      			$this->data['name'] = $_POST['name'];
      		} elseif (!empty($coupon_info)) {
      			$this->data['name'] = $coupon_info['name'];
      		} else {
      			$this->data['name'] = '';
      		}

      		if (isset($_POST['code'])) {
      			$this->data['code'] = $_POST['code'];
      		} elseif (!empty($coupon_info)) {
      			$this->data['code'] = $coupon_info['code'];
      		} else {
      			$this->data['code'] = '';
      		}

      		if (isset($_POST['type'])) {
      			$this->data['type'] = $_POST['type'];
      		} elseif (!empty($coupon_info)) {
      			$this->data['type'] = $coupon_info['type'];
      		} else {
      			$this->data['type'] = '';
      		}

      		if (isset($_POST['discount'])) {
      			$this->data['discount'] = $_POST['discount'];
      		} elseif (!empty($coupon_info)) {
      			$this->data['discount'] = $coupon_info['discount'];
      		} else {
      			$this->data['discount'] = '';
      		}

      		if (isset($_POST['logged'])) {
      			$this->data['logged'] = $_POST['logged'];
      		} elseif (!empty($coupon_info)) {
      			$this->data['logged'] = $coupon_info['logged'];
      		} else {
      			$this->data['logged'] = '';
      		}

      		if (isset($_POST['shipping'])) {
      			$this->data['shipping'] = $_POST['shipping'];
      		} elseif (!empty($coupon_info)) {
      			$this->data['shipping'] = $coupon_info['shipping'];
      		} else {
      			$this->data['shipping'] = '';
      		}

      		if (isset($_POST['total'])) {
      			$this->data['total'] = $_POST['total'];
      		} elseif (!empty($coupon_info)) {
      			$this->data['total'] = $coupon_info['total'];
      		} else {
      			$this->data['total'] = '';
      		}

      		if (isset($_POST['coupon_product'])) {
      			$products = $_POST['coupon_product'];
      		} elseif (isset($_GET['coupon_id'])) {
      			$products = $this->model_sale_coupon->getCouponProducts($_GET['coupon_id']);
      		} else {
      			$products = array();
      		}

      		$this->load->model('catalog/product');

      		$this->data['coupon_product'] = array();

      		foreach ($products as $product_id) {
      			$product_info = $this->model_catalog_product->getProduct($product_id);

      			if ($product_info) {
      				$this->data['coupon_product'][] = array(
					'product_id' => $product_info['product_id'],
					'name'       => $product_info['name']
      				);
      			}
      		}

      		$this->load->model('catalog/category');

      		$this->data['categories'] = $this->model_catalog_category->getCategories(0);
      		 
      		if (isset($_POST['date_start'])) {
       		$this->data['date_start'] = $_POST['date_start'];
      		} elseif (isset($coupon_info)) {
      			$this->data['date_start'] = date('Y-m-d', strtotime($coupon_info['date_start']));
      		} else {
      			$this->data['date_start'] = date('Y-m-d', time());
      		}

      		if (isset($_POST['date_end'])) {
       		$this->data['date_end'] = $_POST['date_end'];
      		} elseif (isset($coupon_info)) {
      			$this->data['date_end'] = date('Y-m-d', strtotime($coupon_info['date_end']));
      		} else {
      			$this->data['date_end'] = date('Y-m-d', time());
      		}

      		if (isset($_POST['uses_total'])) {
      			$this->data['uses_total'] = $_POST['uses_total'];
      		} elseif (isset($coupon_info)) {
      			$this->data['uses_total'] = $coupon_info['uses_total'];
      		} else {
      			$this->data['uses_total'] = 1;
      		}

      		if (isset($_POST['uses_customer'])) {
      			$this->data['uses_customer'] = $_POST['uses_customer'];
      		} elseif (isset($coupon_info)) {
      			$this->data['uses_customer'] = $coupon_info['uses_customer'];
      		} else {
      			$this->data['uses_customer'] = 1;
      		}

      		if (isset($_POST['status'])) {
      			$this->data['status'] = $_POST['status'];
      		} elseif (isset($coupon_info)) {
      			$this->data['status'] = $coupon_info['status'];
      		} else {
      			$this->data['status'] = 1;
      		}

      		$this->template = 'sale/coupon_form.tpl';
      		$this->children = array(
			'common/header',	
			'common/footer'	
			);

			$this->response->setOutput($this->render());
	}

	private function validateForm() {
		if (!$this->user->hasPermission('modify', 'sale/coupon')) {
			$this->error['warning'] = __('error_permission');
		}
			
		if ((utf8_strlen($_POST['name']) < 3) || (utf8_strlen($_POST['name']) > 128)) {
			$this->error['name'] = __('error_name');
		}
			
		if ((utf8_strlen($_POST['code']) < 3) || (utf8_strlen($_POST['code']) > 10)) {
			$this->error['code'] = __('error_code');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	private function validateDelete() {
		if (!$this->user->hasPermission('modify', 'sale/coupon')) {
			$this->error['warning'] = __('error_permission');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	public function history() {

		global $post;
		$coupon_history = array();
		 
		if($post){
			$coupon_history = get_post_meta($post->ID, 'coupon_history',true);
		}

		$this->data['coupon_history'] = $coupon_history;
	}



	function data() {
			
		global $post;
		$data = get_post_meta($post->ID, 'data',true);
		$coupon_code = get_post_meta($post->ID, 'coupon_code',true);

		if($post) $this->data['coupon_id'] = $post->ID;

		if(($data)) {
			foreach ($data as $key => $value) {
				$this->data[$key] = $value;
			}
		}

		if( !$coupon_code )	{
			$this->data['code'] = $this->model_sale_coupon->genCouponCode();
		} else {
			$this->data['code'] = $coupon_code;

		}

		$this->data['coupon_product'] = null;

		if(isset($data['coupon_product'])) {
			foreach ($data['coupon_product'] as $value)	{
				$this->data['coupon_product'][] = array(
	  				'product_id' => $value,
	  				'name' => get_post($value)->post_title
				);
			}
		}

		if(empty($this->data['category'])) $this->data['category'] = array();

		$this->data['categories'] = $this->model_catalog_category->getCategories();

		$this->data['text_no'] = __('No');
		$this->data['text_yes'] = __('Yes');
		$this->data['text_percent'] = __('Percentage');
		$this->data['text_amount'] = __('Fixed Amount');
		$this->data['entry_name'] = __('Coupon Name:');
		$this->data['entry_description'] = __('Description');
		$this->data['entry_code'] = __('Code:<br /><span class="help">The code the customer enters to get the discount</span>');
		$this->data['entry_discount'] = __('Discount:');
		$this->data['entry_logged'] = __('Customer Login:<br /><span class="help">Customer must be logged in to use the coupon.</span>');
		$this->data['entry_shipping'] = __('Free Shipping:');
		$this->data['entry_type'] = __('Type:<br /><span class="help">Percentage or Fixed Amount</span>');
		$this->data['entry_total'] = __('Total Amount:<br /><span class="help">The total amount that must reached before the coupon is valid.</span>');
		$this->data['entry_category'] = __('Category:<br /><span class="help">Choose all products under selected category.</span>');
		$this->data['entry_product'] = __('Products:<br /><span class="help">Choose specific products the coupon will apply to. Select no products to apply coupon to entire cart.</span>');
		$this->data['entry_date_start'] = __('Date start:');
		$this->data['entry_date_end'] = __('Date end:');
		$this->data['entry_uses_total'] = __('Uses Per Coupon:<br /><span class="help">The maximum number of times the coupon can be used by any customer. Leave blank for unlimited</span>');
		$this->data['entry_uses_customer'] = __('Uses Per Customer:<br /><span class="help">The maximum number of times the coupon can be used by a single customer. Leave blank for unlimited</span>');
		$this->data['entry_status'] = __('Status:');
		$this->data['button_save'] = __('Save');
		$this->data['button_cancel'] = __('Cancel');
		$this->data['tab_general'] = __('General');
		$this->data['tab_coupon_history'] = __('Coupon History');
	}
}
?>