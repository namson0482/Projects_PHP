<?php
class impresscart_account_download_controller extends impresscart_framework_controller {
	public function index() {
		
		if (!$this->customer->isLogged()) {
						
			$this->session->data['redirect'] = $this->url->link('account/download', '', 'SSL');
			$this->redirect($this->url->link('account/login', '', ''));
			return;
		}
		
      	$download_total = $this->model_account_download->getTotalDownloads();
		
		if ($download_total) {
			
			$this->data['heading_title'] = __('Account Downloads');

			$this->data['text_order'] = __('Order ID:');
			$this->data['text_date_added'] = __('Date Added');
			$this->data['text_name'] = __('Name');
			$this->data['text_remaining'] = __('Remaining');
			$this->data['text_size'] = __('Size');
			$this->data['text_download'] = __('Download');
			
			$this->data['button_continue'] = __('Continue');

			$this->data['downloads'] = array();
			
			$results = $this->model_account_download->getDownloads();
			
			foreach ($results as $result) {
				
				if (file_exists(IMPRESSCART_DIR_DOWNLOAD . $result['filename'])) {
					$size = filesize(IMPRESSCART_DIR_DOWNLOAD . $result['filename']);

					$i = 0;

					$suffix = array(
						'B',
						'KB',
						'MB',
						'GB',
						'TB',
						'PB',
						'EB',
						'ZB',
						'YB'
					);

					while (($size / 1024) > 1) {
						$size = $size / 1024;
						$i++;
					}
			
					$this->data['downloads'][] = array(
						'order_id'   => $result['order_id'],
						'date_added' => date(__('D-M-Y'), strtotime($result['date_added'])),
						'name'       => $result['name'],
						'remaining'  => $result['remaining'],
						'size'       => round(substr($size, 0, strpos($size, '.') + 4), 2) . $suffix[$i],
						'href'       => $this->url->link('account/download/download/:' . base64_encode('order_id=' . $result['order_id'] . '&download_id=' . $result['download_id']), 'SSL')
					);
				}
			}

			$this->data['continue'] = $this->url->link('account/account', '', 'SSL');			

		} else {
			$this->data['continue'] = $this->url->link('account/account', '', 'SSL');
			echo __('You have not made any previous downloadable orders!');
			$this->autoRender = false;
		}
	}

	public function download() {
			
		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/download', '', 'SSL');

			$this->redirect($this->url->link('account/login', '', 'SSL'));
		}
		
		$route = get_query_var('route');
		
		$params = explode(':', $route);
		
		if(isset($params[1]))
		{
			$test = base64_decode($params[1]);
			$params = array();
			parse_str($test, $params);
		}
		
		
		if (isset($params['download_id'])) {
			$download_id = $params['download_id'];
		} else {
			$download_id = 0;
		}
		
		if(isset($params['order_id']))
		{
			$order_id = $params['order_id'];
			
		} else {
			
			$order_id = 0;
		}
		
		$download_info = $this->model_account_download->getDownload($order_id, $download_id);
		
		if ($download_info) {
			$file = IMPRESSCART_DIR_DOWNLOAD . $download_info['filename'];
			$mask = basename($download_info['mask']);

			if (!headers_sent()) {
				if (file_exists($file)) {
					header('Content-Description: File Transfer');
					header('Content-Type: application/octet-stream');
					header('Content-Disposition: attachment; filename="' . ($mask ? $mask : basename($file)) . '"');
					header('Content-Transfer-Encoding: binary');
					header('Expires: 0');
					header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
					header('Pragma: public');
					header('Content-Length: ' . filesize($file));					
					readfile($file, 'rb');
					
					$this->model_account_download->updateRemaining($order_id, $download_id);					
					exit;
				} else {
					exit('Error: Could not find file ' . $file . '!');
				}
			} else {
				exit('Error: Headers already sent out!');
			}
		} else {
			$this->redirect($this->url->link('account/download', '', 'SSL'));
		}
	}
}
?>