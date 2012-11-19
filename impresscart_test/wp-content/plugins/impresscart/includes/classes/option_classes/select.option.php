<?php

require_once dirname(__FILE__) . '/optional_abstract.option.php';

class impresscart_option_class_select extends impresscart_option_class_optional_abstract {

	public function displayAtBuyForm($basePrice, $postmeta, $option) {
		$buyOptions = array();

		?>
		<select name="buyoptions[<?php echo $option->ID?>]" >
			<?php if(@$postmeta[$option->ID]['required']) : ?>
					<option value=""></option>
				<?php endif;?>
			<?php foreach($option->meta['options'] as $op) : ?>
				<?php $code = @$op['code'] ? $op['code'] : $op['name']?>
				<?php
					$buyOptions = array($option->ID => $code);
					$price = $this->calculateBuyOptionPrice($basePrice, $postmeta, $option, $buyOptions);
					$priceOut = impresscart_framework::service('currency')->format($price);
					$priceOut = $price > 0 ? '+' . $priceOut : $priceOut;
				?>
				<?php if(@$postmeta[$option->ID]['options'][$code]['display']) : ?>
					<option value="<?php echo $code?>"><?php echo $op['name']?><?php echo (int)$price != 0 ? '('.$priceOut. ')' : ''?></option>
				<?php endif;?>
			<?php endforeach;?>
		</select>
		<?php
	}
}


