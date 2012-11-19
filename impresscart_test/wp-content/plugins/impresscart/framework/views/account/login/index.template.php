  <h1><?php echo $heading_title; ?></h1>
  <?php if ($success) { ?>
  <div class="success"><?php echo $success; ?></div>
  <?php } ?>
  <div class="modal"><!-- Place at bottom of page --></div>
  
  <div class="login-content">
    <div class="left">
      <h2><?php echo $text_new_customer; ?></h2>
      <div class="content">
        <p><b><?php echo $text_register; ?></b></p>
        <p><?php echo $text_register_account; ?></p>
        <a href="<?php echo $register; ?>" class="button"><span><?php echo $button_continue; ?></span></a></div>
    </div>
    <div class="right">
      <h2><?php echo $text_returning_customer; ?></h2>
      <form action="<?php echo $action; ?>" method="POST" id="login_form" name="login_form">
        <div class="content">
          <div id="warning"><?php echo $error_warning; ?></div>
          <p><?php echo $text_i_am_returning_customer; ?></p>
          <b><?php echo $entry_email; ?></b>
          <input type="text" id="email" name="email" value="" />
          <br />
          <br />
          <b><?php echo $entry_password; ?></b>
          <input type="password" id="password" name="password" value="" />
          <br />
          <a href="<?php echo $forgotten; ?>"><?php echo $text_forgotten; ?></a><br />
          <br />          
          <a  class="button" name="button-login" id="button-login"><span><?php echo $button_login; ?></span></a>
          <?php if ($redirect) { ?>
          <input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
          <?php } ?>
        </div>
      </form>
    </div>
  </div>
<script type="text/javascript"><!--
jQuery('#password').keydown(function(e) {
	if (e.keyCode == 13) {
		submitForm();
	}
});

//onclick="jQuery('#login').submit();"
jQuery('#button-login').live('click', function() {
	submitForm();
});

function submitForm() {

	var values = {
			action: 'framework',
			fwurl: '/account/login',
			email : jQuery('#email').val(),
			password : jQuery('#password').val(),
		};
		
	jQuery.ajax({
		url: impresscart.ajaxurl,
		type: 'post',
		data : values,
		dataType: 'json',
		success: function(json) {
			if (json['redirect']) {
				location = json['redirect'];
				return;
			}
			if(json['warning']) {
				jQuery('#warning').addClass("warning");
				jQuery('#warning').html(json['warning']);
			}
		}
	});
	
}

//--></script>