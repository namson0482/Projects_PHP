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
								Flat Rate Shipping Method
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
							<input name="impresscart[shipping_method][flatrate][name]" size="60" value="<?php echo !isset($setting['name']) ? 'Flat rate' : $setting['name'];?>" />
						</td>
					</tr>

					<tr>
						<td class='widefat_extend'>
							
							<label style="v-align: middle;">Cost:</label>
							
						</td>
						<td class='widefat_extend'>
						
							<input name="impresscart[shipping_method][flatrate][cost]" value='<?php echo !isset($setting['cost']) ? '5' : $setting['cost'];?>' />
							
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
							<input name="impresscart[shipping_method][flatrate][order]" value="<?php echo !isset($setting['order']) ? '5' : $setting['order'];?>" />
						</td>
					</tr>
					
					<tr>
						<td class='widefat_extend'>
							<label>Enabled</label>
							
						</td>
						<td class='widefat_extend'>
							<select name="impresscart[shipping_method][flatrate][enabled]" >
								<option value="1" <?php if($setting['enabled'] == '1') echo 'selected="selected"'; ?>>Yes</option>
								<option value="0" <?php if($setting['enabled'] == '0') echo 'selected="selected"'; ?>>No</option>
							</select>
						</td>
					</tr>
					
					
					<tr>
						<td colspan="2" class='widefat_extend'>
							<input type="submit" name="save" value="save" />
							<input type="hidden" name="impresscart[shipping_method][flatrate][code]" value="flatrate" />
						</td>
					</tr>
				</tbody>
			</table>
		


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