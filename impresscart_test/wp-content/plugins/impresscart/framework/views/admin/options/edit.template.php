<div class="wrap">
	<h2>
		<?php echo @$option->ID ? 'Edit Option - ' : 'Add Option - '; echo $classes[$option->class]?>
		<a class="add-new-h2" href="<?php echo $framework->buildURL('/admin/options/index')?>">Back to List</a>
	</h2>
	<div class="form-wrap">
		<form method="post">
			<input type="hidden" name="class" value="<?php echo @$option->class ? $option->class : $_GET['class']?>" />
			<table border="0" cellspacing="0" cellpadding="5">
				<tr>
					<td>
						<div class="form-field form-required">
							<label for="name">Name</label>
							<input type="text" name="name" value="<?php echo @$option->name?>" size="100"/>
							<p>The name of the option.</p>
						</div>
					</td>
				</tr>
                                
                                <tr>
					<td>
						<div class="form-field form-required">
							<label for="name">Group</label>
							<select name="group">
								<?php foreach($groups as $grp) : ?>
									<option value="<?php echo @$grp->term_id; ?>" <?php echo @$grp->term_id == @$option->group_id ? 'selected="selected"' : ''?>>
										<?php echo @$grp->name; ?>
									</option>
								<?php endforeach;?>
							</select>
							<p>The parent group.</p>
						</div>
					</td>
				</tr>
                                
				<tr>
					<td>
						<div class="form-field form-required">
							<label>Meta</label>
							<?php impresscart_option::factory(@$option->class)->displayAdminMetaInForm($option)?>
						</div>
					</td>
				</tr>
				<tr>
					<td><input type="submit" name="submit" 	class="button" value="Save Option" /></td>
				</tr>
			</table>
		</form>
	</div>
</div>