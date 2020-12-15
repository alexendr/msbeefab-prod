<?php
/**
 * Initialize Theme functions for NOO Themes.
 *
 * @package    NOO Themes
 * @version    1.0.0
 * @author     Kan Nguyen <khanhnq@nootheme.com>
 * @copyright  Copyright (c) 2014, NooTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://nootheme.com
 */

// Content Width
if ( ! isset( $content_width ) ) :
	$content_width = 970;
endif;

// Initialize Theme
if (!function_exists('noo_umbra_init_theme')):
	function noo_umbra_init_theme() {
		load_theme_textdomain( 'noo-umbra', get_template_directory() . '/languages' );

		require_once get_template_directory() . '/includes/libs/noo-check-version.php';

        if ( is_admin() ) {     
            $license_manager = new Noo_Umbra_Check_Version(
                'noo-umbra',
                'Noo Umbra',
                'http://update.nootheme.com/api/license-manager/v1',
                'theme',
                '',
                false
            );
        }

		// Title Tag -- From WordPress 4.1.
		add_theme_support('title-tag');
		// @TODO: Automatic feed links.
		add_theme_support('automatic-feed-links');
		// Add support for some post formats.
		add_theme_support('post-formats', array(
			'image',
			'gallery',
			'video',
			'audio'
		));

		add_theme_support( 'woocommerce' );

		// WordPress menus location.
		$menu_list = array();
		
		$menu_list['primary']           =   esc_html__( 'Primary Menu', 'noo-umbra');
        $menu_list['primary-left']      =   esc_html__( 'Menu Left', 'noo-umbra');
        $menu_list['primary-right']     =   esc_html__( 'Menu Right', 'noo-umbra');


		// Register Menu
		register_nav_menus($menu_list);

		// Define image size
		add_theme_support('post-thumbnails');
		
		add_image_size('noo-thumbnail-medium', 240, 140, true);

		add_image_size('noo-thumbnail-square',600,450, true);

        add_image_size('noo-thumbnail-sq',270,370, true);

        add_image_size('noo-thumbnail-product',650,650, true);

        /*
	 * Enable support for custom logo.
	 *
	 * @since Umbra
	 */
        add_theme_support( 'custom-logo', array(
            'height'      => 248,
            'width'       => 248,
            'flex-height' => true,
        ) );

		$default_values = array( 
				'primary_color'         => '#d2a637',
				'secondary_color'       => '#4666a3',
				'font_family'           => 'Lato',
				'text_color'            => '#000',
				'font_size'             => '14',
				'font_weight'           => '400',
				'headings_font_family'  => 'Dosis',
				'headings_color'        => '#000',
				'logo_color'            => '#000',
				'logo_font_family'      => 'Open Sans',
			);
		noo_umbra_set_theme_default( $default_values );
	}
	add_action('after_setup_theme', 'noo_umbra_init_theme');
endif;