<?php
// define the woocommerce_after_add_attribute_fields callback 
function action_woocommerce_after_attribute_fields(  ) { 
	$attribute_id = $_REQUEST['edit'];
	$imagedata = get_option('product_attributes_image_'.$attribute_id, $attribute_id);
	?>
	<tr>
		<th scope="row" valign="top"><label for="attribute_image">Attribute Visual</label></th>
		<td><input name="attribute_image" id="attribute_image" type="text" class="meta-image regular-text" value="<?php if(!empty($imagedata['attribute_image'])) { echo $imagedata['attribute_image']; }?>">
			<input type="button" class="button image-upload" value="Browse">
			<p class="description">Image for the attribute (shown on the front-end).</p>
			<?php if(!empty($imagedata['attribute_image'])) { ?>
				<div class="image-preview"><img src="<?php echo $imagedata['attribute_image']; ?>" style="max-width: 250px;"></div>
			<?php } ?>
		</td>
	</tr>
	<script>
	    jQuery(document).ready(function ($) {
	      // Instantiates the variable that holds the media library frame.
	      var meta_image_frame;
	      // Runs when the image button is clicked.
	      $('.image-upload').click(function (e) {
	        // Get preview pane
	        var meta_image_preview = $(this).parent().parent().children('.image-preview');
	        // Prevents the default action from occuring.
	        e.preventDefault();
	        var meta_image = $(this).parent().children('.meta-image');
	        // If the frame already exists, re-open it.
	        if (meta_image_frame) {
	          meta_image_frame.open();
	          return;
	        }
	        // Sets up the media library frame
	        meta_image_frame = wp.media.frames.meta_image_frame = wp.media({
	          title: meta_image.title,
	          button: {
	            text: meta_image.button
	          }
	        });
	        // Runs when an image is selected.
	        meta_image_frame.on('select', function () {
	          // Grabs the attachment selection and creates a JSON representation of the model.
	          var media_attachment = meta_image_frame.state().get('selection').first().toJSON();
	          // Sends the attachment URL to our custom image input field.
	          meta_image.val(media_attachment.url);
	          meta_image_preview.children('img').attr('src', media_attachment.url);
	        });
	        // Opens the media library frame.
	        meta_image_frame.open();
	      });
	    });
	</script>
	<?php
}; 
add_action( 'woocommerce_after_add_attribute_fields', 'action_woocommerce_after_attribute_fields', 10, 0 ); 
add_action( 'woocommerce_after_edit_attribute_fields', 'action_woocommerce_after_attribute_fields', 10, 0 ); 

// define the woocommerce_attribute_added callback 
function action_woocommerce_attribute_added( $attribute_id) { 
	$imagedata = array('attribute_id' => $attribute_id, 'attribute_image' => $_POST['attribute_image']);
    add_option('product_attributes_image_'.$attribute_id, $imagedata);
};
add_action( 'woocommerce_attribute_added', 'action_woocommerce_attribute_added', 10, 3 ); 

// define the woocommerce_attribute_updated callback 
function action_woocommerce_attribute_updated( $attribute_id, $attribute, $old_attribute_name ) { 
	$imagedata = array('attribute_id' => $attribute_id, 'attribute_image' => $_POST['attribute_image']);
    update_option('product_attributes_image_'.$attribute_id, $imagedata);
};
add_action( 'woocommerce_attribute_updated', 'action_woocommerce_attribute_updated', 10, 3 ); 


add_action( 'woocommerce_after_product_attribute_settings', 'add_custom_option_action', 10, 2 );
function add_custom_option_action($attribute, $i) {

	global $post;
	if($_POST['post_id']){
		$productID = $_POST['post_id'];
	} else{
		$productID = $post->ID;
	}
	$termSlug = $attribute->get_name();
	
	if($termSlug != "pa_colors" && $termSlug != "pa_measurement-type"){
		$singlePrice = get_post_meta($productID, 'single_price_'.$termSlug, true);
		$singleCheckbox = get_post_meta($productID, 'single_checkbox_'.$termSlug, true);
		$singleCheckbox_label = get_post_meta($productID, 'single_checkbox_label_'.$termSlug, true);
		?>
		<tr>
			<td>

				<label><?php esc_html_e( 'Attribute Price:', 'woocommerce' ); ?></label>
				<input type="number" class="number" value="<?php echo $singlePrice; ?>" name="attribute_custom_price[<?php echo esc_attr( $i ); ?>]" min="0" step="any" /> 
			</td>
		</tr>
		<tr>
			<td>
				<label><input type="checkbox" class="checkbox attribute_custom_checkbox" <?php checked( $singleCheckbox, true ); ?> name="attribute_custom_checkbox[<?php echo esc_attr( $i ); ?>]" value="1" /> <?php esc_html_e( 'Do you want to display a "No" option?', 'woocommerce' ); ?>
			</td>
		</tr>
		<tr class="labeldiv">
			<td>
				<label><?php esc_html_e( '"No" Option Label:', 'woocommerce' ); ?><br>(default text is "No")</label>
				<input type="text" class="text" value="<?php echo $singleCheckbox_label; ?>" name="attribute_custom_checkbox_label[<?php echo esc_attr( $i ); ?>]" min="1" />
			</td>
		</tr>
		<?php
	}
}

add_filter('woocommerce_admin_meta_boxes_prepare_attribute','ips_woocommerce_admin_meta_boxes_prepare_attribute',10,3);
function ips_woocommerce_admin_meta_boxes_prepare_attribute($attribute, $data, $i){
	$terms = $data['attribute_names'];
	$i=0;
    foreach ($terms as $termvalue) {
    	$attribute_custom_price = $data['attribute_custom_price'][$i];
    	$attribute_custom_checkbox = $data['attribute_custom_checkbox'][$i];
    	$attribute_custom_checkbox_label = $data['attribute_custom_checkbox_label'][$i];
    	update_post_meta($_POST['post_id'], 'single_price_'.$termvalue, $attribute_custom_price); 
    	update_post_meta($_POST['post_id'], 'single_checkbox_'.$termvalue, $attribute_custom_checkbox);
    	update_post_meta($_POST['post_id'], 'single_checkbox_label_'.$termvalue, $attribute_custom_checkbox_label); 
		$i++;
    }
    return $attribute;
}

// save custom field for admin
function ips_save_custom_field( $post_id ) {
 	$terms = $_POST['attribute_names'];
	$i=0;
    foreach ($terms as $termvalue) {
    	$attribute_custom_price = $_POST['attribute_custom_price'][$i];
    	$attribute_custom_checkbox = $_POST['attribute_custom_checkbox'][$i];
    	$attribute_custom_checkbox_label = $_POST['attribute_custom_checkbox_label'][$i];
    	update_post_meta($post_id, 'single_price_'.$termvalue, $attribute_custom_price); 
    	update_post_meta($post_id, 'single_checkbox_'.$termvalue, $attribute_custom_checkbox);
    	update_post_meta($post_id, 'single_checkbox_label_'.$termvalue, $attribute_custom_checkbox_label); 
		$i++;
    }
}
add_action( 'woocommerce_process_product_meta', 'ips_save_custom_field', 99 );

// custom js for admin
function custom_admin_js() {
    ?>
    <script type="text/javascript">
    	$( document ).ready(function() {
    		$('.woocommerce_attribute_data').each(function() {
    			if ( $(this).find('input.attribute_custom_checkbox').attr('checked') ) {
    				$(this).find('.labeldiv').show();
    			}	else{
    				$(this).find('.labeldiv').hide();
    			}		  
			});
			$('.woocommerce_attribute_data input.attribute_custom_checkbox').on('change', function () {
			    $(this).closest('div').find('.labeldiv').toggle();
			});
    	});
    </script>
    <?php
}
add_action('admin_footer', 'custom_admin_js', 10);


// Create the section for color attribute images the products tab
// First Register the Tab by hooking into the 'woocommerce_product_data_tabs' filter
add_filter( 'woocommerce_product_data_tabs', 'add_my_custom_product_data_tab' );
function add_my_custom_product_data_tab( $product_data_tabs ) {
    $product_data_tabs['attribute-custom-tab'] = array(
        'label' => __( 'Color Images', 'woocommerce' ),
        'target' => 'custom_product_data_color',
        'class'     => array( 'show_if_simple' ),
    );
    return $product_data_tabs;
}

//CSS To Add Custom tab Icon
add_action( 'admin_head', 'ips_admin_custom_style' );
function ips_admin_custom_style() {?>
	<style>
	#woocommerce-product-data ul.wc-tabs li.attribute-custom-tab_options a:before { font-family: WooCommerce; content: '\e006'; }
	.attribute_image_field input {margin-right: 1%;width: 100%;margin-bottom: 2%;}
	.imagewrap{display: inline-block;float: left;padding: 5px 20px 5px 162px!important}
	.labelcustom{float: left;clear: both;margin-right: 10px;}
	.custom_delete_btn{top: 0;right: 7px;padding: 2px;z-index: 9999;display: block;text-indent: -9999px;position: relative;height: 1em;width: 1em;font-size: 1.4em;}
	.custom_attr_img{width: 80px;float: left;border: 1px solid #d5d5d5;margin: 9px 9px 0 0;}
	a.custom_delete_btn:before {font-family: Dashicons;speak: none;font-weight: 400;text-transform: none;-webkit-font-smoothing: antialiased;text-indent: 0px;position: absolute;top: 0px;text-align: center;content: "\f335";color: #fff;height: 1em;width: 1em;font-variant: normal;margin: 0px;background: #999;border-radius: 50%;right: 0;}
	a.custom_delete_btn:hover:before{background: red;}
	.imagewrap input.button {margin-left: 3px;}
	#woocommerce-order-items .woocommerce_order_items_wrapper table.woocommerce_order_items table.display_meta tr th{width: 35%}
	</style>
<?php 
}

// Create fields for sku, title and image for color attribute
add_action('woocommerce_product_data_panels', 'ips_custom_product_data_fields');
function ips_custom_product_data_fields() {
	// Note the 'id' attribute needs to match the 'target' parameter set above
	?>
	<div id='custom_product_data_color'class='panel woocommerce_options_panel'>
	    <?php
	    global $post;
	    $product = wc_get_product($post->ID);
	    if( $product->is_type( 'simple' ) ){
		    $attributes = $product->get_attributes();
		    $args      = array(
				'orderby'    => 'name',
				'hide_empty' => 0,
			);
			foreach ($attributes as $attribute) {
				if($attribute->get_taxonomy() == "pa_colors") {
					$options = $attribute->get_options();
					$all_terms = get_terms( $attribute->get_taxonomy(), apply_filters( 'woocommerce_product_attribute_terms', $args ) );
					if ( $all_terms ) {
						$i=0;
						foreach ( $all_terms as $term ) {
							$options = $attribute->get_options();
							$options = ! empty( $options ) ? $options : array();
							if(in_array($term->term_id, $options)){
								$label = esc_attr( apply_filters( 'woocommerce_product_attribute_term_name', $term->name, $term ) );
								$appendIDs = '_'.$term->term_id.'_'.$post->ID;
								$attribute_color_sku = get_post_meta($post->ID, 'attribute_color_sku'.$appendIDs, true);
								$attribute_color_title = get_post_meta($post->ID, 'attribute_color_title'.$appendIDs, true);
								$color_attribute_image = get_post_meta($post->ID, 'color_attribute_image'.$appendIDs, true);
								?>
								<div class="options_group">
									<p class="form-field attribute_image_field">
										<label for="attribute_image"><?php echo $label; ?></label>
										<span class="wrap">
											<strong class="labelcustom">Image SKU</strong>
											<input id="attribute_color_sku" placeholder="Image SKU" class="input-text" type="text" name="attribute_color_sku<?php echo $appendIDs; ?>" value="<?php if($attribute_color_sku != "") { echo $attribute_color_sku; }?>">
											<strong class="labelcustom">Image Title</strong>
											<input placeholder="Image Title" class="input-text" type="text" name="attribute_color_title<?php echo $appendIDs; ?>" value="<?php if($attribute_color_title != "") { echo $attribute_color_title; }?>">
										
									
									<div class="imagewrap">
										<!-- start image tag -->
										<strong class="labelcustom">Upload Image</strong>
										<input name="color_attribute_image<?php echo $appendIDs; ?>" id="color_attribute_image" type="text" class="color-meta-image<?php echo $i; ?> regular-text" value="<?php if($color_attribute_image != "") { echo $color_attribute_image; }?>">
										<input type="button" class="button color_attribute_image_upload<?php echo $i; ?>" value="Browse">
										
										<span class="color-image-preview<?php echo $i; ?>">
										<?php if($color_attribute_image != "") { ?>
											<img src="<?php echo $color_attribute_image; ?>" class="custom_attr_img">
											<a href="javascript:void(0)" class="custom_delete_btn custom_delete<?php echo $i; ?>" title="Delete image">Delete</a>
										<?php } ?>
										</span>
										
										<!-- end image tag -->
									</div>
									</p>
									</span>
								</div>
								<?php
							} else{
								$i--;
							}
						$i++;
						}
					}
				}
			}
		}
    	?>
    </div>
	<script>
	    jQuery(document).ready(function ($) {

	    	$( "#custom_product_data_color .options_group" ).each(function( index ) {
	    		// remove image
	    		$(".custom_delete"+index).on('click', function(e) { 
	    			e.preventDefault();
	    			if (confirm('Are you sure you want to remove image?')) {
					    var current_image = $(this).parent().parent().children('.color-meta-image'+index);    		
		    			current_image.removeAttr('value');
		    			$(this).prev("img").remove();
		    			$(this).remove();
					} else {
					    // Do nothing!
					}	    			
	    		});
		      // Instantiates the variable that holds the media library frame.
		      var meta_image_frame;
		      // Runs when the image button is clicked.
		      $('.color_attribute_image_upload'+index).click(function (e) {
		        // Get preview pane
		        var meta_image_preview = $(this).next('span .color-image-preview'+index);
		        // Prevents the default action from occuring.
		        e.preventDefault();
		        var meta_image = $(this).parent().children('.color-meta-image'+index);
		        // If the frame already exists, re-open it.
		        if (meta_image_frame) {
		          meta_image_frame.open();
		          return;
		        }
		        // Sets up the media library frame
		        meta_image_frame = wp.media.frames.meta_image_frame = wp.media({
		          title: meta_image.title,
		          button: {
		            text: meta_image.button
		          }
		        });
		        // Runs when an image is selected.
		        meta_image_frame.on('select', function () {
		          // Grabs the attachment selection and creates a JSON representation of the model.
		          var media_attachment = meta_image_frame.state().get('selection').first().toJSON();
		          // Sends the attachment URL to our custom image input field.
		          meta_image.val(media_attachment.url);
		          meta_image_preview.children('img').attr('src', media_attachment.url);
		        });
		        // Opens the media library frame.
		        meta_image_frame.open();
		      });
		  });
	    });
	</script>
	<?php
}

// Hook callback function to save custom fields information
add_action( 'woocommerce_process_product_meta_simple', 'woocom_save_proddata_custom_fields'  );
function woocom_save_proddata_custom_fields($post_id) {
    $product = wc_get_product($post_id);
    if( $product->is_type( 'simple' ) ){
	    $attributes = $product->get_attributes();
	    $args      = array(
			'orderby'    => 'name',
			'hide_empty' => 0,
		);
		foreach ($attributes as $attribute) {
			if($attribute->get_taxonomy() == "pa_colors") {
				$options = $attribute->get_options();
				$all_terms = get_terms( $attribute->get_taxonomy(), apply_filters( 'woocommerce_product_attribute_terms', $args ) );
				if ( $all_terms ) {
					foreach ( $all_terms as $term ) {
						$appendIDs = '_'.$term->term_id.'_'.$post_id;
						$options = $attribute->get_options();
						$options = ! empty( $options ) ? $options : array();
						if(in_array($term->term_id, $options)){
							
							$attribute_color_title = $_POST['attribute_color_title'.$appendIDs];
						    
						    update_post_meta($post_id, 'attribute_color_title'.$appendIDs, esc_attr($attribute_color_title));
						  
						    $attribute_color_sku = $_POST['attribute_color_sku'.$appendIDs];
						  
						    update_post_meta($post_id, 'attribute_color_sku'.$appendIDs, esc_attr($attribute_color_sku));
						  
						    $attribute_color_sku = $_POST['color_attribute_image'.$appendIDs];
						   
						    update_post_meta($post_id, 'color_attribute_image'.$appendIDs, esc_attr($attribute_color_sku));
						}
					}
				}
			}
		}
	}
}



/*Front Changes*/

// add content before cart button
add_action( 'woocommerce_before_add_to_cart_button', 'select_attributes_custom_action', 9 );
function select_attributes_custom_action() {
	global $product;
	if( $product->is_type( 'simple' ) ){
		wc_get_template( 'single-product/select-product-attributes.php', array(
			'product'            => $product,
			'attributes'         => array_filter( $product->get_attributes(), 'wc_attributes_array_filter_visible' ),
			'display_dimensions' => apply_filters( 'wc_product_enable_dimensions_display', $product->has_weight() || $product->has_dimensions() ),
		) );
	}
}

// get product price
add_action("wp_ajax_load_data", "customcount_ajaxcall",99);
add_action("wp_ajax_nopriv_load_data", "customcount_ajaxcall",99);
function customcount_ajaxcall() {
	$product = wc_get_product($_POST['productId']);
	$product_price = $product->get_price();	
	$total = get_price_total($_POST,$product_price,$_POST['productId']);	
  	echo wc_price($total);
  	die();
}
/*
 * @desc Remove quantity selector in all product type
 */
/*function remove_all_quantity_fields( $return, $product ) {
    return true;
}
add_filter( 'woocommerce_is_sold_individually', 'remove_all_quantity_fields', 10, 2 );*/

// add custom data to cart and add every item as individual
add_filter( 'woocommerce_add_cart_item_data', 'add_cart_item_data', 10, 3 );
function add_cart_item_data( $cart_item_data, $product_id, $variation_id ) {
	// @desc Force individual cart item
	$unique_cart_item_key = md5( microtime().rand() );
  	$cart_item_data['unique_key'] = $unique_cart_item_key;

	$product = wc_get_product( $product_id );
	$product_price = $product->get_price();
	$total = get_price_total($_POST,$product_price,$product_id);

	if(isset($total)){
		$product = wc_get_product( $product_id );
		$price = $product->get_price();
	 	// Store the overall price for the product, including the cost of the attributes
		$cart_item_data['custom_attributes_price'] = $total;
		$cart_item_data['custom_attribute_list'] = $_POST;

		return $cart_item_data;
	}	 
}


// common function to get total price
function get_price_total($data,$product_price,$product_id){
	$total = 0;
	if($data['attribute_pa_colors'] != ""){
		if($data['attribute_pa_colors'] == "no"){
			$color_price = "";
		} else {
			$color_price = get_post_meta($product_id,'single_price_pa_colors' ,true);
		}
	}
	if($data['attribute_pa_choose-heading-style'] != ""){
		if($data['attribute_pa_choose-heading-style'] == "no"){
			$headingstyle_price = "";
		} else {
			$headingstyle_price = get_post_meta($product_id, 'single_price_pa_choose-heading-style' ,true);
		}		
	}
	if($data['attribute_pa_measurement-type'] != ""){
		if($data['attribute_pa_measurement-type'] == "no"){
			$measurement_price = "";
		} else {
			$measurement_price = get_post_meta($product_id, 'single_price_pa_measurement-type' ,true);
		}
	}
	if($data['attribute_pa_sheer-curtain'] != ""){
		if($data['attribute_pa_sheer-curtain'] == "no"){
			$sheer_price = "";
		} else {
			$sheer_price = get_post_meta($product_id, 'single_price_pa_sheer-curtain' ,true);
		}		
	}
	if($data['attribute_pa_lining'] != ""){
		if($data['attribute_pa_lining'] == "no"){
			$lining_price = "";
		} else {
			$lining_price = get_post_meta($product_id, 'single_price_pa_lining' ,true);
		}
	}
	if($data['attribute_pa_valance'] != ""){
		if($data['attribute_pa_valance'] == "no"){
			$valance_price = "";
		} else {
			$valance_price = get_post_meta($product_id, 'single_price_pa_valance' ,true);
		}		
	}
	if($data['attribute_pa_tie-back'] != ""){
		if($data['attribute_pa_tie-back'] == "no"){
			$tieback_price = "";
		} else {
			$tieback_price = get_post_meta($product_id, 'single_price_pa_tie-back' ,true);
		}
	}
	if($data['panel-size-width'] != ""){
		if($data['panel-size-width'] == 0){
			$data['panel-size-width'] = 1;
		}
		$customPrice_valance = ((float)$data['panel-size-width'] * (float)$valance_price);
		$customPrice_sheercurtain = ((float)$data['panel-size-width'] * (float)$sheer_price);
		$customPrice_lining = ((float)$data['panel-size-width'] * (float)$lining_price);
		$customPrice_product_price = ((float)$data['panel-size-width'] * (float)$product_price);

		$total = ((float)$customPrice_product_price + (float)$color_price + (float)$headingstyle_price + (float)$measurement_price + (float)$customPrice_sheercurtain + (float)$customPrice_lining + (float)$customPrice_valance +  (float)$tieback_price);
	} elseif ($data['window-width'] != "") {
		$data['window-width']=(float)$data['window-width']+8;
		if($data['window-width'] == 0){
			$data['window-width'] = 1;
		}
		$customPrice_valance = ((float)$data['window-width'] * (float)$valance_price);
		$customPrice_sheercurtain = ((float)$data['window-width'] * (float)$sheer_price);
		$customPrice_lining = ((float)$data['window-width'] * (float)$lining_price);
		$customPrice_product_price = ((float)$data['window-width'] * (float)$product_price);

		$total = ((float)$customPrice_product_price + (float)$color_price + (float)$headingstyle_price + (float)$measurement_price + (float)$customPrice_sheercurtain + (float)$customPrice_lining + (float)$customPrice_valance +  (float)$tieback_price);
	} else {
		$total = ((float)$product_price + (float)$color_price + (float)$headingstyle_price + (float)$measurement_price + (float)$sheer_price + (float)$lining_price + (float)$valance_price +  (float)$tieback_price);
	}
	return $total;
}

// set price for cart for each item
add_action( 'woocommerce_before_calculate_totals', 'before_calculate_totals', 10, 1 );
function before_calculate_totals( $cart_obj ) {
	if ( is_admin() && ! defined( 'DOING_AJAX' ) ) {
	 	return;
	}
 	// Iterate through each cart item
	foreach( $cart_obj->get_cart() as $key=>$value ) {
		if( isset( $value['custom_attributes_price'] ) ) {
		 	$price = $value['custom_attributes_price'];
		 	$value['data']->set_price( ( $price ) );
		}
	}
}

// Remove the additional information tab
function woo_remove_product_tabs( $tabs ) {
    unset( $tabs['additional_information'] );
    return $tabs;
}
add_filter( 'woocommerce_product_tabs', 'woo_remove_product_tabs', 98 );


// Move price in single page
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10, 2);
add_action( 'woocommerce_before_add_to_cart_quantity', 'ips_move_price_bottom_singlepage', 98 );
function ips_move_price_bottom_singlepage() {
	global $product;
	?><p class="customprice price"><?php echo $product->get_price_html(); ?></p>
<?php }

// define the woocommerce_cart_item_name callback to list selected attributes for cart and checkout page
add_filter('woocommerce_cart_item_name','ips_cart_single_item', 99, 3);
function ips_cart_single_item($product_name, $cart_item, $cart_item_key )   {
	$custom_attribute_list = $cart_item['custom_attribute_list'];
	echo $product_name; 
	ips_list_selected_attributes($custom_attribute_list);
}

// common function to get attributes for cart and checkout page
function ips_list_selected_attributes($custom_attribute_list){
	global $wpdb;
	foreach ($custom_attribute_list as $key => $value) {
		if($value != "" && $key != "quantity" && $key != "add-to-cart") {
			if (strpos($key, 'attribute_') !== false) {

				$tax = str_replace("attribute_", "", $key);
				$term = get_term_by('slug', $value, $tax);

				$attribute_name = str_replace("attribute_pa_", "", $key);
				$select_tax_name_query = "SELECT * FROM `wp_woocommerce_attribute_taxonomies` WHERE attribute_name='".$attribute_name."'";
				$myrows = $wpdb->get_row($select_tax_name_query);	
				if($term->name == ""){
					echo '<p>'.$myrows->attribute_label. ': No</p>';
				}else{
					echo '<p>'.$myrows->attribute_label. ': ' .$term->name.'</p>';
				}
			} else{	
				if($key == "panel-size-width"){
					$label = "Curtain Rod Width";
				} else if($key == "panel-size-length"){
					$label = "Curtain Length";
				} else if($key == "window-height"){
					$label = "Window height";
				} else if($key == "height-above-floor"){
					$label = "Height above floor";
				} else if($key == "window-width"){
					$label = "Window Width";
				} else if($key == "floor-height"){
					$label = "Floor Height";
				} else if($key == "imageSKU"){
					$label = "";
					$value = "";
				}
				if($label != ""){
					echo '<p>'.ucfirst($label). ' : ' .$value.' inches</p>';
				}
			}
		}
	}
}

// get selected color image into cart page
add_filter( 'woocommerce_cart_item_thumbnail', 'custom_new_product_image', 10, 3 );
function custom_new_product_image( $_product_img, $cart_item, $cart_item_key ) {
	$custom_attribute_list = $cart_item['custom_attribute_list'];
	if($custom_attribute_list['colorImage'] != ""){
    	$product_colorImg = '<img src="'.$custom_attribute_list['colorImage'].'" width="32" />';
 	   return $product_colorImg;
	} else{
		return $_product_img;
	}
}

//Add custom data as Metadata to Order Items table
add_action( 'woocommerce_checkout_create_order_line_item', 'ips_add_custom_text_to_order_items', 10, 4 );
function ips_add_custom_text_to_order_items( $item, $cart_item_key, $values, $order ) {
	if ( empty( $values['custom_attribute_list'] ) ) {
		return;
	}
	foreach ($values['custom_attribute_list'] as $key => $value) {
    	if($value != "" && $key != "quantity" && $key != "add-to-cart") {
    		$item->add_meta_data($key, $value);
    	}
    }	
}

// define the woocommerce_order_item_get_formatted_meta_data callback for display meta in admin/email/order-review page
add_filter( 'woocommerce_order_item_get_formatted_meta_data', 'filter_woocommerce_order_item_get_formatted_meta_data', 10, 2 );
function filter_woocommerce_order_item_get_formatted_meta_data( $formatted_meta, $instance ) {

	$new_meta = array();
	foreach ( $formatted_meta as $id => $meta_array ) {
        if ($meta_array->key == 'panel-size-width') { 
        	$meta_array->display_key = "Curtain Rod Width (inches)"; 
        }
        else if($meta_array->key == "panel-size-length"){
			$meta_array->display_key = 'Curtain Length (inches)';
		} else if($meta_array->key == 'window-height'){
			$meta_array->display_key = 'Window height (inches)';
		} else if($meta_array->key == 'height-above-floor'){
			$meta_array->display_key = 'Height above floor (inches)';
		} else if($meta_array->key == 'window-width'){
			$meta_array->display_key = 'Window Width (inches)';
		} else if($meta_array->key == 'floor-height'){
			$meta_array->display_key = 'Floor Height (inches)';
		} else if($meta_array->key == 'imageSKU'){
			$meta_array->display_key = 'Image SKU';
		} else if($meta_array->key == 'colorImage'){
			$meta_array->display_key = 'Color Image';
		}
        $new_meta[$id] = $meta_array;        
    }
	if(is_admin()){
	    return $new_meta; 
	} else{
		foreach ( $new_meta as $id => $meta_array ) {
			if( in_array( $meta_array->key, array('imageSKU', 'colorImage') ) ) {
           		unset($new_meta[$id]);
           	}
		}
		return $new_meta;
	} 
}