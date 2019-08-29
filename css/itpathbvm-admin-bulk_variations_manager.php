<?php
defined( 'ABSPATH' ) || exit;
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://itpathsolutions.com
 * @since      1.0.0
 *
 * @package    itpathbvm
 * @subpackage itpathbvm/admin/partials
 * @author     info <info@itpathsolutions.com>
 */

class bulk_variations_manager {

    public static function output() {

        if(isset($_POST['bvm_apply'])){
            self::process_update_variable_products();
        }

        $attributes = wc_get_attribute_taxonomies_terms();
        self::load_attribute_as_tree_view($attributes);

    }

    private static function process_update_variable_products(){
        check_admin_referer('Itpathbvm-update_variations');
        $terms = self::get_posted_terms();
        global $wpdb;

        foreach ($terms as $termkey => $termvalue) {
            if(isset($_POST['is_terms'])){
                if(in_array($termkey,array_keys($_POST['is_terms']))) { 
                    $wpdb->replace(
                          'itpathbvm',
                          array(
                              'name' => $termkey,
                              'price' => $termvalue,
                              'checked' => "1",
                              'dtime'=>date("Y/m/d h:i:sa")
                          )
                      );
                } else{
                    unset($terms[$termkey]);
                }
            } 
            
        }

        $id = wc_itpath_update_all_variation_product_price($terms,$_POST['product']);

        if ( is_wp_error( $id ) ) {
            return $id;
        }

        echo '<div class="updated"><p>' . __( 'variation updated successfully', 'itpathbvm' ) . '</p><p><a href="' . esc_url( admin_url( 'edit.php?post_type=product&amp;page=product_attributes' ) ) . '">' . __( 'Back to Attributes', 'itpathbvm' ) . '</a></p></div>';

        return true;

    }

    private static function get_posted_terms(){
        return $_POST['terms'];
    }

    protected static function load_attribute_as_tree_view($attributes){
        ?>

        <div class="wrap itpathbvm">
            <h1><?php esc_html_e( 'IPS bulk update variation prices', 'itpathbvm'); ?></h1>

            <div class="controls">
                <button id="Collepsed"><?php esc_html_e( 'Collepsed', 'itpathbvm'); ?></button>
                <button id="Expanded"><?php esc_html_e( 'Expanded', 'itpathbvm'); ?></button>
                <button id="Checked_All"><?php esc_html_e( 'Checked All', 'itpathbvm'); ?></button>
                <button id="Unchek_All"><?php esc_html_e( 'Unchek All', 'itpathbvm'); ?></button>
            </div>
            <?php //var_dump($attributes);?>    
            <form action="edit.php?post_type=product&amp;page=product_bulk_variations_manager" method="post">
                <table class="form-table">
                <?php $products = wc_get_products(['type' => 'variable']); ?>
                <tr>
                    <th scope="row"><label style="color:#000;"> <?php esc_html_e( 'Select Product', 'itpathbvm'); ?></label></th>
                    <td>
                        <select name="product">
                            <option value="-1"><?php esc_html_e( 'All Products', 'itpathbvm'); ?></option>
                            <?php foreach ($products as $product) { ?>
                            <option value="<?php echo $product->get_id();?>"><?php echo $product-> get_name();?></option>
                            <?php } ?>
                        </select>
                        <p class="description"><?php esc_html_e( 'Bulk operation applied on selected or all product(s).', 'itpathbvm'); ?></p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label><?php esc_html_e( 'Update Price', 'itpathbvm'); ?></label>
                     <p class="description" style="font-weight: initial;"><?php esc_html_e( 'This will update variation price based on their options.', 'itpathbvm'); ?></p>    
                    </th>
                    <td>
                        <ul class="tree">
                    <?php
                    global $wpdb;
                    $myrows = $wpdb->get_results( "SELECT name, price, checked FROM itpathbvm" );
                        
                        foreach ($attributes as $attribute){
                            $li = '';
                            $classHas = '';
                            if(count($attribute->WP_Terms) > 0){
                                $classHas = 'class=has';

                                $ul = '<ul>';
                                
                                foreach ($attribute->WP_Terms as $WP_Term){
                                    
                                    $xvalue = '';
                                    $yvalue = self::check_for_value('pa_'.$WP_Term->slug, $myrows);
                                    if($yvalue !== false){
                                        $xvalue = $yvalue;
                                    }
                                    $ul .= "<li class='has'> {$xy} <input type=\"checkbox\" name=\"is_terms[pa_{$WP_Term->slug}]\" value=\"$WP_Term->labal\" /> 
                                        <label> $WP_Term->name </label><input placeholder=\"price\" type=\"number\" min=0 name=\"terms[pa_{$WP_Term->slug}]\" value=\"$xvalue\" /></li>";
                                }
                                $ul .= '</ul>';
                            }
                            $li .= "<li $classHas> <input type=\"checkbox\" name=\"\" value=\"1\"/> <label> {$attribute->attribute_label} </label><input type=\"number\"/ min=0 placeholder=\"global price of attribute option \"> {$ul} </li>";
                            echo $li;

                        }
                    
                    ?>
                    
                </ul> 
                <p class="description"><?php esc_html_e( 'Price affect for product(s) who have combination of ticked options only.', 'itpathbvm'); ?></p>       
                    </td>
                </tr>

                </table>
                <input id="bvm_apply" name="bvm_apply" type="submit" class="button-primary" value="Apply">
                    <?php wp_nonce_field( 'Itpathbvm-update_variations' ); ?>
            </form>
        </div>
        <?php
    }

    public static function check_for_value($xvalue, $rows){
        foreach ($rows as $row) {
            if($row->name == $xvalue){
                return $row->price; 
            }
        }
        return false;
    }
}