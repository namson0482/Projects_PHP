// Check if string is non-blank
var isNonblank_re    = /\S/;
function isNonblank (s) {
   return String (s).search (isNonblank_re) != -1
}

/*
var goscom_temp_css_class = "";
jQuery("body").on({
    ajaxStart: function() {
    	//goscom_temp_css_class = jQuery(this)[0].className;
    	//jQuery(this)[0].className = '';
    	jQuery(this).addClass("loading"); 
    },
    ajaxStop: function() { 
    	jQuery(this).removeClass("loading");
    	//jQuery(this)[0].className  = goscom_temp_css_class;
    	 
    },
    ajaxComplete : function() {
		
    }    
});
*/

//jQuery.blockUI({ message: '<h1><img src="busy.gif" /> Just a moment...</h1>' });

/*
 	Blocking with a custom message:

		$.blockUI({ message: '<h1><img src="busy.gif" /> Just a moment...</h1>' });
	
	Blocking with custom style:

		$.blockUI({ css: { backgroundColor: '#f00', color: '#fff'} }); 
 */

jQuery(document).on({
	ajaxStart: function() {
		var loc = window.location.pathname;
		var dir = loc.substring(0, loc.lastIndexOf('/')) + '/' + 'wp-content/plugins/impresscart1809/assets/images/busy.gif';
		jQuery.blockUI({ message: '<h1><img src="' + dir + '" /> Just a moment...</h1>' });
		
	},
	ajaxStop: function() {
		jQuery.unblockUI();
	}
}); 


