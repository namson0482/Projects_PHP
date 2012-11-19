 	<table class="form">
          <tr>
            <td><span class="required">*</span> <?php echo $entry_code; ?></td>
            <td><input type="text" name="voucher_code" value="<?php echo @$code; ?>" readonly="readonly" />              
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_from_name; ?></td>
            <td><input type="text" name="data[from_name]" value="<?php echo @$from_name; ?>" />
              
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_from_email; ?></td>
            <td><input type="text" name="data[from_email]" value="<?php echo @$from_email; ?>" />             
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_to_name; ?></td>
            <td><input type="text" name="data[to_name]" value="<?php echo @$to_name; ?>" />              
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_to_email; ?></td>
            <td><input type="text" name="data[to_email]" value="<?php echo @$to_email; ?>" />             
          </tr>
               
          <tr>
            <td><span class="required">*</span> <?php echo $entry_message; ?></td>
            <td><textarea name="data[message]" cols="40" rows="5"><?php echo @$message; ?></textarea></td>
          </tr>
          <tr>
            <td><?php echo $entry_amount; ?></td>
            <td><input type="text" name="data[amount]" value="<?php echo @$amount; ?>" />            
          </tr>          
       </table>