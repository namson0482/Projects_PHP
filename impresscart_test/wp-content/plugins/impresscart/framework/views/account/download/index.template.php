<h1><?php echo $heading_title; ?></h1>
  <?php if(isset($downloads)) { foreach ($downloads as $download) {  	
  	
  	?>
  <div class="download-list">
    <div class="download-id"><b><?php echo $text_order; ?></b> <?php echo $download['order_id']; ?></div>
    <div class="download-status"><b><?php echo $text_size; ?></b> <?php echo $download['size']; ?></div>
    <div class="download-content">      
      <div class="download-info">
       
        <div><b><?php echo $text_name; ?></b> <?php echo $download['name']; ?><br />
        <b><?php echo $text_date_added; ?></b> <?php echo $download['date_added']; ?></div>
      <div><b><?php echo $text_remaining; ?></b> <?php echo $download['remaining']; ?></div>
       <?php if ($download['remaining'] > 0) { ?>
        <a href="<?php echo $download['href']; ?>" class="button"><span><?php echo $text_download; ?></span></a>
        <?php } ?>
      </div>
    </div>
    <br/><br/>
  </div>
  <?php } 
  }?>
  <div class="pagination"><?php // echo $pagination; ?></div>
  <div class="buttons">
    <div class="right"><a href="<?php echo $continue; ?>" class="button"><span><?php echo $button_continue; ?></span></a></div>
  </div>