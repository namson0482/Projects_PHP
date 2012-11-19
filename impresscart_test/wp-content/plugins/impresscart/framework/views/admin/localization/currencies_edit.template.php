<div class="impresscart_header">
<h1 class="theme-title"><?php echo @$row->currency_id ? 'Edit Currency' : 'Add Currency'; ?></h1>
</div>
<div class="wrap">
	<h2>
		<a class="add-new-h2" href="<?php echo $framework->buildURL('/admin/localization/currencies_index')?>">Back to List</a>
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
							<label for="name">Title</label>
							<input type="text" name="title" value="<?php echo @$row->title;?>" size="20"/>
							<p>(Euro,Pound Sterling,US Dollar,Vietnam Dong)</p>
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<div class="form-field form-required">
							<label for="name">Code</label>
							<input type="text" name="code" value="<?php echo @$row->code;?>" size="3"/>
							<p>Currency code.</p>
						</div>
					</td>
				</tr>

				<tr>
					<td>
						<div class="form-field form-required">
							<label for="name">value</label>
							<input type="text" name="value" value="<?php echo @$row->value;?>" size="10"/>
							<p>value.</p>
						</div>
					</td>
				</tr>

				<tr>
					<td>
						<div class="form-field form-required">
							<label for="name">Symbol left</label>
							<input type="text" name="symbol_left" value="<?php echo @$row->symbol_left;?>" size="10"/>

						</div>
					</td>
				</tr>

				<tr>
					<td>
						<div class="form-field form-required">
							<label for="name">Symbol right</label>
							<input type="text" name="symbol_right" value="<?php echo @$row->symbol_right;?>" size="10"/>

						</div>
					</td>
				</tr>

				<tr>
					<td>
						<div class="form-field form-required">
							<label for="name">Decimal place</label>
							<input type="text" name="decimal_place" value="<?php echo @$row->decimal_place;?>" size="5"/>

						</div>
					</td>
				</tr>

				<tr>
					<td>
						<div class="form-field form-required">
							<label for="status">Enabled</label>
							<select name="status">
								<option value="1" <?php if(@$row->status == '1') echo 'selected="selected"';?>>Yes</option>
								<option value="0" <?php if(@$row->status == '0') echo 'selected="selected"';?>>No</option>
							</select>
						</div>
					</td>
				</tr>

				<tr>
					<td><input type="submit" name="submit" 	class="button" value="Save" /></td>
				</tr>
			</table>
		</form>
	</div>
</div>
