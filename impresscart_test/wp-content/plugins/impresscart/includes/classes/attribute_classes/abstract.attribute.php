<?php

abstract class impresscart_attribute_class_abstract {

	/**
	 * This function is used to display the meta data in the admin list
	 *
	 * @param array $meta
	 */
	public function displayAdminMetaInList($attribute){
		@print_r($attribute->meta);
		$method = __METHOD__;
		$class = get_class($this);
		echo "Override this {$class}:{$method} function to display meta in admin list";
	}

	public function displayAdminMetaInForm($attribute){
		@print_r($attribute->meta);
		$method = __METHOD__;
		$class = get_class($this);
		echo "Override this {$class}:{$method} function to display meta in admin form";
	}

	public function displayPostMetaInMetaBox($postmeta, $attribute){
		@print_r($attribute->meta);
		$method = __METHOD__;
		$class = get_class($this);
		echo "Override this {$class}:{$method} function to display meta in post form";
	}

	public function hasPostMetaInMetaBox($postmeta, $attribute) {
		@print_r($attribute->meta);
		$method = __METHOD__;
		$class = get_class($this);
		echo "Override this {$class}:{$method} function to display meta in product detail";
	}

	public function displayPostMetaInProductDetail($postmeta, $attribute, $return = false) {
		@print_r($attribute->meta);
		$method = __METHOD__;
		$class = get_class($this);
		echo "Override this {$class}:{$method} function to display meta in product detail";
	}
}