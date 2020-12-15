<?php
// Incremental ID Counter for Templates
if ( ! function_exists( 'noo_vc_elements_id_increment' ) ) :
    function noo_vc_elements_id_increment() {
        static $count = 0; $count++;
        return $count;
    }
endif;
// Function for handle element's visibility
if ( ! function_exists( 'noo_visibility_class' ) ) :
    function noo_visibility_class( $visibility = '' ) {
        switch ($visibility) {
            case 'hidden-phone':
                return ' hidden-xs';
            case 'hidden-tablet':
                return ' hidden-sm';
            case 'hidden-pc':
                return ' hidden-md hidden-lg';
            case 'visible-phone':
                return ' visible-xs';
            case 'visible-tablet':
                return ' visible-sm';
            case 'visible-pc':
                return ' visible-md visible-lg';
            default:
                return '';
        }
    }
endif;
if ( class_exists('WPBakeryVisualComposerAbstract') ):
    function nootheme_includevisual(){
        require_once NOO_PLUGIN_SERVER_PATH . '/admin/vc_extension/map/new_params.php';
        require_once NOO_PLUGIN_SERVER_PATH . '/admin/vc_extension/map/map.php';
        // VC Templates
        $vc_templates_dir = NOO_PLUGIN_SERVER_PATH . '/admin/vc_extension/shortcodes/vc_templates/';
        vc_set_shortcodes_templates_dir($vc_templates_dir);

        // require file
        require_once NOO_PLUGIN_SERVER_PATH . '/admin/vc_extension/shortcodes/noo-product-grid.php';
        require_once NOO_PLUGIN_SERVER_PATH . '/admin/vc_extension/shortcodes/noo-testimonial.php';
        require_once NOO_PLUGIN_SERVER_PATH . '/admin/vc_extension/shortcodes/noo-mailchimp.php';
        require_once NOO_PLUGIN_SERVER_PATH . '/admin/vc_extension/shortcodes/noo-services.php';
        require_once NOO_PLUGIN_SERVER_PATH . '/admin/vc_extension/shortcodes/noo-partner.php';
        require_once NOO_PLUGIN_SERVER_PATH . '/admin/vc_extension/shortcodes/noo-product-sale.php';
        require_once NOO_PLUGIN_SERVER_PATH . '/admin/vc_extension/shortcodes/noo-banner.php';
        require_once NOO_PLUGIN_SERVER_PATH . '/admin/vc_extension/shortcodes/noo-simple-banner.php';
        require_once NOO_PLUGIN_SERVER_PATH . '/admin/vc_extension/shortcodes/noo-countdown.php';
        require_once NOO_PLUGIN_SERVER_PATH . '/admin/vc_extension/shortcodes/noo-product-countdown.php';
        require_once NOO_PLUGIN_SERVER_PATH . '/admin/vc_extension/shortcodes/noo-blog.php';
        require_once NOO_PLUGIN_SERVER_PATH . '/admin/vc_extension/shortcodes/noo-product-simple-slider.php';
        require_once NOO_PLUGIN_SERVER_PATH . '/admin/vc_extension/shortcodes/noo-short-image.php';
        require_once NOO_PLUGIN_SERVER_PATH . '/admin/vc_extension/shortcodes/noo-blog-masonry.php';
        require_once NOO_PLUGIN_SERVER_PATH . '/admin/vc_extension/shortcodes/noo-simple-product.php';
        require_once NOO_PLUGIN_SERVER_PATH . '/admin/vc_extension/shortcodes/noo-custom-link.php';
        require_once NOO_PLUGIN_SERVER_PATH . '/admin/vc_extension/shortcodes/noo-member.php';
        require_once NOO_PLUGIN_SERVER_PATH . '/admin/vc_extension/shortcodes/noo-introduce.php';

    }
    add_action('init', 'nootheme_includevisual', 20);
endif;

