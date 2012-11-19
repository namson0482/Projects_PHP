<?php
class impresscart_admin_voucher_controller extends impresscart_framework_controller {

	private $error = array();

	public function history() {
		global $post;
		// get voucher from db
		$voucher_history = get_post_meta($post->ID, 'voucher_history',true);
		?>

<table class="list" id="voucher-history">
	<thead>
		<tr>
			<td class="left">Order ID</td>
			<td class="left">Customer</td>
			<td class="right">Amount</td>
			<td class="right">Date Added</td>
		</tr>
	</thead>
	<tbody id="voucher-history-row">
	<?php if($voucher_history) foreach( $voucher_history as $voucher_history_entry ) { ?>
		<tr>
			<td class="left"><?php echo $voucher_history_entry['order_id'];?></td>
			<td class="left"><?php $customer = get_userdata($voucher_history_entry['customer']);
			
			if($customer) {
				echo $customer->data->user_login;	
			}
			
			
			?>
			</td>
			<td class="right"><?php echo $voucher_history_entry['amount'];?></td>
			<td class="right"><?php echo $voucher_history_entry['date_added'];?>
			</td>
		</tr>
		<?php } ?>
	</tbody>

</table>


		<?php
			
		$this->autoRender = false;

	}

	function data()  {
		global $post;
		$data = get_post_meta($post->ID, 'data',true);
		$voucher_code = get_post_meta($post->ID, 'voucher_code',true);

		if(($data)){
			foreach ($data as $key => $value)
			{
				$this->data[$key] = $value;
			}
		}

		if( !$voucher_code )
		{
			$this->data['code'] = $this->model_sale_voucher->genVoucherCode();
		} else {
			$this->data['code'] = $voucher_code;
		}

		$this->data['coupon_product'] = null;
		if(isset($data['coupon_product']))
		foreach ($data['coupon_product'] as $value)
		{
			$this->data['coupon_product'][] = array(
	        		'product_id' => $value,
	        		'name' => get_post($value)->post_title
			);
		}

		$voucher_theme_model = impresscart_framework::model('sale/voucher_theme');
		$this->data['voucher_themes'] = $voucher_theme_model->getThemes();
		$this->data['heading_title'] = __('Purchase a Gift Certificate');
		$this->data['text_enabled'] = __('text_enabled');
		$this->data['text_disabled'] = __('text_disabled');

		$this->data['entry_code'] = __('Code:<br /><span class="help">The code the customer enters to activate the voucher.</span>');
		$this->data['entry_from_name'] = __('From Name:');
		$this->data['entry_from_email'] = __('From Email:');
		$this->data['entry_to_name'] = __('To Name:');
		$this->data['entry_to_email'] = __('To Email:');
		$this->data['entry_message'] = __('Message:');
		$this->data['entry_amount'] = __('Amount:');



	}

}
?>