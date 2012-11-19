<div class="impresscart_header">
	<h1 class="theme-title">
	<?php echo $heading;?>
	</h1>
</div>
<?php 
	echo Goscom::generateMenu($pages);
?>
<div class="content">

	<table class="form">
		<tr>
			<td><?php echo $entry_date_start; ?> <input type="text"
				name="filter_date_start" value="<?php echo $filter_date_start; ?>"
				id="date-start" size="12" /></td>
			<td><?php echo $entry_date_end; ?> <input type="text"
				name="filter_date_end" value="<?php echo $filter_date_end; ?>"
				id="date-end" size="12" /></td>
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
				<th ><?php echo $column_points; ?></th>
				<th ><?php echo $column_orders; ?></th>
				<th ><?php echo $column_total; ?></th>
			</tr>
		</thead>
		<tbody>
		<?php if ($customers) { ?>
		<?php foreach ($customers as $customer) { ?>
			<tr>
				<td class="left"><?php echo $customer['customer']; ?></td>
				<td class="left"><?php echo $customer['email']; ?></td>
				<td class="left"><?php echo $customer['customer_group']; ?></td>
				<td class="left"><?php echo $customer['status']; ?></td>
				<td class="right"><?php echo $customer['points']; ?></td>
				<td class="right"><?php echo $customer['orders']; ?></td>
				<td class="right"><?php echo $customer['total']; ?></td>
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
				<th ><?php echo $column_points; ?></th>
				<th ><?php echo $column_orders; ?></th>
				<th ><?php echo $column_total; ?></th>
			</tr>
		</tfoot>
	</table>
	</div>
	
</div>
<script type="text/javascript"><!--
function filter() {
	url = '<?php echo $url ?>';
	
	var filter_date_start = jQuery('input[name=\'filter_date_start\']').attr('value');
	
	if (filter_date_start) {
		url += '&filter_date_start=' + encodeURIComponent(filter_date_start);
	}

	var filter_date_end = jQuery('input[name=\'filter_date_end\']').attr('value');
	
	if (filter_date_end) {
		url += '&filter_date_end=' + encodeURIComponent(filter_date_end);
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
