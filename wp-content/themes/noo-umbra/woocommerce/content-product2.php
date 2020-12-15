<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see     http://docs.woothemes.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

global $product;

// Ensure visibility
if ( ! $product || ! $product->is_visible() ) {
    return;
}

// Increase loop count

$noo_columns = noo_umbra_get_option('noo_shop_grid_column',5);
if( is_product() ){
    $noo_columns = 5;
}
// Extra post classes
$classes = array();
$classes[] = 'noo-product-item noo-product-sm-'.$noo_columns;
$noo_featured = noo_umbra_get_post_meta(get_the_ID(),'_featured');

if( isset($noo_featured) && $noo_featured == 'yes' ){
    $classes[] = 'noo_featured';
}else{
    $classes[] = 'not_featured';
}

?>
<div <?php post_class( $classes ); ?>>
    <div class="noo-product-inner noo-product-inner2">
        <?php
        /**
         * woocommerce_before_shop_loop_item hook.
         *
         * @hooked woocommerce_template_loop_product_link_open - 10
         */
        do_action( 'woocommerce_before_shop_loop_item' );

        /**
         * woocommerce_before_shop_loop_item_title hook.
         *
         * @hooked woocommerce_show_product_loop_sale_flash - 10
         * @hooked woocommerce_template_loop_product_thumbnail - 10
         */
        do_action( 'woocommerce_before_shop_loop_item_title2' );


        /**
         * woocommerce_shop_loop_item_title hook.
         *
         * @hooked woocommerce_template_loop_product_title - 10
         */
        echo '<h3><a href="'.get_the_permalink().'">'.get_the_title().'</a></h3>';

        /**
         * woocommerce_after_shop_loop_item_title hook.
         *
         * @hooked woocommerce_template_loop_rating - 5
         * @hooked woocommerce_template_loop_price - 10
         */
        echo '<div class="shop-loo-after-item">';
        do_action( 'woocommerce_after_shop_loop_item_title2' );
        echo '</div>';

        echo '<div class="noo-loop-cart">';
        /**
         * woocommerce_after_shop_loop_item hook.
         *
         * @hooked woocommerce_template_loop_product_link_close - 5
         * @hooked woocommerce_template_loop_add_to_cart - 10
         */
        do_action( 'woocommerce_after_shop_loop_item' );
        echo '</div>';
        ?>
    </div><!--end .noo-product-inner-->
</div>
