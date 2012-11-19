<table class="list" id="return_action_data">
<tbody>           
	<?php if ($return_actions) { ?>
    <?php foreach ($return_actions as $return_action) { ?>
    <tr>
    	<td class="left"><input type="text" name="<?php echo IMPRESSCART_OPTIONS_NAME;?>[return_action_data][]" value="<?php echo $return_action['name']; ?>" /></td>
    	<td><a class="remove_return_action" href="#"><span>Remove</span></a></td>
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
    	<td><a href="#"><span id="add_return_action">Add</span></a></td>
    </tr>
    </tbody>
</table>

  <script type="text/javascript">
  
  jQuery('#add_return_action').live('click', function(){  	  
  	jQuery('#return_action_data > tbody:first').append("<tr><td class=\"left\"><input type=\"text\" name=\"impresscart_settings[return_action_data][]\" value=\"\" /></td><td ><a class=\"remove_return_action\" href=\"#\"><span >Remove</span></a></td></tr>");
  	
  	return false;
  });
  
  jQuery('.remove_return_action').live('click', function() {  	  	
    	jQuery(this).parent().parent().remove();
    	return false;
  });
  </script>