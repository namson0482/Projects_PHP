<table class="list" id="order_status_data">
<tbody>           
	<?php if ($order_statuses) { ?>
    <?php foreach ($order_statuses as $order_status) { ?>
    <tr>
    	<td class="left"><input type="text" name="<?php echo IMPRESSCART_OPTIONS_NAME;?>[order_status_data][]" value="<?php echo $order_status['name']; ?>" /></td>
    	<td><a class="remove_order_status" href="#"><span>Remove</span></a></td>
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
    	<td><a href="#"><span id="add_order_status">Add</span></a></td>
    </tr>
    </tbody>
</table>

  <script type="text/javascript">
  
  jQuery('#add_order_status').live('click', function(){  	  
  	jQuery('#order_status_data > tbody:first').append("<tr><td class=\"left\"><input type=\"text\" name=\"impresscart_settings[order_status_data][]\" value=\"\" /></td><td ><a class=\"remove_order_status\" href=\"#\"><span >Remove</span></a></td></tr>");
  	
  	return false;
  });
  
  jQuery('.remove_order_status').live('click', function() {  	  	
    	jQuery(this).parent().parent().remove();
    	return false;
  });
  </script>