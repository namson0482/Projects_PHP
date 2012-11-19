<?php

class impresscart_admin_order_controller extends impresscart_framework_controller {

	private $order_info;
	
	private $products;
	
	private $totals;
	
	function __construct() {
		global $post;
		if($post) {
			$data = get_post_meta($post->ID, 'data');
			$this->products = get_post_meta($post->ID, 'products');
			if(($this->products) && is_array($this->products) && count($this->products)) {
				$this->totals = get_post_meta($post->ID, 'totals');
				$this->products = $this->products[0];
				$this->totals = $this->totals[0];
				$this->order_info = $data[0];
				if($this->order_info) {
					foreach($this->order_info as $key => $value)
						$this->data[$key] = $value;
				}
			}
			self::init($post);
		}
		$this->data['pages'] = apply_filters('impresscart_administration_pages', array());
	}
	
	private function init($post) {
		$result = get_post_meta($post->ID, 'invoice_no');
		if(!empty($result)) {
			$this->data['invoice_no'] = $result[0];
		}
		$result_reward_point = get_post_meta($post->ID, 'reward_point');
		if(empty($result_reward_point)) {
			$this->data['text_reward'] = __('Add Reward Points:');
		} else {
			if(floatval($result_reward_point[0]) == 0) {
				$this->data['text_reward'] = __('Add Reward Points:');
			} else {
				$this->data['text_reward'] = __('Remove Reward Points:');
			}
		}
		$this->data['order_id'] = $post->ID;
		$this->data['heading_title'] = __('Order Detail');
		$this->data['text_order_id'] = __('Order ID:');
		$this->data['text_invoice_no'] = __('Invoice No:');
		$this->data['text_invoice_date'] = __('Invoice Date:');
		$this->data['text_store_name'] = __('Store name:');
		$this->data['text_store_url'] = __('Store url:');
		$this->data['text_customer'] = __('Customer');
		$this->data['text_customer_group'] = __('Customer Group:');
		$this->data['text_email'] = __('Email:');
		$this->data['text_ip'] = __('IP:');
		$this->data['text_telephone'] = __('Telephone:');
		$this->data['text_fax'] = __('Fax:');
		$this->data['text_total'] = __('Total:');
		$this->data['text_order_status'] = __('Order status:');
		$this->data['text_comment'] = __('Comment:');
		$this->data['text_affiliate'] = __('Affiliate:');
		$this->data['text_commission'] = __('Commission:');
		$this->data['text_date_added'] = __('Date added:');
		$this->data['text_date_modified'] = __('Date modified:');
		$this->data['text_firstname'] = __('Firstname:');
		$this->data['text_lastname'] = __('Lastname:');
		$this->data['text_company'] = __('Company:');
		$this->data['text_address_1'] = __('Address 1:');
		$this->data['text_address_2'] = __('Address 2:');
		$this->data['text_city'] = __('City:');
		$this->data['text_postcode'] = __('Postcode');
		$this->data['text_zone'] = __('Zone:');
		$this->data['text_zone_code'] = __('Zone code:');
		$this->data['text_country'] = __('Country:');
		$this->data['text_shipping_method'] = __('Shipping method');
		$this->data['text_payment_method'] = __('Payment method');
		$this->data['text_download'] = __('Download');
		$this->data['text_wait'] = __('text_wait');
		$this->data['text_create_invoice_no'] = __('Generate');
		$this->data['text_reward_add'] = __('Add reward:');
		$this->data['text_reward_remove'] = __('Remove reward:');
		$this->data['text_commission_add'] = __('Add commission:');
		$this->data['text_commission_remove'] = __('Remove commission:');
		$this->data['text_credit_add'] = __('Add credit:');
		$this->data['text_credit_remove'] = __('Remove credit:');
		$this->data['column_product'] = __('Product');
		$this->data['column_model'] = __('Model');
		$this->data['column_quantity'] = __('Quantity');
		$this->data['column_price'] = __('Price');
		$this->data['column_total'] = __('Total');
		$this->data['column_download'] = __('Download');
		$this->data['column_filename'] = __('Filename');
		$this->data['column_remaining'] = __('Remaining');
		$this->data['entry_order_status'] = __('Order status:');
		$this->data['entry_notify'] = __('Notify');
		$this->data['entry_comment'] = __('Comment');
		$this->data['button_invoice'] = __('Invoice');
		$this->data['button_cancel'] = __('Cancel');
		$this->data['button_add_history'] = __('Add history');
		$this->data['text_no_results'] = __('No Results');
		
	}
	
	public function updateOrderReward() {
		$json = array();
		if($_REQUEST['order_id']) {
			$post_id = $_REQUEST['order_id']; 
			$data = get_post_meta($post_id, 'data');
			$result_reward_point = get_post_meta($post_id, 'reward_point');
			if(empty($result_reward_point) ) {
				$result_reward_point = $data[0]['reward'];
				$json['reward'] = __('Remove Reward Points:');
			} else {
				if(floatval($result_reward_point[0]) == 0) {
					$result_reward_point = $data[0]['reward'];
					$json['reward'] = __('Remove Reward Points:');
				} else {
					$result_reward_point = 0;
					$json['reward'] = __('Add Reward Points:');
				}
			}
			
			$order_model = impresscart_framework::model('checkout/order');
			$order_model->updateRewardData($_REQUEST['order_id'], $result_reward_point);
		}
		
		$this->autoRender = false;
		echo json_encode($json);
		exit(0);
	}

	public function createInvoiceNo() {
		$json = array();
		if($_REQUEST['order_id']) {
			$invoice_no = Goscom::GOSCOM_INVOICE_PREFIX . '_' . $_REQUEST['order_id'];
			$order_model = impresscart_framework::model('checkout/order');
			$order_model->updateInvoiceData($_REQUEST['order_id'], $invoice_no);
			$json['invoice_no'] = $invoice_no;
		}

		$this->autoRender = false;
		echo json_encode($json);
		exit(0);
	}

	public function data() {
		
		$this->data['total'] = $this->currency->format($this->order_info['total'], $this->order_info['currency_code'], $this->order_info['currency_value']);
		$statuses = $this->table_order_status->fetchAll();
		$statuses_html = '<select name="data[order_status]" >';
		foreach($statuses as $status)
		if($status->order_status_id == $this->order_info['order_status_id'])
		$statuses_html .= "<option selected='selected' value='".$status->order_status_id."'>".$status->name."</option>";
		else $statuses_html .= "<option value='".$status->order_status_id."'>".$status->name."</option>";
		$statuses_html .= "</select>";
		$this->data['order_status'] = $statuses_html;
	}

	public function shipping() {

		$shipping_zone_id = $this->order_info['shipping_zone_id'];
		$shipping_country_id = $this->order_info['shipping_country_id'];
		$shipping_country_html = "<select name='shipping[country]'><option value='0'>"._e('Select Country')."</option>";
		$countries = $this->table_country->fetchAll();
		foreach($countries as $country) {
			if($country->country_id == $shipping_country_id)
				$shipping_country_html .= '<option selected="selected" value="'.$country->country_id.'">'.$country->name.'</option>';
			else $shipping_country_html .= '<option value="'.$country->country_id.'">'.$country->name.'</option>';
		}
		$shipping_country_html .= "</select>";
		$this->data['shipping_country'] = $shipping_country_html;
		$shipping_zone_html = "<select name='shipping[zone]'><option value='0'>"._e('Select Zone')."</option>";
		$zones = $this->table_zone->fetchAll(
		array('conditions' => array('country_id' => $shipping_country_id)));


		foreach($zones as $zone) {
			if($zone->zone_id == $shipping_zone_id) {
				$shipping_zone_html .= '<option selected="selected" value="'.$zone->zone_id.'">'.$zone->name.'</option>';
				$this->data['shipping_zone_code'] = $zone->code;
			} else $shipping_zone_html .= '<option value="'.$zone->zone_id.'">'.$zone->name.'</option>';
				
		}
		$shipping_zone_html .= "</select>";

		$this->data['shipping_country'] = $shipping_country_html;
		$this->data['shipping_zone'] = $shipping_zone_html;

	}

	public function payment() {

		$payment_zone_id = $this->order_info['payment_zone_id'];
		$payment_country_id = $this->order_info['payment_country_id'];
		$payment_country_html = "<select name='payment[country]'><option value='0'>"._e('Select Country')."</option>";
		$countries = $this->table_country->fetchAll();
		foreach($countries as $country) {
			if($country->country_id == $payment_country_id) {
				$payment_country_html .= '<option selected="selected" value="'.$country->country_id.'">'.$country->name.'</option>';
			} else {
				$payment_country_html .= '<option value="'.$country->country_id.'">'.$country->name.'</option>';
			}
		}

		$payment_country_html .= "</select>";
		$this->data['payment_country'] = $payment_country_html;
		$payment_zone_html = "<select name='payment[zone]'><option value='0'>"._e('Select Zone')."</option>";
		$zones = $this->table_zone->fetchAll(
		array('conditions' => array('country_id' => $payment_country_id)));
		foreach($zones as $zone) {
			if($zone->zone_id == $payment_zone_id) {
				$payment_zone_html .= '<option selected="selected" value="'.$zone->zone_id.'">'.$zone->name.'</option>';
				$this->data['payment_zone_code'] = $zone->code;
			} else	$payment_zone_html .= "<option value='".$zone->zone_id."'>".$zone->name."</option>";
		}
		$payment_zone_html .= "</select>";
		$this->data['payment_country'] = $payment_country_html;
		$this->data['payment_zone'] = $payment_zone_html;
			
	}

	public function items() {
		$downloads = array();
		if(isset($this->products))
		foreach ($this->products as $item) {
			$this->data['products'][] = $item;
			if(isset($item['download']) && count($item['download'])) {
				$downloads[] = $item['download'][0];
			}
		}
		$this->data['downloads'] = $downloads;
		$this->data['totals'] = $this->totals;
	}

	public function resetHistory() {
		$args = array(
			'post_type'       => 'order'
			);
			$posts_array = get_posts( $args );

	}
	
	
	public function history() {
		global $post;
		$this->data['history_post_id'] = _($post->ID);
		$this->data['column_date_added'] = __('Date Added');
		$this->data['column_status'] = __('Status');
		$this->data['column_notify'] = __('Notify');
		$this->data['column_comment'] = __('Comment');
		$histories =  $this->model_account_order->getOrderHistories($post->ID);
		$this->data['histories'] = array();
		if(is_array(@$histories)) {
			foreach($histories as $history) {
				$status = $this->table_order_status->fetchOne(array(
				'conditions' => array(
					'order_status_id' => @$history['order_status_id']
				)
				));

				$this->data['histories'][] = array(
					'notify'     => @$history['notify'] ? __('Yes') : __('No'),
					'status'     => $status->name,
					'comment'    => nl2br(@$history['comment']),
	        		'date_added' => date(__('d/m/Y'), strtotime(@$history['date_added']))
				);
			}
			
			
			
		}
		//var_dump($this->data['histories']); die();
		
		
		$this->data['order_statuses'] = $this->table_order_status->fetchAll();
	}
	
	public function addHistory() {
		$comment = $_POST['comment'];
		$notify_Customer = $_POST['notify_Customer'] == 'true'? true: false;
		$order_Status_Id = $_POST['order_Status_Id'];
		$history_post_id = $_POST['history_post_id'];
		$currentDate = date('d/m/Y');
		$currentHistories = $this->model_account_order->getOrderHistories($history_post_id);
		
		$order_info = $this->model_account_order->getOrder($history_post_id);
		$data = array(
			'order_id' => $history_post_id,
			'order_status_id' => $order_Status_Id,
			'notify' => $notify_Customer,
			'comment' => $comment,
			'date_added' => $currentDate);
		
		$currentHistories[count($currentHistories)] = $data;
		update_post_meta($history_post_id, 'histories', $currentHistories);
		$currentHistories = $this->model_account_order->getOrderHistories($history_post_id);
		
		if(isset($notify_Customer)) {
			$status = $this->table_order_status->fetchOne( array('conditions' => array('order_status_id' => $order_Status_Id)));
			$data['order_status'] = $status->name;
			$data['email'] = $order_info['email'];
			$data['customer_id'] = $order_info['customer_id'];
			$this->model_sale_order->notifyOrderHistoryStatus($data);
		}
		
		$json = array();
		$html = '
		<input type="hidden" value="' . $history_post_id . '" name="history_post_id" />
		<table class="list">
		  <thead>
		    <tr>
		      <td class="left"><b> ' . __('Date Added') . '</b></td>
		      <td class="left"><b> ' . __('Comment') . '</b></td>
		      <td class="left"><b> ' . __('Status') . '</b></td>
		      <td class="left"><b> ' . __('Notify') . '</b></td>
		    </tr>
		  </thead>
		  <tbody>';
		if ($currentHistories) {
			foreach ($currentHistories as $history) {
				$status = $this->table_order_status->fetchOne(array(
				'conditions' => array(
					'order_status_id' => @$history['order_status_id']
				)
				));
				$html .= '
			    <tr>
			      <td class="left">' . $history['date_added'] . '</td>
			      <td class="left">' . $history['comment'] . '</td>
			      <td class="left">' . $status->name . '</td>
			      <td class="left">' . $history['notify'] . '</td>
			    </tr>';
			}
		} else {
			$html .= '<tr>
		      <td class="center" colspan="4">' . _('No Results'). '</td>
		    </tr>';
		}
		$html .= '</tbody></table>';
		$json['output'] = $html;
		echo json_encode($json);
		
		exit(0);
	}

	
}