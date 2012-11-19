  <h1><?php echo $heading_title; ?></h1>
  <form action="#" method="post" enctype="multipart/form-data" id="password">
    <h2><?php echo $text_password; ?></h2>
    <div class="content">
      
      <table class="form">
      	<tr>
      		<td><span class="required">*</span> <?php echo $entry_current_password; ?></td>
      		<td><input type="password" id="current_password" name="current_password" value="<?php echo $current_password; ?>" />
            <?php if ($error_current_password) { ?>
            <span class="error"><?php echo $error_current_password; ?></span>
            <?php } ?></td>
      	</tr>
        <tr>
          <td><span class="required">*</span> <?php echo $entry_password; ?></td>
          <td><input type="password" id="password" name="password" value="<?php echo $password; ?>" />
            <?php if ($error_password) { ?>
            <span class="error"><?php echo $error_password; ?></span>
            <?php } ?></td>
        </tr>
        
        <tr>
          <td><span class="required">*</span> <?php echo $entry_confirm; ?></td>
          <td><input type="password" name="confirm" value="<?php echo $confirm; ?>" />
            <?php if ($error_confirm) { ?>
            <span class="error"><?php echo $error_confirm; ?></span>
            <?php } ?></td>
        </tr>
      </table>
    </div>
    
    <div class="buttons">
      <div class="left"><a href="<?php echo $back; ?>" class="button"><span><?php echo $button_back; ?></span></a></div>
      <div class="right"><a onclick="jQuery('#password').submit();" class="button"><span><?php echo $button_continue; ?></span></a></div>
    </div>
       <input type="hidden" name="pagename" value="shop" />
    <input type="hidden" name="route" value="account/password" />
  </form>