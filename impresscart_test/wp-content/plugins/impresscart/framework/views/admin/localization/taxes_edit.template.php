<?php 
include IMPRESSCART_CLASSES . '/impresscart-menu.php';
?>
<?php
	$rate_options = '';
	foreach($rates as $rate) :
	$rate_options .= '<option value="' . $rate->tax_rate_id . '">' . $rate->name . '</option>';
	endforeach
?>

<script type="text/javascript">
	// script data
	var rate_options = <?php echo json_encode($rate_options);?>;
	var base_options = '<option value="shipping">Shipping Address</option>'
						+ '<option value="payment">Payment Address</option>'
						+ '<option value="store" selected="selected">Store Address</option>';
	var rule_index = <?php echo !empty($rules) ? count($rules) : 1?>;
</script>

<div class="wrap">
	
	<?php if(!empty($errors)) : ?>
		<div style="background:yellow;color:red;border-radius:5px;display:block-inline;padding:5px;"><?php echo $errors?></div>
	<?php endif;?>
	
	<div class="form-wrap">
		<form method="post">
		
			<table style="border-spacing: 0; border-collapse: collapse;"
				class="wp-list-table widefat fixed pages">
				<thead>
					<tr>
						<th colspan="2" style="border: 1px;">
							<h2>
								<?php echo @$tax->tax_rate_id ? 'Edit Tax Rate' : 'Add  Tax Rate'; ?>
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
							value="<?php echo $framework->buildURL('/admin/localization/taxes_index')?>">
						</td>
					</tr>
					<tr>
						<td class='widefat_extend'>
							<label for="title">Title</label>
							<p style="color: #C3C3C3;">The name of the tax class.</p>
						</td>
						<td class='widefat_extend'>
							<input type="text" name="title" value="<?php echo @$tax->title?>" size="50"/>
						</td>
					</tr>

					<tr>
						<td class='widefat_extend'>
							<label for="name">Description</label>
							<p style="color: #C3C3C3;">The description of the tax class.</p>
						</td>
						<td class='widefat_extend'>
							<textarea name="description" cols="96" rows="2"><?php echo @$tax->description?></textarea>
							
						</td>
					</tr>

					<tr>
						<td class='widefat_extend'>
						
							<label for="name">Countries and Zones</label>
							
						</td>

						<td class='widefat_extend'>
							
						</td>
					</tr>

					<tr>
						<td colspan="2">
							<table class="wp-list-table widefat fixed pages" cellspacing="0">
								<thead>
									<tr>
										<th>
											Tax Rate
										</th>
										<th>
											Based On
										</th>
										<th>
											Priority
										</th>
										<th width="150">&nbsp;
											
										</th>
									</tr>
								</thead>
								<tbody id="geo_zone_container_list">
									<?php $i = 0;?>
									<?php if(!empty($rules)) : ?>
										<?php foreach($rules as $rule) : ?>
											<?php $i++;?>
											<tr>
												<td>
													<select class="tax_rate" name="rules[<?php echo $i?>][tax_rate_id]" valuez="<?php echo $rule->tax_rate_id?>">
													</select>
												</td>
												<td>
													<select class="based" name="rules[<?php echo $i?>][based]" valuez="<?php echo $rule->based?>">
													</select>
												</td>
												<td>
													<input type="text" name="rules[<?php echo $i?>][priority]" value="<?php echo $rule->priority?>" />
												</td>
												<td><a class="remove" href="#randomize">Remove</a></td>
											</tr>
										<?php endforeach;?>
									<?php endif;?>
								</tbody>
								<tfoot>
									<tr>
										<th>
											Tax Rate
										</th>
										<th >
											Based On
										</th>
										<th>
											Priority
										</th>
										<th >
											<a class="add right" href="#randomize">Add Rule</a>
										</th>
									</tr>
								</tfoot>
							</table>	
							<p style="color: #C3C3C3;">The countries and zones covered by this geo zone.</p>						
						</td>
					</tr>
					
					
					<tr>
						<td colspan="2" class='widefat_extend'>
							<input type="submit" name="submit" 	class="button" value="Save Tax Rate" />
						</td>
					</tr>
				</tbody>
			</table>
			
			<!-- ************************************************************ -->
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

<script type="text/javascript">
		jQuery(function(){

			jQuery('#geo_zone_container')
				.delegate('.add', 'click', function(){
					rule_index++;
					var html = '<tr>';
						html += '<td>';
						html += '<select class="tax_rate" name="rules[' + rule_index + '][tax_rate_id]">';
						html += rate_options;
						html += '</select>';
						html += '</td>';
						html += '<td>';
						html += '<select class="based" name="rules[' + rule_index + '][based]">';
						html += base_options;
						html += '</select>';
						html += '</td>';
						html += '<td>';
						html += '<input type="text" name="rules[' + rule_index + '][priority]">';
						html += '</td>';
						html += '<td>';
						html += '<a class="remove" href="#randomize">Remove</a>';
						html += '</td>';
						html += '</tr>;'
						jQuery('#geo_zone_container_list').append(html);
				})
				.delegate('.remove', 'click', function(){
					jQuery(this).closest('tr').remove();
				});

			jQuery('#geo_zone_container_list').find('select.tax_rate').each(function(){
				var val = jQuery(this).attr('valuez');
				jQuery(this).html(rate_options).val(val);
			});
			jQuery('#geo_zone_container_list').find('select.based').each(function(){
				var val = jQuery(this).attr('valuez');
				jQuery(this).html(base_options).val(val);
			});
		});
	</script>
