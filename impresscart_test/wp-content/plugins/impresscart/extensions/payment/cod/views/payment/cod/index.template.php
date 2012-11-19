<div class="buttons">
  <div class="right"><a id="cod-button-confirm" class="button"><span><?php echo $button_confirm; ?></span></a></div>
</div>
<script type="text/javascript"><!--
jQuery('#cod-button-confirm').bind('click', function() {
	jQuery.ajax({
		url: impresscart.ajaxurl,
		data : { action : 'framework', fwurl : '/payment/cod/confirm' },
		success: function() {
			location = '<?php echo $continue; ?>';
		}		
	});
});
//--></script>