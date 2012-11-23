<?php 
include IMPRESSCART_CLASSES . '/impresscart-menu.php';
?>

<div class="wrap">
	
	<?php if(!empty($errors)) : ?>
		<div style="background:yellow;color:red;border-radius:5px;display:block-inline;padding:5px;"><?php echo $errors?></div>
	<?php endif;?>
	<div class="form-wrap">
		<form method="post">
			<table style="border-spacing: 0; border-collapse: collapse;" class="wp-list-table widefat fixed pages">
				<thead>
					<tr>
						<th colspan="2" style="border: 1px;">
							<h2>
								<?php echo @$row->unit_id ? 'Edit Measurement Units' : 'Add Measurement Units'; ?>
							</h2>
						</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td colspan="2">
						<input type="button" name="backtolist"
							id="backtolist" class="button" value="Back to list" /> <input
							type="hidden" id="backaddress" name="backaddress"
							value="<?php echo $framework->buildURL('/admin/localization/countries_index')?>">
						</td>
					</tr>
					<tr>
						<td class='widefat_extend'>
								
							<label for="title">Title</label>
							
							<p style="color: #C3C3C3;">(Kilogam, gram, pound,ounce,centimet, milimet, inch)</p>	
								
						
						</td>
						<td class='widefat_extend'>
							<input type="text" name="title" value="<?php echo @$row->title;?>" size="100"/>
						</td>
					</tr>

					<tr>
						<td class='widefat_extend'>
							
							<label for="unit">unit</label>
							
							<p style="color: #C3C3C3;">Unit(sign).</p>
							
						</td>
						<td class='widefat_extend'>
						
							<input type="text" name="unit" value="<?php echo @$row->unit;?>" size="2"/>
							
						</td>
					</tr>

					<tr>
						<td class='widefat_extend'>
							<label for="value">value</label>
							
							<p style="color: #C3C3C3;">Value.</p>
							
						</td>

						<td class='widefat_extend'>
							<input type="text" name="value" value="<?php echo @$row->value;?>" size="10"/>
						</td>
					</tr>

					<tr>
						<td class='widefat_extend'>
						
							<label for="type">type</label>
							
							<p style="color: #C3C3C3;">Unit type.</p>
						
						
							
						</td>
						<td class='widefat_extend'>
							<select name="type" >
								<option value="weight" <?php if(@$row->type == 'weight') echo "selected='selected'";?>>weight</option>
								<option value="length" <?php if(@$row->type == 'length') echo "selected='selected'";?>>length</option>
							</select>
						</td>
					</tr>

					<tr>
						<td colspan="2" class='widefat_extend'>
							<input type="submit" name="submit" 	class="button" value="Save Unit" />
						</td>
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
