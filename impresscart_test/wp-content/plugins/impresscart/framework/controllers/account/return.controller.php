<?php 
class impresscart_account_return_controller extends impresscart_framework_controller { 
	private $error = array();
	
	public function index() {
    	if (!$this->customer->isLogged()) {
      		$this->session->data['redirect'] = $this->url->link('account/return', '', 'SSL');

	  		$this->redirect($this->url->link('account/login', '', 'SSL'));
	  		return;
    	}

    	$this->data['heading_title'] = __('Product Returns');
		
		$this->data['text_return_id'] = __('Return ID:');
		$this->data['text_order_id'] = __('Order ID:');
		$this->data['text_status'] = __('Status:');
		$this->data['text_date_added'] = __('Date Added:');
		$this->data['text_customer'] = __('Customer:');
		$this->data['text_products'] = __('Products:');
		$this->data['text_empty'] = __('You have not made any previous returns!');

		$this->data['button_view'] = __('View');
		$this->data['button_continue'] = __('Continue');
		
		$this->data['action'] = $this->url->link('account/history', '', 'SSL');
		
		$this->data['returns'] = array();
		
		$return_total = $this->model_account_return->getTotalReturns();
		
		$page = isset($page) ? $page : 1;
		
		$results = $this->model_account_return->getReturns(($page - 1) * $this->config->get('catalog_item_per_page'), $this->config->get('catalog_item_per_page'));
		if(count($results))
		foreach ($results as $result) {
			$product_total = $this->model_account_return->getTotalReturnProductsByReturnId($result['return_id']);

			$this->data['returns'][] = array(
				'return_id'  => $result['return_id'],
				'order_id'   => $result['order_id'],
				'name'       => $result['firstname'] . ' ' . $result['lastname'],
				'status'     => $result['status']->name,
				'date_added' => date(__('d/m/Y'), strtotime($result['date_added'])),
				'products'   => $product_total,
				'href'       => $this->url->link('account/return/info', 'return_id=' . $result['return_id'] . $url, 'SSL')
			);
		}		
	}
	
	public function info() {
		
		if (isset($_GET['return_id'])) {
			$return_id = $_GET['return_id'];
		} else {
			$return_id = 0;
		}
    	
		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/return/info', 'return_id=' . $return_id, 'SSL');
			
			$this->redirect($this->url->link('account/login', '', 'SSL'));
    	}
		
		$return_info = $this->model_account_return->getReturn($return_id);
		
		if ($return_info) {
			
			$this->data['heading_title'] = __('Return Information');
			
			$this->data['text_return_id'] = __('Return ID:');
			$this->data['text_order_id'] = __('Order ID:');
			$this->data['text_date_ordered'] = __('Order Date:');
			$this->data['text_customer'] = __('Customer:');
			$this->data['text_email'] = __('text_email');
			$this->data['text_telephone'] = __('text_telephone');			
			$this->data['text_status'] = __('Status:');
			$this->data['text_date_added'] = __('Date Added:');
			$this->data['text_product'] = __('Products:');
			$this->data['text_comment'] = __('Comment');
      		$this->data['text_history'] = __('Return History');
			
      		$this->data['column_name'] = __('Product Name');
      		$this->data['column_model'] = __('Model');
      		$this->data['column_quantity'] = __('Quantity');
      		$this->data['column_opened'] = __('Opened');
			$this->data['column_reason'] = __('Reason');
			$this->data['column_action'] = __('Action');
			$this->data['column_date_added'] = __('Date Added');
      		$this->data['column_status'] = __('Status');
      		$this->data['column_comment'] = __('Comment');
							
			$this->data['button_continue'] = __('Continue');
			
			$this->data['return_id'] = $return_info['return_id'];
			$this->data['order_id'] = $return_info['order_id'];
			$this->data['date_ordered'] = date(__('d/m/Y'), strtotime($return_info['date_ordered']));
			$this->data['firstname'] = $return_info['firstname'];
			$this->data['lastname'] = $return_info['lastname'];
			$this->data['email'] = $return_info['email'];
			$this->data['telephone'] = $return_info['telephone'];						
			$this->data['comment'] = $return_info['comment'];			
			$this->data['date_added'] = date(__('d/m/Y'), strtotime($return_info['date_added']));
				
			$this->data['products'] = array();
			
		 	$results = $this->model_account_return->getReturnProducts($_GET['return_id']);
			
			foreach ($results as $result) {
				$this->data['products'][] = array(
					'name'     => $result['name'],
					'model'    => $result['model'],
					'quantity' => $result['quantity'],
					'reason'   => $result['reason'],
					'opened'   => $result['opened'] ? __('Yes') : __('No'),
					'comment'  => nl2br($result['comment']),
					'action'   => $result['action']
				);
			}
						
			$this->data['histories'] = array();
			
			$results = $this->model_account_return->getReturnHistories($_GET['return_id']);
			
      		foreach ($results as $result) {
        		$this->data['histories'][] = array(
          			'date_added' => date(__('d/m/Y'), strtotime($result['date_added'])),
          			'status'     => $result['status'],
          			'comment'    => nl2br($result['comment'])
        		);
      		}			
			
		} else {
			echo __('The returns you requested could not be found!');
			$this->autoRender = false;	
		}
	}
		
	public function insert() {
		
    	if (($_SERVER['REQUEST_METHOD'] == 'POST') && $this->validate()) {
  			if($this->model_account_return->addReturn($_POST))	  		
			$this->redirect($this->url->link('account/return/success', '', 'SSL'));
			else {
				$this->autoRender = false;
				echo _("Error add return!");
				return;
			}
    	} 
				
    	$this->data['heading_title'] = __('Product Returns');

		$this->data['text_description'] = __('<p>Please complete the form below to request an RMA number.</p>');
		$this->data['text_order'] = __('Order Information');
		$this->data['text_product'] = __('Product Information &amp; Reason for Return');
		$this->data['text_additional'] = __('Additional Information');
		$this->data['text_yes'] = __('Yes');
		$this->data['text_no'] = __('No');
		
		$this->data['entry_order_id'] = __('Order ID:');	
		$this->data['entry_date_ordered'] = __('Order Date:');	    	
		$this->data['entry_firstname'] = __('First Name:');
    	$this->data['entry_lastname'] = __('Last Name:');
    	$this->data['entry_email'] = __('E-Mail:');
    	$this->data['entry_telephone'] = __('Telephone:');
		$this->data['entry_product'] = __('Product Name:');	
		$this->data['entry_model'] = __('Product Code:');			
		$this->data['entry_quantity'] = __('Quantity:');				
		$this->data['entry_reason'] = __('Reason for Return:');	
		$this->data['entry_opened'] = __('Product is opened:');	
		$this->data['entry_fault_detail'] = __('Faulty or other details:');	
				
		$this->data['button_continue'] = __('Continue');
		$this->data['button_back'] = __('Back');
		$this->data['button_add_product'] = __('Add Product');
		$this->data['button_remove'] = __('Remove');
		    
		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
		if (isset($this->error['order_id'])) {
			$this->data['error_order_id'] = $this->error['order_id'];
		} else {
			$this->data['error_order_id'] = '';
		}
				
		if (isset($this->error['firstname'])) {
			$this->data['error_firstname'] = $this->error['firstname'];
		} else {
			$this->data['error_firstname'] = '';
		}	
		
		if (isset($this->error['lastname'])) {
			$this->data['error_lastname'] = $this->error['lastname'];
		} else {
			$this->data['error_lastname'] = '';
		}		
	
		if (isset($this->error['email'])) {
			$this->data['error_email'] = $this->error['email'];
		} else {
			$this->data['error_email'] = '';
		}
		
		if (isset($this->error['telephone'])) {
			$this->data['error_telephone'] = $this->error['telephone'];
		} else {
			$this->data['error_telephone'] = '';
		}
				
		if (isset($this->error['name'])) {
			$this->data['error_name'] = $this->error['name'];
		} else {
			$this->data['error_name'] = '';
		}
		
		if (isset($this->error['model'])) {
			$this->data['error_model'] = $this->error['model'];
		} else {
			$this->data['error_model'] = '';
		}
						
		if (isset($this->error['reason'])) {
			$this->data['error_reason'] = $this->error['reason'];
		} else {
			$this->data['error_reason'] = '';
		}
		
 		if (isset($this->error['captcha'])) {
			$this->data['error_captcha'] = $this->error['captcha'];
		} else {
			$this->data['error_captcha'] = '';
		}	
						
		$this->data['action'] = $this->url->link('account/return/insert', '', 'SSL');

    	if (isset($_POST['order_id'])) {
      		$this->data['order_id'] = $_POST['order_id']; 	
		} elseif (isset($this->session->data['return']['order_id'])) {
			$this->data['order_id'] = $this->session->data['return']['order_id'];
		} else {
      		$this->data['order_id'] = ''; 
    	}
				
    	if (isset($_POST['date_ordered'])) {
      		$this->data['date_ordered'] = $_POST['date_ordered']; 	
		} elseif (isset($this->session->data['return'])) {
			$this->data['date_ordered'] = date('Y-m-d', strtotime($this->session->data['return']['date_added']));
		} else {
      		$this->data['date_ordered'] = '';
    	}
				
		if (isset($_POST['firstname'])) {
    		$this->data['firstname'] = $_POST['firstname'];
		} else {
			$this->data['firstname'] = $this->customer->getFirstName();
		}

		if (isset($_POST['lastname'])) {
    		$this->data['lastname'] = $_POST['lastname'];
		} else {
			$this->data['lastname'] = $this->customer->getLastName();
		}
		
		if (isset($_POST['email'])) {
    		$this->data['email'] = $_POST['email'];
		} else {
			$this->data['email'] = $this->customer->getEmail();
		}
		
		if (isset($_POST['telephone'])) {
    		$this->data['telephone'] = $_POST['telephone'];
		} else {
			$this->data['telephone'] = $this->customer->getTelephone();
		}
		
		$model_return_reason = impresscart_framework::model('localisation/return_reason');
		
    	$this->data['return_reasons'] = $model_return_reason->getReturnReasons();

    	if (isset($_POST['return_product'])) {
      		$this->data['return_products'] = $_POST['return_product']; 	
		} elseif (isset($this->session->data['return'])) {
			$this->data['return_products'] = array();			
			foreach ($this->session->data['return']['product'] as $result) {
				$this->data['return_products'][] = array(
					'name'     => $result['name'],
					'model'    => $result['model'],
					'quantity' => 1,
					'opened'   => false,
					'comment'  => ''
				);
			}
		} else {
      		$this->data['return_products'] = array();
    	}
    	
		if (isset($this->session->data['return'])) {
			unset($this->session->data['return']);
		}
		
    	if (isset($_POST['comment'])) {
      		$this->data['comment'] = $_POST['comment']; 	
		} else {
      		$this->data['comment'] = '';
    	}

		if (isset($_POST['captcha'])) {
			$this->data['captcha'] = $_POST['captcha'];
		} else {
			$this->data['captcha'] = '';
		}		
		
		$this->data['back'] = $this->url->link('account/account', '', 'SSL');
  	}
	
  	public function success() {
		
 		echo 'You have added product returns successfully! Please wait for feedback from us.';
 			
    	$this->autoRender = false; 
	}
		
  	private function validate() {
  		
    	if (!$_POST['order_id']) {
      		$this->error['order_id'] = __('error_order_id');
    	}
		
		if ((utf8_strlen($_POST['firstname']) < 1) || (utf8_strlen($_POST['firstname']) > 32)) {
      		$this->error['firstname'] = __('error_firstname');
    	}

    	if ((utf8_strlen($_POST['lastname']) < 1) || (utf8_strlen($_POST['lastname']) > 32)) {
      		$this->error['lastname'] = __('error_lastname');
    	}

    	if ((utf8_strlen($_POST['email']) > 96) || !preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $_POST['email'])) {
      		$this->error['email'] = __('error_email');
    	}
		
    	if ((utf8_strlen($_POST['telephone']) < 3) || (utf8_strlen($_POST['telephone']) > 32)) {
      		$this->error['telephone'] = __('error_telephone');
    	}		

		if (!isset($_POST['return_product'])) {
			$this->error['warning'] = __('error_product');
		} else {
			foreach ($_POST['return_product'] as $key => $value) {
				if (!isset($value['return_reason_id'])) {
					$this->error['reason'][$key] = __('Warning: Please select reason for return.');
				}	
				
				if ((utf8_strlen($value['name']) < 1) || (utf8_strlen($value['name']) > 255)) {
					$this->error['name'][$key] = __('error_name');
				}	
				
				if ((utf8_strlen($value['model']) < 1) || (utf8_strlen($value['model']) > 64)) {
					$this->error['model'][$key] = __('error_model');
				}							
			}			
		}
		
//    	if (!isset($this->session->data['captcha']) || ($this->session->data['captcha'] != $_POST['captcha'])) {
//      		$this->error['captcha'] = __('error_captcha');
//    	}

		if (!$this->error) {
      		return true;
    	} else {
      		return false;
    	}
  	}
	
	public function captcha() {
		$this->load->library('captcha');
		
		$captcha = new Captcha();
		
		$this->session->data['captcha'] = $captcha->getCode();
		
		$captcha->showImage();
	}	
}
?>
