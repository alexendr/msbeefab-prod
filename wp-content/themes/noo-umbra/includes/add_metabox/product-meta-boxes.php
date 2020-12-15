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
if (!function_exists('noo_umbra_product_meta_boxes')):
	function noo_umbra_product_meta_boxes() {
		// Declare helper object
		$prefix = '_noo_wp_product';
		$helper = new NOO_Meta_Boxes_Helper($prefix, array(
			'page' => 'product'
		));


		// Page Settings: Single Post
		$meta_box = array(
			'id' => "{$prefix}_meta_box_single_page",
			'title' => esc_html__( 'Page Settings: Single Product', 'noo-umbra'),
			'description' => esc_html__( 'Choose various setting for your Single product page.', 'noo-umbra'),
		);
		$meta_box['fields'][] = array( 'type' => 'divider' );
		$meta_box['fields'][] = array(
							'id'    => 'single_product_heading_image',
							'label' => esc_html__( 'Heading Background Image', 'noo-umbra' ),
							'desc'  => esc_html__( 'An unique heading image for this post. If leave it blank, the default heading image of Blog single ( in Customizer settings ) will be used.', 'noo-umbra'),
							'type'  => 'image',
						);


		$helper->add_meta_box( $meta_box );

	}
	
endif;

add_action('add_meta_boxes', 'noo_umbra_product_meta_boxes');
