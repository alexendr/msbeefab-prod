<?php
/**
 * NOO Meta Boxes Package
 *
 * Setup NOO Meta Boxes for Post
 * This file add Meta Boxes to WP Post edit page.
 *
 * @package    NOO Framework
 * @subpackage NOO Meta Boxes
 * @version    1.0.0
 * @author     Kan Nguyen <khanhnq@nootheme.com>
 * @copyright  Copyright (c) 2014, NooTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://nootheme.com
 */
if (!function_exists('noo_umbra_post_meta_boxes')):
	function noo_umbra_post_meta_boxes() {
		// Declare helper object
		$prefix = '_noo_wp_post';
		$helper = new NOO_Meta_Boxes_Helper($prefix, array(
			'page' => 'post'
		));

		// Post type: Gallery
		$meta_box = array(
			'id' => "{$prefix}_meta_box_gallery",
			'title' => esc_html__( 'Gallery Settings', 'noo-umbra'),
			'fields' => array(
				array(
					'id' => "{$prefix}_gallery",
					// 'label' => esc_html__( 'Your Gallery', 'noo-umbra' ),
					'type' => 'gallery',
				),
				array(
					'type' => 'divider',
				),
				array(
					'id' => "{$prefix}_gallery_preview",
					'label' => esc_html__( 'Preview Content', 'noo-umbra'),
					'type' => 'radio',
					'std' => 'featured',
					'options' => array(
						array(
							'label' => esc_html__( 'Featured Image', 'noo-umbra'),
							'value' => 'featured',
						),
						array(
							'label' => esc_html__( 'First Image on Gallery', 'noo-umbra'),
							'value' => 'first_image',
						),
						array(
							'label' => esc_html__( 'Image Slideshow', 'noo-umbra'),
							'value' => 'slideshow',
						),
					)
				)
			)
		);

		$helper->add_meta_box($meta_box);

		// Post type: Video
		$meta_box = array(
			'id' => "{$prefix}_meta_box_video",
			'title' => esc_html__( 'Video Settings', 'noo-umbra'),
			'fields' => array(
				array(
					'id' => "{$prefix}_video_embed",
					'label' => esc_html__( 'Embedded Video Code', 'noo-umbra'),
					'desc' => esc_html__( 'If you are using videos from online sharing sites (YouTube, Vimeo, etc.) paste the embedded code here. This field will override the above settings.', 'noo-umbra'),
					'type' => 'textarea',
					'std' => ''
				),
				array(
					'id' => "{$prefix}_video_ratio",
					'label' => esc_html__( 'Video Aspect Ratio', 'noo-umbra'),
					'desc' => esc_html__( 'Choose the aspect ratio for your video.', 'noo-umbra'),
					'type' => 'select',
					'std' => '16:9',
					'options' => array(
						array('value'=>'16:9','label'=>'16:9'),
						array('value'=>'5:3','label'=>'5:3'),
						array('value'=>'5:4','label'=>'5:4'),
						array('value'=>'4:3','label'=>'4:3'),
						array('value'=>'3:2','label'=>'3:2')
					)
				),
				array(
					'label' => esc_html__( 'Preview Content', 'noo-umbra'),
					'id' => "{$prefix}_video_preview",
					'type' => 'radio',
					'std' => 'video',
					'options' => array(
						array(
							'label' => esc_html__( 'Featured Image', 'noo-umbra'),
							'value' => 'featured',
						),
						array(
							'label' => esc_html__( 'Video', 'noo-umbra'),
							'value' => 'video',
						)
					)
				)
			)
		);
		
		$helper->add_meta_box($meta_box);

		// Post type: Audio
		$meta_box = array(
			'id' => "{$prefix}_meta_box_audio",
			'title' => esc_html__( 'Audio Settings', 'noo-umbra'),
			'fields' => array(
				array(
					'id' => "{$prefix}_audio_embed",
					'label' => esc_html__( 'Embedded Audio Code', 'noo-umbra'),
					'desc' => esc_html__( 'If you are using videos from online sharing sites (like Soundcloud) paste the embedded code here. This field will override above settings.', 'noo-umbra'),
					'type' => 'textarea',
					'std' => ''
				)
			)
		);
		
		$helper->add_meta_box($meta_box);

		// Post type: Quote
		$meta_box = array(
			'id' => "{$prefix}_meta_box_quote",
			'title' => esc_html__( 'Quote Settings', 'noo-umbra'),
			'fields' => array(
				array(
					'id' => "{$prefix}_quote",
					'label' => esc_html__( 'The Quote', 'noo-umbra'),
					'desc' => esc_html__( 'Input your quote.', 'noo-umbra'),
					'type' => 'textarea',
				),
				array(
					'id' => "{$prefix}_quote_citation",
					'label' => esc_html__( 'Citation', 'noo-umbra'),
					'desc' => esc_html__( 'Who originally said the quote?', 'noo-umbra'),
					'type' => 'text',
				)
			)
		);
		
		$helper->add_meta_box($meta_box);

		// Post type: Link
		$meta_box = array(
			'id' => "{$prefix}_meta_box_link",
			'priority' => 'core',
			'title' => esc_html__( 'Link Settings', 'noo-umbra'),
			'fields' => array(
				array(
					'id' => "{$prefix}_link",
					'label' => esc_html__( 'The Link', 'noo-umbra'),
					'type' => 'text',
					'std' => 'http://nootheme.com',
				)
			)
		);
		
		$helper->add_meta_box($meta_box);

		// Page Settings: Single Post
		$meta_box = array(
			'id' => "{$prefix}_meta_box_single_page",
			'title' => esc_html__( 'Page Settings: Single Post', 'noo-umbra'),
			'description' => esc_html__( 'Choose various setting for your Single Post page.', 'noo-umbra'),
			'fields' => array(
				array(
					'label' => esc_html__( 'Page Layout', 'noo-umbra'),
					'id' => "{$prefix}_global_setting",
					'type' => 'page_layout',
				),
				array(
					'label' => esc_html__( 'Override Global Settings?', 'noo-umbra'),
					'id' => "{$prefix}_override_layout",
					'type' => 'checkbox',
					'child-fields' => array(
						'on' => "{$prefix}_layout,{$prefix}_sidebar"
					),
				),
				array(
					'label' => esc_html__( 'Page Layout', 'noo-umbra'),
					'id' => "{$prefix}_layout",
					'type' => 'radio',
					'std' => 'sidebar',
					'options' => array(
						'fullwidth' => array(
							'label' => esc_html__( 'Full-Width', 'noo-umbra'),
							'value' => 'fullwidth',
						),
						'sidebar' => array(
							'label' => esc_html__( 'With Right Sidebar', 'noo-umbra'),
							'value' => 'sidebar',
						),
						'left_sidebar' => array(
							'label' => esc_html__( 'With Left Sidebar', 'noo-umbra'),
							'value' => 'left_sidebar',
						),
					),
					// 'child-fields' => array(
					// 	'sidebar' => "{$prefix}_sidebar",
					// 	'left_sidebar' => "{$prefix}_sidebar",
					// ),
					
				),
				array(
					'label' => esc_html__( 'Post Sidebar', 'noo-umbra'),
					'id' => "{$prefix}_sidebar",
					'type' => 'sidebars',
					'std' => 'sidebar-main'
				),
			)
		);


		$meta_box['fields'][] = array( 'type' => 'divider' );
		$meta_box['fields'][] = array(
							'id'    => 'single_post_heading_image',
							'label' => esc_html__( 'Heading Background Image', 'noo-umbra' ),
							'desc'  => esc_html__( 'An unique heading image for this post. If leave it blank, the default heading image of Blog single ( in Customizer settings ) will be used.', 'noo-umbra'),
							'type'  => 'image',
						);


		$helper->add_meta_box( $meta_box );
	}
	
endif;

add_action('add_meta_boxes', 'noo_umbra_post_meta_boxes');
