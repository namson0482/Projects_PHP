<table class="list" id="return_status_data">
<tbody>           
	<?php if ($return_statuses) { ?>
    <?php foreach ($return_statuses as $return_status) { ?>
    <tr>
    	<td class="left"><input type="text" name="<?php echo IMPRESSCART_OPTIONS_NAME;?>[return_status_data][]" value="<?php echo $return_status['name']; ?>" /></td>
    	<td><a class="remove_return_status" href="#"><span>Remove</span></a></td>
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
    	<td><a href="#"><span id="add_return_status">Add</span></a></td>
    </tr>
    </tbody>
</table>

  <script type="text/javascript">
  
  jQuery('#add_return_status').live('click', function(){  	  
  	jQuery('#return_status_data > tbody:first').append("<tr><td class=\"left\"><input type=\"text\" name=\"impresscart_settings[return_status_data][]\" value=\"\" /></td><td ><a class=\"remove_return_status\" href=\"#\"><span >Remove</span></a></td></tr>");
  	
  	return false;
  });
  
  jQuery('.remove_return_status').live('click', function() {  	  	
    	jQuery(this).parent().parent().remove();
    	return false;
  });
  </script>