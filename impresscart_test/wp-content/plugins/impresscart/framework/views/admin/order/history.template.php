<div id="history_list">
	<input type="hidden" value="<?php echo $history_post_id; ?>" name="history_post_id" />
	<table class="list">
	  <thead>
	    <tr>
	      <td class="left"><b><?php echo $column_date_added; ?></b></td>
	      <td class="left"><b><?php echo $column_comment; ?></b></td>
	      <td class="left"><b><?php echo $column_status; ?></b></td>
	      <td class="left"><b><?php echo $column_notify; ?></b></td>
	    </tr>
	  </thead>
	  <tbody>
	    <?php if (@$histories && count($histories)) { ?>
	    <?php foreach ($histories as $history) { ?>
	    <tr>
	      <td class="left"><?php echo $history['date_added']; ?></td>
	      <td class="left"><?php echo $history['comment']; ?></td>
	      <td class="left"><?php echo $history['status']; ?></td>
	      <td class="left"><?php echo $history['notify']; ?></td>
	    </tr>
	    <?php } ?>
	    <?php } else { ?>
	    <tr>
	      <td class="center" colspan="4"><?php echo @$text_no_results; ?></td>
	    </tr>
	    <?php } ?>
	    
	  </tbody>
	</table>
</div>

<table class="form">
	<tbody>
		<tr>
			<td>Order Status:</td>
			<td>
				<select name="order_status_id">
				<?php foreach ($order_statuses as $status) { ?>
	    			<option value="<?php echo $status->order_status_id; ?>"><?php echo $status->name; ?></option>
	    <?php } ?>
			</select>		
			</td>
		</tr>
		<tr>
			<td>Notify Customer:</td>
			<td><input type="checkbox" value="1" name="notify"></td>
		</tr>
		<tr>
			<td>Comment:</td>
			<td><textarea style="width: 99%" rows="8" cols="40"
					name="comment"></textarea>
				<div style="margin-top: 10px; text-align: right;">
					<a class="button" id="button-history" onclick='addHistory();'>Add History</a>
				</div></td>
		</tr>
	</tbody>
</table>

<script type="text/javascript">

function addHistory() {

	var history_post_id_Value = jQuery('input[name=\'history_post_id\']').val();	

	var orderStatusId_Value = jQuery('select[name=\'order_status_id\']').val();
	
	var comment_Value = jQuery('textarea[name=\'comment\']').val();
	
	var notifyCustomer_Value = jQuery('input[name=notify]').is(':checked');
	
	var url = "<?php $protocol = isset( $_SERVER["HTTPS"] ) ? 'https://' : 'http://'; echo admin_url( 'admin-ajax.php', $protocol );?>";
	
	jQuery.ajax({
		url: url,
		data: { action : 'framework', fwurl : '/admin/order/addHistory' ,
			order_Status_Id: orderStatusId_Value,
			comment: comment_Value,
			notify_Customer: notifyCustomer_Value,
			history_post_id: history_post_id_Value,
		},
		type: 'post',
		dataType: 'json',
		success: function(json) {
			if (json['output']) {
				jQuery('#history_list').html(json['output']);
			} else {
				jQuery('#history_list').html(json);
			}
		}
	});
}	
	
</script> 




