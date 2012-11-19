<?php

require_once dirname(__FILE__) . '/abstract.attribute.php';

abstract class impresscart_attribute_class_optional_abstract extends impresscart_attribute_class_abstract {

	public function displayAdminMetaInList($attribute){
		?>
			<?php if(!empty($attribute->meta['options'])) : ?>
				<b>Options:</b>
				<?php $attributes = ''?>
				<?php foreach($attribute->meta['options'] as $op) : ?>
					<?php $attributes .= $op['name'] . ', '?>
				<?php endforeach;?>
				<?php echo trim($attributes,' ,')?>
			<?php else:?>
				No options
			<?php endif;?>
		<?php
	}

	public function displayAdminMetaInForm($attribute){
		?>
			<script language="javascript">
				jQuery(function(){
					jQuery('#admin-option-select-wrapper')
						.delegate('.add', 'click', function(){
							var html = '<tr>';
								html += '<td>';
								html += '<input size="50" name="meta[options][][name]" type="text" />';
								html += '</td>';
								html += '<td>';
								html += '<a class="remove">Remove</a>';
								html += '</td>';
								html += '</tr>;'
								jQuery('#admin_option_select').append(html);
						})
						.delegate('.remove', 'click', function(){
							jQuery(this).closest('tr').remove();
						})
				});
			</script>
			<div id="admin-option-select-wrapper">
				<table id="admin_option_select" class="wp-list-table widefat fixed pages" >
					<thead>
						<tr>
							<th>Value <a class="add" href="#randomize">Add New Value</a></th>
							<th width="80">&nbsp;</th>
						</tr>
					</thead>
					<tbody>
					<?php if(!empty($attribute->meta['options'])) : ?>
						<?php foreach($attribute->meta['options'] as $op) : ?>
							<tr>
								<td>
									<input type="text" size="50" name="meta[options][][name]" value="<?php echo $op['name']?>"/>
								</td>
								<td>
									<a class="remove" href="#randomize">Remove</a>
								</td>
							</tr>
						<?php endforeach;?>
					<?php endif;?>
					</tbody>
					<tfoot>
						<tr>
							<th>Value <a class="add right" href="#randomize">Add New Value</a></th>
							<th>&nbsp;</th>
						</tr>
					</tfoot>
				</table>

			</div>
		<?php
	}

	public function displayPostMetaInMetaBox($postmeta, $attribute) {
		?>
			<?php if(!empty($attribute->meta['options'])) : ?>
				<select name="productattributes[<?php echo $attribute->ID?>][value]">
					<option value=""></option>
					<?php foreach($attribute->meta['options'] as $op) : ?>
						<option value="<?php echo $op['name']?>" <?php echo @$postmeta[$attribute->ID]['value'] == $op['name'] ? 'selected="selected"' : ''?>><?php echo $op['name']?></option>
					<?php endforeach;?>
				</select>
			<?php else:?>
				No options to select.
			<?php endif;?>
		<?php
	}

	public function hasPostMetaInMetaBox($postmeta, $attribute){
		return strlen($postmeta[$attribute->ID]['value']) > 0;
	}

	public function displayPostMetaInProductDetail($postmeta, $attribute, $return = false) {
		if($return) {
			return @$postmeta[$attribute->ID]['value'];
		} else {
			echo @$postmeta[$attribute->ID]['value'];
		}
	}

}


