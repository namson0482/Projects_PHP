<?php
class impresscart_account_transaction_controller extends impresscart_framework_controller {

	public function index() {

		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/transaction', '', 'SSL');
				
			$this->redirect($this->url->link('account/login', '', 'SSL'));
		}

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
        	'text'      => __('Home'),
			'href'      => site_url(),	//$this->url->link('common/home'),
        	'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
        	'text'      => __('text_account'),
			'href'      => $this->url->link('account/account', '', 'SSL'),
        	'separator' => __(' :: ')
		);

		$this->data['breadcrumbs'][] = array(
        	'text'      => __('Your Transactions'),
			'href'      => $this->url->link('account/transaction', '', 'SSL'),
        	'separator' => __(' :: ')
		);

		$this->data['heading_title'] = __('Your Transactions');
		$this->data['column_date_added'] = __('Date Added');
		$this->data['column_description'] = __('Description');
		$this->data['column_amount'] = sprintf(__('Amount (%s)'), $this->config->get('config_currency'));

		$this->data['text_total'] = __('Your current balance is:');
		$this->data['text_empty'] = __('You do not have any transactions!');
		$this->data['button_continue'] = __('Continue');

		if (isset($_GET['page'])) {
			$page = $_GET['page'];
		} else {
			$page = 1;
		}

		$this->data['transactions'] = array();

		$data = array(
			'sort'  => 'date_added',
			'order' => 'DESC',
			'start' => ($page - 1) * 10,
			'limit' => 10
		);

		$transaction_total = $this->model_account_transaction->getTotalTransactions($data);

		$results = $this->model_account_transaction->getTransactions($data);
			
		foreach ($results as $result) {
			$this->data['transactions'][] = array(
				'amount'      => $this->currency->format($result['amount'], $this->config->get('config_currency')),
				'description' => $result['description'],
				'date_added'  => date(__('date_format_short'), strtotime($result['date_added']))
			);
		}

		$pagination = new Pagination();
		$pagination->total = $transaction_total;
		$pagination->page = $page;
		$pagination->limit = 10;
		$pagination->text = __('text_pagination');
		$pagination->url = $this->url->link('account/transaction', 'page={page}', 'SSL');
			
		$this->data['pagination'] = $pagination->render();

		$this->data['total'] = $this->currency->format($this->customer->getBalance());

		$this->data['continue'] = $this->url->link('account/account', '', 'SSL');



	}
}
?>