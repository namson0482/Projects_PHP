<div class="impresscart_header">
<h1 class="theme-title"><?php echo __('');?></h1>
</div>
<div class="wrap">
	<h2>
		<?php echo @$tax->tax_rate_id ? 'Edit Tax Rate' : 'Add  Tax Rate'; ?>
		<a class="add-new-h2" href="<?php echo $framework->buildURL('/admin/localization/taxes_rate_index')?>">Back to List</a>
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
							<label for="name">Tax Name</label>
							<input type="text" name="name" value="<?php echo @$tax->name?>" size="50"/>
							<p>The name of the tax.</p>
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<div class="form-field form-required">
							<label for="rate">Tax Rate</label>
							<input type="text" name="rate" value="<?php echo @$tax->rate?>" size="50"/>
							<p>The rate of the tax.</p>
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<div class="form-field form-required">
							<label for="type">Type</label>
							<select name="type">
								<option value="P" <?php echo @$tax->type == 'P' ? 'selected="selected"' : ''?>>Percentage</option>
								<option value="F" <?php echo @$tax->type == 'F' ? 'selected="selected"' : ''?>>Fixed Amount</option>
							</select>
							<p>The type of the tax.</p>
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<div class="form-field form-required">
							<label for="geo_zone_id">Geo Zone</label>
							<select name="geo_zone_id">
								<?php foreach($geos as $geo) : ?>
									<option value="<?php echo $geo->geo_zone_id; ?>" <?php echo $geo->geo_zone_id == @$tax->geo_zone_id ? 'selected="selected"' : ''?> ><?php echo @$geo->name?></option>
								<?php endforeach;?>
							</select>
							<p>The type of the tax.</p>
						</div>
					</td>
				</tr>
				<tr>
					<td><input type="submit" name="submit" 	class="button" value="Save Tax Rate" /></td>
				</tr>
			</table>
		</form>
	</div>
</div>
