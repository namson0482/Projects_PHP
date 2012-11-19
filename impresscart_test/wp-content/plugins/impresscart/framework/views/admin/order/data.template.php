<table class="form">

          <tr>
            <td><?php echo $text_order_id; ?></td>
            <td>
            	<span>#<?php echo $order_id; ?></span>
            	<a id="print-invoice"><?php echo __('Print invoice'); ?></a>
            </td>
          </tr>
          <tr> 
            <td><?php echo $text_invoice_no; ?></td>
            <td><?php if (@$invoice_no) { ?>
              <?php echo $invoice_no; ?>
              <?php } else { ?>
              <span id="invoice"><b>[</b> <a id="invoice-create"><?php echo $text_create_invoice_no; ?></a> <b>]</b></span>
              <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo @$text_store_name; ?></td>
            <td><?php echo @$store_name; ?></td>
          </tr>
          <tr>
            <td><?php echo $text_store_url; ?></td>
            <td><a onclick="window.open('<?php echo $store_url; ?>');"><i><?php echo @$store_url; ?></i></a></td>
          </tr>
          <tr>
            <td><?php echo @$text_firstname; ?></td>
            <td><input type="text" name="firstname" value="<?php echo @$firstname; ?>" /></td>
          </tr>
          
          <tr>
            <td><?php echo @$text_lastname; ?></td>
            <td><input type="text" name="lastname" value="<?php echo @$lastname; ?>" /></td>
          </tr>
          
          
          <?php if (isset($customer_group)) { ?>
          <tr>
            <td><?php echo $text_customer_group; ?></td>
            <td><?php echo $customer_group; ?></td>
          </tr>
          <?php } ?>
          
          
          <tr>
            <td><?php echo $text_ip; ?></td>
            <td><?php echo @$ip; ?></td>
          </tr>
          <tr>
            <td><?php echo $text_email; ?></td>
            <td><input type="text" name="data[email]" value="<?php echo @$email; ?>" /></td>
          </tr>
          <tr>
            <td><?php echo $text_telephone; ?></td>
            <td><input type="text" name="data[telephone]" value="<?php echo @$telephone; ?>" /></td>
          </tr>
          <?php if (@$fax) { ?>
          <tr>
            <td><?php echo $text_fax; ?></td>
            <td><input type="text" name="data[fax]" value="<?php echo $fax; ?>" /></td>
          </tr>
          <?php } ?>
          
          <?php if (@$order_status) { ?>
          <tr>
            <td><?php echo $text_order_status; ?></td>
            <td id="order-status">
            	<?php echo $order_status; ?>
            </td>
          </tr>
          <?php } ?>
          
          <!--  
          <tr>
            <td><?php echo $text_affiliate; ?></td>
            <td id="affiliate"></td>
          </tr>
          
          
          <tr>
            <td><?php echo $text_commission; ?></td>
            <td id="commission"></td>
          </tr>
          
          -->
          
          <?php if (@$comment) { ?>
          <tr>
            <td><?php echo $text_comment; ?></td>
            <td><textarea name="data[comment]" ><?php echo $comment; ?></textarea></td>
          </tr>
          <?php } ?>
          <tr>
            <td><?php echo $text_total; ?></td>
            <td><?php echo @$total; ?>
              <?php if (isset($credit) && isset($customer)) { ?>
              <?php if (!$credit_total) { ?>
              <span id="credit"><b>[</b> <a id="credit-add"><?php echo $text_credit_add; ?></a> <b>]</b></span>
              <?php } else { ?>
              <span id="credit"><b>[</b> <a id="credit-remove"><?php echo $text_credit_remove; ?></a> <b>]</b></span>
              <?php } ?>
              <?php } ?></td>
          </tr>
          
          
          <tr> 
            <td><?php echo $text_reward; ?></td>
            <td>
            	<?php echo $reward; ?><span id="reward">&nbsp;<b>[</b> <a id="reward-update"><?php echo $text_reward; ?></a> <b>]</b></span>
            </td>
            
          </tr>
          
          <tr>
            <td><?php echo $text_date_added; ?></td>
            <td><?php echo @$date_added; ?></td>
          </tr>
          <tr>
            <td><?php echo $text_date_modified; ?></td>
            <td><?php echo @$date_modified; ?></td>
          </tr>          
</table>
<script>
//Create invoice-no
jQuery('#invoice-create').live('click', function() {
	jQuery.ajax({
		url: ajaxurl,
		type : 'get',
		data : { 
				action : 'framework', 
				fwurl : '/admin/order/createInvoiceNo',
				order_id : <?php echo '\''.$order_id.'\'' ?>, 
		},
		dataType: 'json',
		beforeSend: function() {
			jQuery('#invoice').after('<img src="images/loading.gif" class="loading" style="padding-left: 5px;" />');	
		},
		complete: function() {
			jQuery('.loading').remove();
		},
		success: function(json) {
			if (json['error']) {
				//jQuery('#tab-order').prepend('<div class="warning" style="display: none;">' + json['error'] + '</div>');
				//jQuery('.warning').fadeIn('slow');
			}
			
			if (json.invoice_no) {
				jQuery('#invoice').fadeOut('slow', function() {
					jQuery('#invoice').html(json['invoice_no']);
					jQuery('#invoice').fadeIn('slow');
				});
			}
		}
	});
});

//Add reward to order 
jQuery('#reward-update').live('click', function() {
	jQuery.ajax({
		url: ajaxurl,
		type : 'get',
		data : { 
				action : 'framework', 
				fwurl : '/admin/order/updateOrderReward',
				order_id : <?php echo '\''.$order_id.'\'' ?>, 
		},
		dataType: 'json',
		beforeSend: function() {
			jQuery('#reward').after('<img src="images/loading.gif" class="loading" style="padding-left: 5px;" />');	
		},
		complete: function() {
			jQuery('.loading').remove();
		},
		success: function(json) {
			if (json['error']) {
				//jQuery('#tab-order').prepend('<div class="warning" style="display: none;">' + json['error'] + '</div>');
				//jQuery('.warning').fadeIn('slow');
			}
			
			if (json.reward) {
				jQuery('#reward').fadeOut('slow', function() {
					jQuery('#reward-update').html(json['reward']);
					jQuery('#reward').fadeIn('slow');
				});
			}
		}
	});
});


jQuery('#print-invoice').live('click', function() {
	var order_id = <?php echo $order_id; ?>;
	var url = 'admin.php?page=catalog&fwurl=/report/customer_order/invoice&order_id=' + order_id ;
	alert('As Soon As constructor');
	//window.open(url);
	//alert(url);
	
});


</script>