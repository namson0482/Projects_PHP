<?php

class impresscart_paginate_service extends impresscart_service {

	public $params = array();

	public function query($table, $options = array(), $limit = 1, $page = null) {
		# count
		$countOptions = $options;
		$countOptions['fields'] = array('count(*) as total');
		unset($countOptions['limit']);
		$row = $table->fetchOne($countOptions);

		$this->params['total_rows'] = $row->total;

		$page = null === $page ? (int)@$_GET['p'] : $page;
		$limit = null === $limit ? 1 : (int)$limit;
		
		$options['limit'] 	= $limit;
		$options['offset'] 	= $page > 0 ? ($page - 1) * $limit : 0;
		
		$this->params['limit'] 	= $limit;
		$this->params['page'] 	= $page > 0 ? $page : 1;

		return $table->fetchAll($options);
	}

	public function render($router, $baseParams = array()) {
		if(empty($baseParams)) {
			$baseParams = $_GET;
			unset($baseParams['p']);
		}

		$this->params['total_pages'] = floor(1.0 * $this->params['total_rows'] / $this->params['limit']);
		if($this->params['total_pages'] < 1.0 * $this->params['total_rows'] / $this->params['limit']){
			$this->params['total_pages'] += 1;
		}

		$current 	= $this->params['page'];
		$showFrom 	= $current-5;
		$showTo		= $current+5;

		echo '<div class="tablenav-pages">';
		for($i = $showFrom; $i<=$showTo; $i++) {
			if($i > 0 && $i <= $this->params['total_pages']) {
				$baseParams['p'] = $i;
				$urlP = impresscart_framework::getInstance()->buildURL($router, $baseParams);
				?>
					<a class="<?php echo $i == $current ? 'current-page' : ''?>" href="<?php echo $urlP?>"><span class="first-page"><?php echo $i?></span></a>
				<?php
			}
		}
		echo '</div>';
	}
	
	
	function pagination($pages = '', $range = 4)
	{ 
	     $showitems = ($range * 2)+1; 
	 
	     global $paged;
	     if(empty($paged)) $paged = 1;
	 
	     if($pages == '')
	     {
	         global $wp_query;
	         $pages = $wp_query->max_num_pages;
	         if(!$pages)
	         {
	             $pages = 1;
	         }
	     }  
	 
	     if(1 != $pages)
	     {
	         echo "<div class=\"pagination\"><span>Page ".$paged." of ".$pages."</span>";
	         if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='".get_pagenum_link(1)."'>&laquo; First</a>";
	         if($paged > 1 && $showitems < $pages) echo "<a href='".get_pagenum_link($paged - 1)."'>&lsaquo; Previous</a>";
	 
	         for ($i=1; $i <= $pages; $i++)
	         {
	             if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
	             {
	                 echo ($paged == $i)? "<span class=\"current\">".$i."</span>":"<a href='".get_pagenum_link($i)."' class=\"inactive\">".$i."</a>";
	             }
	         }
	 
	         if ($paged < $pages && $showitems < $pages) echo "<a href=\"".get_pagenum_link($paged + 1)."\">Next &rsaquo;</a>"; 
	         if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($pages)."'>Last &raquo;</a>";
	         echo "</div>\n";
	     }
	}
}