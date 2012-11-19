<?php

abstract class impresscart_option_class_abstract {

	/**
	 * This function is used to display the meta data in the admin list
	 *
	 * @param array $meta
	 */
	public function displayAdminMetaInList($option){
		@print_r($option->meta);
		$method = __METHOD__;
		$class = get_class($this);
		echo "Override this {$class}:{$method} function to display meta in admin list";
	}

	public function displayAdminMetaInForm($option){
		@print_r($option->meta);
		$method = __METHOD__;
		$class = get_class($this);
		echo "Override this {$class}:{$method} function to display meta in admin form";
	}

	public function displayPostMetaInMetaBox($postmeta, $option){
		@print_r($option->meta);
		$method = __METHOD__;
		$class = get_class($this);
		echo "Override this {$class}:{$method} function to display meta in post form";
	}

	public function displayAtBuyForm($basePrice, $postmeta, $option) {
		@print_r($option->meta);
		$method = __METHOD__;
		$class = get_class($this);
		echo "Override this {$class}:{$method} function to display meta in post form";
	}

	public function calculateBuyOptionPrice($basePrice, $postmeta, $option, $buyOptions) {
		@print_r($option->meta);
		$method = __METHOD__;
		$class = get_class($this);
		echo "Override this {$class}:{$method} function to display meta in post form";
	}

	public function isUsed($postmeta, $option){
		return (bool)@$postmeta[$option->ID]['used'];
	}

	public function isRequired($postmeta, $option){
		return (bool)@$postmeta[$option->ID]['required'];
	}

	public function getOptionValue($basePrice, $postmeta, $option) {
		@print_r($option->meta);
		$method = __METHOD__;
		$class = get_class($this);
		echo "Override this {$class}:{$method} function to display meta in post form";
	}
}