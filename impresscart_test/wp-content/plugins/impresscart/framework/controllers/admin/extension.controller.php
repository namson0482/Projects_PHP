<?php

class impresscart_admin_extension_controller extends impresscart_framework_controller {	
	public function index()
	{       
		if(!empty($_FILES))
                {   
                    //var_dump($_FILES);die();
                    move_uploaded_file($_FILES["pluginzip"]["tmp_name"], impresscart_EXTENSION . "/upload/" . $_FILES["pluginzip"]["name"]);
                    $working_dir = impresscart_EXTENSION . '/' . $_POST['type'].  '/';
                    //var_dump(impresscart_EXTENSION . "/upload/" . $_FILES["pluginzip"]["name"]);die();
                    $package = impresscart_EXTENSION . "/upload/" . $_FILES["pluginzip"]["name"];
                    //$result = unzip_file($package, $working_dir );                    


                    $za = new ZipArchive();

                    $res = $za->open($package); 
                    if($res == TRUE)
                    {
                        $za->extractTo($working_dir);
                        $message = "success";
                    } else {
                        $message = "failed";
                    }
                    unlink(impresscart_EXTENSION . "/upload/" . $_FILES["pluginzip"]["name"]);                        
                } 
                
                $this->data['message'] = $message;
	}
}