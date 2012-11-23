<?php 
	echo Goscom::generateHeader($pages);
?>
<div>

<form action="" method="post">
	<table style="border-spacing: 0; border-collapse: collapse;" class="wp-list-table widefat fixed pages">
			<thead>
				<tr>
					<th colspan="2" style="border: 1px;">
						<h2>
							Citylink Shipping Method
						</h2>
					</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td colspan="2">
					<input type="button" name="backtolist"
						id="backtolist" class="button" value="Back to list" /> 
						<input type="hidden" id="backaddress" name="backaddress"
						value="<?php echo(get_bloginfo('url') . '/wp-admin/' . 'admin.php?page=shipping');?>">
					</td>
				</tr>
				<tr>
					<td class='widefat_extend'>
						<label>Title</label>
					
					</td>
					<td class='widefat_extend'>
						<input name="impresscart[shipping_method][citylink][citylink_name]" size="60" value="<?php echo !isset($setting['name']) ? 'Citylink' : $setting['citylink_name'];?>" />
					</td>
				</tr>

				<tr>
					<td class='widefat_extend'>
						
						<label style="v-align: middle;">Citylink Rates:</label>
						
						
					</td>
					<td class='widefat_extend'>
					
						<textarea name="impresscart[shipping_method][citylink][citylink_rate]" rows="5" cols="40" ><?php echo !isset($setting['citylink_total']) ? '10:11.6,15:14.1,20:16.60,25:19.1,30:21.6,35:24.1,40:26.6,45:29.1,50:31.6,55:34.1,60:36.6,65:39.1,70:41.6,75:44.1,80:46.6,100:56.6,125:69.1,150:81.6,200:106.6' : $setting['citylink_rate'];?></textarea>
						
					</td>
				</tr>

				<tr>
					<td class='widefat_extend'>
						<label>Tax classes</label>
					</td>

					<td class='widefat_extend'>
						<?php echo $tax_classes; ?>
					</td>
				</tr>

				<tr>
					<td class='widefat_extend'>
						<label>Geo Zones</label>
					</td>
					<td class='widefat_extend'>
						<?php echo $geo_zones; ?>
					</td>
				</tr>
				<tr>
					<td class='widefat_extend'>
						<label>Sort Order</label>
						
					</td>
					<td class='widefat_extend'>
						<input name="impresscart[shipping_method][citylink][citylink_order]" value="<?php echo !isset($setting['citylink_order']) ? '5' : $setting['citylink_order'];?>" />
					</td>
				</tr>
				<tr>
					<td class='widefat_extend'>
						<label>Enabled</label>
					</td>
					<td class='widefat_extend'>
						<select name="impresscart[shipping_method][citylink][enabled]" >
							<option value="1" <?php if($setting['enabled'] == '1') echo 'selected="selected"'; ?>>Yes</option>
							<option value="0" <?php if($setting['enabled'] == '0') echo 'selected="selected"'; ?>>No</option>
						</select>
					</td>
				</tr>
				
				<tr>
					<td colspan="2" class='widefat_extend'>
						<input type="submit" name="save" value="save" />
						<input type="hidden" name="impresscart[shipping_method][citylink][code]" value="citylink" />
					</td>
				</tr>
			</tbody>
		</table>

<!-- ************************************************ -->
</form>
</div>
<script type="text/javascript"><!--

jQuery('#backtolist').bind('click', function() {
	  //alert('User clicked on "foo."');
	  //window.history.back(-1);
	  window.location.href = jQuery('#backaddress').val();
	  return false;
});

//--></script>