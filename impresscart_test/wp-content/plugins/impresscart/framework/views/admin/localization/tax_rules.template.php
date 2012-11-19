<div class="impresscart_header">
<h1 class="theme-title"><?php echo __('Countries');?></h1>
</div>
<?php $rate_options = '';?>
<?php foreach($rates as $rate) : ?>
<?php $rate_options .= '<option value="' . $rate->tax_rate_id . '">' . $rate->name . '</option>';?>
<?php endforeach;?>

<script language="javascript">
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
			<table border="0" cellspacing="0" cellpadding="5">
				<tr>
					<td>
						<div class="form-field form-required" id="geo_zone_container">
							<label for="name">Add a tax rule to this class</label>

							<table class="wp-list-table widefat fixed pages" cellspacing="0">
								<thead>
									<th>
										Tax Rate
									</th>
									<th>
										Based On
									</th>
									<th>
										Priority
									</th>
									<th width="150">
										&nbsp;
									</th>
								</thead>
								<tbody id="geo_zone_container_list">
									<?php $i = 0;?>
									<?php if(!empty($rules)) : ?>
										<?php foreach($rules as $rule) : ?>
											<?php $i++;?>
											<tr>
												<td>
													<select class="tax_rate" name="rules[<?php echo $i?>][tax_rate_id]" valuez="<?php echo $rule['tax_rate_id'];?>">
													</select>
												</td>
												<td>
													<select class="based" name="rules[<?php echo $i?>][based]" valuez="<?php echo $rule['based'];?>">
													</select>
												</td>
												<td>
													<input type="text" name="rules[<?php echo $i?>][priority]" value="<?php echo $rule['priority'];?>" />
												</td>
												<td><a class="remove" href="#randomize">Remove</a></td>
											</tr>
										<?php endforeach;?>
									<?php endif;?>
								</tbody>
								<tfoot>
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
								</tfoot>
							</table>

							<p>The countries and zones covered by this geo zone.</p>
						</div>
					</td>
				</tr>
				<tr>
					<td><input type="submit" name="submit" 	class="button" value="Save Tax Class" /></td>
				</tr>
			</table>
	</div>
</div>

<script language="javascript">
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
