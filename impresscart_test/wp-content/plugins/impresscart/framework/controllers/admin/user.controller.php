<?php

//require_once IMPRESSCART_CLASSES . '/impresscart_attribute.php';

class impresscart_admin_user_controller extends impresscart_framework_controller {
	
	function init($user_id) {
		
		$this->data['text_description'] = 'Description ';
		$this->data['text_amount'] = 'Amount ';
		$transactions = get_user_meta($user_id, 'transactions', true);
		$table_data_transactions = '';
		
		if($transactions != '') {
			$transactions_descriptions = $transactions['description'];
			$transactions_amounts = $transactions['amount'];
			
			if($this->validate($transactions_amounts)) {
				for($i=0; $i<count($transactions_descriptions);$i++) {
					$temp = $transactions_descriptions[$i];
					$description = '<td><span>Description : </span><input type="text" name="impresscart[credit][description][]" value="'. $transactions_descriptions[$i] .'"></td>';
					$amount = '<td><span>Amount : </span><input type="text" name="impresscart[credit][amount][]" value="'. $transactions_amounts[$i] .'"></td>';
					$table_data_transactions .= '<tr>' . $description . $amount . '</tr>' ;
				}
			}
		}
		$this->data['table_data_transactions'] = $table_data_transactions;
	}
	
	function validate($transactions_amounts) {
		for($i=0;$i<count($transactions_amounts);$i++) {
			$transactions_amount = $transactions_amounts[$i];
			if( !is_numeric($transactions_amount)) 
				return false;
		}
		return true;
	}

	function index($param) {
		
		if (($_SERVER['REQUEST_METHOD'] == 'POST')) {
			/*
			$json = array();
			
			$user_id = $_REQUEST['user_id'];
			//$this->delete($user_id);					
			//$this->update($user_id);					
			
			$transactions = get_user_meta($user_id, 'transactions');
			//var_dump(get_user_meta($user_id, 'transactions'));
			//die();
			if($transactions == '') {
				$transactions[] = array(
					'description'	=> $_REQUEST['description'] ,
					'amount'	=> $_REQUEST['amount']
					);
				
			}
			
			$transactions[] = array(
					'description'	=> $_REQUEST['description'] ,
					'amount'	=> $_REQUEST['amount']
					);
			update_user_meta($user_id, 'transactions', $transactions);
			var_dump(get_user_meta($user_id, 'transactions', true));
			echo json_encode($json);
			exit(0);
			//get_user_meta($customer_id, 'fax', true);
			//var_dump($this->customer->);
			*/ 
			/*var_dump($_REQUEST['description']);
			var_dump($_REQUEST['amount']);
			die();
			*/
		} else {
			self::init($param);	
		}
		
				 
	}
}
