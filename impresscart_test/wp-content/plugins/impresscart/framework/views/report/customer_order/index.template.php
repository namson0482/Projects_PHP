<?php 
	echo Goscom::generateHeader($pages);
?>
<div class="content">
	<br>
	<table class="form">
		<tr>
			<td><?php echo $entry_date_start; ?> <input type="text"
				name="filter_date_start" value="<?php echo $filter_date_start; ?>"
				id="date-start" size="12" /></td>
			<td><?php echo $entry_date_end; ?> <input type="text"
				name="filter_date_end" value="<?php echo $filter_date_end; ?>"
				id="date-end" size="12" /></td>
			<td><?php echo $entry_status; ?> <select
				name="filter_order_status_id">
				<?php if (-1 == $filter_order_status_id) { ?>
					<option value="-1" selected="selected">
					<?php echo $text_all_status; ?>
					</option>
					<?php } else { ?>
					<option value="-1">
					<?php echo $text_all_status; ?>
					</option>
					<?php } ?>


					<?php foreach ($order_statuses as $order_status) { ?>
					<?php if ($order_status['order_status_id'] == $filter_order_status_id) { ?>
					<option value="<?php echo $order_status['order_status_id']; ?>"
						selected="selected">
						<?php echo $order_status['name']; ?>
					</option>
					<?php } else { ?>
					<option value="<?php echo $order_status['order_status_id']; ?>">
					<?php echo $order_status['name']; ?>
					</option>
					<?php } ?>
					<?php } ?>
			</select></td>
			<td style="text-align: right;"><a onclick="filter();" class="button"><?php echo $button_filter; ?>
			</a></td>
		</tr>
	</table>
	 <div class="wrap">
	    <table class="wp-list-table widefat fixed pages" cellspacing="0">
			<thead>
				<tr>
					<th ><?php echo $column_customer; ?></th>
					<th ><?php echo $column_email; ?></th>
					<th ><?php echo $column_customer_group; ?></th>
					<th ><?php echo $column_status; ?></th>
					<th ><?php echo $column_orders; ?></th>
					<th ><?php echo $column_products; ?></th>
					<th ><?php echo $column_total; ?></th>
				</tr>
			</thead>
			<tbody>
			<?php if ($customers) { ?>
			<?php foreach ($customers as $customer) { ?>
				<tr>
					<td ><?php echo $customer['customer']; ?></td>
					<td ><?php echo $customer['email']; ?></td>
					<td ><?php echo $customer['customer_group']; ?></td>
					<td ><?php echo $customer['status']; ?></td>
					<td ><?php echo $customer['orders']; ?></td>
					<td ><?php echo $customer['products']; ?></td>
					<td ><?php echo $customer['total']; ?></td>
				</tr>
				<?php } ?>
				<?php } else { ?>
				<tr>
					<td style="text-align: center;" colspan="7"><?php echo $text_no_results; ?></td>
				</tr>
				<?php } ?>
			</tbody>
			<tfoot>
				<tr>
					<th ><?php echo $column_customer; ?></th>
					<th ><?php echo $column_email; ?></th>
					<th ><?php echo $column_customer_group; ?></th>
					<th ><?php echo $column_status; ?></th>
					<th ><?php echo $column_orders; ?></th>
					<th ><?php echo $column_products; ?></th>
					<th ><?php echo $column_total; ?></th>
				</tr>
			</tfoot>
		</table>
	</div>
	<div class="pagination">
	<?php echo @$pagination; ?>
	</div>
</div>

<script type="text/javascript"><!--
function filter() {
	url = '<?php echo $url; ?>';
	
	var filter_date_start = jQuery('input[name=\'filter_date_start\']').attr('value');
	
	if (filter_date_start) {
		url += '&filter_date_start=' + encodeURIComponent(filter_date_start);
	}

	var filter_date_end = jQuery('input[name=\'filter_date_end\']').attr('value');
	
	if (filter_date_end) {
		url += '&filter_date_end=' + encodeURIComponent(filter_date_end);
	}
	
	var filter_order_status_id = jQuery('select[name=\'filter_order_status_id\']').attr('value');
	
	if (filter_order_status_id) {
		url += '&filter_order_status_id=' + encodeURIComponent(filter_order_status_id);
	}	

	location = url;
}
//--></script>
<script type="text/javascript"><!--
jQuery(document).ready(function() {
	jQuery('#date-start').datepicker({dateFormat: 'yy-mm-dd'});
	
	jQuery('#date-end').datepicker({dateFormat: 'yy-mm-dd'});
});
//--></script>
