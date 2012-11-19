<?php

require_once dirname(__FILE__) . '/optional_abstract.option.php';

class impresscart_option_class_radio extends impresscart_option_class_optional_abstract {

	public function displayAtBuyForm($basePrice, $postmeta, $option) {
		$buyOptions = array();
		?>
			<?php foreach($option->meta['options'] as $op) : ?>
				<?php $code = @$op['code'] ? $op['code'] : $op['name']?>
				<?php
					$buyOptions = array($option->ID => $code);
					$price = $this->calculateBuyOptionPrice($basePrice, $postmeta, $option, $buyOptions);
					$priceOut = impresscart_framework::service('currency')->format($price);
					$priceOut = $price > 0 ? '+' . $priceOut : $priceOut;
				?>
				<?php if(@$postmeta[$option->ID]['options'][$code]['display']) : ?>
					<label><input name="buyoptions[<?php echo $option->ID?>][]" type="radio" value="<?php echo $code?>"/>
					<?php echo $op['name']?><?php echo (int)$price != 0 ? '('.$priceOut. ')' : ''?></label>
				<?php endif;?>
			<?php endforeach;?>
		<?php
	}
}


