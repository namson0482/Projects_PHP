<?php 
echo Goscom::generateHeader($pages);
?>

<div>
	<form action="" method="post">
		<table style="border-spacing: 0; border-collapse: collapse;"
			class="wp-list-table widefat fixed pages">

			<thead>
				<tr>
					<th colspan="2" style="border: 1px;">
						<h2>Cash on delivery</h2>
					</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td colspan="2"><input type="button" name="backtolist"
						id="backtolist" class="button" value="Back to list" /> <input
						type="hidden" id="backaddress" name="backaddress"
						value="<?php echo(get_bloginfo('url') . '/wp-admin/' . 'admin.php?page=payment');?>">

					</td>
				</tr>
				<tr>
					<td class='widefat_extend'><label>Title</label>
					</td>
					<td class='widefat_extend'><input
						name="impresscart[payment_method][cod][name]" size="60"
						value="<?php echo !isset($setting['name']) ? 'cod' : $setting['name'];?>" />
					</td>
				</tr>

				<tr>
					<td class='widefat_extend'><label style="v-align: middle;">Total:</label>

					</td>
					<td class='widefat_extend'><input
						name="impresscart[payment_method][cod][total]"
						value="<?php echo !isset($setting['total']) ? '0.01' : $setting['total'];?>" />
					</td>
				</tr>

				<tr>
					<td class='widefat_extend'><label>Order status</label>
					</td>

					<td class='widefat_extend'><?php echo @$order_statuses; ?>
					</td>
				</tr>

				<tr>
					<td class='widefat_extend'><label>Geo Zones</label>
					</td>
					<td class='widefat_extend'><?php echo $geo_zones; ?>
					</td>
				</tr>

				<tr>
					<td class='widefat_extend'><label>Sort Order</label>
					</td>
					<td class='widefat_extend'><input
						name="impresscart[payment_method][cod][order]"
						value="<?php echo !isset($setting['order']) ? '5' : $setting['order'];?>" />
					</td>
				</tr>

				<tr>
					<td class='widefat_extend'><label>Enabled</label>
					</td>
					<td class='widefat_extend'><select
						name="impresscart[payment_method][cod][enabled]">
							<option value="yes"
							<?php if($setting['enabled'] == 'yes') echo 'selected="selected"'; ?>>Yes</option>
							<option value="no"
							<?php if($setting['enabled'] == 'no') echo 'selected="selected"'; ?>>No</option>
					</select>
					</td>
				</tr>

				<tr>
					<td colspan="2" class='widefat_extend'><input type="submit"
						name="save" value="save" /> <input type="hidden"
						name="impresscart[payment_method][cod][code]" value="cod" />
					</td>
				</tr>
			</tbody>
		</table>


		<!-- ************************************************* -->


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
