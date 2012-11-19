<?php 
	echo Goscom::generateHeader($pages);
?>


<?php 
if ($success) { 
	echo '<div class="warning">' . $success . '</div>';
}
if ($error) {
	echo '<div class="warning">' . $error . '</div>';
}
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
