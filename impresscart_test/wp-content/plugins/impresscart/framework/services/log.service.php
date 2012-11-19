<?php
class impresscart_log_service extends impresscart_service
{
	private $filename;
	
	public function __construct() {
		$this->filename = 'log.txt';
	}	
	
	public function write($message = '')
	{
		if(!isset($this->filename)) $this->filename = 'log.txt';
		$file = IMPRESSCART_LOG . '/' . $this->filename;		
		$handle = fopen($file, 'a+'); 
		
		fwrite($handle, date('Y-m-d G:i:s') . ' - ' . $message . "\n");
			
		fclose($handle); 
	} 
}