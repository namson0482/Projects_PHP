<div class="impresscart_header">
	<h1 class="theme-title">
	<?php echo __('Impress Cart Order Total Detail');?>
	</h1>
</div>
	<?php if ($success) { ?>
<div class="success">
<?php echo $success; ?>
</div>
<?php } ?>
<?php if ($error) { ?>
<div class="warning">
<?php echo $error; ?>
</div>
<?php }
echo Goscom::generateMenu($pages);
?>
<div class="wrap">
<div>
	<table class="wp-list-table widefat fixed pages" cellspacing="0">
		<thead>
			<tr>
				<th><?php echo $column_name;?>
				</th>
				<th><?php echo $column_status ?>
				</th>
				<th><?php echo $column_sort_order ?>
				</th>
				<th><?php echo $column_action ?>
				</th>
			</tr>
		</thead>
		<tbody>
				<?php if ($totals) { 
					foreach ($totals as $total) {
				?>	
				<tr>
					<td>
						<?php echo $total['title']; ?>	
					</td>
					<td>
						<?php echo $total['status'] == 'yes' ?  'Enabled' :  'Disabled';   ?>
					</td>
					<td>
						<?php echo $total['order']; ?>
					</td>
					<td>
						[ <a
						href="<?php echo $total['action']['href']; ?>"><?php echo $total['action']['text']; ?>
						</a> ]
					</td>
				</tr>
				<?php } }?>
		</tbody>
		<tfoot>
			<tr>
				<th><?php echo $column_name;?>
				</th>
				<th><?php echo $column_status ?>
				</th>
				<th><?php echo $column_sort_order ?>
				</th>
				<th><?php echo $column_action ?>
				</th>
			</tr>
		</tfoot>
	</table>

</div>
</div>
