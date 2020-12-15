<?php
/**
 * NOO Meta Boxes Package
 *
 * Setup NOO Meta Boxes for Page
 * This file add Meta Boxes to WP Page edit page.
 *
 * @package    NOO Framework
 * @subpackage NOO Meta Boxes
 * @version    1.0.0
 * @author     Kan Nguyen <khanhnq@nootheme.com>
 * @copyright  Copyright (c) 2014, NooTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://nootheme.com
 */

if (!function_exists('noo_umbra_page_meta_boxes')):
	function noo_umbra_page_meta_boxes() {
		// Declare helper object
		$prefix = '_noo_wp_page';
		$helper = new NOO_Meta_Boxes_Helper($prefix, array(
			'page' => 'page'
		));

		// Page Settings
		$meta_box = array(
			'id' => "{$prefix}_meta_box_page_heading",
			'title' => esc_html__( 'Heading Settings', 'noo-umbra') ,
			'description' => esc_html__( 'Choose various setting for your heading.', 'noo-umbra') ,
			'fields' => array(
                array(
                    'label' => esc_html__( 'Show Heading ?', 'noo-umbra') ,
                    'id' => "{$prefix}_status_heading",
                    'type' => 'radio',
                    'std'   => 'hide',
                    'options' => array(
                        array('value'=>'show','label' => esc_html__( 'Show', 'noo-umbra') ),
                        array('value'=>'hide','label' => esc_html__( 'Hide', 'noo-umbra') ),
                    )
                ),
                array(
                    'id'    => '_heading_sub_title',
                    'label' => esc_html__( 'Sub title', 'noo-umbra' ),
                    'type'  => 'text',
                ),
                array(
                    'id'    => '_heading_height',
                    'label' => esc_html__( 'Height of Heading background', 'noo-umbra' ),
                    'type'  => 'text',
                    'desc'  => esc_html__( 'Height heading using unit px', 'noo-umbra'),
                    'std'   =>  360
                ),
                array(
                    'label' => esc_html__( 'Using parallax for heading ?', 'noo-umbra') ,
                    'id'    => "noo_parallax_heading",
                    'desc'  => esc_html__( 'Please choose image have height image > height of heading', 'noo-umbra'),
                    'type'  => 'checkbox',
                    'std'   => true,
                ),
                array(
                    'id'    => '_heading_image',
                    'label' => esc_html__( 'Heading Background Image', 'noo-umbra' ),
                    'desc'  => esc_html__( 'An unique heading image for this page', 'noo-umbra'),
                    'type'  => 'image',
                )
			)
		);

		$helper->add_meta_box( $meta_box );

		// Page Settings
		$meta_box = array(
			'id' => "{$prefix}_meta_box_page",
			'title' => esc_html__( 'Header Settings', 'noo-umbra') ,
			'description' => esc_html__( 'Choose various setting for your Page.', 'noo-umbra') ,
			'fields' => array(
                array(
                    'id'    => "{$prefix}_nav_position",
                    'label' => esc_html__( 'Navbar Position' , 'noo-umbra' ),
                    'desc'  => esc_html__( 'Navbar Position for Page', 'noo-umbra' ),
                    'type'  => 'radio',
                    'std'   => 'default',
                    'options' => array(
                        array('value'=>'default','label'=> esc_html__('Using Navbar Position in customizer','noo-umbra')),
                        array('value'=>'static_top','label'=>esc_html__('Static Top','noo-umbra')),
                        array('value'=>'fixed_top','label'=>esc_html__('Fixed Top','noo-umbra'))
                    ),
                ),
                array(
                    'id'    => "{$prefix}_header_style",
                    'label' => esc_html__( 'Header Setting' , 'noo-umbra' ),
                    'desc'  => esc_html__( 'Header Setting for this page.', 'noo-umbra' ),
                    'type'  => 'radio',
                    'std'   => 'default',
                    'options' => array(
                        array('value'=>'default','label' => esc_html__( 'Using Header in customizer', 'noo-umbra') ),
                        array('value'=>'header-1','label' => esc_html__( 'Header Default', 'noo-umbra') ),
                        array('value'=>'header-2','label' => esc_html__( 'Header Business', 'noo-umbra') ),
                        array('value'=>'header-3','label' => esc_html__( 'Header Center', 'noo-umbra') ),
                        array('value'=>'transparent','label' => esc_html__( 'Header Transparent', 'noo-umbra') )
                    )
                ),
			)
		);


        $helper->add_meta_box( $meta_box );

        // Page Sidebar
        $meta_box = array(
            'id' => "{$prefix}_meta_box_sidebar",
            'title' => esc_html__( 'Sidebar', 'noo-emigo'),
            'context'      => 'side',
            'priority'     => 'default',
            'fields' => array(
                array(
                    'label' => esc_html__( 'Page Sidebar', 'noo-emigo') ,
                    'id' => "{$prefix}_sidebar",
                    'type' => 'sidebars',
                    'std' => 'sidebar-main'
                ) ,
            )
        );

        $helper->add_meta_box( $meta_box );
		//
		// Revolution Sliders
		//
		if ( class_exists( 'RevSlider' ) ) {
			// Home Slider
			$meta_box = array(
				'id' => "{$prefix}_meta_box_home_slider",
				'title' => __('Choose Revolution', 'noo-umbra'),
				'description' => esc_html__( 'This option only using when you choose Template: Page Revolution', 'noo-umbra') ,
				'fields' => array(
					array(
						'label' => __( 'Revolution Slider', 'noo-umbra' ),
						'desc' => __( 'Select a Slider from Revolution Slider.', 'noo-umbra' ),
						'id'   => "{$prefix}_slider_rev",
						'type' => 'rev_slider',
						'std'  => ''
					)
				)
			);

			$helper->add_meta_box($meta_box);
		}
	}
endif;

add_action('add_meta_boxes', 'noo_umbra_page_meta_boxes');