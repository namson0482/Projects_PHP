<?php

class impresscart_attribute_class_group extends impresscart_attribute_class_abstract{

	public function displayAdminMetaInList($attribute){
		?>
			<i>There is not meta data supported for Group class.</i>
		<?php
	}

	public function displayAdminMetaInForm($attribute){
		?>
			<p>There is not meta data required for Group class.</p>
		<?php
	}

	public function displayPostMetaInMetaBox($postmeta, $attribute) {
		// empty for Group
	}

}
