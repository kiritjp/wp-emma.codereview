<?php
/**
 * Product attributes
 *
 * Used by list_attributes() in the products class.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-attributes.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
global $wpdb;
global $post;
?>
<table class="single_shop_attributes">
	<?php foreach ( $attributes as $attribute ) :
	$hasno_option = get_post_meta($post->ID, 'single_checkbox_'.$attribute->get_name(), true);
	$hasno_option_label = get_post_meta($post->ID, 'single_checkbox_label_'.$attribute->get_name(), true);
	$color_attribute_image = get_post_meta($post->ID, 'color_attribute_image'.$appendIDs, true);
	 ?>
		<tr>
			<!-- <th><?php echo wc_attribute_label( $attribute->get_name() ); ?></th> -->
			<td <?php if($attribute->get_name() == "pa_colors") { echo 'colspan="2"'; } ?>><?php
				if ( $attribute->is_taxonomy() ) {
					$attribute_taxonomy = $attribute->get_taxonomy_object();
					$attribute_values = wc_get_product_terms( $product->get_id(), $attribute->get_name(), array( 'fields' => 'all' ) );
					if($attribute->get_name() == "pa_colors") {
						echo '<div id="picker_pa_colors" class="select swatch-control">';
						echo '<select id="'.$attribute->get_name().'" name="attribute_'.$attribute->get_name().'" data-attribute_name="attribute_'.$attribute->get_name().'">';
						echo '<option value="">'.wc_attribute_label( $attribute->get_name() ).'</option>';
							foreach ( $attribute_values as $attribute_value ) { ?>	
									<option value="<?php echo $attribute_value->slug; ?>"><?php echo $attribute_value->name; ?></option>
							<?php } 
						echo '</select>';
						
						foreach ( $attribute_values as $attribute_value ) {
							$appendIDs = '_'.$attribute_value->term_id.'_'.$post->ID;
							$attribute_color_title = get_post_meta($post->ID, 'attribute_color_title'.$appendIDs, true);
							$attribute_color_sku = get_post_meta($post->ID, 'attribute_color_sku'.$appendIDs, true);
							$color_attribute_image = get_post_meta($post->ID, 'color_attribute_image'.$appendIDs, true);
							$thumbnail_id = get_woocommerce_term_meta( $attribute_value->term_id, 'pa_colors_swatches_id_photo', true );
							$textureImg = wp_get_attachment_image_src( $thumbnail_id );
							echo '<div class="select-option swatch-wrapper" data-attribute="'.$attribute->get_name().'" data-value="'.$attribute_value->slug.'">';
							echo '<a href="#" style="width:32px;height:32px" class="swatch-anchor" data-image="'.$color_attribute_image.'" data-sku="'.$attribute_color_sku.'" data-title="'.$attribute_color_title.'">';
								echo '<img src="'.$color_attribute_image.'" alt="'.$attribute_color_title.'" title="'.$attribute_color_title.'" class="wp-post-image swatch-photo'.$attribute->get_name().'_swatches_id swatch-img">';
							echo '</a>';
							echo '</div>';
						}
						echo '</div>';
					}else{
						echo '<select id="'.$attribute->get_name().'" name="attribute_'.$attribute->get_name().'" required="required">';
						echo '<option value="">'.wc_attribute_label( $attribute->get_name() ).'</option>';
							foreach ( $attribute_values as $attribute_value ) { ?>	
									<option value="<?php echo $attribute_value->slug; ?>"><?php echo $attribute_value->name; ?></option>
							<?php } 
						if($hasno_option != "" || $hasno_option != NULL){ 
							if($hasno_option_label != "" || $hasno_option_label != NULL) { ?>
								<option value="no"><?php echo $hasno_option_label; ?></option> 
							<?php } else{ ?>
								<option value="no">No <?php echo wc_attribute_label( $attribute->get_name() ); ?></option> 
						<?php }
						}
						echo '</select>';
					}
				} ?>

			</td>
			<td class="whatsthis">
				<?php			
				$attributeName = str_replace("pa_", "", $attribute->get_name());
				$sql = "SELECT attribute_id FROM ".$wpdb->prefix."woocommerce_attribute_taxonomies WHERE attribute_name = '".$attributeName."'";
				$attribute_id = $wpdb->get_row($sql);

				if (!empty($attribute_id)) {
					$attributeData = get_option('product_attributes_image_'.$attribute_id->attribute_id); 
					if($attributeData['attribute_image'] != "") { ?>
						<a class="image-popup-vertical-fit" href="<?php echo $attributeData['attribute_image']; ?>" title="">What is this?</a>
					<?php }
				}
				?>
			</td>
			<?php if($attribute->get_name() == "pa_measurement-type") { ?>
				<tr class="panel-size" style="display: none;">
					<td><label>1. Curtain Rod Width (inches)</label></td>
					<td>
						<input type="number" name="panel-size-width" id="panel-size-width" min="1" max="90" maxlength="2">
					</td>					
				</tr>
				<tr class="panel-size" style="display: none;">
					<td><label>2. Curtain Length (inches)</label></td>
					<td>
						<input type="number" name="panel-size-length" id="panel-size-length" min="1" max="9999" maxlength="4">
					</td>
				</tr>
				<tr class="window-door-dimensions" style="display: none;">
					<td><label>1. Window height (inches)</label></td>
					<td>
						<input type="number" name="window-height" id="window-height" min="1" max="9999" maxlength="4">
					</td>
				</tr>
				<tr class="window-door-dimensions" style="display: none;">
					<td><label>2. Height above floor (inches)</label></td>
					<td>
						<input type="number" name="height-above-floor" id="height-above-floor" min="1" max="9999" maxlength="4">
					</td>
				</tr>
				<tr class="window-door-dimensions" style="display: none;">
					<td><label>3. Window Width (inches)</label></td>
					<td>
						<input type="number" name="window-width" id="window-width" min="1" max="90" maxlength="2">
					</td>
				</tr>
				<tr class="window-door-dimensions" style="display: none;">
					<td><label>4. Floor Height (inches)</label></td>
					<td>
						<input type="number" name="floor-height" id="floor-height" min="1" max="9999" maxlength="4">
					</td>
				</tr>
			<?php } ?>

		</tr>
		<input type="hidden" name="imageSKU" class="color_imageSKU" value="">
		<input type="hidden" name="colorImage" class="color_imageSRC" value="">
	<?php endforeach; ?>
</table>
