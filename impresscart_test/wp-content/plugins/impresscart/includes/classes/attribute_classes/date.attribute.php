<?php

class impresscart_attribute_class_date extends impresscart_attribute_class_abstract{

	public function displayAdminMetaInList($attribute){
		?>
			<i>There is not meta data supported for Text class.</i>
		<?php
	}

	public function displayAdminMetaInForm($attribute){
		?>
			<p>There is not meta data required for Text class.</p>
		<?php
	}

	public function displayPostMetaInMetaBox($postmeta, $attribute) {
		?>
			<input size="20" type="text" class="date_attribute" name="productattributes[<?php echo $attribute->ID?>][value]" value="<?php echo @$postmeta[$attribute->ID]['value']?>" />
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
