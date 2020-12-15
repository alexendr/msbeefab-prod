<?php
/**
 * NOO Customizer Package.
 *
 * Register Options
 * This file register options used in NOO-Customizer
 *
 * @package    NOO Framework
 * @version    1.0.0
 * @author     Kan Nguyen <khanhnq@nootheme.com>
 * @copyright  Copyright (c) 2014, NooTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://nootheme.com
 */
// =============================================================================

global $wp_customize;
if ( isset( $wp_customize ) || noo_umbra_get_option('noo_use_inline_css', false) ) {
	add_action( 'wp_head', 'noo_umbra_customizer_css_generator', 100, 0 );
}


//
// Register NOO Customizer Sections and Options
//
function noo_umbra_customize_partial_blogname() {
    bloginfo( 'name' );
}
// 1. Site Enhancement options.
if ( ! function_exists( 'noo_umbra_customizer_register_options_general' ) ) :
	function noo_umbra_customizer_register_options_general( $wp_customize ) {

		// declare helper object.
		$helper = new NOO_Customizer_Helper( $wp_customize );

		// Section: Site Enhancement
		$helper->add_section(
			'noo_umbra_customizer_section_site_enhancement',
			esc_html__( 'Site Enhancement', 'noo-umbra' ),
			esc_html__( 'Enable/Disable some features for your site.', 'noo-umbra' )
		);

		noo_customizer_add_controls(
			$wp_customize,
			array(
				'noo_back_to_top' => array(
					'type'		=> 'noo_switch',
					'label'		=> esc_html__( 'Back To Top Button', 'noo-umbra' ),
					'default'	=> 1,
					'preview_type' => 'custom'
				),
				'noo_page_heading' => array(
					'type'		=> 'noo_switch',
					'label'		=> esc_html__( 'Enable Page Heading', 'noo-umbra' ),
					'default'	=> 1
				)
			)
		);
	}
add_action( 'customize_register', 'noo_umbra_customizer_register_options_general' );
endif;

// 2. Design and Layout options.
if ( ! function_exists( 'noo_umbra_customizer_register_options_layout' ) ) :
	function noo_umbra_customizer_register_options_layout( $wp_customize ) {

		// declare helper object.
		$helper = new NOO_Customizer_Helper( $wp_customize );

		// Section: Layout
		$helper->add_section(
			'noo_umbra_customizer_section_layout',
			esc_html__( 'Design and Layout', 'noo-umbra' ),
			esc_html__( 'Set Style and Layout for your site. Boxed Layout will come with additional setting options for background color and image.', 'noo-umbra' )
		);

		noo_customizer_add_controls(
			$wp_customize,
			array(
				'noo_site_layout' => array(
					'type' => 'noo_radio',
					'label' => esc_html__( 'Site Layout', 'noo-umbra' ),
					'default' => 'fullwidth',
					'control' => array(
						'choices' => array( 'fullwidth' => esc_html__( 'Fullwidth', 'noo-umbra' ), 'boxed' => esc_html__( 'Boxed', 'noo-umbra' ) ),
						'json'  => array(
							'child_options' => array(
								'boxed' => 'noo_layout_site_width
											,noo_layout_site_max_width
											,noo_layout_bg_color
		                                    ,noo_layout_bg_image_sub_section
		                                    ,noo_layout_bg_image
		                                    ,noo_layout_bg_repeat
		                                    ,noo_layout_bg_align
		                                    ,noo_layout_bg_attachment
		                                    ,noo_layout_bg_cover'
							)
						),
						'preview_type' => 'custom'
					)
				),
				'noo_layout_site_width' => array(
					'type' => 'ui_slider',
					'label' => esc_html__( 'Site Width (%)', 'noo-umbra' ),
					'default' => '100',
					'control' => array(
						'json' => array(
							'data_min' => 60,
							'data_max' => 100,
						),
						'preview_type' => 'custom'
					)
				),
				'noo_layout_site_max_width' => array(
					'type' => 'ui_slider',
					'label' => esc_html__( 'Site Max Width (px)', 'noo-umbra' ),
					'default' => '1200',
					'control' => array(
						'json' => array(
							'data_min'  => 980,
							'data_max'  => 1600,
							'data_step' => 10,
						),
						'preview_type' => 'custom'
					)
				),
				'noo_layout_bg_color' => array(
					'type' => 'color_control',
					'label' => esc_html__( 'Background Color', 'noo-umbra' ),
					'default' => '#ffffff',
					'preview_type' => 'custom'
				)
			)
		);

		// Sub-section: Background Image
		$helper->add_sub_section(
			'noo_layout_bg_image_sub_section',
			esc_html__( 'Background Image', 'noo-umbra' ),
			noo_umbra_kses( __( 'Upload your background image here, you have various settings for your image:<br/><strong>Repeat Image</strong>: enable repeating your image, you will need it when using patterned background.<br/><strong>Alignment</strong>: Set the position to align your background image.<br/><strong>Attachment</strong>: Make your image scroll with your site or fixed.<br/><strong>Auto resize</strong>: Enable it to ensure your background image always fit the windows.', 'noo-umbra' ) )
		);

		// Control: Background Image
		$helper->add_control(
			'noo_layout_bg_image',
			'noo_image',
			esc_html__( 'Background Image', 'noo-umbra' ),
			'',
			array( 'preview_type' => 'custom' )
		);

		// Control: Repeat Image
		$helper->add_control(
			'noo_layout_bg_repeat',
			'radio',
			esc_html__( 'Background Repeat', 'noo-umbra' ),
			'no-repeat',
			array(
				'choices' => array(
					'repeat' => esc_html__( 'Repeat', 'noo-umbra' ),
					'no-repeat' => esc_html__( 'No Repeat', 'noo-umbra' ),
				),
				'preview_type' => 'custom'
			)
		);

		// Control: Align Image
		$helper->add_control(
			'noo_layout_bg_align',
			'select',
			esc_html__( 'BG Image Alignment', 'noo-umbra' ),
			'left top',
			array(
				'choices' => array(
					'left top'       => esc_html__( 'Left Top', 'noo-umbra' ),
					'left center'     => esc_html__( 'Left Center', 'noo-umbra' ),
					'left bottom'     => esc_html__( 'Left Bottom', 'noo-umbra' ),
					'center top'     => esc_html__( 'Center Top', 'noo-umbra' ),
					'center center'     => esc_html__( 'Center Center', 'noo-umbra' ),
					'center bottom'     => esc_html__( 'Center Bottom', 'noo-umbra' ),
					'right top'     => esc_html__( 'Right Top', 'noo-umbra' ),
					'right center'     => esc_html__( 'Right Center', 'noo-umbra' ),
					'right bottom'     => esc_html__( 'Right Bottom', 'noo-umbra' ),
				),
				'preview_type' => 'custom'
			)
		);

		// Control: Enable Scrolling Image
		$helper->add_control(
			'noo_layout_bg_attachment',
			'radio',
			esc_html__( 'BG Image Attachment', 'noo-umbra' ),
			'fixed',
			array(
				'choices' => array(
					'fixed' => esc_html__( 'Fixed Image', 'noo-umbra' ),
					'scroll' => esc_html__( 'Scroll with Site', 'noo-umbra' ),
				),
				'preview_type' => 'custom'
			)
		);

		// Control: Auto Resize
		$helper->add_control(
			'noo_layout_bg_cover',
			'noo_switch',
			esc_html__( 'Auto Resize', 'noo-umbra' ),
			0,
			array( 'preview_type' => 'custom' )
		);

		// Sub-Section: Links Color
		$helper->add_sub_section(
			'noo_general_sub_section_links_color',
			esc_html__( 'Color', 'noo-umbra' ),
			esc_html__( 'Here you can set the color for links and various elements on your site.', 'noo-umbra' )
		);

		// Control: Primary Color
		$helper->add_control(
			'noo_site_primary_color',
			'color_control',
			esc_html__( 'Primary Color', 'noo-umbra' ),
			noo_umbra_get_theme_default( 'primary_color' ),
			array( 'preview_type' => 'update_css', 'preview_params' => array( 'css' => 'design' ) )
		);

		// Control: Secondary Color
		$helper->add_control(
			'noo_site_secondary_color',
			'color_control',
			esc_html__( 'Secondary Color', 'noo-umbra' ),
			noo_umbra_get_theme_default( 'secondary_color' ),
			array( 'preview_type' => 'update_css', 'preview_params' => array( 'css' => 'design' ) )
		);
	}
add_action( 'customize_register', 'noo_umbra_customizer_register_options_layout' );
endif;

// 3. Typography options.
if ( ! function_exists( 'noo_umbra_customizer_register_options_typo' ) ) :
	function noo_umbra_customizer_register_options_typo( $wp_customize ) {

		// declare helper object.
		$helper = new NOO_Customizer_Helper( $wp_customize );

		// Section: Typography
		$helper->add_section(
			'noo_umbra_customizer_section_typo',
			esc_html__( 'Typography', 'noo-umbra' ),
			noo_umbra_kses( __( 'Customize your Typography settings. Merito integrated all Google Fonts. See font preview at <a target="_blank" href="http://www.google.com/fonts/">Google Fonts</a>.', 'noo-umbra' ) )
		);

		// Control: Use Custom Fonts
		$helper->add_control(
			'noo_typo_use_custom_fonts',
			'noo_switch',
			esc_html__( 'Use Custom Fonts?', 'noo-umbra' ),
			0,
			array( 'json' => array( 
				'on_child_options'  => 'noo_typo_headings_font,noo_typo_body_font' 
				),
				'preview_type' => 'update_css',
				'preview_params' => array( 'css' => 'typography' )
			)
		);

		// Control: Use Custom Font Color
		$helper->add_control(
			'noo_typo_use_custom_fonts_color',
			'noo_switch',
			esc_html__( 'Custom Font Color?', 'noo-umbra' ),
			0,
			array( 'json' => array(
				'on_child_options'  => 'noo_typo_headings_font_color,noo_typo_body_font_color'
				),
				'preview_type' => 'update_css',
				'preview_params' => array( 'css' => 'design' )
			)
		);

		// Sub-Section: Headings
		$helper->add_sub_section(
			'noo_typo_sub_section_headings',
			esc_html__( 'Headings', 'noo-umbra' )
		);

		// Control: Headings font
		$helper->add_control(
			'noo_typo_headings_font',
			'google_fonts',
			esc_html__( 'Headings Font', 'noo-umbra' ),
			noo_umbra_get_theme_default( 'headings_font_family' ),
			array(
				'weight' => '700',
				'style'	=> 'italic',
				'preview_type' => 'custom'
			)
		);

		// Control: Headings Font Color
		$helper->add_control(
			'noo_typo_headings_font_color',
			'color_control',
			esc_html__( 'Font Color', 'noo-umbra' ),
			noo_umbra_get_theme_default( 'headings_color' ),
			array( 'preview_type' => 'custom' )
		);

		// Control: Headings Font Uppercase
		$helper->add_control(
			'noo_typo_headings_uppercase',
			'checkbox',
			esc_html__( 'Transform to Uppercase', 'noo-umbra' ),
			0,
			array( 'preview_type' => 'custom' )
		);

		// Sub-Section: Body
		$helper->add_sub_section(
			'noo_typo_sub_section_body',
			esc_html__( 'Body', 'noo-umbra' )
		);

		// Control: Body font
		$helper->add_control(
			'noo_typo_body_font',
			'google_fonts',
			esc_html__( 'Body Font', 'noo-umbra' ),
			noo_umbra_get_theme_default( 'font_family' ),
			array( 'preview_type' => 'custom' )
		);

		// Control: Body Font Size
		$helper->add_control(
			'noo_typo_body_font_size',
			'font_size',
			esc_html__( 'Font Size (px)', 'noo-umbra' ),
			noo_umbra_get_theme_default( 'font_size' ),
			array( 'preview_type' => 'custom' )
		);

		// Control: Body Font Color
//		$helper->add_control(
//			'noo_typo_body_font_color',
//			'color_control',
//			esc_html__( 'Font Color', 'noo-umbra' ),
//			noo_umbra_get_theme_default( 'text_color' ),
//			array(
//				'preview_type' => 'custom'
//			)
//		);
	}
add_action( 'customize_register', 'noo_umbra_customizer_register_options_typo' );
endif;


// 4. Header options.
if ( ! function_exists( 'noo_umbra_customizer_register_options_header' ) ) :
	function noo_umbra_customizer_register_options_header( $wp_customize ) {

		// declare helper object.
		$helper = new NOO_Customizer_Helper( $wp_customize );

		// Section: Header
		$helper->add_section(
			'noo_umbra_customizer_section_header',
			esc_html__( 'Header', 'noo-umbra' ),
			esc_html__( 'Customize settings for your Header, including Navigation Bar (Logo and Navigation) and an optional Top Bar.', 'noo-umbra' ),
			true
		);

		// Sub-section: General Options
		$helper->add_sub_section(
			'noo_header_sub_section_general',
			esc_html__( 'General Options', 'noo-umbra' ),
			''
		);

        // Sub-Section: Header Bar
        $helper->add_sub_section(
            'noo_header_sub_section_style',
            esc_html__( 'Header Style', 'noo-umbra' ),
            esc_html__( 'Choose style for header', 'noo-umbra' )
        );

        // Control: Header Style
        $helper->add_control(
            'noo_header_nav_style',
            'noo_radio',
            esc_html__( 'Header Style', 'noo-umbra' ),
            'header-1',
            array(
                'choices' => array(
                    'header-1'     => esc_html__( 'header Default', 'noo-umbra' ),
                    'header-2'     => esc_html__( 'Header Business', 'noo-umbra' ),
                    'header-3'     => esc_html__( 'Header Center', 'noo-umbra' ),
                    'header-4'     => esc_html__( 'Header Transparent', 'noo-umbra' )
                )
            )
        );

		// Sub-Section: Navigation Bar
		$helper->add_sub_section(
			'noo_header_sub_section_nav',
			esc_html__( 'Navigation Bar', 'noo-umbra' ),
			esc_html__( 'Adjust settings for Navigation Bar. You also can customize some settings for the Toggle Button on Mobile in this section.', 'noo-umbra' )
		);

		// Control: NavBar Position
		$helper->add_control(
			'noo_header_nav_position',
			'noo_radio',
			esc_html__( 'NavBar Position', 'noo-umbra' ),
			'fixed_top', 
			array(
				'choices' => array(
					'static_top'       => esc_html__( 'Static Top', 'noo-umbra' ),
					'fixed_top'     => esc_html__( 'Fixed Top', 'noo-umbra' ),
					// 'fixed_left'     => esc_html__( 'Fixed Left', 'noo-umbra' ),
					// 'fixed_right'     => esc_html__( 'Fixed Right', 'noo-umbra' ),
				),
				'json' => array(
					'child_options' => array(
						'fixed_top'   => 'noo_header_nav_shrinkable,noo_header_nav_smart_scroll,noo_header_sub_section_nav_floating,noo_header_nav_floating',
						// 'fixed_left'  => 'noo_header_side_nav_width,noo_header_side_nav_alignment,noo_header_side_logo_margin_top,noo_header_side_nav_link_height',
						// 'fixed_right' => 'noo_header_side_nav_width,noo_header_side_nav_alignment,noo_header_side_logo_margin_top,noo_header_side_nav_link_height',
					)
				)
			)
		);



        if( NOO_WOOCOMMERCE_EXIST ) {
            // Control: Show Cart Icon
            $helper->add_control(
                'noo_header_nav_icon_cart',
                'noo_switch',
                esc_html__( 'Show Shopping Cart', 'noo-umbra' ),
                1
            );
        }

        // Control: Show Search
        $helper->add_control(
            'noo_header_nav_icon_search',
            'noo_switch',
            esc_html__( 'Show Search Icon', 'noo-umbra' ),
            1,
            array(
                'json' => array(
                    'on_child_options'  => ''
                )
            )
        );


        // Control: Show Wishlist
        $helper->add_control(
            'noo_header_nav_icon_wishlist',
            'noo_switch',
            esc_html__( 'Show Wishlist Icon', 'noo-umbra' ),
            1,
            array(
                'json' => array(
                    'on_child_options'  => ''
                )
            )
        );

		// Control: Divider 2
		$helper->add_control( 'noo_header_nav_divider_2', 'divider', '' );

		// Control: Custom NavBar Font
		$helper->add_control(
			'noo_header_custom_nav_font',
			'noo_switch',
			esc_html__( 'Use Custom NavBar Font and Color?', 'noo-umbra' ),
			0,
			array( 'json' => array( 
					'on_child_options'  => 'noo_header_nav_font,noo_header_nav_link_color,noo_header_nav_link_hover_color' 
				),
				'preview_type' => 'update_css',
				'preview_params' => array( 'css' => 'header' )
			)
		);

		// Control: NavBar font
		$helper->add_control(
			'noo_header_nav_font',
			'google_fonts',
			esc_html__( 'NavBar Font', 'noo-umbra' ),
			noo_umbra_get_theme_default( 'headings_font_family' ),
			array(
				'weight' => '700',
				'style'	=> 'normal',
				'preview_type' => 'custom',
			)
		);

		// Control: NavBar Font Size
		$helper->add_control(
			'noo_header_nav_font_size',
			'ui_slider',
			esc_html__( 'Font Size (px)', 'noo-umbra' ),
			'16',
			array(
				'json' => array(
					'data_min' => 9,
					'data_max' => 30,
				),
				'preview_type' => 'custom'
			)
		);

		// Control: NavBar Link Color
		$helper->add_control(
			'noo_header_nav_link_color',
			'color_control',
			esc_html__( 'Link Color', 'noo-umbra' ),
			'',
			array(
				'preview_type' => 'custom'
			)
		);

		// Control: NavBar Link Hover Color
		$helper->add_control(
			'noo_header_nav_link_hover_color',
			'color_control',
			esc_html__( 'Link Hover Color', 'noo-umbra' ),
			''
		);

		// Control: NavBar Font Uppercase
		$helper->add_control(
			'noo_header_nav_uppercase',
			'checkbox',
			esc_html__( 'Transform to Uppercase', 'noo-umbra' ),
			1,
			array(
				'preview_type' => 'custom'
			)
		);
		// Control: NavBar Link Spacing (px)
		$helper->add_control(
			'noo_header_nav_link_spacing',
			'ui_slider',
			esc_html__( 'NavBar Link Spacing (px)', 'noo-umbra' ),
			'20',
			array(
				'json' => array(
					'data_min' => 20,
					'data_max' => 50,
				),
				'preview_type' => 'custom'
			)
		);



		// Sub-Section: Logo
		$helper->add_sub_section(
			'noo_header_sub_section_logo',
			esc_html__( 'Logo', 'noo-umbra' ),
			esc_html__( 'All the settings for Logo go here. If you do not use Image for Logo, plain text will be used.', 'noo-umbra' )
		);

		// Control: Use Image for Logo
		$helper->add_control(
			'noo_header_use_image_logo',
			'noo_switch',
			esc_html__( 'Use Image for Logo?', 'noo-umbra' ),
			0,
			array(
				'json' => array(
					'on_child_options'   => 'noo_header_logo_image,noo_header_logo_image_height',
					'off_child_options'  => 'blogname
										,noo_header_logo_font
                                        ,noo_header_logo_font_size
                                        ,noo_header_logo_font_color
                                        ,noo_header_logo_uppercase'
				)
			)
		);

		// Control: Blog Name
		$helper->add_control(
			'blogname',
			'text',
			esc_html__( 'Blog Name', 'noo-umbra' ),
			get_bloginfo( 'name' ),
			array(
				'preview_type' => 'custom'
			)
		);

		// Control: Logo font
		$helper->add_control(
			'noo_header_logo_font',
			'google_fonts',
			esc_html__( 'Logo Font', 'noo-umbra' ),
			noo_umbra_get_theme_default( 'logo_font_family' ),
			array(
				'weight' => '700',
				'style'	=> 'normal',
				'preview_type' => 'custom'
			)
		);

		// Control: Logo Font Size
		$helper->add_control(
			'noo_header_logo_font_size',
			'ui_slider',
			esc_html__( 'Font Size (px)', 'noo-umbra' ),
			'50',
			array(
				'json' => array(
					'data_min' => 15,
					'data_max' => 80,
				),
				'preview_type' => 'custom'
			)
		);

		// Control: Logo Font Color
		$helper->add_control(
			'noo_header_logo_font_color',
			'color_control',
			esc_html__( 'Font Color', 'noo-umbra' ),
			noo_umbra_get_theme_default( 'logo_color' ),
			array(
				'preview_type' => 'custom'
			)
		);

		// Control: Logo Font Uppercase
		$helper->add_control(
			'noo_header_logo_uppercase',
			'checkbox',
			esc_html__( 'Transform to Uppercase', 'noo-umbra' ),
			0,
			array(
				'preview_type' => 'custom'
			)
		);

		// Control: Logo Image
		$helper->add_control(
			'noo_header_logo_image',
			'noo_logo'
		);

		// Control: Logo Image Height
		$helper->add_control(
			'noo_header_logo_image_height',
			'ui_slider',
			esc_html__( 'Image Height (px)', 'noo-umbra' ),
			'40',
			array(
				'json' => array(
					'data_min' => 15,
					'data_max' => 150,
				),
				'preview_type' => 'custom'
			)
		);


        // Sub-Section: NavBar Alignment
        $helper->add_sub_section(
            'noo_header_sub_section_topbra',
            esc_html__( 'Top bar', 'noo-umbra' ),
            ''
        );
        $helper->add_control(
            'noo_header_topbar',
            'noo_switch',
            esc_html__( 'Show Top Bar', 'noo-umbra' ),
            1,
            array(
                'json' => array(
                    'on_child_options'  => ''
                )
            )
        );

        $helper->add_control(
            'noo_header_topbar_mail',
            'text',
            esc_html__( 'Mail', 'noo-umbra' ),
            '',
            array(
                'preview_type' => 'custom'
            )
        );
        $helper->add_control(
            'noo_header_topbar_phone',
            'text',
            esc_html__( 'Phone', 'noo-umbra' ),
            '',
            array(
                'preview_type' => 'custom'
            )
        );

        $helper->add_control( 'noo_topbar_divider_1', 'divider', '' );

        // Control: Show Wishlist
        $helper->add_control(
            'noo_header_topbar_wishlist',
            'noo_switch',
            esc_html__( 'Show Wishlist', 'noo-umbra' ),
            1,
            array(
                'json' => array(
                    'on_child_options'  => ''
                )
            )
        );

        // Control: Show My Account
        $helper->add_control(
            'noo_header_topbar_my_account',
            'noo_switch',
            esc_html__( 'Show My Account', 'noo-umbra' ),
            1,
            array(
                'json' => array(
                    'on_child_options'  => ''
                )
            )
        );

        // Control: Show My Account
        $helper->add_control(
            'noo_header_topbar_checkout',
            'noo_switch',
            esc_html__( 'Show Checkout', 'noo-umbra' ),
            1,
            array(
                'json' => array(
                    'on_child_options'  => ''
                )
            )
        );


    }
add_action( 'customize_register', 'noo_umbra_customizer_register_options_header' );
endif;

// 5. Footer options.
if ( ! function_exists( 'noo_umbra_customizer_register_options_footer' ) ) :
	function noo_umbra_customizer_register_options_footer( $wp_customize ) {

		// declare helper object.
		$helper = new NOO_Customizer_Helper( $wp_customize );

		// Section: Footer
		$helper->add_section(
			'noo_umbra_customizer_section_footer',
			esc_html__( 'Footer', 'noo-umbra' ),
			esc_html__( 'Footer contains Widgetized area and Footer Bottom. You can change any parts.', 'noo-umbra' )
		);

		// // Control: Divider 1
		// $helper->add_control( 'noo_footer_divider_1', 'divider', '' );


		// Control: Footer Columns (Widgetized)
		$helper->add_control(
			'noo_footer_layout',
			'select',
			esc_html__( 'Footer layout', 'noo-umbra' ),
			'boxed',
			array(
				'choices' => array(
					'boxed'         => esc_html__( 'Boxed', 'noo-umbra' ),
					'fullwidth'     => esc_html__( 'FullWidth', 'noo-umbra' )
				)
			)
		);

        $helper->add_control(
			'noo_footer_widgets',
			'select',
			esc_html__( 'Footer Columns (Widgetized)', 'noo-umbra' ),
			'4',
			array(
				'choices' => array(
					0       => esc_html__( 'None (No Footer Main Content)', 'noo-umbra' ),
					1     => esc_html__( 'One', 'noo-umbra' ),
					2     => esc_html__( 'Two', 'noo-umbra' ),
					3     => esc_html__( 'Three', 'noo-umbra' ),
					4     => esc_html__( 'Four', 'noo-umbra' )
				)
			)
		);

        // Control: Footer Image
        $helper->add_control(
            'noo_footer_background_image',
            'noo_image',
            esc_html__( 'Background Image', 'noo-umbra' ),
            ''
        );

		// Control: Divider 2
		$helper->add_control( 'noo_footer_divider_2', 'divider', '' );

		// Control: Bottom Bar Content
		$helper->add_control(
			'noo_bottom_bar_content',
			'textarea',
			esc_html__( 'Footer Bottom Content (HTML)', 'noo-umbra' ),
			'&copy; 2015. Designed with <i class="fa fa-heart text-primary" ></i> by NooTheme',
			array(
				'preview_type' => 'custom'
			)
		);

	}
add_action( 'customize_register', 'noo_umbra_customizer_register_options_footer' );
endif;

// 6. WP Sidebar options.
if ( ! function_exists( 'noo_umbra_customizer_register_options_sidebar' ) ) :
	function noo_umbra_customizer_register_options_sidebar( $wp_customize ) {

		global $wp_version;
		if ( $wp_version >= 4.0 ) {
			// declare helper object.
			$helper = new NOO_Customizer_Helper( $wp_customize );

			// Change the sidebar panel priority
			$widget_panel = $wp_customize->get_panel('widgets');
			if(!empty($widget_panel)) {
				$widget_panel->priority = $helper->get_new_section_priority();
			}
		}
	}
add_action( 'customize_register', 'noo_umbra_customizer_register_options_sidebar' );
endif;

// 7. Blog options.
if ( ! function_exists( 'social' ) ) :
	function noo_umbra_customizer_register_options_blog( $wp_customize ) {

		// declare helper object.
		$helper = new NOO_Customizer_Helper( $wp_customize );

		// Section: Blog
		$helper->add_section(
			'noo_umbra_customizer_section_blog',
			esc_html__( 'Blog', 'noo-umbra' ),
			esc_html__( 'In this section you have settings for your Blog page, Archive page and Single Post page.', 'noo-umbra' ),
			true
		);

		// Sub-section: Blog Page (Index Page)
		$helper->add_sub_section(
			'noo_blog_sub_section_blog_page',
			esc_html__( 'Post List', 'noo-umbra' ),
			esc_html__( 'Choose Layout settings for your Post List', 'noo-umbra' )
		);

		// Control: Blog Layout
		$helper->add_control(
			'noo_blog_layout',
			'noo_radio',
			esc_html__( 'Blog Layout', 'noo-umbra' ),
			'sidebar',
			array(
				'choices' => array(
					'fullwidth'   => esc_html__( 'Full-Width', 'noo-umbra' ),
					'sidebar'   => esc_html__( 'With Right Sidebar', 'noo-umbra' ),
					'left_sidebar'   => esc_html__( 'With Left Sidebar', 'noo-umbra' )
				),
				'json' => array(
					'child_options' => array(
						'fullwidth'   => '',
						'sidebar'   => 'noo_blog_sidebar',
						'left_sidebar'   => 'noo_blog_sidebar'
					)
				)
			)
		);

		// Control: Blog Sidebar
		$helper->add_control(
			'noo_blog_sidebar',
			'widgets_select',
			esc_html__( 'Blog Sidebar', 'noo-umbra' ),
			'sidebar-main'
		);

		// Control: Blog Style
		$helper->add_control(
			'noo_blog_style',
			'noo_radio',
			esc_html__( 'Blog Style', 'noo-umbra' ),
			'list',
			array(
				'choices' => array(
					'list'   => esc_html__( 'List', 'noo-umbra' ),
					'masonry'   => esc_html__( 'Masonry', 'noo-umbra' )
				),
				'json' => array(
					'child_options' => array(
						'masonry'   => 'noo_blog_masonry_column'
					)
				)
			)
		);

		// Control: Blog Masonry Columns
		$helper->add_control(
			'noo_blog_masonry_column',
			'select',
			esc_html__( 'Masonry Columns', 'noo-umbra' ),
			'3',
			array(
				'choices' => array(
					'2'         =>  esc_html__('2 columns','noo-umbra'),
	                '3'         =>  esc_html__('3 columns','noo-umbra'),
	                '4'         =>  esc_html__('4 columns','noo-umbra')
				),
			)
		);

		// Control: Divider 1
		$helper->add_control( 'noo_blog_divider_1', 'divider', '' );

        // Control: Heading status
        $helper->add_control(
            'noo_blog_heading_status',
            'noo_radio',
            esc_html__( 'Show Heading?', 'noo-umbra' ),
            'show',
            array(
                'choices' => array(
                    'show'   => esc_html__( 'Show', 'noo-umbra' ),
                    'hide'       => esc_html__( 'Hide', 'noo-umbra' ),
                ),
            )
        );

		// Control: Heading Title
		$helper->add_control(
			'noo_blog_heading_title',
			'text',
			esc_html__( 'Heading Title', 'noo-umbra' ),
			esc_html__('Blog', 'noo-umbra')
		);

        // Control: Heading Sub Title
		$helper->add_control(
			'noo_blog_heading_sub_title',
			'text',
			esc_html__( 'Heading Sub Title', 'noo-umbra' )
		);
        // Control: Heading height
        $helper->add_control(
            'noo_blog_heading_height',
            'ui_slider',
            esc_html__( 'Height of Heading background', 'noo-umbra' ),
            '360',
            array(
                'json' => array(
                    'data_min'  => 360,
                    'data_max'  => 760,
                    'data_step' => 30
                )
            )
        );
		  // Control: Heading Sub Title
		$helper->add_control(
			'noo_blog_heading_parallax',
			'checkbox',
			esc_html__( 'Using parallax ?', 'noo-umbra' ),
            true
		);

		// Control: Heading Image
		$helper->add_control(
			'noo_blog_heading_image',
			'noo_image',
			esc_html__( 'Heading Background Image', 'noo-umbra' ),
			''
		);

		// Control: Divider 2
		$helper->add_control( 'noo_blog_divider_2', 'divider', '' );


		// Sub-section: Single Post
		$helper->add_sub_section(
			'noo_blog_sub_section_post',
			esc_html__( 'Single Post', 'noo-umbra' )
		);


		// Control: Heading status
		$helper->add_control(
			'noo_blog_single_heading_status',
			'noo_radio',
			esc_html__( 'Show Heading?', 'noo-umbra' ),
			'show',
			array(
				'choices' => array(
					'show'   => esc_html__( 'Show', 'noo-umbra' ),
					'hide'       => esc_html__( 'Hide', 'noo-umbra' ),
				),
			)
		);

		// Control: Heading Sub Title
		$helper->add_control(
			'noo_blog_single_heading_sub_title',
			'text',
			esc_html__( 'Heading Sub Title', 'noo-umbra' )
		);
		// Control: Heading height
		$helper->add_control(
			'noo_blog_single_heading_height',
			'ui_slider',
			esc_html__( 'Height of Heading background', 'noo-umbra' ),
			'360',
			array(
				'json' => array(
					'data_min'  => 360,
					'data_max'  => 760,
					'data_step' => 30
				)
			)
		);
		// Control: Heading Sub Title
		$helper->add_control(
			'noo_blog_single_heading_parallax',
			'checkbox',
			esc_html__( 'Using parallax ?', 'noo-umbra' ),
			true
		);

		// Control: Heading Image
		$helper->add_control(
			'noo_blog_single_heading_image',
			'noo_image',
			esc_html__( 'Heading Background Image', 'noo-umbra' ),
			''
		);

		// Control: Divider 1
		$helper->add_control( 'noo_blog_single_divider_1', 'divider', '' );

		// Control: Post Layout
		$helper->add_control(
			'noo_blog_post_layout',
			'noo_same_as_radio',
			esc_html__( 'Post Layout', 'noo-umbra' ),
			'same_as_blog',
			array(
				'choices' => array(
					'same_as_blog'   => esc_html__( 'Same as Blog Layout', 'noo-umbra' ),
					'fullwidth'   => esc_html__( 'Full-Width', 'noo-umbra' ),
					'sidebar'   => esc_html__( 'With Right Sidebar', 'noo-umbra' ),
					'left_sidebar'   => esc_html__( 'With Left Sidebar', 'noo-umbra' ),
				),
				'json' => array(
					'child_options' => array(
						'fullwidth'   => '',
						'sidebar'   => 'noo_blog_post_sidebar',
						'left_sidebar'   => 'noo_blog_post_sidebar',
					)
				)
			)
		);

		// Control: Post Sidebar
		$helper->add_control(
			'noo_blog_post_sidebar',
			'widgets_select',
			esc_html__( 'Post Sidebar', 'noo-umbra' ),
			'sidebar-main'
		);
		
		// Control: Divider 1
		$helper->add_control( 'noo_blog_post_divider_1', 'divider', '' );
		// COntrol: Related Post
		$helper->add_control(
			'noo_blog_post_related',
			'noo_switch',
			esc_html__( 'Enable Related Post', 'noo-umbra' ),
			1
		);
		
		// Control: Divider 1
		$helper->add_control( 'noo_blog_post_divider_1', 'divider', '' );
		
		// Control: Show Post Meta
		$helper->add_control(
			'noo_blog_post_show_post_meta',
			'checkbox',
			esc_html__( 'Show Post Meta', 'noo-umbra' ),
			1
		);


		// Control: Show Author Bio
		// $helper->add_control(
		// 	'noo_blog_post_author_bio',
		// 	'checkbox',
		// 	esc_html__( 'Show Author\'s Bio', 'noo-umbra' ),
		// 	1
		// );

		// Control: Divider 2
		$helper->add_control( 'noo_blog_post_divider_2', 'divider', '' );

		// Control: Enable Social Sharing
		$helper->add_control(
			'noo_blog_social',
			'noo_switch',
			esc_html__( 'Enable Social Sharing', 'noo-umbra' ),
			1,
			array(
				'json' => array( 'on_child_options' => 'noo_blog_social_facebook,
		                                                noo_blog_social_twitter,
		                                                noo_blog_social_google,
		                                                noo_blog_social_pinterest,
		                                                noo_blog_social_linkedin'
				)
			)
		);

		// Control: Sharing Title
		$helper->add_control(
			'noo_blog_social_title',
			'text',
			esc_html__( 'Sharing Title', 'noo-umbra' ),
			esc_html__( 'Share This Post', 'noo-umbra' )
		);

		// Control: Facebook Share
		$helper->add_control(
			'noo_blog_social_facebook',
			'checkbox',
			esc_html__( 'Facebook Share', 'noo-umbra' ),
			1
		);

		// Control: Twitter Share
		$helper->add_control(
			'noo_blog_social_twitter',
			'checkbox',
			esc_html__( 'Twitter Share', 'noo-umbra' ),
			1
		);

		// Control: Google+ Share
		$helper->add_control(
			'noo_blog_social_google',
			'checkbox',
			esc_html__( 'Google+ Share', 'noo-umbra' ),
			1
		);

		// Control: Pinterest Share
		$helper->add_control(
			'noo_blog_social_pinterest',
			'checkbox',
			esc_html__( 'Pinterest Share', 'noo-umbra' ),
			0
		);

		// Control: LinkedIn Share
		$helper->add_control(
			'noo_blog_social_linkedin',
			'checkbox',
			esc_html__( 'LinkedIn Share', 'noo-umbra' ),
			0
		);
	}
add_action( 'customize_register', 'noo_umbra_customizer_register_options_blog' );
endif;

// 8. Custom Post Type options
if ( ! function_exists( 'noo_umbra_customizer_register_options_post_type' ) ) :
	function noo_umbra_customizer_register_options_post_type( $wp_customize ) {
		global $noo_post_types;
		if( empty( $noo_post_types ) ) return;

		// declare helper object.
		$helper = new NOO_Customizer_Helper( $wp_customize );

		foreach ($noo_post_types as $post_type => $args) {
			if( !isset( $args['customizer'] ) || empty( $args['customizer'] ) )
				continue;

			$pt_customizer = $args['customizer'];

			$pt_customizer['panel'] = isset( $pt_customizer['panel'] ) ? $pt_customizer['panel'] : array( 'single' );

			$helper->add_section(
				array(
					'id' => "noo_umbra_customizer_section_{$post_type}",
					'label' => $args['name'],
					'description' => sprintf( esc_html__( 'Firstly assign a page as your %s page from dropdown list. %s page can be any page. Once you chose a page as %s Page, its slug will be your %s\'s main slug.', 'noo-umbra' ), $args['name'], $args['name'], $args['name'], $args['name'] ),
					'is_panel' => count( $pt_customizer['panel'] ) > 1
				)
			);

			if( in_array('list', $pt_customizer['panel'] ) ) {
				// Sub-section: List
				$helper->add_sub_section(
					"{$post_type}_archive_sub_section",
					sprintf( esc_html__( 'List %s', 'noo-umbra' ), $args['name'] )
				);
			}

			if( in_array('page', $pt_customizer) ) {
				// Control: Post type Page
				$helper->add_control(
					array(
						'id' => "{$post_type}_archive_page",
						'type' => 'pages_select',
						'label' => sprintf( esc_html__( '%s Page', 'noo-umbra' ), $args['name'] ),
						'default' => '',
					)
				);
			}

			if( in_array('heading-title', $pt_customizer) ) {
				$default = isset( $args['heading-title'] ) ? $args['heading-title'] : sprintf( esc_html__( '%s List', 'noo-umbra' ), $args['name'] );

				// Control: Heading Title
				$helper->add_control(
					array(
						'id' => "{$post_type}_heading_title",
						'type' => 'text',
						'label' => sprintf( esc_html__( '%s Heading Title', 'noo-umbra' ), $args['name'] ),
						'default' => $default,
					)
				);
			}

			if( in_array('heading-image', $pt_customizer) ) {
				// Control: Heading Title
				$helper->add_control(
					array(
						'id' => "{$post_type}_heading_image",
						'type' => 'noo_image',
						'label' => sprintf( esc_html__( '%s Heading Background Image', 'noo-umbra' ), $args['name'] ),
						'default' => '',
					)
				);
			}

			if( in_array('list-layout', $pt_customizer) ) {
				// Control: List Layout
				$helper->add_control(
					array(
						'id' => "{$post_type}_archive_layout",
						'type' => 'noo_radio',
						'label' => sprintf( esc_html__( '%s List Layout', 'noo-umbra' ), $args['name'] ),
						'default' => 'sidebar',
						'control' => array(
								'choices' => array(
									'fullwidth'   => esc_html__( 'Full-Width', 'noo-umbra' ),
									'sidebar'   => esc_html__( 'With Right Sidebar', 'noo-umbra' ),
									'left_sidebar'   => esc_html__( 'With Left Sidebar', 'noo-umbra' )
								),
								'json' => array(
									'child_options' => array(
										'fullwidth'   => '',
										'sidebar'   => "{$post_type}_archive_sidebar",
										'left_sidebar'   => "{$post_type}_archive_sidebar"
									)
								)
							),
					)
				);

				// Control: Event List Sidebar
				$helper->add_control(
					array(
						'id' => "{$post_type}_archive_sidebar",
						'type' => 'widgets_select',
						'label' => sprintf( esc_html__( '%s List Sidebar', 'noo-umbra' ), $args['name'] ),
						'default' => 'sidebar-main',
					)
				);
			}

			if( in_array('layout', $pt_customizer) ) {
				// Control: List Layout
				$helper->add_control(
					array(
						'id' => "{$post_type}_archive_layout",
						'type' => 'noo_radio',
						'label' => sprintf( esc_html__( '%s Layout', 'noo-umbra' ), $args['name'] ),
						'default' => 'sidebar',
						'control' => array(
								'choices' => array(
									'fullwidth'   => esc_html__( 'Full-Width', 'noo-umbra' ),
									'sidebar'   => esc_html__( 'With Right Sidebar', 'noo-umbra' ),
									'left_sidebar'   => esc_html__( 'With Left Sidebar', 'noo-umbra' )
								),
								'json' => array(
									'child_options' => array(
										'fullwidth'   => '',
										'sidebar'   => "{$post_type}_archive_sidebar",
										'left_sidebar'   => "{$post_type}_archive_sidebar"
									)
								)
							),
					)
				);

				// Control: Event List Sidebar
				$helper->add_control(
					array(
						'id' => "{$post_type}_archive_sidebar",
						'type' => 'widgets_select',
						'label' => sprintf( esc_html__( '%s Sidebar', 'noo-umbra' ), $args['name'] ),
						'default' => 'sidebar-main',
					)
				);
			}

			do_action( "{$post_type}_archive_customizer", $wp_customize );

			if( in_array('list_num', $pt_customizer) ) {
				// Control: Number of Item per Page
				$helper->add_control(
					array(
						'id' => "{$post_type}_num",
						'type' => 'ui_slider',
						'label' => esc_html__( 'Items Per Page', 'noo-umbra' ),
						'8',
		 				'control' => array(
		 					'json' => array(
		 						'data_min'  => '4',
		 						'data_max'  => '50',
		 						'data_step' => '2'
		 					)
		 				),
					)
				);
			}

			if( in_array('single', $pt_customizer['panel'] ) ) {
				// Sub-section: Single
				$helper->add_sub_section(
					"{$post_type}_single_sub_section",
					sprintf( esc_html__( 'Single %s', 'noo-umbra' ), $args['singular_name'] )
				);
			}

			if( in_array('single-layout', $pt_customizer) ) {
				// Control: Single Layout
				$helper->add_control(
					array(
						'id' => "{$post_type}_single_layout",
						'type' => 'noo_same_as_radio',
						'label' => sprintf( esc_html__( 'Single %s Layout', 'noo-umbra' ), $args['singular_name'] ),
						'default' => "same_as_archive",
						'control' => array(
								'choices' => array(
									"same_as_archive"   => sprintf( esc_html__( 'Same as %s List Layout', 'noo-umbra' ), $args['name'] ),
									'fullwidth'   => esc_html__( 'Full-Width', 'noo-umbra' ),
									'sidebar'   => esc_html__( 'With Right Sidebar', 'noo-umbra' ),
									'left_sidebar'   => esc_html__( 'With Left Sidebar', 'noo-umbra' ),
								),
								'json' => array(
									'child_options' => array(
										'fullwidth'   => '',
										'sidebar'   => "{$post_type}_single_sidebar",
										'left_sidebar'   => "{$post_type}_single_sidebar",
									)
								)
							),
					)
				);

				// Control: Single Sidebar
				$helper->add_control(
					array(
						'id' => "{$post_type}_single_sidebar",
						'type' => 'widgets_select',
						'label' => sprintf( esc_html__( '%s Sidebar', 'noo-umbra' ), $args['singular_name'] ),
						'default' => 'sidebar-main',
					)
				);
			}



			do_action( "{$post_type}_single_customizer", $wp_customize );

			if( in_array('single-social', $pt_customizer) ) {
				$helper->add_control(
				 	array(
						'id' => "{$post_type}_single_divider_1",
						'type' => 'divider'
					)
				);

				// Control: Enable Social Sharing
		        $helper->add_control(
		        	array(
						'id' => "{$post_type}_single_social",
						'type' => 'noo_switch',
						'label' => esc_html__( 'Enable Social Sharing', 'noo-umbra' ),
						'default' => 1,
						'control' => array(
			                'json' => array( 'on_child_options' => "{$post_type}_single_social_facebook,
					                                                {$post_type}_single_social_twitter,
					                                                {$post_type}_single_social_google,
					                                                {$post_type}_single_social_pinterest,
					                                                {$post_type}_single_social_linkedin"
			                )
			            )
					)
		        );

				// Control: Facebook Share
				$helper->add_control(
					array(
						'id' => "{$post_type}_single_social_facebook",
						'type' => 'noo_switch',
						'label' => esc_html__( 'Facebook Share', 'noo-umbra' ),
						'default' => 1,
					)
				);

				// Control: Twitter Share
				$helper->add_control(
					array(
						'id' => "{$post_type}_single_social_twitter",
						'type' => 'noo_switch',
						'label' => esc_html__( 'Twitter Share', 'noo-umbra' ),
						'default' => 1,
					)
				);

				// Control: Google+ Share
				$helper->add_control(
					array(
						'id' => "{$post_type}_single_social_google",
						'type' => 'noo_switch',
						'label' => esc_html__( 'Google+ Share', 'noo-umbra' ),
						'default' => 1,
					)
				);

				// Control: Pinterest Share
				$helper->add_control(
					array(
						'id' => "{$post_type}_single_social_pinterest",
						'type' => 'noo_switch',
						'label' => esc_html__( 'Pinterest Share', 'noo-umbra' ),
						'default' => 1,
					)
				);

				// Control: LinkedIn Share
				$helper->add_control(
					array(
						'id' => "{$post_type}_single_social_linkedin",
						'type' => 'noo_switch',
						'label' => esc_html__( 'LinkedIn Share', 'noo-umbra' ),
						'default' => 1,
					)
				);
			}
		}
        
	}
	add_action( 'customize_register', 'noo_umbra_customizer_register_options_post_type' );
endif;

// 9. Portfolio options.

// 10. WooCommerce options.
 if( NOO_WOOCOMMERCE_EXIST ) :
 	if ( ! function_exists( 'noo_umbra_customizer_register_options_woocommerce' ) ) :
 		function noo_umbra_customizer_register_options_woocommerce( $wp_customize ) {

 			// declare helper object.
 			$helper = new NOO_Customizer_Helper( $wp_customize );

 			// Section: Revolution Slider
 			$helper->add_section(
 				'noo_umbra_customizer_section_shop',
 				esc_html__( 'WooCommerce', 'noo-umbra' ),
 				'',
 				true
 			);

 			// Sub-section: Shop Page
 			$helper->add_sub_section(
 				'noo_woocommerce_sub_section_shop_page',
 				esc_html__( 'Shop Page', 'noo-umbra' ),
 				esc_html__( 'Choose Layout and Headline Settings for your Shop Page.', 'noo-umbra' )
 			);

            // Control: Heading status
            $helper->add_control(
                'noo_shop_heading_status',
                'noo_radio',
                esc_html__( 'Show Heading?', 'noo-umbra' ),
                'show',
                array(
                    'choices' => array(
                        'show'   => esc_html__( 'Show', 'noo-umbra' ),
                        'hide'       => esc_html__( 'Hide', 'noo-umbra' ),
                    ),
                )
            );

            // Control: Heading height
            $helper->add_control(
                'noo_shop_heading_height',
                'ui_slider',
                esc_html__( 'Height of Heading background', 'noo-umbra' ),
                '360',
                array(
                    'json' => array(
                        'data_min'  => 360,
                        'data_max'  => 760,
                        'data_step' => 30
                    )
                )
            );
            // Control: Heading Sub Title
            $helper->add_control(
                'noo_shop_heading_parallax',
                'checkbox',
                esc_html__( 'Using parallax ?', 'noo-umbra' ),
                true
            );

            // Control: Heading Title
            $helper->add_control(
                'noo_shop_heading_title',
                'text',
                esc_html__( 'Shop title', 'noo-umbra' ),
                esc_html__('Shop', 'noo-umbra')
            );
            // Control: Heading sub Title
            $helper->add_control(
                'noo_shop_heading_sub_title',
                'text',
                esc_html__( 'Shop sub title ', 'noo-umbra' ),
                esc_html__('Shop', 'noo-umbra')
            );


            // Control: Heading Image
            $helper->add_control(
                'noo_shop_heading_image',
                'noo_image',
                esc_html__( 'Heading Background Image', 'noo-umbra' ),
                ''
            );

            // Control: Divider 2
            $helper->add_control( 'noo_blog_divider_2', 'divider', '' );

            $helper->add_control(
                'noo_shop_width',
                'noo_radio',
                esc_html__( 'Shop Layout', 'noo-umbra' ),
                'fullwidth',
                array(
                    'choices' => array(
                        'fullwidth'   => esc_html__( 'Fullwidth', 'noo-umbra' ),
                        'boxed'       => esc_html__( 'Boxed', 'noo-umbra' ),
                    ),
                )
            );


 			// Control: Shop Layout
 			$helper->add_control(
 				'noo_shop_layout_sidebar',
 				'noo_radio',
 				esc_html__( 'Shop Sidebar', 'noo-umbra' ),
 				'no_sidebar',
 				array(
 					'choices' => array(
                        'no_sidebar'     => esc_html__( 'No Sidebar', 'noo-umbra' ),
 						'right_sidebar'  => esc_html__( 'With Right Sidebar', 'noo-umbra' ),
 						'left_sidebar'   => esc_html__( 'With Left Sidebar', 'noo-umbra' )
 					),
 				)
 			);

 			// Control: Shop Sidebar
 			$helper->add_control(
 				'noo_shop_sidebar',
 				'widgets_select',
 				esc_html__( 'Choose Sidebar', 'noo-umbra' ),
 				''
 			);

 			// Control: Divider 1
 			$helper->add_control( 'noo_shop_divider_1', 'divider', '' );


            $helper->add_control(
                'noo_shop_grid_column',
                'ui_slider',
                esc_html__( 'Products Grid Columns', 'noo-umbra' ),
                '5',
                array(
                    'json' => array(
                        'data_min'  => 1,
                        'data_max'  => 5,
                        'data_step' => 1
                    )
                )
            );

            $helper->add_control(
                'noo_shop_default_attribute',
                'noo_radio',
                esc_html__( 'Show filter by attribute ?', 'noo-umbra' ),
                'no',
                array(
                    'choices' => array(
                        'no'   => esc_html__( 'No', 'noo-umbra' ),
                        'yes'   => esc_html__( 'Yes', 'noo-umbra' ),
                    ),
                )
            );

 			$helper->add_control(
 				'noo_shop_default_layout',
 				'noo_radio',
 				esc_html__( 'Shop display by view ?', 'noo-umbra' ),
 				'grid',
 				array(
 					'choices' => array(
 						'grid'   => esc_html__( 'Grid', 'noo-umbra' ),
 						'list'   => esc_html__( 'List', 'noo-umbra' ),
 					),
 				)
 			);


 			$helper->add_control(
 				'noo_shop_default_style',
 				'noo_radio',
 				esc_html__( 'Shop View Style ?', 'noo-umbra' ),
 				'one',
 				array(
 					'choices'       => array(
 						'one'       => esc_html__( 'Style one', 'noo-umbra' ),
 						'two'       => esc_html__( 'Style two', 'noo-umbra' ),
                        'three'     => esc_html__( 'Style three', 'noo-umbra' ),
 					),
 				)
 			);



 			// Control: Number of Product per Page
 			$helper->add_control(
 				'noo_shop_num',
 				'ui_slider',
 				esc_html__( 'Products Per Page', 'noo-umbra' ),
 				'12',
 				array(
 					'json' => array(
 						'data_min'  => 4,
 						'data_max'  => 50,
 						'data_step' => 2
 					)
 				)
 			);

			$helper->add_control(
				'noo_shop_show_popup_added',
				'noo_switch',
				esc_html__( 'Show popup after adding to cart', 'noo-umbra' ),
				0,
				array()
			);

 			// Sub-section: Single Product
 			$helper->add_sub_section(
 				'noo_woocommerce_sub_section_product',
 				esc_html__( 'Single Product', 'noo-umbra' )
 			);

 			// Control: Product Layout

 			$helper->add_control(
 				'noo_woocommerce_product_layout',
 				'noo_radio',
 				esc_html__( 'Product Layout', 'noo-umbra' ),
 				'fullwidth',
 				array(
 					'choices' => array(
 						'fullwidth'   => esc_html__( 'Full-Width', 'noo-umbra' ),
 						'boxed'       => esc_html__( 'Boxed', 'noo-umbra' ),
 					),
 				)
 			);

 			// Control: Shop Layout
 			$helper->add_control(
 				'noo_woocommerce_layout_sidebar',
 				'noo_radio',
 				esc_html__( 'Shop Sidebar', 'noo-umbra' ),
 				'no_sidebar',
 				array(
 					'choices' => array(
                        'no_sidebar'     => esc_html__( 'No Sidebar', 'noo-umbra' ),
 						'right_sidebar'  => esc_html__( 'With Right Sidebar', 'noo-umbra' ),
 						'left_sidebar'   => esc_html__( 'With Left Sidebar', 'noo-umbra' )
 					),
 					'json' => array(
 						'child_options' => array(
							'no_sidebar'    => '',
							'right_sidebar' => 'noo_woocommerce_product_sidebar',
							'left_sidebar'  => 'noo_woocommerce_product_sidebar',
 						)
 					)
 				)
 			);

 			// Control: Product Sidebar
 			$helper->add_control(
 				'noo_woocommerce_product_sidebar',
 				'widgets_select',
 				esc_html__( 'Product Sidebar', 'noo-umbra' ),
 				''
 			);

 			// Control: Divider 1
 			$helper->add_control( 'noo_shop_divider_5', 'divider', '' );

 			// Control: Products related
 		    $helper->add_control(
 			    'noo_woocommerce_product_related',
 			    'text',
 			    esc_html__( 'Number of Related Products', 'noo-umbra' ),
 			    '5'
 		    );

 			$helper->add_control(
                'noo_woocommerce_product_grid_column',
                'ui_slider',
                esc_html__( 'Related Products Grid Columns', 'noo-umbra' ),
                '3',
                array(
                    'json' => array(
                        'data_min'  => 1,
                        'data_max'  => 5,
                        'data_step' => 1
                    )
                )
            );

 		}
 	add_action( 'customize_register', 'noo_umbra_customizer_register_options_woocommerce' );
 	endif;
 endif;





// 12. Custom Code
if ( ! function_exists( 'noo_umbra_customizer_register_options_custom_code' ) ) :
	function noo_umbra_customizer_register_options_custom_code( $wp_customize ) {

		// declare helper object.
		$helper = new NOO_Customizer_Helper( $wp_customize );

		// Section: Custom Code
		$helper->add_section(
			'noo_umbra_customizer_section_custom_code',
			esc_html__( 'Custom Code', 'noo-umbra' ),
			esc_html__( 'In this section you can add custom JavaScript and CSS to your site.<br/>Your Google analytics tracking code should be added to Custom JavaScript field.', 'noo-umbra' )
		);

		// Control: Custom JS (Google Analytics)
		$helper->add_control(
			'noo_custom_javascript',
			'textarea',
			esc_html__( 'Custom JavaScript', 'noo-umbra' ),
			'',
			array( 'preview_type' => 'custom' )
		);

		// Control: Custom CSS
		$helper->add_control(
			'noo_custom_css',
			'textarea',
			esc_html__( 'Custom CSS', 'noo-umbra' ),
			'',
			array( 'preview_type' => 'custom' )
		);
	}
add_action( 'customize_register', 'noo_umbra_customizer_register_options_custom_code' );
endif;

// 13. Import/Export Settings.
if ( ! function_exists( 'noo_umbra_customizer_register_options_tools' ) ) :
	function noo_umbra_customizer_register_options_tools( $wp_customize ) {

		// declare helper object.
		$helper = new NOO_Customizer_Helper( $wp_customize );

		// Section: Custom Code
		$helper->add_section(
			'noo_umbra_customizer_section_tools',
			esc_html__( 'Import/Export Settings', 'noo-umbra' ),
			esc_html__( 'All themes from NooTheme share the same theme setting structure so you can export then import settings from one theme to another conveniently without any problem.', 'noo-umbra' )
		);

		// Sub-section: Import Settings
		$helper->add_sub_section(
			'noo_tools_sub_section_import',
			esc_html__( 'Import Settings', 'noo-umbra' ),
			noo_umbra_kses( __( 'Click Upload button then choose a JSON file (.json) from your computer to import settings to this theme.<br/>All the settings will be loaded for preview here and will not be saved until you click button "Save and Publish".', 'noo-umbra' ) )
		);

		// Control: Upload Settings
		$helper->add_control(
			'noo_tools_import',
			'import_settings',
			esc_html__( 'Upload', 'noo-umbra' )
		);

		// Sub-section: Export Settings
		$helper->add_sub_section(
			'noo_tools_sub_section_export',
			esc_html__( 'Export Settings', 'noo-umbra' ),
			noo_umbra_kses( __( 'Simply click Download button to export all your settings to a JSON file (.json).<br/>You then can use that file to restore theme settings to any theme of NooTheme.', 'noo-umbra' ) )
		);

		// Control: Download Settings
		$helper->add_control(
			'noo_tools_export',
			'export_settings',
			esc_html__( 'Download', 'noo-umbra' )
		);

	}
add_action( 'customize_register', 'noo_umbra_customizer_register_options_tools' );
endif;

