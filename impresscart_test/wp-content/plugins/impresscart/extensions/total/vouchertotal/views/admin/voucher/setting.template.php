<div class="impresscart_header">
<h1 class="theme-title"><?php echo $heading;?></h1>
</div>

  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  
    <div class="content">
      <form action="" method="post" enctype="multipart/form-data" id="form">
        <table class="form">
          <tr>
            <td><?php echo $entry_status; ?></td>
            <td><select name="status">
                <?php if ($voucher_status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_order; ?></td>
            <td><input type="text" name="order" value="<?php echo $voucher_order; ?>" size="1" /></td>
          </tr>
        </table>
      </form>
    </div>
    
    <div class="buttons"><a onclick="jQuery('#form').submit();" class="button"><?php echo $button_save; ?></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><?php echo $button_cancel; ?></a></div>