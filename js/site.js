$(document).ready(function(){
	
	$('.mobile-menu-toggle').click(function(){
		$('.mobile-menu-list').fadeToggle();
		$(this).toggleClass('open');
		
		return false;
	}); 

	$('.image-popup-vertical-fit').magnificPopup({
		type: 'image',
		closeOnContentClick: true,
		mainClass: 'mfp-img-mobile',
		image: {
			verticalFit: true
		}
		
	});
	$(".panel-size").hide();
	$(".window-door-dimensions").hide();
	$('#pa_measurement-type').change(function(){
		if(this.value == "panel-size"){
			$(".panel-size").show();
		} else{
			$(".panel-size").hide();
		}
		if(this.value == "window-door-dimensions"){
			$(".window-door-dimensions").show();
		} else{
			$(".window-door-dimensions").hide();
		}
	});
});
function lengthvalidation(inputlength){
	var maxLength = 90;
	var value = inputlength;
	if(value != ""){
	   	if (value > maxLength){
	        alert('Due to the width of a typical fabric roll, it is not possible to make a panel longer than 90" without a seam. If interested in a longer drape, please contact us directly and we will be happy to discuss ideas and costs for your specific project.');
	        return false;
	   	}
	}
}
$(document).ready(function(){
	$(".single_add_to_cart_button ").click(function(){
		if ( $(".single_shop_attributes .select-option.swatch-wrapper").length > 0) {
			if($(".select-option.swatch-wrapper").hasClass( "selected" ) === false){
				alert('Please select color');
				return false;
			}
		}
		lengthvalidation($("#panel-size-width").val());
		lengthvalidation($("#window-width").val());
	});
	
	$("#panel-size-width").on("change", function(){
	   lengthvalidation($(this).val());
	});
	$("#window-width").on("change", function(){
	    lengthvalidation($(this).val());
	});


	$(function(){
	  $(':input[type=number]').on('mousewheel',function(e){ $(this).blur(); });
	});
	$("#panel-size-width").keyup(function(){
		customcount();
	});
	$("#window-width").keyup(function(){
		customcount();
	});
	$("#floor-height").keyup(function(){
		customcount();
	}); 
	$("select").change(function(){
		customcount();
		if($( "#pa_measurement-type option:selected" ).val() == "window-door-dimensions"){
			$( "#panel-size-width" ).val("");
			$(".panel-size input").removeAttr("required");
			$(".window-door-dimensions input").prop('required',true);
		}
		if($( "#pa_measurement-type option:selected" ).val() == "panel-size"){
			$( "#window-width" ).val("");
			$(".window-door-dimensions input").removeAttr("required");
			$(".panel-size input").prop('required',true);
		}
	});

	// color swatches and images in click
	$(".product-type-simple .select-option").click(function(e){
		e.preventDefault();
		var $this = $(this);
            //Get the wrapper select div
            var $option_wrapper = $this.closest('div.select').eq(0);
            var $label = $option_wrapper.parent().find('.swatch-label').eq(0);

            if ($this.hasClass('disabled')) {
                return false;
            } else if ($this.hasClass('selected')) {
                $this.removeClass('selected');
                var $wc_select_box = $option_wrapper.find('select').first();
                $wc_select_box.children('option:eq(0)').prop("selected", "selected").change();
                if ($label) {
                    $label.html("&nbsp;");
                }

                var imgsrc = $this.find("a").data('image');
            	$(".product-type-simple .woocommerce-product-gallery__wrapper img.wp-post-image").show();
            	$(".product-type-simple .woocommerce-product-gallery__wrapper .attributeImg").remove();
            	//alert('test');
            } else {
            	var imgsrc = $this.find("a").data('image');
            	var imgtitle = $this.find("a").data('title');
            	var imgsku = $this.find("a").data('sku');
            	if(imgsrc != ""){
            		$(".woocommerce-product-gallery__wrapper img").hide();
            		$(".woocommerce-product-gallery__wrapper .attributeImg").remove();
            		$(".woocommerce-product-gallery__wrapper").prepend('<div class="attributeImg"><img id="attributeImg" title="'+imgtitle+'" alt="'+imgtitle+'" src="'+imgsrc+'" /><h2>'+imgtitle+'</h2></div>');
            		$(".color_imageSKU").val(imgsku);
            		$(".color_imageSRC").val(imgsrc);
            	} else{
            		$(".woocommerce-product-gallery__wrapper img.wp-post-image").show();
            		$(".woocommerce-product-gallery__wrapper .attributeImg").remove();
            		$(".color_imageSKU").val("");
            		$(".color_imageSRC").val("");
            	}


                $option_wrapper.find('.select-option').removeClass('selected');
                //Set the option to selected.
                $this.addClass('selected');

                //Select the option.
                var wc_select_box_id = $option_wrapper.data('selectid');
                var $wc_select_box = $option_wrapper.find('select').first();

                // Decode entities
                var attr_val = $('<div/>').html($this.data('value')).text();

                // Add slashes
                attr_val = attr_val.replace(/'/g, '\\\'');
                attr_val = attr_val.replace(/"/g, '\\\"');

                $wc_select_box.trigger('focusin').children("[value='" + attr_val + "']").prop("selected", "selected").change();
                if ($label) {
                    $label.html($wc_select_box.children("[value='" + attr_val + "']").eq(0).text());
                }
            }
	});
});
function customcount(){
	 	var valance_attName = $( "#pa_valance option:selected" ).val();
	 	var valance_attfullName = "pa_"+valance_attName;

	 	var sheercurtain_attName = $( "#pa_sheer-curtain option:selected" ).val();	 	
    	var sheercurtain_attfullName = "pa_"+sheercurtain_attName;

    	var lining_attName = $( "#pa_lining option:selected" ).val();	 	
    	var lining_attfullName = "pa_"+lining_attName;

	 	var panel_size_length = $( "#panel-size-length" ).val();

	 	var window_height = $( "#window-height" ).val();
	 	var height_above_floor = $( "#height-above-floor" ).val();
	 	
	 	var floor_height = $( "#floor-height" ).val();
	 	
	 	if($( "#pa_measurement-type option:selected" ).val() == "panel-size"){
	 		var panel_size_width = $( "#panel-size-width" ).val();
	 	} else {
	 		var window_width = $( "#window-width" ).val();
	 	}

	 	 var product_data = jQuery.parseJSON(custom_params.posts);
	      data = {
	        'action': 'load_data',
	        'productId': product_data.ID,

	        'panel-size-width': panel_size_width,
	        'panel_size_length': panel_size_length,

	        'window_height': window_height,
	        'height_above_floor': height_above_floor,
	        'window-width': window_width,
	        'floor-height': floor_height,

	        'attribute_pa_colors': getselectedColor(),
	        'attribute_pa_choose-heading-style': getheadingStyle(),
	        'attribute_pa_measurement-type': getselectedMeasurement(),
	        'attribute_pa_sheer-curtain': getselectedSheer(),
	        'attribute_pa_lining': getselectedLining(),
	        'attribute_pa_valance': getselectedValance(),
	        'attribute_pa_tie-back': getselectedTie(),
	      };
	    jQuery.ajax({
	        type : "post",
	        url : custom_params.ajaxurl,
	        data : data,
	        success: function(response) {
	            $(".customprice").html(response);  
	        }
	    })
}
function getselectedColor(){
	var attName = $( "#pa_colors option:selected" ).val();
	if(attName != ""){
		if(attName == "no"){ var FullattName = attName; }
		else{ var FullattName = "pa_"+attName; }
		return FullattName;
	}
}
function getheadingStyle(){	
	var attName = $( "#pa_choose-heading-style option:selected" ).val();
	if(attName != ""){
		if(attName == "no"){ var FullattName = attName; }
		else{ var FullattName = "pa_"+attName; }
		return FullattName;
	}
}
function getselectedMeasurement(){
	var attName = $( "#pa_measurement-type option:selected" ).val();
	if(attName != ""){
		if(attName == "no"){ var FullattName = attName; }
		else{ var FullattName = "pa_"+attName; }
		return FullattName;
	}
}
function getselectedSheer(){	
	var attName = $( "#pa_sheer-curtain option:selected" ).val();
	if(attName != ""){
		if(attName == "no"){ var FullattName = attName; }
		else{ var FullattName = "pa_"+attName; }
		return FullattName;
	}
}
function getselectedLining(){	
	var attName = $( "#pa_lining option:selected" ).val();
	if(attName != ""){
		if(attName == "no"){ var FullattName = attName; }
		else{ var FullattName = "pa_"+attName; }
		return FullattName;
	}
}
function getselectedValance(){	
	var attName = $( "#pa_valance option:selected" ).val();
	if(attName != ""){
		if(attName == "no"){ var FullattName = attName; }
		else{ var FullattName = "pa_"+attName; }
		return FullattName;
	}
}
function getselectedTie(){	
	var attName = $( "#pa_tie-back option:selected" ).val();
	if(attName != ""){
		if(attName == "no"){ var FullattName = attName; }
		else{ var FullattName = "pa_"+attName; }
		return FullattName;
	}
}