<?php
/*** Woocommerce Overrides ***/
function mytheme_add_woocommerce_support() {
	add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', 'mytheme_add_woocommerce_support' );

function my_theme_wrapper_start() {
  echo '
		<div id="main-body">
			<div id="content">
				<div class="container">
		';
}
function my_theme_wrapper_end() {
  echo '
				</div>
			</div>
		</div>
		';
}
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
add_action('woocommerce_before_main_content', 'my_theme_wrapper_start', 10);
add_action('woocommerce_after_main_content', 'my_theme_wrapper_end', 10);


/**
 * Custom variable price HTML.
 * Shows "Starting at" prefix with when min price is different from max price.
 *
 * @param stirng $price Product price HTML
 * @param WC_Product_Variable $product Product data.
 * @return string
 */
function cs_my_wc_custom_variable_price_html( $price, $product ) {
	$prices = $product->get_variation_prices( true );
	$min_price = current( $prices['price'] );
	$max_price = end( $prices['price'] );
	// Return price if min is equal to max.
	if ( $min_price === $max_price || $product->is_on_sale() ) {
		return $price;
	}
	return sprintf( __( 'Starts at %s', 'your-text-domain' ), wc_price( $min_price ) . $product->get_price_suffix() );
}
add_filter( 'woocommerce_variable_price_html', 'cs_my_wc_custom_variable_price_html', 10, 2 );
/*** End Woocommerce Overrides ***/