<table class="list" id="coupon-history">
		  <thead>
		    <tr>
		      <td class="left">Order ID</td>
		      <td class="left">Customer</td>
		      <td class="right">Amount</td>
		      <td class="right">Date Added</td>
		    </tr>
		  </thead>
  <tbody id="coupon-history-row">
    <?php if(isset($coupon_history) && $coupon_history && count($coupon_history)) foreach( $coupon_history as $coupon_history_entry ) { ?>
    <tr>
      <td class="left"><?php echo $coupon_history_entry['order_id'];?></td>
      <td class="left"><?php $customer = get_userdata($coupon_history_entry['customer']); 

      if($customer) {
      	echo $customer->data->user_login;
      }
      ?></td>
      <td class="right"><?php echo $coupon_history_entry['amount'];?></td>
      <td class="right"><?php echo $coupon_history_entry['date_added'];?></td>
    </tr>
    <?php } ?>
  </tbody>
                              
</table>