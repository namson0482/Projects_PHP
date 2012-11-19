<?php

require_once dirname(__FILE__) . '/abstract.attribute.php';
require_once dirname(__FILE__) . '/text.attribute.php';

class impresscart_attribute_class_text_general extends impresscart_attribute_class_text {

	public function displayPostMetaInMetaBox($postmeta, $attribute) {
		?>
			<input size="20" type="text" name="productgeneralattributes[<?php echo $attribute->ID?>][value]" value="<?php echo @$postmeta[$attribute->ID]['value']?>" />
		<?php
	}
}
