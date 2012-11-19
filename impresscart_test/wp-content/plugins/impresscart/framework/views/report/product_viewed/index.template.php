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
				<th ><?php echo $column_name; ?></th>
				<th ><?php echo $column_model; ?></th>
				<th ><?php echo $column_viewed; ?></th>
				<th ><?php echo $column_percent; ?></th>
			</tr>
		</thead>
		<tbody>
		<?php if ($products) { ?>
		<?php foreach ($products as $product) { ?>
			<tr>
				<td ><?php echo $product['name']; ?></td>
				<td ><?php echo $product['model']; ?></td>
				<td ><?php echo $product['viewed']; ?></td>
				<td ><?php echo $product['percent']; ?></td>
			</tr>
			<?php } ?>
			<?php } else { ?>
			<tr>
				<td  style="text-align: center;" colspan="4"><?php echo $text_no_results; ?></td>
			</tr>
			<?php } ?>
			<tfoot>
				<tr>
					<th ><?php echo $column_name; ?></th>
					<th ><?php echo $column_model; ?></th>
					<th ><?php echo $column_viewed; ?></th>
					<th ><?php echo $column_percent; ?></th>
				</tr>
			</tfoot>
		</tbody>
	</table>
	</div>
</div>
