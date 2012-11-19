  <h1><?php echo $heading_title; ?></h1>
  <?php if ($success) { ?>
  <div class="success"><?php echo $success; ?></div>
  <?php } ?>
  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  <div class="login-content">
    <div class="left">
      <h2><?php echo $text_new_affiliate; ?></h2>
      <div class="content">
        <p><b><?php echo $text_register; ?></b></p>
        <p><?php echo $text_register_account; ?></p>
        <a href="<?php echo $register; ?>" class="button"><span><?php echo $button_continue; ?></span></a></div>
    </div>
    <div class="right">
      <h2><?php echo $text_returning_affiliate; ?></h2>
      <form action="#<?php //echo $action; ?>" method="post" id="login">
        <div class="content">
          <p><?php echo $text_i_am_returning_affiliate; ?></p>
          <b><?php echo $entry_email; ?></b>
          <input type="text" id="email" name="email" value="" />
          <br />
          <br />
          <b><?php echo $entry_password; ?></b>
          <input type="password" id="password" name="password" value="" />
          <br />
          <a href="<?php echo $forgotten; ?>"><?php echo $text_forgotten; ?></a><br />
          <br />          
          <a onclick="jQuery('#login').submit();" class="button"><span><?php echo $button_login; ?></span></a>
          <?php if ($redirect) { ?>
          <input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
          <?php } ?>
        </div>
      </form>
    </div>
  </div>
<script type="text/javascript"><!--
jQuery('#login input').keydown(function(e) {
	if (e.keyCode == 13) {
		$('#login').submit();
	}
});
//--></script>