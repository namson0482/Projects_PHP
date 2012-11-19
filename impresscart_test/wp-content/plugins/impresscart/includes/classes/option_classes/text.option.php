<?php

class impresscart_option_class_text extends impresscart_option_class_abstract{

	public function displayAdminMetaInList($option){
		?>
			<i>There is not meta data supported for Text class.</i>
		<?php
	}

	public function displayAdminMetaInForm($option){
		?>
			<p>There is not meta data required for Text class.</p>
		<?php
	}

	public function displayPostMetaInMetaBox($postmeta, $option) {
		?>
			<input size="90" type="text" name="productoptions[<?php echo $option->ID?>][value]" value="<?php echo @$postmeta[$option->ID]['value']?>" />
		<?php
	}

	public function displayAtBuyForm($basePrice, $postmeta, $option) {
		?>
		<input type="text" name="buyoptions[<?php echo $option->ID?>]" />
		<?php
	}

	public function calculateBuyOptionPrice($basePrice, $postmeta, $option, $buyOptions){
		return 0; # no price for text
	}

	public function getOptionValue($basePrice, $postmeta, $option) {
		return @$postmeta[$option->ID]['value'];
	}
}
