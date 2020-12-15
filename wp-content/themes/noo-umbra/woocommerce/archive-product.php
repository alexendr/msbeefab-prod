<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see 	    http://docs.woothemes.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header( 'shop' );



$shop_style = noo_umbra_get_option('noo_shop_width','fullwidth');
$shop_style_class = 'noo-container-shop noo-shop-wrap';
if( $shop_style == 'boxed' ){
    $shop_style_class = 'noo-container noo-shop-boxed noo-shop-wrap';
}

// config sidebar
$shop_sidebar = noo_umbra_get_option('noo_shop_layout_sidebar','no_sidebar');
$shop_sidebar_class = 'noo-md-12';
if( $shop_sidebar == 'right_sidebar' ){
    $shop_sidebar_class = 'noo-md-9';
}elseif( $shop_sidebar == 'left_sidebar' ){
    $shop_sidebar_class = 'noo-md-9 pull-right';
}

// style grid or list for product
$style_product = noo_umbra_get_option('noo_shop_default_layout','grid');
if( isset($_GET['filter_style']) && $_GET['filter_style'] != ''){
    $style_product = $_GET['filter_style'];
}

// style for product
$noo_style  = noo_umbra_get_option('noo_shop_default_style','style_1');
if( isset($_GET['product_style']) && $_GET['product_style'] != ''){
    $noo_style = $_GET['product_style'];
}
if( $noo_style == 'three' ){
    remove_action( 'woocommerce_before_shop_loop_item_title2', 'noo_umbra_template_loop_product_thumbnail', 10 );
    add_action( 'woocommerce_before_shop_loop_item_title2', 'noo_umbra_template_loop_product_thumbnail2', 10 );
}
?>

    <div class="<?php echo esc_html($shop_style_class); ?>">
        <?php
            /**
             * woocommerce_before_main_content hook.
             *
             * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
             * @hooked woocommerce_breadcrumb - 20
             */
            do_action( 'woocommerce_before_main_content' );
        ?>

		<?php if ( have_posts() ) : ?>
            <div class="noo-container-catalog">
                <div class="noo-catalog">
                    <?php
                        /**
                         * woocommerce_before_shop_loop hook.
                         *
                         * @hooked woocommerce_result_count - 20
                         * @hooked woocommerce_catalog_ordering - 30
                         * @hooked woocommerce_attribute_ordering - 35
                         */
                        do_action( 'woocommerce_before_shop_loop' );
                    ?>
                </div>
            </div>
            <div class="noo-row">

                <div class="<?php echo esc_attr($shop_sidebar_class) .' '. esc_attr($noo_style); ?>">

                    <?php woocommerce_product_loop_start(); ?>

                        <?php woocommerce_product_subcategories(); ?>
                            <?php if( $style_product == 'list' ): ?>

                                <?php while ( have_posts() ) : the_post(); ?>

                                    <?php wc_get_template_part( 'content', 'list' ); ?>

                                <?php endwhile; // end of the loop. ?>

                            <?php else:

                                    if( $noo_style == 'one' ):

                                     while ( have_posts() ) : the_post();

                                         wc_get_template_part( 'content', 'product' );

                                     endwhile; // end of the loop.

                                    else:

                                        while ( have_posts() ) : the_post();

                                            wc_get_template_part( 'content', 'product2' );

                                        endwhile; // end of the loop.

                                    endif; ?>

                            <?php endif; ?>

                    <?php woocommerce_product_loop_end(); ?>

                    <?php
                        /**
                         * woocommerce_after_shop_loop hook.
                         *
                         * @hooked woocommerce_pagination - 10
                         */
                        do_action( 'woocommerce_after_shop_loop' );
                    ?>

                    <?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>

                        <?php wc_get_template( 'loop/no-products-found.php' ); ?>

                    <?php endif; ?>

                    <?php
                        /**
                         * woocommerce_after_main_content hook.
                         *
                         * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
                         */
                        do_action( 'woocommerce_after_main_content' );
                    ?>

                </div>
                <?php
                if( $shop_sidebar != 'no_sidebar' ){
                    /**
                     * woocommerce_sidebar hook.
                     *
                     * @hooked woocommerce_get_sidebar - 10
                     */
                    do_action( 'woocommerce_sidebar' );
                }
                ?>
            </div>
      
    </div>
<?php get_footer( 'shop' ); ?>
