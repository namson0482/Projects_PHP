<table class="list" id="stock_status_data">
<tbody>           
	<?php if ($stock_statuses) { ?>
    <?php foreach ($stock_statuses as $stock_status) { ?>
    <tr>
    	<td class="left"><input type="text" name="<?php echo IMPRESSCART_OPTIONS_NAME;?>[stock_status_data][]" value="<?php echo $stock_status['name']; ?>" /></td>
    	<td><a class="remove_stock_status" href="#"><span>Remove</span></a></td>
	</tr>
    <?php } ?>
    <?php } else { ?>
    <tr>
    	<td class="center" colspan="3"><?php echo $text_no_results; ?></td>
    </tr>
    <?php } ?>            
    </tbody>
    <tbody>
    <tr>
    	<td><a href="#"><span id="add_stock_status">Add more</span></a></td>
    </tr>
    </tbody>
</table>

  <script type="text/javascript">
  
  jQuery('#add_stock_status').live('click', function(){  	  
  	jQuery('#stock_status_data > tbody:first').append("<tr><td class=\"left\"><input type=\"text\" name=\"impresscart_settings[stock_status_data][]\" value=\"\" /></td><td ><a class=\"remove_stock_status\" href=\"#\"><span >Remove</span></a></td></tr>");
  	
  	return false;
  });
  
  jQuery('.remove_stock_status').live('click', function() {  	  	
    	jQuery(this).parent().parent().remove();
    	return false;
  });
  </script>