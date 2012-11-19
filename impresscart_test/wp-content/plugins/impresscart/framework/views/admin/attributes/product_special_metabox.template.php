

<table id="post_specials" class="wp-list-table widefat fixed pages" cellspacing="0">
	<thead>
		<tr>
			<th width="180">Customer Group</th>
			<th width="70">Priority</th>
			<th>Price</th>
			<th width="90">Start</th>
			<th width="90">End</th>
			<th><a class="add right" href="#randomize">Add Special</a></th>
		</tr>
	</thead>
	<tbody>
		<?php $i = 0;?>
		<?php foreach(@$postmeta as $special) : ?>
		<?php $i++?>
		<tr>
			<td>
			<select name="productspecials[<?php echo $i?>][customer]" >
			<?php foreach($groups as $key => $group):?>
			<?php if( $special['customer'] == $key ):?>
				<option selected="selected" value="<?php echo $key?>"><?php echo $group;?></option>
			<?php else: ?>
				<option value="<?php echo $key?>"><?php echo $group;?></option>
			<?php endif;?>
			<?php endforeach;; ?>
			</select>			
			</td>
			<td>
				<input size="1" type="text"
						name="productspecials[<?php echo $i?>][priority]"
						value="<?php echo $special['priority']?>" />
			</td>
			<td>
				<input size="10" type="text"
						name="productspecials[<?php echo $i?>][price]"
						value="<?php echo $special['price']?>" />
			</td>
			<td>
				<input size="8" type="text" class="datepicker"
						name="productspecials[<?php echo $i?>][start_date]"
						value="<?php echo $special['start_date']?>" />
			</td>
			<td>
				<input size="8" type="text" class="datepicker"
						name="productspecials[<?php echo $i?>][end_date]"
						value="<?php echo $special['end_date']?>" />
			</td>
			<td><a class="remove right" href="#randomize">Remove</a></td>
		</tr>
		<?php endforeach;?>
	</tbody>
	<tfoot>
		<tr>
			<th>Customer Group</th>
			<th>Priority</th>
			<th>Price</th>
			<th>Start</th>
			<th>End</th>
			<th><a class="add right" href="#randomize">Add Special</a></th>
		</tr>
	</tfoot>
</table>

<script language="javascript">
		var zone_index = <?php echo (int)$i?>;
		jQuery(function(){
			jQuery('#post_specials .datepicker').datepicker({dateFormat : 'yy-mm-dd'});
			jQuery('#post_specials')
				.delegate('.add', 'click', function(){
					zone_index++;
					var html = '<tr>';
						html += '<td>';
						html += '<select name="productspecials['+ zone_index + '][customer]" >';
						<?php foreach($groups as $key => $group):?>
							html += '<option value="<?php echo $key?>"><?php echo $group;?></option>';							
						<?php endforeach;; ?>;
						html += '</td>';
						html += '<td>';
						html += '<input size="1" type="text" '
							+ 'name="productspecials[' + zone_index + '][priority]" '
							+ 'value="" />';
						html += '</td>';
						html += '<td>';
						html += '<input size="10" type="text" '
							+ 'name="productspecials[' + zone_index + '][price]" '
							+ 'value="" />';
						html == '</td>';
						html += '<td>';
						html += '<input size="8" type="text"  class="datepicker" '
							+ 'name="productspecials[' + zone_index + '][start_date]" '
							+ 'value="" />';
						html += '</td>';
						html += '<td>';
						html += '<input size="8" type="text" class="datepicker" '
							+ 'name="productspecials[' + zone_index + '][end_date]" '
							+ 'value="" />';
						html += '</td>';
						html += '<td>';
						html += '<a class="remove right" href="#randomize">Remove</a>';
						html += '</td>';
						html += '</tr>;';
						var $toAppend = jQuery(html);
						jQuery('#post_specials').append($toAppend);
						$toAppend.find('.datepicker').datepicker({dateFormat: 'yy-mm-dd'});
				})
				.delegate('.remove', 'click', function(){
					jQuery(this).closest('tr').remove();
				});
		});
	</script>
