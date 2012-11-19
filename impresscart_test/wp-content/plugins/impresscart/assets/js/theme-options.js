/*
Copyright 2010-2011 Impress Dev LLC. This software is distributed under the GNU General Public License version 2. 

Contact: support@impressdev.com
*/

var gradient_options = null;

jQuery(document).ready(function() {
    
	//image upload
	jQuery('#upload_image_button').click(function() {
		var productPostId = jQuery('#productPostId').val();
		formfield = jQuery('#upload_image').attr('name');
		var url = 'media-upload.php?post_id='+productPostId+'&amp;type=image&amp;TB_iframe=true&amp'
		tb_show('', url);
		return false;
	});

	window.send_to_editor = function(html) {
		imgurl = jQuery('img',html).attr('src');
		jQuery('#upload_image').val(imgurl);
		jQuery('#insert_images').append('<div><input type="hidden" name="product_image[]" value="'+imgurl+'" /><img width="32" height="32" src="'+imgurl+'" /><a class="product_image_remove" href="#">(remove)</a></div>');
		tb_remove();
	}
	
	jQuery('.product_image_remove').live('click', function(){		
		jQuery(this).parent().remove();
		return false;
	});
	
    // show options
    jQuery("#im_option_loading").css("display", "none");
    jQuery("#im_option_wrapper").css("visibility", "visible");

    // theme tabs
    jQuery("#theme-options").tabs();
    
    // product tabs
    //
    jQuery("#product-tabs").tabs();
    // site columns js
    jQuery("#site_columns").bind('change', ip_site_columns);
    jQuery("#site_columns").trigger('change');
    
    // show css
    jQuery("#show_css").bind('change', generate_button_css);
    jQuery("#show_css").trigger('change');

	// show hide options
	jQuery(".group_option a").live('click', function(e, type) {
		
		var selectedTabIndex = jQuery("#theme-options").tabs('option', "selected");
		var selectedTab = jQuery("#theme-options .ui-tabs-panel:eq(" + selectedTabIndex + ")");
		jQuery(selectedTab).find(".group-tab").css("height", "auto");
		
		// hide all group_options
		jQuery(this).parents('.option-tab').find('.group_options').css("display", "none");
		jQuery(this).parents('.option-tab').find('.group_option a').removeClass('active').html('+');
		//jQuery(this).parents('.option-tab').find('.group_option a').removeClass('active').html('+');
		
		var id = jQuery(this).attr("href");
		var this_id = jQuery(this).attr("id");
		
		// pos or neg
		var html = jQuery(this).html();
		if (html == '+') {
			
			jQuery(this).parent('.group_option').next('.group_options').css("display", "block");
			jQuery(this).html("-");

			// add active class
			jQuery(this).addClass('active');
			
			// add cookie
			if (type != "trigger") {
				//jQuery.cookie("im_active_group", this_id);
			}
			
		} else {
			jQuery(id).find('.group_options').css("display", "none");
			//jQuery(this).parent('.group_option').next('.group_options').css("display", "none");
			jQuery(this).html("+");

			// remove active class
			jQuery(this).removeClass('active');
			
		}		
			
		// set Height
		jQuery(selectedTab).find(".group-tab").css("height", jQuery(selectedTab).find(".option-tab-wrapper").height());
		
		return false;
	});
	jQuery(".group_option").live('click', function() {
		jQuery("a", this).trigger('click');
	});
	jQuery(".option-tab").find(".group_option:first a").trigger('click', ['trigger']);
	
	//if (jQuery.cookie("im_active_group") && !jQuery("#button-preview").length) {
	//	jQuery("#" + jQuery.cookie("im_active_group")).trigger('click');
	//}

    // slider
    jQuery(".slider").each(function() {
        ip_slider(this);
    });

    // widget page assignment
    window.setInterval(ip_page_assignment, 100);
    window.setInterval(ip_button_preview, 500);

    // save button
    window.setInterval(ip_save_button, 100);
    jQuery(document).scroll(function () {
        ip_save_button();
    });
    
    // Add more swatch
    jQuery(".add-swatch").click(function() {
        clone = jQuery(this).parents(".button-gradient-swatch-wrapper").find('.button-gradient-clone').clone();
        
        // remove clone attributes
        clone.removeClass('button-gradient-clone');
        clone.find("input").attr("disabled", "");
        
        // replace some text
        clone.html(clone.html().replace(/_X/g, "_" + (jQuery(this).parents(".button-gradient-swatch-wrapper").find(".button-gradient-swatch").length + 1)));
        
        // Delete swatch
        clone.find(".delete-swatch").click(function() {
            jQuery(this).parents('.button-gradient-swatch').remove();
            return false;
        });
        
        // show
        clone.css("display", "block");
        jQuery(this).parents(".button-gradient-swatch-wrapper").append(clone);
        
        // add js
        ip_slider(clone.find('.slider'));
        ip_color(clone.find('.color-picker'));
        
        return false;
    });
    
    // Delete swatch
    jQuery(".delete-swatch").click(function() {
        jQuery(this).parents('.button-gradient-swatch').remove();
        return false;
    });
    
    // gradient toggle
    gradient_options = jQuery("#gradient_x_start,#gradient_y_start,#gradient_x_end,#gradient_y_end,.button-gradient-swatch,#hover_gradient_x_start,#hover_gradient_y_start,#hover_gradient_x_end,#hover_gradient_y_end");
    check_gradient();

    jQuery("#button_gradient_enable").click(function() {
        check_gradient();
    });
});

function generate_button_css() {
    // show hide css
    if (jQuery("#show_css").is(":checked")) {
        // add wrapper
        if (!jQuery("#show_css").parents(".form-field").find("#show_css_wrapper").length) {
            jQuery("#show_css").wrap("<div id=\"show_css_wrapper\" style=\"float: left;\" />");
        }
        // add textarea
        if (!jQuery("#show_css_wrapper").find("#css_code").length) {
            jQuery("#show_css_wrapper").append("<br /><div id=\"css_instruction\" style=\"color: #F00;\"><strong>Instruction:</strong> To use the following css, you will nead a html markup like this:<br /><code>&lt;div id=\"<span class=\"button_id\"></span>_wrapper\"&gt;&lt;a href=\"#\" id=\"<span class=\"button_id\"></span>\"&gt;Text Here&lt;/a&gt;&lt;/div&gt;</code>.</div>");
            jQuery("#show_css_wrapper").append("<br /><textarea id=\"css_code\" style=\"width: 600px; height: 800px; background: #DCFFC4; padding: 5px;\" />");
        } else {
            jQuery("#css_code").css("display", "block");
            jQuery("#css_instruction").css("display", "block");
        }
    } else {
        if (jQuery("#css_code").length) {
            jQuery("#css_code").css("display", "none");
            jQuery("#css_instruction").css("display", "none");
        }
    }
    jQuery("#css_code").unbind("click");
    jQuery("#css_code").click(function() {
        jQuery(this).focus();
        jQuery(this).select();
    });
}

function generate_button_css_gradient_source(stops, colors, tab) {
    stop_values = new Array();
    color_values = new Array();
    jQuery("." + stops + ":not(:disabled)").each(function(index, item) {
        stop_values[index] = jQuery(item).val();
    });
    jQuery("." + colors + ":not(:disabled)").each(function(index, item) {
        color_values[index] = jQuery(item).val();
    });
        
    first_color = "#ffffff";
    final_color = "#ffffff";
    moz_stop_array = new Array();
    webkit_stop_array = new Array();
        
    jQuery.each(color_values, function(index, item) {
        if (index == 0) {
            first_color = item;
        }
        if (index == color_values.length - 1) {
            final_color = item;
        }
        moz_stop_array.push(item + " " + stop_values[index] + "%");
        webkit_stop_array.push("color-stop(" + stop_values[index] + "%, " + item + ")");
    });
        
    gradient_x_start = jQuery("#gradient_x_start_custom").val();
    if (!gradient_x_start) gradient_x_start = jQuery("#gradient_x_start").val();
    gradient_y_start = jQuery("#gradient_y_start_custom").val();
    if (!gradient_y_start) gradient_y_start = jQuery("#gradient_y_start").val();
    gradient_x_end = jQuery("#gradient_x_end_custom").val();
    if (!gradient_x_end) gradient_x_end = jQuery("#gradient_x_end").val();
    gradient_y_end = jQuery("#gradient_y_end_custom").val();
    if (!gradient_y_end) gradient_y_end = jQuery("#gradient_y_end").val();
        
    if (gradient_x_start == gradient_x_end) {
        moz_gradient_x_start = 'center';
    } else {
        moz_gradient_x_start = gradient_x_start;
    }
    if (gradient_y_start == gradient_y_end) {
        moz_gradient_y_start = 'center';
    } else {
        moz_gradient_y_start = gradient_y_start;
    }
    if (gradient_x_start != gradient_x_end) {
        ie_gradient_type = '1';
    } else {
        ie_gradient_type = '0';
    }
        
    html = "";    
        
    // gradient css
    html += tab + "background: -moz-linear-gradient(" + moz_gradient_x_start + " " +  moz_gradient_y_start + ", " + moz_stop_array.join(",") + ");";
    html += tab + "background: -webkit-gradient(linear, " + gradient_x_start + " " + gradient_y_start + ", " + gradient_x_end + " " + gradient_y_end + ", " + webkit_stop_array.join(",") + ");";
    html += tab + "background: -o-linear-gradient(" + moz_gradient_x_start + " " + moz_gradient_y_start + ", " + moz_stop_array.join(",") + ");";
    html += tab + "-pie-background: linear-gradient(" + first_color + ", " + final_color + ");";
    html += tab + "filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='" + first_color + "', endColorstr='" + final_color + "', GradientType=" + ie_gradient_type + ");";
    
    return html;
}

function generate_button_css_source() {
    
    // tab
    tab = "\n        ";
    newline = "\n";
    // code area
    code_area = jQuery("#css_code");
    
    if (code_area.length == 0) return false;
    
    // get options
    // button gradient
    button_gradient_enable = jQuery("#button_gradient_enable").is(":checked");
    // text
    button_text = jQuery("#button_text").val();
    // href
    button_href = jQuery("#button_url").val();
    // width, height
    button_width = jQuery("#button_width").val();
    button_height = jQuery("#button_height").val();
    // padding, margin
    button_padding = jQuery("#button_padding").val();
    button_margin = jQuery("#button_margin").val();
    // align
    button_text_alignment = jQuery("#button_text_alignment").val();
    // font family
    button_font = jQuery("#button_font_custom").val();
    if (!button_font) button_font = jQuery("#button_font").val();
    // font size
    button_font_size = jQuery("#button_font_size").val();
    // color
    button_font_color = jQuery("#button_font_color").val();
    // shadow
    button_text_shadow = jQuery("#button_text_shadow").is(":checked");
    button_text_shadow_x = jQuery("#button_text_shadow_x").val();
    button_text_shadow_y = jQuery("#button_text_shadow_y").val();
    button_text_shadow_thickness = jQuery("#button_text_shadow_thickness").val();
    button_text_shadow_color = jQuery("#button_text_shadow_color").val();
    // round radius
    button_border_round_radius = jQuery("#button_border_round_radius").val();
    // border
    button_border_thickness = jQuery("#button_border_thickness").val();
    button_border_color = jQuery("#button_border_color").val();
    // border shadow
    button_border_shadow_color = jQuery("#button_border_shadow_color").val();
    button_border_shadow_thickness = jQuery("#button_border_shadow_thickness").val();
    // background color
    button_background_color = jQuery("#button_background_color").val();
    // opacity
    button_opacity = jQuery("#button_opacity").val();
    // background image
    button_image = jQuery("#button_image_img").val();
    
    // background position
    button_image_horizontal_alignment = jQuery("#button_image_horizontal_alignment_custom").val();
    button_image_vertical_alignment = jQuery("#button_image_vertical_alignment_custom").val();
    if (!button_image_horizontal_alignment) button_image_horizontal_alignment = jQuery("#button_image_horizontal_alignment").val();
    if (!button_image_vertical_alignment) button_image_vertical_alignment = jQuery("#button_image_vertical_alignment").val();
    
    // hover
    // color
    button_font_color_hover = jQuery("#button_font_color_hover").val();
    // border
    button_border_thickness = jQuery("#button_border_thickness").val();
    button_border_hover_color = jQuery("#button_border_hover_color").val();
    // background color
    button_background_hover_color = jQuery("#button_background_hover_color").val();
    // background image
    button_hover_image = jQuery("#button_hover_image_img").val();
    button_hover_opacity = jQuery("#button_hover_opacity").val();
    
    // gradient
    // button gradient
    button_css_gradient = "";
    button_css_gradient_hover = "";
    if (button_gradient_enable) {
        button_css_gradient = generate_button_css_gradient_source("gradient_color_swatches_stop_value", "gradient_color_swatches_color_value", tab);
        button_css_gradient_hover = generate_button_css_gradient_source("hover_gradient_color_swatches_stop_value", "hover_gradient_color_swatches_color_value", tab);
    }
    
    button_id = jQuery("#button_name").val().replace(/ /, '_').toLowerCase();
    button_id = button_id.replace(/[^a-zA-Z0-9_]+/g, '');
    
    jQuery("#css_instruction").find('.button_id').html(button_id);
    
    html = "#" + button_id + " {";
    html += tab + "display: block;"
    html += tab + "float: left;";
    html += tab + "text-decoration: none;";
    html += tab + "padding: 0;";
    html += tab + "margin: 0;";
    html += tab + "background: transparent;";
    html += tab + "border: none;"
                
    html += tab + "text-align: " + button_text_alignment + ";";
                    
    html += tab + "padding: " + button_padding + ";";

    html += tab + "width: " + button_width + ";";
    html += tab + "height: " + button_height + ";";
    html += tab + "line-height: " + button_height + ";";

    html += tab + "font-family: " + button_font + ";";
    html += tab + "font-size: " + button_font_size + ";";
    html += tab + "color: " + button_font_color + ";";

    if (button_text_shadow) {
        html += tab + "-webkit-text-shadow: " + button_text_shadow_x + " " + button_text_shadow_y + " " + button_text_shadow_thickness + " " + button_text_shadow_color + ";";
        html += tab + "-moz-text-shadow: " + button_text_shadow_x + " " + button_text_shadow_y + " " + button_text_shadow_thickness + " " + button_text_shadow_color + ";";
        html += tab + "text-shadow: " + button_text_shadow_x + " " + button_text_shadow_y + " " + button_text_shadow_thickness + " " + button_text_shadow_color + ";";
    }
                
    if (button_gradient_enable) {
        html += tab + "background-color: " + button_background_color + ";";
    }
    if (button_image) {
        html += tab + "background-image: url(" + button_image + ");";
        html += tab + "background-repeat: no-repeat;";
        html += tab + "background-position:  " + button_image_horizontal_alignment + " " + button_image_vertical_alignment + ";";
    }
                
    html += tab + "opacity: " + button_opacity + ";";
    html += newline + "}" + newline;
    
    html += "#" + button_id + ":hover {";
    html += tab + "display: block;";
    html += tab + "float: left;";
    html += tab + "text-decoration: none;";
    html += tab + "padding: 0;";
    html += tab + "margin: 0;";
    html += tab + "background: transparent;";
    html += tab + "border: none;";
    html += tab + "text-align: " + button_text_alignment + ";";
    html += tab + "padding: " + button_padding + ";";
    html += tab + "width: " + button_width + ";";
    html += tab + "height: " + button_height + ";";
    html += tab + "line-height: " + button_height + ";";
    html += tab + "font-family: " + button_font + ";";
    html += tab + "font-size: " + button_font_size + ";";
    html += tab + "color: " + button_font_color_hover + ";";
    if (button_text_shadow) {
        html += tab + "-webkit-text-shadow: " + button_text_shadow_x + " " + button_text_shadow_y + " " + button_text_shadow_thickness + " " + button_text_shadow_color + ";";
        html += tab + "-moz-text-shadow: " + button_text_shadow_x + " " + button_text_shadow_y + " " + button_text_shadow_thickness + " " + button_text_shadow_color + ";";
        html += tab + "text-shadow: " + button_text_shadow_x + " " + button_text_shadow_y + " " + button_text_shadow_thickness + " " + button_text_shadow_color + ";";
    }

    if (button_gradient_enable) {
        html += tab + "background-color: " + button_background_hover_color + ";";
    }
    if (button_hover_image) {
        html += tab + "background-image: url(" + button_hover_image + ");";
        html += tab + "background-repeat: no-repeat;";
        html += tab + "background-position:  " + button_image_horizontal_alignment + " " + button_image_vertical_alignment + ";";
    }
    html += tab + "opacity: " + button_hover_opacity + ";";
    html += newline + "}" + newline;
    
    html += "#" + button_id + "_wrapper {";
    html += tab + "float: left;";
    html += tab + "overflow: hidden;";
    html += tab + "margin: " + button_margin + ";";
    html += tab + "border: " + button_border_thickness + " solid " + button_border_color + ";";
    html += tab + "-webkit-border-radius: " + button_border_round_radius + ";";
    html += tab + "-moz-border-radius: " + button_border_round_radius + ";";
    html += tab + "border-radius: " + button_border_round_radius + ";";
    html += tab + "box-shadow: 0 0 " + button_border_shadow_thickness + " " + button_border_shadow_thickness + " " + button_border_shadow_color + "; ";
    html += tab + "-webkit-box-shadow: 0 0 " + button_border_shadow_thickness + " " + button_border_shadow_thickness + " " + button_border_shadow_color + "; ";
    html += tab + "-moz-box-shadow: 0 0 " + button_border_shadow_thickness + " " + button_border_shadow_thickness + " " + button_border_shadow_color + "; ";
    html += tab + "opacity: " + button_opacity + ";";
    html += button_css_gradient;
    html += newline + "}" + newline;
    
    html += "#" + button_id + "_wrapper:hover {";
    html += tab + "float: left;";
    html += tab + "overflow: hidden;";
    html += tab + "margin: " + button_margin + ";";
    html += tab + "border: " + button_border_thickness + " solid " + button_border_hover_color + ";";
    html += tab + "-webkit-border-radius: " + button_border_round_radius + ";";
    html += tab + "-moz-border-radius: " + button_border_round_radius + ";";
    html += tab + "border-radius: " + button_border_round_radius + ";";
    html += tab + "box-shadow: 0 0 " + button_border_shadow_thickness + " " + button_border_shadow_thickness + " " + button_border_shadow_color + "; ";
    html += tab + "-webkit-box-shadow: 0 0 " + button_border_shadow_thickness + " " + button_border_shadow_thickness + " " + button_border_shadow_color + "; ";
    html += tab + "-moz-box-shadow: 0 0 " + button_border_shadow_thickness + " " + button_border_shadow_thickness + " " + button_border_shadow_color + "; ";
    html += tab + "opacity: " + button_hover_opacity + ";";
    html += button_css_gradient_hover;
    html += newline + "}" + newline;
    
    if (html != code_area.val()) {
        code_area.val(html);
    }
}

function check_gradient() {
    if (jQuery("#button_gradient_enable").is(':checked')) {
        gradient_options.parents('.form-field').css('display', 'block');
    } else {
        gradient_options.parents('.form-field').css('display', 'none');
    }
}

function ip_save_button() {
    scrollTop = jQuery("html").scrollTop();
    browserHeight = jQuery(window).height();
    bodyHeight = jQuery(document).height();
    maxScrollHeight = bodyHeight - browserHeight;
    if (scrollTop > maxScrollHeight - 58) {
        jQuery("#save_options_fixed").css("bottom", scrollTop - maxScrollHeight + 58 + "px");
    } else {
        jQuery("#save_options_fixed").css("bottom", "10px");
    }
}

function ip_color(input) {
    var myPicker = new jscolor.color(document.getElementById(jQuery(input).attr("id")), {});
}

function ip_slider(slider) {
    var slider_id = jQuery(slider).attr("id");
    var slider_value = jQuery("#" + slider_id + "_value").val();
    var slider_max = parseInt(jQuery(slider).attr("max"));
    if (!slider_max) slider_max = 5;
    jQuery(slider).slider({
        min: 0,
        max: slider_max,
        step: 1,
        value: slider_value,
        slide: function(event, ui) {
            // change value
            slider_id = jQuery(slider).attr("id");
            jQuery("#" + slider_id + "_value").val(ui.value);

            if (jQuery(slider).attr("multitext")) {
                // multitext
                slider_multitext(ui.value, jQuery(slider).attr("multitext"));
            }
        }
    });
}

function ip_page_assignment() {
    jQuery(".ip_pa_all:not(.ip_pa_js)").click(function() {
        parent = jQuery(this).parents(".ip-page-assignment");
        parent.find(".ip_pa_list option").attr("selected", "selected");
        parent.find(".ip_pa_list").attr("disabled", "disabled");
        jQuery(".ip_pa").addClass('ip_pa_js');
    });
    jQuery(".ip_pa_none:not(.ip_pa_js)").click(function() {
        parent = jQuery(this).parents(".ip-page-assignment");
        parent.find(".ip_pa_list option").attr("selected", "");
        parent.find(".ip_pa_list").attr("disabled", "disabled");
        jQuery(".ip_pa").addClass('ip_pa_js');
    });
    jQuery(".ip_pa_select:not(.ip_pa_js)").click(function() {
        parent = jQuery(this).parents(".ip-page-assignment");
        parent.find(".ip_pa_list").attr("disabled", "");
        parent.find(".ip_pa_list").focus();
        jQuery(".ip_pa").addClass('ip_pa_js');
    });
}

function slider_multitext(value, multitext_id) {
    // multitext
    multitext = jQuery("." + multitext_id);

    // clear
    multitext.remove();
    
    // clone field
    for (i = 0; i <  value; i ++) {
        clone = jQuery("." + multitext_id + "_clone").clone().removeClass(multitext_id + "_clone").addClass(multitext_id).css("display", "inline").attr("disabled", "");
        // append
        jQuery("#" + multitext_id).append(clone);
    }

    // auto equal value
    multitext = jQuery("." + multitext_id);
    new_value = Math.round(100 / multitext.length * 10) / 10;
    total_value = 0;
    jQuery.each(multitext, function(index, item) {
        if (index != multitext.length - 1) {
            jQuery(item).val(new_value + '%');
        } else {
            jQuery(item).val(Math.round((100 - total_value) * 100) / 100 + '%');
        }
        total_value = total_value + new_value;
    });
}

function ip_site_columns() {
    // hide all fields
    jQuery("#site_sidebar_1_width").parent(".form-field").css("display", "none");
    jQuery("#site_sidebar_2_width").parent(".form-field").css("display", "none");
    jQuery("#site_columns_order_1").parent(".form-field").css("display", "none");
    jQuery("#site_columns_order_2").parent(".form-field").css("display", "none");
    jQuery("#site_content_width").parent(".form-field").css("display", "none");

    // only display need fields
    site_columns = jQuery("#site_columns").val();
    if (site_columns == 3) {
        jQuery("#site_sidebar_1_width").parent(".form-field").css("display", "block");
        jQuery("#site_sidebar_2_width").parent(".form-field").css("display", "block");
        jQuery("#site_columns_order_1").parent(".form-field").css("display", "block");
        jQuery("#site_content_width").parent(".form-field").css("display", "block");
    } else if (site_columns == 2) {
        jQuery("#site_sidebar_1_width").parent(".form-field").css("display", "block");
        jQuery("#site_columns_order_2").parent(".form-field").css("display", "block");
        jQuery("#site_content_width").parent(".form-field").css("display", "block");
    } else if (site_columns == 1) {
        jQuery("#site_content_width").parent(".form-field").css("display", "block");
    }
}

var button_live_preview = true;

function ip_button_gradient_ie(wrapper, button, stop_values, color_values, gradient_x_start, gradient_y_start, gradient_type) {
    
    if (!jQuery.browser.msie) {
        return false;
    }
    
    wrapper = jQuery(wrapper);
    button = jQuery(button);
    
    if (wrapper.length == 0 || button.length == 0) {
        return false;
    }
    
    // remove for live preview
    wrapper.find('.im_gr').remove();

    // init
    if (wrapper.find('.im_gr_wrapper').length == 0) {
        wrapper.css('position', 'relative');
        wrapper.prepend('<div class="im_gr_wrapper" />');
        wrapper.css({
            width: button.outerWidth(),
            height: button.outerHeight()
        });
        
        wrapper.find('.im_gr_wrapper').css({
            width: button.outerWidth(),
            height: button.outerHeight(),
            position: 'absolute',
            top: 0,
            left: 0,
            zIndex: 8
        });

        button.css({
            position: 'absolute',
            top: 0,
            left: 0,
            zIndex: 9
        });
    } else {
        // for live preview
        wrapper.css({
            width: button.outerWidth(),
            height: button.outerHeight()
        });
        wrapper.find('.im_gr_wrapper').css({
            width: button.outerWidth(),
            height: button.outerHeight()
        });
    }

    // add more div
    for (i = 0; i <= stop_values.length; i++) {
        wrapper.find('.im_gr_wrapper').append('<span class="im_gr im_gr_' + i + '" />');
    }

    // set background
    wrapper.find(".im_gr").each(function (index, item) {
        jQuery(item).css("display", "block");
        jQuery(item).css("z-index", "8");
        jQuery(item).css("position", "absolute");
        
        if (gradient_type == 0) {
            jQuery(item).css("width", wrapper.width());
            if (gradient_y_start == "top") {
                if (index == 0) {
                    jQuery(item).css("top", "0%");
                    jQuery(item).css("height", stop_values[index] + "%");
                    jQuery(item).css("filter", "progid:DXImageTransform.Microsoft.gradient(startColorstr='" + color_values[index] + "', endColorstr='" + color_values[index] + "', GradientType=" + gradient_type + ")");
                } else if (index == stop_values.length) {
                    jQuery(item).css("top", stop_values[index - 1] + "%");
                    jQuery(item).css("height", (100 - stop_values[index - 1]) + "%");
                    jQuery(item).css("filter", "progid:DXImageTransform.Microsoft.gradient(startColorstr='" + color_values[index - 1] + "', endColorstr='" + color_values[index - 1] + "', GradientType=" + gradient_type + ")");
                } else {
                    jQuery(item).css("top", stop_values[index - 1] + "%");
                    jQuery(item).css("height", (stop_values[index] - stop_values[index - 1]) + "%");
                    jQuery(item).css("filter", "progid:DXImageTransform.Microsoft.gradient(startColorstr='" + color_values[index - 1] + "', endColorstr='" + color_values[index] + "', GradientType=" + gradient_type + ")");
                }
            } else {
                if (index == 0) {
                    jQuery(item).css("top", (100 - stop_values[index]) + "%");
                    jQuery(item).css("height", stop_values[index] + "%");
                    jQuery(item).css("filter", "progid:DXImageTransform.Microsoft.gradient(startColorstr='" + color_values[index] + "', endColorstr='" + color_values[index] + "', GradientType=" + gradient_type + ")");
                } else if (index == stop_values.length) {
                    jQuery(item).css("top",  "0%");
                    jQuery(item).css("height", (100 - stop_values[index - 1]) + "%");
                    jQuery(item).css("filter", "progid:DXImageTransform.Microsoft.gradient(startColorstr='" + color_values[index - 1] + "', endColorstr='" + color_values[index - 1] + "', GradientType=" + gradient_type + ")");
                } else {
                    jQuery(item).css("top",  (100 - stop_values[index]) + "%");
                    jQuery(item).css("height", (stop_values[index] - stop_values[index - 1]) + "%");
                    jQuery(item).css("filter", "progid:DXImageTransform.Microsoft.gradient(startColorstr='" + color_values[index] + "', endColorstr='" + color_values[index - 1] + "', GradientType=" + gradient_type + ")");
                }
            }
        } else {
            jQuery(item).css("height", wrapper.height());
            if (gradient_x_start == "left") {
                if (index == 0) {
                    jQuery(item).css("left", "0%");
                    jQuery(item).css("width", stop_values[index] + "%");
                    jQuery(item).css("filter", "progid:DXImageTransform.Microsoft.gradient(startColorstr='" + color_values[index] + "', endColorstr='" + color_values[index] + "', GradientType=" + gradient_type + ")");
                } else if (index == stop_values.length) {
                    jQuery(item).css("left", stop_values[index - 1] + "%");
                    jQuery(item).css("width", (100 - stop_values[index - 1]) + "%");
                    jQuery(item).css("filter", "progid:DXImageTransform.Microsoft.gradient(startColorstr='" + color_values[index - 1] + "', endColorstr='" + color_values[index - 1] + "', GradientType=" + gradient_type + ")");
                } else {
                    jQuery(item).css("left", stop_values[index - 1] + "%");
                    jQuery(item).css("width", (stop_values[index] - stop_values[index - 1]) + "%");
                    jQuery(item).css("filter", "progid:DXImageTransform.Microsoft.gradient(startColorstr='" + color_values[index - 1] + "', endColorstr='" + color_values[index] + "', GradientType=" + gradient_type + ")");
                }
            } else {
                if (index == 0) {
                    jQuery(item).css("left", (100 - stop_values[index]) + "%");
                    jQuery(item).css("width", stop_values[index] + "%");
                    jQuery(item).css("filter", "progid:DXImageTransform.Microsoft.gradient(startColorstr='" + color_values[index] + "', endColorstr='" + color_values[index] + "', GradientType=" + gradient_type + ")");
                } else if (index == stop_values.length) {
                    jQuery(item).css("left", "0%");
                    jQuery(item).css("width", (100 - stop_values[index - 1]) + "%");
                    jQuery(item).css("filter", "progid:DXImageTransform.Microsoft.gradient(startColorstr='" + color_values[index - 1] + "', endColorstr='" + color_values[index - 1] + "', GradientType=" + gradient_type + ")");
                } else {
                    jQuery(item).css("left", (100 - stop_values[index]) + "%");
                    jQuery(item).css("width", (stop_values[index] - stop_values[index - 1]) + "%");
                    jQuery(item).css("filter", "progid:DXImageTransform.Microsoft.gradient(startColorstr='" + color_values[index] + "', endColorstr='" + color_values[index - 1] + "', GradientType=" + gradient_type + ")");
                }
            }
        }
    });
}

function ip_button_gradient(stops, colors) {
    stop_values = new Array();
    color_values = new Array();
    jQuery("." + stops + ":not(:disabled)").each(function(index, item) {
        stop_values[index] = jQuery(item).val();
    });
    jQuery("." + colors + ":not(:disabled)").each(function(index, item) {
        color_values[index] = jQuery(item).val();
    });
        
    first_color = "#ffffff";
    final_color = "#ffffff";
    moz_stop_array = new Array();
    webkit_stop_array = new Array();
        
    jQuery.each(color_values, function(index, item) {
        if (index == 0) {
            first_color = item;
        }
        if (index == color_values.length - 1) {
            final_color = item;
        }
        moz_stop_array.push(item + " " + stop_values[index] + "%");
        webkit_stop_array.push("color-stop(" + stop_values[index] + "%, " + item + ")");
    });
        
    gradient_x_start = jQuery("#gradient_x_start_custom").val();
    if (!gradient_x_start) gradient_x_start = jQuery("#gradient_x_start").val();
    gradient_y_start = jQuery("#gradient_y_start_custom").val();
    if (!gradient_y_start) gradient_y_start = jQuery("#gradient_y_start").val();
    gradient_x_end = jQuery("#gradient_x_end_custom").val();
    if (!gradient_x_end) gradient_x_end = jQuery("#gradient_x_end").val();
    gradient_y_end = jQuery("#gradient_y_end_custom").val();
    if (!gradient_y_end) gradient_y_end = jQuery("#gradient_y_end").val();
        
    if (gradient_x_start == gradient_x_end) {
        moz_gradient_x_start = 'center';
    } else {
        moz_gradient_x_start = gradient_x_start;
    }
    if (gradient_y_start == gradient_y_end) {
        moz_gradient_y_start = 'center';
    } else {
        moz_gradient_y_start = gradient_y_start;
    }
    if (gradient_x_start != gradient_x_end) {
        ie_gradient_type = '1';
    } else {
        ie_gradient_type = '0';
    }
    
    // gradient css
    if (!jQuery.browser.msie) {
        button_wrapper.css("-pie-background", "linear-gradient(" + first_color + ", " + final_color + ");");
        button_wrapper.css("background", "-moz-linear-gradient(" + moz_gradient_x_start + " " +  moz_gradient_y_start + ", " + moz_stop_array.join(",") + ")");
        button_wrapper.css("background", "-webkit-gradient(linear, " + gradient_x_start + " " + gradient_y_start + ", " + gradient_x_end + " " + gradient_y_end + ", " + webkit_stop_array.join(",") + ")");
        button_wrapper.css("background", "-o-linear-gradient(" + moz_gradient_x_start + " " + moz_gradient_y_start + ", " + moz_stop_array.join(",") + ")");
    } else {
        ip_button_gradient_ie("#im_button_preview_wrapper", "#im_button_preview", stop_values, color_values, moz_gradient_x_start, moz_gradient_y_start, ie_gradient_type);
    }
}

function ip_button_preview() {
    
    if (jQuery("#button-preview").length == 0) {
        return false;
    }
    
    // check live preview
    if (!button_live_preview) {
        return false;
    }
    
    // variable
    button_preview_wrapper = jQuery("#button-preview");
    button_wrapper = jQuery("#im_button_preview_wrapper");
    button = jQuery("#im_button_preview");
    
    /* Load Button Settings */
    
    // button gradient
    button_gradient_enable = jQuery("#button_gradient_enable").is(":checked");
    
    // text
    button_text = jQuery("#button_text").val();
    button.html(button_text);
    
    
    // href
    button_href = jQuery("#button_url").val();
    button.attr("href", button_href);
    
    // width, height
    button_width = jQuery("#button_width").val();
    button_height = jQuery("#button_height").val();
    button.css("width", button_width);
    button.css("height", button_height);
    
    if (button_height != "auto") {
        button.css("line-height", button_height);
    }
    
    // padding, margin
    button_padding = jQuery("#button_padding").val();
    button_margin = jQuery("#button_margin").val();
    button.css("padding", button_padding);
    button.css("margin", button_margin);
    
    // align
    button_text_alignment = jQuery("#button_text_alignment").val();
    button.css("text-align", button_text_alignment);
    
    // font family
    button_font = jQuery("#button_font_custom").val();
    if (!button_font) button_font = jQuery("#button_font").val();
    button.css("font-family", button_font);
    
    // font size
    button_font_size = jQuery("#button_font_size").val();
    button.css("font-size", button_font_size);
    
    // color
    button_font_color = jQuery("#button_font_color").val();
    button.css("color", button_font_color);
    
    // shadow
    button_text_shadow = jQuery("#button_text_shadow").is(":checked");
    if (button_text_shadow) {
        button_text_shadow_x = jQuery("#button_text_shadow_x").val();
        button_text_shadow_y = jQuery("#button_text_shadow_y").val();
        button_text_shadow_thickness = jQuery("#button_text_shadow_thickness").val();
        button_text_shadow_color = jQuery("#button_text_shadow_color").val();
        button.css("text-shadow", button_text_shadow_x + " " + button_text_shadow_y + " " + button_text_shadow_thickness + " " + button_text_shadow_color);
        button.css("-moz-text-shadow", button_text_shadow_x + " " + button_text_shadow_y + " " +  button_text_shadow_thickness + " " + button_text_shadow_color);
        button.css("-webkit-text-shadow", button_text_shadow_x + " " + button_text_shadow_y + " " +  button_text_shadow_thickness + " " + button_text_shadow_color);
    } else {
        button.css("text-shadow", "none");
        button.css("-moz-text-shadow", "none");
        button.css("-webkit-text-shadow", "none");
    }
    
    // round radius
    button_border_round_radius = jQuery("#button_border_round_radius").val();
    button.css("border-radius", button_border_round_radius);
    button.css("-moz-border-radius", button_border_round_radius);
    button.css("-webkit-border-radius", button_border_round_radius);
    button_wrapper.css("border-radius", button_border_round_radius);
    button_wrapper.css("-moz-border-radius", button_border_round_radius);
    button_wrapper.css("-webkit-border-radius", button_border_round_radius);
    
    // border
    button_border_thickness = jQuery("#button_border_thickness").val();
    button_border_color = jQuery("#button_border_color").val();
    button.css("border", button_border_thickness + " solid " + button_border_color);
    
    // border shadow
    button_border_shadow_color = jQuery("#button_border_shadow_color").val();
    button_border_shadow_thickness = jQuery("#button_border_shadow_thickness").val();
    button.css("box-shadow", "0 0 " + button_border_shadow_thickness + " " + button_border_shadow_color);

    // background color
    if (!button_gradient_enable) {
        button_background_color = jQuery("#button_background_color").val();
        button.css("background-color", button_background_color);
    } else {
        button.css("background-color", "transparent");
    }
    
    // opacity
    button_opacity = jQuery("#button_opacity").val();
    button.css("opacity", button_opacity);
    button_wrapper.css("opacity", button_opacity);
    
    // background image
    button_image_img = jQuery("#button_image_img").val();
    button.css("background-image", "url(" + button_image_img + ")");
    
    // background repeat
    button.css("background-repeat", "no-repeat");
    
    // background position
    button_image_horizontal_alignment = jQuery("#button_image_horizontal_alignment_custom").val();
    button_image_vertical_alignment = jQuery("#button_image_vertical_alignment_custom").val();
    if (!button_image_horizontal_alignment) button_image_horizontal_alignment = jQuery("#button_image_horizontal_alignment").val();
    if (!button_image_vertical_alignment) button_image_vertical_alignment = jQuery("#button_image_vertical_alignment").val();
    button.css("background-position", button_image_horizontal_alignment + " " + button_image_vertical_alignment);
    
    // button gradient
    if (button_gradient_enable) {
        ip_button_gradient("gradient_color_swatches_stop_value", "gradient_color_swatches_color_value");
    }
    
    // hover
    button.unbind('hover');
    button.hover(function() {
        button_live_preview = false;
        
        // color
        button_font_color_hover = jQuery("#button_font_color_hover").val();
        button.css("color", button_font_color_hover);
        
        // border
        button_border_thickness = jQuery("#button_border_thickness").val();
        button_border_hover_color = jQuery("#button_border_hover_color").val();
        button.css("border", button_border_thickness + " solid " + button_border_hover_color);
        
        // background color
        if (!button_gradient_enable) {
            button_background_hover_color = jQuery("#button_background_hover_color").val();
            button.css("background-color", button_background_color);
        } else {
            button.css("background-color", "transparent");
        }
        
        // background image
        button_hover_image_img = jQuery("#button_hover_image_img").val();
        button.css("background-image", "url(" + button_hover_image_img + ")");
        
        // button gradient
        if (button_gradient_enable) {
            ip_button_gradient("hover_gradient_color_swatches_stop_value", "hover_gradient_color_swatches_color_value");
        }
        
        // opacity
        button_hover_opacity = jQuery("#button_hover_opacity").val();
        button.css("opacity", button_hover_opacity);
        button_wrapper.css("opacity", button_hover_opacity);
        
    }, function() {
        button_live_preview = true;
        
        // color
        button_font_color = jQuery("#button_font_color").val();
        button.css("color", button_font_color);
        
        // border
        button_border_thickness = jQuery("#button_border_thickness").val();
        button_border_color = jQuery("#button_border_color").val();
        button.css("border", button_border_thickness + " solid " + button_border_color);
        
        // background color
        if (!button_gradient_enable) {
            button_background_color = jQuery("#button_background_color").val();
            button.css("background-color", button_background_color);
        } else {
            button.css("background-color", "transparent");
        }
        
        // background image
        button_image_img = jQuery("#button_image_img").val();
        button.css("background-image", "url(" + button_image_img + ")");
        
        // button gradient
        if (button_gradient_enable) {
            ip_button_gradient("gradient_color_swatches_stop_value", "gradient_color_swatches_color_value");
        }
        
        // opacity
        button_opacity = jQuery("#button_opacity").val();
        button.css("opacity", button_opacity);
        button_wrapper.css("opacity", button_opacity);
    })
    
    /* Center */
    browserHeight = jQuery(window).height();
    wrapper_height = jQuery("#button-preview").innerHeight();
    wrapper_width = jQuery("#button-preview").innerWidth();
    button_height = jQuery("#im_button_preview").innerHeight();
    button_width = jQuery("#im_button_preview").innerWidth();
    
    button_preview_wrapper.css({
        top: (browserHeight - wrapper_height) / 2
    });
    button_wrapper.css({
        top: (wrapper_height - button_height) / 2,
        left: (wrapper_width - button_width) / 2
    });
    
    if (button_width >= 200) {
        button_preview_wrapper.css("width", button_width + 10);
    } else {
        button_preview_wrapper.css("width", 200);
    }
    
    if (button_height >= 200) {
        button_preview_wrapper.css("height", button_height + 10);
    } else {
        button_preview_wrapper.css("heigth", 200);
    }
    generate_button_css_source();
}


function CheckProductOptions(id)
{

	if(jQuery('input[name="productoptions['+id+'][used]"]').attr('checked') == 'checked')
	{		
		jQuery('.productoptions_' + id).attr('checked', true);
		
	} else {
		jQuery('.productoptions_' + id).attr('checked', false);
	}	
}