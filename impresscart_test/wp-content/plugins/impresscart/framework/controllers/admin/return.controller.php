<?php    
class impresscart_admin_return_controller extends impresscart_framework_controller {
	 
	private $error = array();
	   
	public function history() { 
		global $post;
		$this->data['text_no_results'] = __('No history added');		
		$this->data['column_date_added'] = __('Date added');
		$this->data['column_status'] = __('Status');
		$this->data['column_notify'] = __('Notify');
		$this->data['column_comment'] = __('Comment');
		$this->data['entry_return_status'] =__('Return Status');
		$this->data['entry_notify'] =__('Notify user');
		$this->data['entry_comment'] =__('Comment');
		$histories = get_post_meta($post->ID, 'histories', true);	
		$model_status = impresscart_framework::model('localisation/return_status');
		if($histories) 
		{
			foreach($histories as $history)
			{
				$return_status = $model_status->getReturnStatus($history["return_status_id"]);
				$this->data['histories'][] = array(
					'date_added' => $history['date_added'],
					'status' => $return_status["name"],
					'comment' => $history['comment'],
					'notify' => $history > 0 ? __('Yes') : __('No')
				);
			}
		}
		
	
		$status_model = impresscart_framework::model('localisation/return_status');		
		$this->data['return_statuses'] = $status_model->getReturnStatusOptions();
	}		
  	
  	function data()
  	{
  		global $post;
  		$return_data = get_post_meta($post->ID, 'data',true);
  		
  		foreach($return_data as $key => $value)
  		{
  			$this->data[$key] = $value;
  		}
  		
  		$this->data['customer'] = $this->data['firstname'] . ' ' . $this->data['lastname'];
  		
  		$order_id = get_post_meta($post->ID, 'order', true);
  		$customer_id = get_post_meta($post->ID, 'customer', true);
  		$this->data['order'] = $this->model_account_order->getOrder($order_id);
  		
  		$this->data['return_id'] = $post->id;
  		
  		$this->data['heading_title'] = __('Product Returns');

		$this->data['text_description'] = __('<p>Please complete the form below to request an RMA number.</p>');
		$this->data['text_order'] = __('Order Information');
		$this->data['text_product'] = __('Product Information &amp; Reason for Return');
		$this->data['text_additional'] = __('Additional Information');
		$this->data['text_yes'] = __('Yes');
		$this->data['text_no'] = __('No');
		
		$this->data['entry_order_id'] = __('Order ID:');	
		$this->data['entry_date_ordered'] = __('Order Date:');	 
		$this->data['entry_customer'] = __('Customer:');   	
		$this->data['entry_firstname'] = __('First Name:');
    	$this->data['entry_lastname'] = __('Last Name:');
    	$this->data['entry_email'] = __('E-Mail:');
    	$this->data['entry_telephone'] = __('Telephone:');
		$this->data['entry_product'] = __('Product Name:');	
		$this->data['entry_model'] = __('Product Code:');			
		$this->data['entry_quantity'] = __('Quantity:');		
		$this->data['entry_return_status'] = __('Return Status:');		
		$this->data['entry_reason'] = __('Reason for Return:');	
		$this->data['entry_comment'] = __('Comment');
		$this->data['entry_opened'] = __('Product is opened:');	
		$this->data['entry_fault_detail'] = __('Faulty or other details:');	
				
		$this->data['button_continue'] = __('Continue');
		$this->data['button_back'] = __('Back');
		$this->data['button_add_product'] = __('Add Product');
		$this->data['button_remove'] = __('Remove');		
		$status_model = impresscart_framework::model('localisation/return_status');
		$this->data['return_statuses'] = $status_model->getReturnStatusOptions();  		
  	}
  	
  	function items()
  	{
  		global $post;
  		
  		$this->data['return_products'] = $this->model_account_return->getReturnProducts($post->ID);  		
  		$this->data['return_reasons'] = impresscart_framework::model('localisation/return_reason')->getReturnReasons();
  		$this->data['return_actions'] = impresscart_framework::model('localisation/return_action')->getReturnActions();
  		$this->data['button_add_product'] = __('Add Product');
  		$this->data['button_remove'] = __('Remove');
  		$this->data['text_select'] =__('Select');
		$this->data['text_opened'] =__('Opened');
		$this->data['text_unopened'] =__('Unopened');
		$this->data['entry_product'] =__('Product');
		$this->data['entry_model'] =__('Model');
		$this->data['entry_quantity'] =__('Quantity');
 		$this->data['entry_reason'] =__('Reason');
		$this->data['entry_opened'] =__('Opened');
		$this->data['entry_action'] =__('Action');	
  	}

}
?>