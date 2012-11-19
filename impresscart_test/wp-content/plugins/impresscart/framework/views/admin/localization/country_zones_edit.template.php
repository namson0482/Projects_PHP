<div class="impresscart_header">
<h1 class="theme-title"><?php echo @$zone->zone_id ? 'Edit Country Zone' : 'Add Country Zone'; ?></h1>
</div>
<div class="wrap">
	<h2>
		
		<a class="add-new-h2" href="<?php echo $framework->buildURL('/admin/localization/country_zones_index')?>">Back to List</a>
	</h2>
	<?php if(!empty($errors)) : ?>
	<div style="background:yellow;color:red;border-radius:5px;display:block-inline;padding:5px;"><?php echo $errors?></div>
	<?php endif;?>
	<div class="form-wrap">
		<form method="post">
			<table border="0" cellspacing="0" cellpadding="5">
				<tr>
					<td>
						<div class="form-field form-required">
							<label for="name">Name</label>
							<input type="text" name="name" value="<?php echo @$zone->name?>" size="50"/>
							<p>The name of the zone.</p>
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<div class="form-field form-required">
							<label for="name">Code</label>
							<input type="text" name="code" value="<?php echo @$zone->code?>" size="2"/>
							<p>The code of the zone.</p>
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<div class="form-field form-required">
							<label for="name">Country</label>
							<select name="country_id">
								<?php foreach($countries as $cty) : ?>
									<option value="<?php echo $cty->country_id ?>" <?php echo $cty->country_id == @$zone->country_id ? 'selected="selected"' : ''?>><?php echo @$cty->name?></option>
								<?php endforeach;?>
							</select>
							<p>The zone belongs to country.</p>
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<div class="form-field form-required">
							<label for="name">Status</label>
							<input type="checkbox" name="status" value="1" <?php echo @$zone->status ?  'checked="checked"' : ''?>/>
							<p>Enabled.</p>
						</div>
					</td>
				</tr>
				<tr>
					<td><input type="submit" name="submit" 	class="button" value="Save Zone" /></td>
				</tr>
			</table>
		</form>
	</div>
</div>
