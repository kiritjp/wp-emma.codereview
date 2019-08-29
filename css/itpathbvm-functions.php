<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * Stack of methods to invoke directly
 *
 * @package    itpathbvm
 * @subpackage itpathbvm/admin
 * @author     info <info@itpathsolutions.com>
 */

function wc_get_attribute_taxonomies_terms()
{
    $wc_attributes = wc_get_attribute_taxonomies();
    if (empty($wc_attributes)) {
        return false;
    }
    foreach ($wc_attributes as $wc_attribute) {
        $wc_attribute->WP_Terms = get_terms('pa_' . $wc_attribute->attribute_name);
    }
    return $wc_attributes;
}

function wc_itpath_update_all_variation_product_price(array $attributes_terms_price = [], $product = null)
{

    $args = ['type' => 'variable'];
    if (!is_null($product) && $product !== '-1') {
        $product = wc_get_product($product);
        wc_itpath_update_product_price($attributes_terms_price, $product);

    } else {
        $wc_variable_products = wc_get_products($args);
        foreach ($wc_variable_products as $product) {
            wc_itpath_update_product_price($attributes_terms_price, $product);
        }
    }
}

function wc_itpath_update_product_price(&$attributes_terms_price, $product)
{
    $variations = $product->get_children();
    foreach ($variations as $variation) {
        $variation_attributes = wc_get_product_variation_attributes($variation);
        $variation_price      = 0;
        foreach ($variation_attributes as $variation_attribute) {
            if (array_key_exists('pa_' . $variation_attribute, $attributes_terms_price)) {
                $variation_price += $attributes_terms_price['pa_' . $variation_attribute];
            }
        }

        update_post_meta($variation, '_regular_price', $variation_price);
        update_post_meta($variation, '_price', $variation_price);
        //update_post_meta( $variation, '_sale_price', $variations_price );
        wc_delete_product_transients($variation); // Clear/refresh the variation cache

    }
    $productId = $product->get_id();
    wc_delete_product_transients($productId);
}
