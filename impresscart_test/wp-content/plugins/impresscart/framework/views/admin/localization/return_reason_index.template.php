<table class="list" id="return_reason_data">
<tbody>           
	<?php if ($return_reasons) { ?>
    <?php foreach ($return_reasons as $return_reason) { ?>
    <tr>
    	<td class="left"><input type="text" name="<?php echo IMPRESSCART_OPTIONS_NAME ?>[return_reason_data][]" value="<?php echo $return_reason['name']; ?>" /></td>
    	<td><a class="remove_return_reason" href="#"><span>Remove</span></a></td>
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
    	<td><a href="#"><span id="add_return_reason">Add</span></a></td>
    </tr>
    </tbody>
</table>

  <script type="text/javascript">
  
  jQuery('#add_return_reason').live('click', function(){  	  
  	jQuery('#return_reason_data > tbody:first').append("<tr><td class=\"left\"><input type=\"text\" name=\"impresscart_settings[return_reason_data][]\" value=\"\" /></td><td ><a class=\"remove_return_reason\" href=\"#\"><span >Remove</span></a></td></tr>");
  	
  	return false;
  });
  
  jQuery('.remove_return_reason').live('click', function() {  	  	
    	jQuery(this).parent().parent().remove();
    	return false;
  });
  </script>