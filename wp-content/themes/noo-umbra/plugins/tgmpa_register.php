<?php
/**
 * This file register the required and recommended plugins to used in this theme.
 *
 *
 * @package    NOO Blank
 * @subpackage Plugin Registration
 * @version    1.0.0
 * @author     Kan Nguyen <khanhnq@nootheme.com>
 * @copyright  Copyright (c) 2014, NooTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://nootheme.com
 */

if ( ! function_exists( 'noo_umbra_register_theme_plugins' ) ) :
	function noo_umbra_register_theme_plugins() {

		$plugins = array(



			array(
                'name'               => 'WPBakery Visual Composer',
                'slug'               => 'js_composer',
                'source'             => 'http://wp.nootheme.com/plugin-files/js_composer.zip',
                'required'           => true,
                'version'            => '5.4.5',
                'force_activation'   => false,
                'force_deactivation' => false,
                'external_url'       => '',
            ),

            array(
                'name'               => 'Noo Umbra Core',
                'slug'               => 'noo-umbra-core',
                'source'             => 'http://wp.nootheme.com/plugin-files/noo-umbra-core.zip',
                'required'           => true,
                'version'            => '1.4.2',
                'force_activation'   => false,
                'force_deactivation' => false,
                'external_url'       => '',
            ),

             array(
                 'name'               => 'Revslider',
                 'slug'               => 'revslider',
                 'source'             => 'http://wp.nootheme.com/plugin-files/revslider.zip',
                 'required'           => false,
                 'version'            => '5.4.6',
                 'force_activation'   => false,
                 'force_deactivation' => false,
                 'external_url'       => '',
             ),
            
             array(
                 'name'    => 'Contact Form 7',
                 'slug'    => 'contact-form-7',
                 'required'  => false,
             ),
            
             array(
                 'name'    => 'Mailchimp For WP',
                 'slug'    => 'mailchimp-for-wp',
                 'required'  => false,
             ),
            
             array(
                 'name'    => 'Breadcrumb NavXT',
                 'slug'    => 'breadcrumb-navxt',
                 'required'  => false,
             ),
            
             array(
                 'name'    => 'WooCommerce',
                 'slug'    => 'woocommerce',
                 'required'  => false,
             ),
            
             array(
                 'name'    => 'YITH WooCommerce Wishlist',
                 'slug'    => 'yith-woocommerce-wishlist',
                 'required'  => false,
             ),

             array(
                 'name'    => 'YITH WooCommerce Compare',
                 'slug'    => 'yith-woocommerce-compare',
                 'required'  => false,
             )
		);

		$config = array(
            'id'           => 'tgmpa',                 // Unique ID for hashing notices for multiple instances of TGMPA.
            'default_path' => '',                      // Default absolute path to bundled plugins.
            'menu'         => 'tgmpa-install-plugins', // Menu slug.
            'parent_slug'  => 'themes.php',            // Parent menu slug.
            'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
            'has_notices'  => true,                    // Show admin notices or not.
            'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
            'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
            'is_automatic' => false,                   // Automatically activate plugins after installation or not.
            'message'      => '',                      // Message to output right before the plugins table.
        );

		tgmpa( $plugins, $config );

	}

	add_action( 'tgmpa_register', 'noo_umbra_register_theme_plugins' );
endif;

function noo_umbra_enable_vc_auto_theme_update() {
    if( function_exists('vc_updater') ) {
        $vc_updater = vc_updater();
        remove_filter( 'upgrader_pre_download', array( $vc_updater, 'preUpgradeFilter' ), 10 );
        if( function_exists( 'vc_license' ) ) {
            if( !vc_license()->isActivated() ) {
                remove_filter( 'pre_set_site_transient_update_plugins', array( $vc_updater->updateManager(), 'check_update' ), 10 );
            }
        }
        remove_filter( 'admin_notices', array( vc_license(), 'adminNoticeLicenseActivation' ) );
    }
}
add_action('vc_after_init', 'noo_umbra_enable_vc_auto_theme_update');
