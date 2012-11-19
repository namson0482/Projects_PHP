<?php

class impresscart_attribute_class_wysiwyg extends impresscart_attribute_class_abstract{

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
			<!--  <input size="60" type="text" name="productattributes[<?php echo $attribute->ID?>][value]" value="<?php echo @$postmeta[$attribute->ID]['value']?>" />  -->
			
			
			<?php 
				$setting = array(
					'media_buttons' => false,
					'textarea_rows' => 10, //can be add an option here
				);
			?>
			<?php wp_editor(@$postmeta[$attribute->ID]['value'],'productattributes[' . $attribute->ID . '][value]', $setting );?>
			
			
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
