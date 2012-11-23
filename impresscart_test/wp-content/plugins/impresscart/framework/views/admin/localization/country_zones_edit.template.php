<?php 
include IMPRESSCART_CLASSES . '/impresscart-menu.php';
?>

<div class="wrap">
	<?php if(!empty($errors)) : ?>
	<div style="background:yellow;color:red;border-radius:5px;display:block-inline;padding:5px;"><?php echo $errors?></div>
	<?php endif;?>
	<div class="form-wrap">
		<form method="post">
			<table style="border-spacing:0;  border-collapse:collapse;" class="wp-list-table widefat fixed pages">
				<thead>
					<tr>
						<th colspan="2" style="border: 1px;">
								<h2>
									Add Country Zone
								</h2>
						</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td colspan="2">
							<input type="button" name="backtolist" id="backtolist" class="button" value="Back to list" />
							<input type="hidden" id="backaddress" name="backaddress" value="<?php echo $framework->buildURL('/admin/localization/country_zones_index')?>">
						</td>
					</tr>
					<tr>
						<td class='widefat_extend'>
						
						<label for="name">Name</label>
						<p style="color : #C3C3C3;">The name of the zone.</p>

						</td>
						<td class='widefat_extend' >
							<input type="text" name="name" value="<?php echo @$zone->name?>" size="50"/>
						</td>
					</tr>

					<tr>
						<td class='widefat_extend'>
							<label for="name">Code</label>
							
							<p style="color : #C3C3C3;">The code of the zone.</p>
						
						
						</td>
						<td class='widefat_extend'>
							<input type="text" name="code" value="<?php echo @$zone->code?>" size="2"/>
						</td>
					</tr>

					<tr>
						<td class='widefat_extend'>
							<label for="name">Country</label>
							
							<p style="color : #C3C3C3;">The zone belongs to country.</p>
							
						</td>

						<td class='widefat_extend'>
							<select name="country_id">
								<?php foreach($countries as $cty) : ?>
									<option value="<?php echo $cty->country_id ?>" <?php echo $cty->country_id == @$zone->country_id ? 'selected="selected"' : ''?>><?php echo @$cty->name?></option>
								<?php endforeach;?>
							</select>
						</td>
					</tr>

					<tr>
						<td class='widefat_extend'>
							<label for="name">Status</label>
							<p style="color : #C3C3C3;">Enabled/Disabled.</p>
						</td>
						<td class='widefat_extend'>
						
							<input type="checkbox" name="status" value="1" <?php echo @$zone->status ?  'checked="checked"' : ''?>/>
							
						</td>
					</tr>

					
					<tr>
						<td colspan="2" class='widefat_extend'>
							<input type="submit" name="submit" 	class="button" value="Save Zone" />	
						</td>
					</tr>
					
					
				</tbody>

			</table>
		
			<!-- ***************************************************************************************** -->
		</form>
	</div>
</div>
