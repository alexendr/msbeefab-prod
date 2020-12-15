<?php
/**
 * Theme functions for NOO Framework.
 * This file include the framework functions, it should remain intact between themes.
 * For theme specified functions, see file functions-<theme name>.php
 *
 * @package    NOO Framework
 * @version    1.0.0
 * @author     Kan Nguyen <khanhnq@nootheme.com>
 * @copyright  Copyright (c) 2014, NooTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://nootheme.com
 */

// Set global constance



if ( !defined( 'NOO_THEME_NAME' ) ) {
    define( 'NOO_THEME_NAME', 'noo-umbra' );
}

if ( !defined( 'NOO_WOOCOMMERCE_EXIST' ) ) define( 'NOO_WOOCOMMERCE_EXIST', class_exists( 'WC_API' ) );

// Initialize NOO Libraries
if ( ! class_exists( 'Noo_Umbrar_Core' ) ) :

require_once get_template_directory() . '/includes/libs/noo-theme.php';
require_once get_template_directory() . '/includes/libs/noo-layout.php';
require_once get_template_directory() . '/includes/libs/noo-post-type.php';
require_once get_template_directory() . '/includes/libs/noo-css.php';
require_once get_template_directory() . '/includes/libs/noo-customize.php';

endif;

// Theme setup
require_once get_template_directory() . '/includes/theme_setup.php';

//
// Customize
//
if ( class_exists( 'Noo_Umbra_Core' ) ) :

require_once get_template_directory() . '/includes/customizer/options.php';

endif;

//
// Plugins
// First we'll check if there's any plugins inluded
//
require_once get_template_directory() . '/includes/class-tgm-plugin-activation.php';
require_once get_template_directory() . '/plugins/tgmpa_register.php';

//
// Enqueue assets
//

function noo_umbra_fonts_url() {
    // Enqueue Fonts.

    $body_font_family     = noo_umbra_get_theme_default( 'font_family' );
    $headings_font_family = noo_umbra_get_theme_default( 'headings_font_family' );
    $nav_font_family      = noo_umbra_get_theme_default( 'nav_font_family' );
    $logo_font_family     = noo_umbra_get_theme_default( 'logo_font_family' );
    $fonts_url = '';
    $subsets   = 'latin,latin-ext';

    $font_families = array();


    $noo_typo_use_custom_fonts     = noo_umbra_get_option( 'noo_typo_use_custom_fonts', false );
    $nav_custom_font                   = noo_umbra_get_option( 'noo_header_custom_nav_font', false );
    $use_image_logo                    = noo_umbra_get_option( 'noo_header_use_image_logo', false );

    $body_trans     =   _x('on', 'Body font: on or off','noo-umbra');

    $heading_trans  =   _x('on', 'Heading font: on or off','noo-umbra');

    $nav_trans      =   _x('on', 'Nav font: on or off','noo-umbra');

    $logo_trans     =   _x('on', 'Logo font: on or off','noo-umbra');

    if( $noo_typo_use_custom_fonts != false) {
        $headings_font_family   = noo_umbra_get_option( 'noo_typo_headings_font', noo_umbra_get_theme_default( 'headings_font_family' ) );
    }

    if( $noo_typo_use_custom_fonts != false) {
        $body_font_family       = noo_umbra_get_option( 'noo_typo_body_font', noo_umbra_get_theme_default( 'font_family' ) );
    }

    if( $nav_custom_font != false) {
        $nav_font_family    = noo_umbra_get_option( 'noo_header_nav_font', noo_umbra_get_theme_default( 'font_family' ) );
    }

    if( $use_image_logo == false) {
        $logo_font_family   = noo_umbra_get_option( 'noo_header_logo_font', noo_umbra_get_theme_default( 'headings_font_family' ) );
    }


    if ( 'off' !== $body_trans ) {
        $font_families[] = $body_font_family . ':' . '100,300,400,500,600,700,900,300italic,400italic,700italic,900italic';

    }

    if ( 'off' !== $heading_trans ) {

        $font_families[] = $headings_font_family . ':' . '100,300,400,500,600,700,900,300italic,400italic,700italic,900italic';

    }

    if ( 'off' !== $nav_trans && $nav_custom_font != false) {

        $font_families[] = $nav_font_family . ':'      . '100,300,400,500,600,700,900,300italic,400italic,700italic,900italic';

    }

    if ( 'off' !== $logo_trans && $use_image_logo == false && !empty($logo_font_family)) {

        $font_families[] = $logo_font_family . ':' . '100,300,400,500,600,700,900,300italic,400italic,700italic,900italic';

    }

    $subset = _x( 'no-subset', 'Add new subset (greek, cyrillic, devanagari, vietnamese)', 'noo-umbra' );

    if ( 'cyrillic' == $subset ) {
        $subsets .= ',cyrillic,cyrillic-ext';
    } elseif ( 'greek' == $subset ) {
        $subsets .= ',greek,greek-ext';
    } elseif ( 'devanagari' == $subset ) {
        $subsets .= ',devanagari';
    } elseif ( 'vietnamese' == $subset ) {
        $subsets .= ',vietnamese';
    }

    if ( $font_families ) {
        $fonts_url = add_query_arg( array(
            'family' => urlencode( implode( '|', $font_families ) ),
            'subset' => urlencode( $subsets ),
        ), 'https://fonts.googleapis.com/css' );
    }
    return esc_url_raw( $fonts_url );

}

function noo_umbra_enqueue_scripts(){
    if ( ! is_admin() ) {

        if( is_file( noo_umbra_upload_dir() . '/custom.css' ) ) {
            wp_register_style( 'noo-custom-style', noo_umbra_upload_url() . '/custom.css', NULL, NULL, 'all' );
        }

        // Vendors
        // Font Awesome
        wp_register_style( 'font-awesome', get_template_directory_uri() . '/assets/vendor/fontawesome/css/font-awesome.min.css',array(),'4.2.0');
        wp_enqueue_style( 'font-awesome' );

          // Font Awesome
        wp_register_style( 'elegantIcons', get_template_directory_uri() . '/assets/vendor/font-elegant/style.css',array());
        wp_enqueue_style( 'elegantIcons' );
        

        // Carousel

        wp_register_style( 'owl_carousel',  get_template_directory_uri() . '/assets/css/owl.carousel.css', NULL, NULL, 'all');
        wp_register_style( 'owl_theme',  get_template_directory_uri() . '/assets/css/owl.theme.css', NULL, NULL, 'all');
        wp_enqueue_style('owl_carousel');
        wp_enqueue_style('owl_theme');

        wp_enqueue_style( 'noo-umbra-fonts', noo_umbra_fonts_url(), array(), null );

        wp_enqueue_style( 'noo-css', get_template_directory_uri() . '/assets/css/noo.css', array(), NULL, NULL);

        // Main style
        wp_enqueue_style( 'noo-style', get_stylesheet_directory_uri() . '/style.css', NULL, NULL, 'all' );



        if( ! noo_umbra_get_option('noo_use_inline_css', false) && wp_style_is( 'noo-custom-style', 'registered' ) ) {
            global $wp_customize;
            if ( !isset( $wp_customize ) ) {
              wp_enqueue_style( 'noo-custom-style' );
            }
        }


        // Main script

        wp_register_script( 'countdown-plugin', get_template_directory_uri() . '/assets/vendor/countdown/jquery.plugin.min.js', array( 'jquery' ), null, true );
        wp_register_script( 'countdown-js', get_template_directory_uri() . '/assets/vendor/countdown/jquery.countdown.min.js', array( 'jquery' ), null, true );

        // vendor script
        wp_register_script( 'modernizr', get_template_directory_uri() . '/assets/vendor/modernizr-2.7.1.min.js', null, null, false );

        wp_register_script( 'imagesloaded', get_template_directory_uri() . '/assets/vendor/imagesloaded.pkgd.min.js', null, null, true );
        wp_register_script( 'isotope', get_template_directory_uri() . '/assets/vendor/jquery.isotope.min.js', array('imagesloaded'), null, true );
        wp_register_script( 'masonry', get_template_directory_uri() . '/assets/vendor/masonry.pkgd.min.js', array('imagesloaded'), null, true );
        wp_register_script( 'infinitescroll', get_template_directory_uri() . '/assets/vendor/infinitescroll-2.0.2.min.js', null, null, true );

        wp_register_script( 'touchSwipe', get_template_directory_uri() . '/assets/vendor/jquery.touchSwipe.js', array( 'jquery' ), null, true );
        wp_register_script( 'carouFredSel', get_template_directory_uri() . '/assets/vendor/carouFredSel/jquery.carouFredSel-6.2.1-packed.js', array( 'jquery', 'touchSwipe','imagesloaded' ), null, true );

        wp_register_script( 'jplayer', get_template_directory_uri() . '/assets/vendor/jplayer/jplayer-2.5.0.min.js', array( 'jquery' ), null, true );
        wp_register_script( 'nivo-lightbox', get_template_directory_uri() . '/assets/vendor/nivo-lightbox/nivo-lightbox.min.js', array( 'jquery' ), null, true );
        wp_register_script( 'fancybox-lightbox', get_template_directory_uri() . '/assets/vendor/fancybox-lightbox/source/jquery.fancybox.pack.js', array( 'jquery' ), null, true );

        wp_register_script( 'parallax', get_template_directory_uri() . '/assets/vendor/jquery.parallax-1.1.3.js', array( 'jquery'), null, true );


        wp_register_script( 'carousel', get_template_directory_uri() . '/assets/js/owl.carousel.min.js', array( 'jquery'), null, true );

        wp_register_script( 'noo-script', get_template_directory_uri() . '/assets/js/noo.js', array( 'jquery' ), null, true );

        wp_enqueue_script( 'modernizr' );

        wp_register_script( 'magnific-popup', get_template_directory_uri() . '/assets/vendor/magnific-popup/jquery.magnific-popup.min.js', array( 'jquery' ), null, true );
        wp_enqueue_script( 'magnific-popup' );

        wp_register_style( 'magnific-popup', get_template_directory_uri() . '/assets/vendor/magnific-popup/magnific-popup.css',array(),'1.0');
        wp_enqueue_style( 'magnific-popup' );

        // Required for nested reply function that moves reply inline with JS
        if ( is_singular() ) wp_enqueue_script( 'comment-reply' );

        $is_shop                = NOO_WOOCOMMERCE_EXIST && is_shop();
        $nooL10n = array(
            'ajax_url'        => admin_url( 'admin-ajax.php', 'relative' ),
            'ajax_finishedMsg'=> esc_html__('All posts displayed', 'noo-umbra'),
            'home_url'        => home_url( '/' ),
            'is_blog'         => is_home() ? 'true' : 'false',
            'is_archive'      => is_post_type_archive('post') ? 'true' : 'false',
            'is_single'       => is_single() ? 'true' : 'false',
            'is_shop'         => NOO_WOOCOMMERCE_EXIST && is_shop() ? 'true' : 'false',
            'is_product'      => NOO_WOOCOMMERCE_EXIST && is_product() ? 'true' : 'false',
            'infinite_scroll_end_msg' => esc_html__( 'All posts displayed', 'noo-umbra'),
            'cart_url' => ( NOO_WOOCOMMERCE_EXIST ) ?  esc_url( wc_get_cart_url() ) : '',
            'show_added_popup' => ( noo_umbra_get_option('noo_shop_show_popup_added', false)) ? 'yes' : 'no',
            'added_to_cart' => esc_html__('Product was successfully added to your cart.', 'noo-umbra'),
            'continue_shopping' => esc_html__('Continue shopping', 'noo-umbra'),
            'view_cart' => esc_html__('View Cart', 'noo-umbra'),
        );

        global $noo_post_types;
        if( !empty( $noo_post_types ) ) {
            foreach ($noo_post_types as $post_type => $args) {
                $nooL10n['is_' . $post_type . '_archive'] = is_post_type_archive( $post_type ) ? 'true' : 'false';
                $nooL10n['is_' . $post_type . '_single'] = is_singular( $post_type ) ? 'true' : 'false';
            }
        }


        wp_localize_script('noo-script', 'nooL10n', $nooL10n);
        wp_enqueue_script( 'infinitescroll' );

        wp_enqueue_script( 'noo-cavnas', get_template_directory_uri() . '/assets/js/off-cavnas.js', array(), null, true );
        wp_enqueue_script( 'noo-new', get_template_directory_uri() . '/assets/js/noo_new.js', array(), null, true );

        $noonew_array = array(
            'ajax_url'        => admin_url( 'admin-ajax.php', 'relative' ),
            'image_loading'   => get_template_directory_uri() . '/assets/images/blog-loading.gif'
        );
        wp_localize_script('noo-new', 'noo_new', $noonew_array);
        wp_enqueue_script( 'noo-script' );

    }
}
add_action( 'wp_enqueue_scripts', 'noo_umbra_enqueue_scripts' );


// Helper functions
require_once get_template_directory() . '/includes/functions/noo-html.php';
require_once get_template_directory() . '/includes/functions/noo-utilities.php';
require_once get_template_directory() . '/includes/functions/noo-style.php';
require_once get_template_directory() . '/includes/functions/noo-wp-style.php';
require_once get_template_directory() . '/includes/functions/noo-user.php';


// Mega Menu
require_once get_template_directory() . '/includes/mega-menu/noo_mega_menu.php';

// WooCommerce

 require_once get_template_directory() . '/includes/woocommerce.php';

//
// Widgets
//
$widget_path = get_template_directory() . '/widgets';

if ( file_exists( $widget_path . '/widgets_init.php' ) ) {
    require_once $widget_path . '/widgets_init.php';
    require_once $widget_path . '/widgets.php';
}
