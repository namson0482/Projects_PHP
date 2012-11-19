<?php

require_once dirname(__FILE__) . '/abstract.attribute.php';
require_once dirname(__FILE__) . '/select.attribute.php';

class impresscart_attribute_class_select_general extends impresscart_attribute_class_select {

	public function displayPostMetaInMetaBox($postmeta, $attribute) {
		?>
			<?php if(!empty($attribute->meta['options'])) : ?>
				<div class="styled-select"><select class="add_selectmenu" name="productgeneralattributes[<?php echo $attribute->ID?>][value]">
					<option value=""></option>
					<?php foreach($attribute->meta['options'] as $op) : ?>
					<?php $key = isset($op['ID']) ? 'ID' : 'name'?>
						<option value="<?php echo $op[$key]?>" <?php echo @$postmeta[$attribute->ID]['value'] == $op[$key] ? 'selected="selected"' : ''?>><?php echo isset($op['name']) ? $op['name'] : $op['title'];?></option>
					<?php endforeach;?>
				</select></div>
			<?php else:?>
				No options to select.
			<?php endif;?>
		<?php
	}

}


