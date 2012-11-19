<div class="impresscart_header">
	<h1 class="theme-title">
	<?php echo $heading;?>
	</h1>
</div>
<?php 
	echo Goscom::generateMenu($pages);
?>
<div class="content">
	<div class="wrap">
		<table class="wp-list-table widefat fixed pages" cellspacing="0">
		<thead>
			<tr>
				<th ><?php echo $column_customer; ?></th>
				<th ><?php echo $column_email; ?></th>
				<th ><?php echo $column_customer_group; ?></th>
				<th ><?php echo $column_status; ?></th>
				<th ><?php echo $column_total; ?></th>
				<th ><?php echo $column_action; ?></th>
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
				<td class="right"><?php echo $customer['total']; ?></td>
				<td class="right"><?php foreach ($customer['action'] as $action) { ?>
					[ <a href="<?php echo $action['href']; ?>"><?php echo $action['text']; ?>
				</a> ] <?php } ?></td>
			</tr>
			<?php } ?>
			<?php } else { ?>
			<tr>
				<td style="text-align: center;" colspan="6"><?php echo $text_no_results; ?></td>
			</tr>
			<?php } ?>
		</tbody>
		<tfoot>
			<tr>
				<th ><?php echo $column_customer; ?></th>
				<th ><?php echo $column_email; ?></th>
				<th ><?php echo $column_customer_group; ?></th>
				<th ><?php echo $column_status; ?></th>
				<th ><?php echo $column_total; ?></th>
				<th ><?php echo $column_action; ?></th>
			</tr>
		
		</tfoot>
		
		
	</table>
	</div>
</div>

