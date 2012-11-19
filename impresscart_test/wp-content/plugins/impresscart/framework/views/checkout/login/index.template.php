<div class="left">
  <h2><?php echo $text_new_customer; ?></h2>
  <p style="margin-bottom: 20px"><?php echo $text_checkout; ?></p>
  <table id="newcustomer" cellpadding="0" cellspacing="0">
    <tr>
    <?php if ($account == 'register') { ?>
        <td>
           <label for="register">
  
    
    <input type="radio" name="account" value="register" id="register" checked="checked" />
    <?php } else { ?>
    <input type="radio" name="account" value="register" id="register" />
    <?php }  ?>
  <b><?php echo $text_register; ?></b></label>  
        </td>
    </tr>
    <tr>
    <?php if ($guest_checkout) { ?>
        <td>
        
  <label for="guest">
    <?php if ($account == 'guest') { ?>
    <input type="radio" name="account" value="guest" id="guest" checked="checked" />
    <?php } else { ?>
    <input type="radio" name="account" value="guest" id="guest" />
    <?php } ?>
            <b><?php echo $text_guest; ?></b></label>
        </td>
        <?php } ?>
     
    </tr>
    <tr>
        <td></td>
    </tr>
<tr><td>  <a id="button-account" class="button"><span><?php echo $button_continue; ?></span></a></td></tr>
  </table>

  

</div>
<div id="login" class="right">
  <h2><?php echo $text_returning_customer; ?></h2>
  <p><?php echo $text_i_am_returning_customer; ?></p>
  <table cellpadding="0" cellspacing="0" id="login">
    <tr>
        <td><b><?php echo $entry_email; ?></b></td>
        <td><input type="text" id="email" name="email" value="" /></td>
    </tr>
    <tr>
        <td><b><?php echo $entry_password; ?></b></td>
        <td><input type="password" id="password" name="password" value="" /></td>
    </tr>
    <tr>
        <td></td>
        <td><a id="forget" href="<?php echo $forgotten; ?>"><?php echo $text_forgotten; ?></a></td>
    </tr>
    <tr>
        <td></td>
        <td><a id="button-login" class="button"><span><?php echo $button_login; ?></span></a></td>
    </tr>
  </table>

  <input type="hidden" name="action" value="framework" />
  <input type="hidden" name="fwurl" value="/checkout/login" />
</div>
<script type="text/javascript"><!--

jQuery('#password').keydown(function(e) {
	if (e.keyCode == 13) {
		doLogin();
		//submitForm();
	}
});


//--></script>   