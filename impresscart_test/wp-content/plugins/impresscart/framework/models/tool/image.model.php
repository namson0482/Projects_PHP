<?php

class impresscart_tool_image_model extends impresscart_model {
	public function resize($filename, $width, $height) {
		if (!file_exists(IMPRESSCART_IMAGES . '/' . $filename) || !is_file(IMPRESSCART_IMAGES . '/' . $filename)) {
			return;
		}

		$info = pathinfo($filename);
		$extension = $info['extension'];

		$old_image = $filename;
		$new_image = 'cache/' . substr($filename, 0, strrpos($filename, '.')) . '-' . $width . 'x' . $height . '.' . $extension;

		if (!file_exists(IMPRESSCART_IMAGES . '/' . $new_image) || (filemtime(IMPRESSCART_IMAGES . '/' . $old_image) > filemtime(IMPRESSCART_IMAGES . '/' . $new_image))) {
			$path = '';

			$directories = explode('/', dirname(str_replace('../', '', $new_image)));

			foreach ($directories as $directory) {
				$path = $path . '/' . $directory;

				if (!file_exists(IMPRESSCART_IMAGES . '/' . $path)) {
					@mkdir(IMPRESSCART_IMAGES . '/' . $path, 0777);
				}
			}

			$image = new Image(IMPRESSCART_IMAGES . '/' . $old_image);
			$image->resize($width, $height);
			$image->save(IMPRESSCART_IMAGES . '/' . $new_image);
		}

		if (isset($_SERVER['HTTPS']) && (($_SERVER['HTTPS'] == 'on') || ($_SERVER['HTTPS'] == '1'))) {
			return HTTPS_IMAGE . $new_image;
		} else {
			return HTTP_IMAGE . $new_image;
		}
	}
}
?>