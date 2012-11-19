<div class="impresscart_header">
<h1 class="theme-title"><?php echo @$row->unit_id ? 'Edit Measurement Units' : 'Add Measurement Units'; ?></h1>
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
							<label for="title">Title</label>
							<input type="text" name="title" value="<?php echo @$row->title;?>" size="100"/>
							<p>(Kilogam, gram, pound,ounce,centimet, milimet, inch)</p>
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<div class="form-field form-required">
							<label for="unit">unit</label>
							<input type="text" name="unit" value="<?php echo @$row->unit;?>" size="2"/>
							<p>unit(sign).</p>
						</div>
					</td>
				</tr>

				<tr>
					<td>
						<div class="form-field form-required">
							<label for="value">value</label>
							<input type="text" name="value" value="<?php echo @$row->value;?>" size="10"/>
							<p>value.</p>
						</div>
					</td>
				</tr>

				<tr>
					<td>
						<div class="form-field form-required">
							<label for="type">type</label>
							<select name="type" >
								<option value="weight" <?php if(@$row->type == 'weight') echo "selected='selected'";?>>weight</option>
								<option value="length" <?php if(@$row->type == 'length') echo "selected='selected'";?>>length</option>
							</select>
							<p>Unit type.</p>
						</div>
					</td>
				</tr>
				<tr>
					<td><input type="submit" name="submit" 	class="button" value="Save Unit" /></td>
				</tr>
			</table>
		</form>
	</div>
</div>
