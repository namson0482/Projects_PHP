<?php
//$firephp = FirePHP::getInstance(true);
//$firephp->log($postmeta, 'postmeta');
?>

<table id="post_discounts" class="wp-list-table widefat fixed pages" cellspacing="0">
	<thead>
		<tr>
			<th width="180">Customer Group</th>
			<th width="70">Qtty</th>
			<th width="70">Priority</th>
			<th>Price</th>
			<th width="90">Start</th>
			<th width="90">End</th>
			<th><a class="add right" href="#randomize">Add Discount</a></th>
		</tr>
	</thead>
	<tbody>
		<?php $i = 0;?>
		<?php foreach(@$postmeta as $discount) : ?>
		<?php 
		?>
		<?php $i++?>
		<tr>
			<td>
			<select name="productdiscounts[<?php echo $i?>][customer]" >
			<?php foreach($groups as $key => $group):?>
			<?php if( $discount['customer'] == $key ):?>
				<option selected="selected" value="<?php echo $key?>"><?php echo $group;?></option>
			<?php else: ?>
				<option value="<?php echo $key?>"><?php echo $group;?></option>
			<?php endif;?>
			<?php endforeach;; ?>
			</select>			
			</td>
			<td>
				<input size="2" type="text"
						name="productdiscounts[<?php echo $i?>][quantity]"
						value="<?php echo $discount['quantity']?>" />
        <input type="hidden" name="productdiscounts[<?php echo $i?>][used_times]" value="<?php echo $discount['used_times']?>"/>
			</td>
			<td>
				<input size="1" type="text"
						name="productdiscounts[<?php echo $i?>][priority]"
						value="<?php echo $discount['priority']?>" />
			</td>
			<td>
				<input size="3" type="text"
						name="productdiscounts[<?php echo $i?>][price]"
						value="<?php echo $discount['price']?>" />
			</td>
			<td>
				<input size="8" type="text" class="datepicker"
						name="productdiscounts[<?php echo $i?>][start_date]"
						value="<?php echo $discount['start_date']?>" />
			</td>
			<td>
				<input size="8" type="text" class="datepicker"
						name="productdiscounts[<?php echo $i?>][end_date]"
						value="<?php echo $discount['end_date']?>" />
			</td>
			<td><a class="remove right" href="#randomize">Remove</a></td>
		</tr>
		<?php endforeach;?>
	</tbody>
	<tfoot>
		<tr>
			<th>Customer Group</th>
			<th>Qtty</th>
			<th>Priority</th>
			<th>Price</th>
			<th>Start</th>
			<th>End</th>
			<th><a class="add right" href="#randomize">Add Discount</a></th>
		</tr>
	</tfoot>
</table>

<script language="javascript">
		var zone_index = <?php echo (int)$i?>;
		jQuery(function(){
			jQuery('#post_discounts .datepicker').datepicker({dateFormat : 'yy-mm-dd'});
			jQuery('#post_discounts')
				.delegate('.add', 'click', function(){
					zone_index++;
					var html = '<tr>';
						html += '<td>';
						html += '<select name="productdiscounts['+ zone_index + '][customer]" >';
						<?php foreach($groups as $key => $group):?>
							html += '<option value="<?php echo $key?>"><?php echo $group;?></option>';							
						<?php endforeach;; ?>;
						html += '</td>';
						html += '<td>';
						html += '<input size="2" type="text" '
							+ 'name="productdiscounts[' + zone_index + '][quantity]" '
							+ 'value="" />';
            html += '<input type="hidden" name="productdiscounts[' + zone_index + '][used_times]" value="0" />';
						html += '</td>';
						html += '<td>';
						html += '<input size="1" type="text" '
							+ 'name="productdiscounts[' + zone_index + '][priority]" '
							+ 'value="" />';
						html += '</td>';
						html += '<td>';
						html += '<input size="10" type="text" '
							+ 'name="productdiscounts[' + zone_index + '][price]" '
							+ 'value="" />';
						html == '</td>';
						html += '<td>';
						html += '<input size="8" type="text"  class="datepicker" '
							+ 'name="productdiscounts[' + zone_index + '][start_date]" '
							+ 'value="" />';
						html += '</td>';
						html += '<td>';
						html += '<input size="8" type="text" class="datepicker" '
							+ 'name="productdiscounts[' + zone_index + '][end_date]" '
							+ 'value="" />';
						html += '</td>';
						html += '<td>';
						html += '<a class="remove right" href="#randomize">Remove</a>';
						html += '</td>';
						html += '</tr>;';
						var $toAppend = jQuery(html);
						jQuery('#post_discounts').append($toAppend);
						$toAppend.find('.datepicker').datepicker({dateFormat: 'yy-mm-dd'});
				})
				.delegate('.remove', 'click', function(){
					jQuery(this).closest('tr').remove();
				});
		});
	</script>
