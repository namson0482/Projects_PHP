<div class="impresscart_header">
<h1 class="theme-title"><?php echo __('Impress Cart Payment Gateways');?></h1>
</div>
<?php 
echo '<div>';
echo Goscom::generateMenu($pages);
echo '</div>';
?>

<div class="wrap">
	<table class="wp-list-table widefat fixed pages" cellspacing="0">
		<thead>
			<tr>
				<th><?php echo __('Shipping Method');?>
				</th>
			</tr>
		</thead>
		<tbody>
			<?php 
			foreach($payment_methods as $method) {
			?>
				<tr>
					<td>
						<?php 
							echo "<a href='".'admin.php?page=payment&fwurl=/admin/'.$method['code'].'/setting'."'>" . $method['title'] . "</a>";
						?>	
					</td>
				</tr>
			<?php 
			}
			?>
		</tbody>
		<tfoot>
			<tr>
				<th><?php echo __('Shipping Method');?>
				</th>
			</tr>
		</tfoot>
	</table>
</div>