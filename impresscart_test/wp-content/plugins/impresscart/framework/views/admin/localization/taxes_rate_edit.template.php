<?php 
include IMPRESSCART_CLASSES . '/impresscart-menu.php';
?>
<div class="wrap">
	<?php if(!empty($errors)) : ?>
	<div style="background:yellow;color:red;border-radius:5px;display:block-inline;padding:5px;"><?php echo $errors?></div>
	<?php endif;?>
	<div class="form-wrap">
		<form method="post">
		
				<table style="border-spacing: 0; border-collapse: collapse;" class="wp-list-table widefat fixed pages">
				<thead>
					<tr>
						<th colspan="2" style="border: 1px;">
							<h2>
								<?php echo @$tax->tax_rate_id ? 'Edit Tax Rate' : 'Add  Tax Rate'; ?>
							</h2>
						</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td colspan="2">
						<input type="button" name="backtolist"
							id="backtolist" class="button" value="Back to list" /> <input
							type="hidden" id="backaddress" name="backaddress"
							value="<?php echo $framework->buildURL('/admin/localization/taxes_rate_index')?>">
						</td>
					</tr>
					<tr>
						<td class='widefat_extend'>
						
							<label for="name">Tax Name</label>
							<p style="color: #C3C3C3;">The name of the tax.</p>
						
						</td>
						<td class='widefat_extend'>
							<input type="text" name="name" value="<?php echo @$tax->name?>" size="50"/>
						</td>
					</tr>

					<tr>
						<td class='widefat_extend'>
							
							<label for="rate">Tax Rate</label>
							<p style="color: #C3C3C3;">The rate of the tax.</p>
							
						</td>
						<td class='widefat_extend'>
						
							<input type="text" name="rate" value="<?php echo @$tax->rate?>" size="50"/>
							
						</td>
					</tr>

					<tr>
						<td class='widefat_extend'>
						
							<label for="type">Type</label>
							
							<p style="color: #C3C3C3;">The type of the tax.</p>
							
						</td>

						<td class='widefat_extend'>
							<select name="type">
								<option value="P" <?php echo @$tax->type == 'P' ? 'selected="selected"' : ''?>>Percentage</option>
								<option value="F" <?php echo @$tax->type == 'F' ? 'selected="selected"' : ''?>>Fixed Amount</option>
							</select>
						</td>
					</tr>

					<tr>
						<td class='widefat_extend'>
						
							<label for="geo_zone_id">Geo Zone</label>
							
							<p style="color: #C3C3C3;">The type of the tax.</p>
						
						
							
						</td>
						<td class='widefat_extend'>
						
							<select name="geo_zone_id">
								<?php foreach($geos as $geo) : ?>
									<option value="<?php echo $geo->geo_zone_id; ?>" <?php echo $geo->geo_zone_id == @$tax->geo_zone_id ? 'selected="selected"' : ''?> ><?php echo @$geo->name?></option>
								<?php endforeach;?>
							</select>
						</td>
					</tr>

					<tr>
						<td colspan="2" class='widefat_extend'>
							<input type="submit" name="submit" 	class="button" value="Save Tax Rate" />
						</td>
					</tr>
				</tbody>
			</table>
		</form>
	</div>
</div>
<script type="text/javascript"><!--

jQuery('#backtolist').bind('click', function() {
	  //alert('User clicked on "foo."');
	  //window.history.back(-1);
	  window.location.href = jQuery('#backaddress').val();
	  return false;
});

//--></script>
