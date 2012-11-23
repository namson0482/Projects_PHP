<?php 
include IMPRESSCART_CLASSES . '/impresscart-menu.php';
?>
<div class="wrap">
	<?php if(!empty($errors)) : ?>
	<div
		style="background: yellow; color: red; border-radius: 5px; display: block-inline; padding: 5px;">
		<?php echo $errors?>
	</div>
	<?php endif;?>
	<div class="form-wrap">
		<form method="post">

			<table style="border-spacing: 0; border-collapse: collapse;"
				class="wp-list-table widefat fixed pages">

				<thead>
					<tr>
						<th colspan="2" style="border: 1px;">
							<h2>Add Country</h2>
						</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td colspan="2"><input type="button" name="backtolist"
							id="backtolist" class="button" value="Back to list" /> <input
							type="hidden" id="backaddress" name="backaddress"
							value="<?php echo $framework->buildURL('/admin/localization/countries_index')?>">
						</td>
					</tr>
					<tr>
						<td class='widefat_extend'><label for="name">Name</label>
							<p style="color: #C3C3C3;">The name of the country.</p>
						</td>
						<td class='widefat_extend'><input type="text" name="name"
							value="<?php echo @$country->name?>" size="50" />
						</td>
					</tr>

					<tr>
						<td class='widefat_extend'><label for="iso_code_2">ISO2 Code</label>
							<p style="color: #C3C3C3;">The 2 characters code.</p>
						</td>
						<td class='widefat_extend'><input type="text" name="iso_code_2"
							value="<?php echo @$country->iso_code_2?>" size="2" />
						</td>
					</tr>

					<tr>
						<td class='widefat_extend'><label for="iso_code_3">ISO3 Code</label>

							<p style="color: #C3C3C3;">The 3 characters code.</p>
						</td>

						<td class='widefat_extend'><input type="text" name="iso_code_3"
							value="<?php echo @$country->iso_code_3?>" size="3" />
						</td>
					</tr>

					<tr>
						<td class='widefat_extend'><label for="address_format">Address
								Format</label>
							<p style="color: #C3C3C3;">The address format.</p>
						</td>
						<td class='widefat_extend'><textarea name="address_format">
								<?php echo @$country->address_format?>
							</textarea>
						</td>
					</tr>

					<tr>
						<td class='widefat_extend'><label for="name">Postcode Required</label>
							<p style="color: #C3C3C3;">Postcode Required.</p>
						</td>
						<td class='widefat_extend'><input type="checkbox"
							name="postcode_required" value="1"
							<?php echo @$country->postcode_required ?  'checked="checked"' : ''?> />
						</td>
					</tr>

					<tr>
						<td class='widefat_extend'><label for="name">Status</label>
							<p style="color: #C3C3C3;">Enabled.</p>
						</td>
						<td class='widefat_extend'><input type="checkbox" name="status"
							value="1"
							<?php echo @$country->status ? 'checked="checked"' : ''?> />
						</td>
					</tr>

					<tr>
						<td colspan="2" class='widefat_extend'><input type="submit"
							name="submit" class="button" value="Save" /></td>
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
