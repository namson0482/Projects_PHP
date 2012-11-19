<div class="impresscart_header">
<h1 class="theme-title">
<?php echo @$country->country_id ? 'Edit Country' : 'Add Country'; ?>
		</h1>
</div>

<div class="wrap">
	<h2>
		<a class="add-new-h2" href="<?php echo $framework->buildURL('/admin/localization/countries_index')?>">Back to List</a>
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
							<input type="text" name="name" value="<?php echo @$country->name?>" size="50"/>
							<p>The name of the country.</p>
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<div class="form-field form-required">
							<label for="iso_code_2">ISO2 Code</label>
							<input type="text" name="iso_code_2" value="<?php echo @$country->iso_code_2?>" size="2"/>
							<p>The 2 characters code.</p>
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<div class="form-field form-required">
							<label for="iso_code_3">ISO3 Code</label>
							<input type="text" name="iso_code_3" value="<?php echo @$country->iso_code_3?>" size="3"/>
							<p>The 3 characters code.</p>
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<div class="form-field form-required">
							<label for="address_format">Address Format</label>
							<textarea type="text" name="address_format" ><?php echo @$country->address_format?></textarea>
							<p>The address format.</p>
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<div class="form-field form-required">
							<label for="name">Postcode Required</label>
							<input type="checkbox" name="postcode_required" value="1" <?php echo @$country->postcode_required ?  'checked="checked"' : ''?>/>
							<p>Postcode Required.</p>
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<div class="form-field form-required">
							<label for="name">Status</label>
							<input type="checkbox" name="status" value="1"  <?php echo @$country->status ? 'checked="checked"' : ''?>/>
							<p>Enabled.</p>
						</div>
					</td>
				</tr>
				<tr>
					<td><input type="submit" name="submit" 	class="button" value="Save Country" /></td>
				</tr>
			</table>
		</form>
	</div>
</div>
