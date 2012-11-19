function container_background_full(img_src) {
    jQuery("#container").prepend('<div id="container_background"><img src="" alt="" /></div>');
    container_background = jQuery("#container_background");
    container_background_img = jQuery("#container_background img");
    
    container_background.css("width", jQuery("#container").outerWidth());
    container_background.css("height", jQuery("#container").outerHeight());
    container_background_img.css("visibility", "hidden");
    
    container_background_img.attr("src", img_src);
    // container_background_img.css("width", jQuery("#container").outerWidth());
    // container_background_img.css("height", jQuery("#container").outerHeight());
    jQuery(window).load(function() {
        container_background = jQuery("#container_background");
        container_background_img = jQuery("#container_background img");
        
        container_width = container_background.width();
        container_height = container_background.height();
        img_width = container_background_img.width();
        img_height = container_background_img.height()
        
        var ratio = (img_height / img_width).toFixed(2);
        
        if ((container_height / container_width) > ratio){
            container_background_img.height(container_height);
            container_background_img.width(container_height / ratio);
        } else {
            container_background_img.width(container_width);
            container_background_img.height(container_width * ratio);
        }
        container_background_img.css('left', (container_width - container_background_img.width()) / 2);
        container_background_img.css('top', (container_height - container_background_img.height()) / 2);
        
        container_background_img.css("visibility", "visible");
    });
}

function ip_button_gradient_ie(wrapper, button, stop_values, color_values, gradient_x_start, gradient_y_start, gradient_type) {
    if (!jQuery.browser.msie) {
        return false;
    }
    
    wrapper = jQuery(wrapper);
    button = jQuery(button);
    
    if (wrapper.length == 0 || button.length == 0 || stop_values.length <= 2) {
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
        // item.addBehavior(pie_behavior);
    });
}

jQuery(document).ready(function() {
    jQuery(".im_button").click(function() {
        if (jQuery(this).attr("href") == '') {
            parent_form = jQuery(this).parents('form');
            if (parent_form) {
                parent_form.submit();
            }
            return false;
        }
    });
});