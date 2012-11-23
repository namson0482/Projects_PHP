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
			<table style="border-spacing:0;  border-collapse:collapse;" class="wp-list-table widefat fixed pages">
				<thead>
					<tr>
						<th colspan="2" class="top-title" style="background:#fdfdfd; border: 1px;">
								<h2>
									Add Currency
								</h2>
						</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td colspan="2" class="bt-back" style="background:#f2f2f2;">
							<input type="button" name="backtolist" id="backtolist" class="button" value="Back to list" />
							<input type="hidden" id="backaddress" name="backaddress" value="<?php echo $framework->buildURL('/admin/localization/currencies_index');?>">
						</td>
					</tr>
					<tr>
						<td class='widefat_extend'><label for="name">Title</label>
							<p style="color : #C3C3C3;">(Euro,Pound Sterling,US Dollar,Vietnam Dong)</p>
						</td>
						<td class='widefat_extend' ><input type="text" name="title"
							value="<?php echo @$row->title;?>" size="20" />
						</td>
					</tr>

					<tr>
						<td class='widefat_extend'><label for="name">Code</label>
							<p style="color : #C3C3C3;">Currency code.</p>
						</td>
						<td class='widefat_extend'><input type="text" name="code"
							value="<?php echo @$row->code;?>" size="3" />
						</td>
					</tr>

					<tr>
						<td class='widefat_extend'><label for="name">Value</label>
							<p style="color : #C3C3C3;">value.</p>
						</td>

						<td class='widefat_extend'><input type="text" name="value"
							value="<?php echo @$row->value;?>" size="10" />
						</td>
					</tr>

					<tr>
						<td class='widefat_extend'><label for="name">Symbol left</label>
						</td>
						<td class='widefat_extend'><input type="text" name="symbol_left"
							value="<?php echo @$row->symbol_left;?>" size="10" />
						</td>
					</tr>

					<tr>
						<td class='widefat_extend'><label for="name">Symbol right</label>
						</td>
						<td class='widefat_extend'><input type="text" name="symbol_right"
							value="<?php echo @$row->symbol_right;?>" size="10" />
						</td>
					</tr>


					<tr>
						<td class='widefat_extend'><label for="name">Decimal place</label>
						</td>
						<td class='widefat_extend'><input type="text" name="decimal_place"
							value="<?php echo @$row->decimal_place;?>" size="5" />
						</td>
					</tr>
					<tr>
						<td class='widefat_extend'><label for="status">Enabled</label>
						</td>
						<td class='widefat_extend'><select name="status">
								<option value="1"
								<?php if(@$row->status == '1') echo 'selected="selected"';?>>Yes</option>
								<option value="0"
								<?php if(@$row->status == '0') echo 'selected="selected"';?>>No</option>
						</select>
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