<div class="wrap">
	<h2>
		<?php echo @$attribute->ID ? 'Edit Option - ' : 'Add Attribute - '; echo $classes[$attribute->class]?>
		<a class="add-new-h2" href="<?php echo $framework->buildURL('/admin/attributes/index')?>">Back to List</a>
	</h2>
	<div class="form-wrap">
		<form method="post">
			<input type="hidden" name="class" value="<?php echo @$attribute->class ? $attribute->class : $_GET['class']?>" />
			<table border="0" cellspacing="0" cellpadding="5">
				<tr>
					<td>
						<div class="form-field form-required">
							<label for="name">Name</label>
							<input type="text" name="name" value="<?php echo @$attribute->name?>" size="100"/>
							<p>The name of the attribute.</p>
						</div>
					</td>
				</tr>
				<?php if($attribute->class != 'group') : ?>
				<tr>
					<td>
						<div class="form-field form-required">
							<label for="name">Group</label>
							<select name="group_id">
                                                            <option value="0"><?php echo __('Select Group'); ?></option>
								<?php foreach($groups as $grp) :  ?>
									<option value="<?php echo @$grp->term_id;?>" <?php echo @$grp->term_id == @$attribute->group_id ? 'selected="selected"' : ''?>>
										<?php echo @$grp->name; ?>
									</option>
								<?php endforeach;?>
							</select>
							<p>The parent group.</p>
						</div>
					</td>
				</tr>
				<?php endif;?>
				<tr>
					<td>
						<div class="form-field form-required">
							<label>Meta</label>
							<?php impresscart_attribute::factory(@$attribute->class)->displayAdminMetaInForm($attribute)?>
						</div>
					</td>
				</tr>
				<tr>
					<td><input type="submit" name="submit" 	class="button" value="Save Attribute" /></td>
				</tr>
			</table>
		</form>
	</div>
</div>
