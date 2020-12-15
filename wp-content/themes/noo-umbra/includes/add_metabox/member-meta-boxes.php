<?php
/**
 * NOO Meta Boxes Package
 *
 * Setup NOO Meta Boxes for Member
 * This file add Meta Boxes to WP Page edit Member.
 *
 * @package    NOO Framework
 * @subpackage NOO Meta Boxes
 * @version    1.0.0
 * @author     Kan Nguyen <khanhnq@nootheme.com>
 * @copyright  Copyright (c) 2015, NooTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://nootheme.com
 */

if (!function_exists('noo_umbra_member_meta_boxes')):
    function noo_umbra_member_meta_boxes() {
        // Declare helper object
        $prefix = '_noo_wp_team_member';
        $helper = new NOO_Meta_Boxes_Helper($prefix, array(
            'page' => 'team_member'
        ));

        // infomation
        $meta_box = array(
            'id' => "{$prefix}_meta_box_team_member",
            'title' => esc_html__('Member Information:', 'noo-umbra'),
            'fields' => array(
                array(
                    'id' => "{$prefix}_image",
                    'label' => esc_html__( 'Image', 'noo-umbra' ),
                    'type' => 'image',
                ),
                array(
                    'id' => "{$prefix}_name",
                    'label' => esc_html__( 'Name', 'noo-umbra' ),
                    'type' => 'text',
                ),
                array(
                    'id' => "{$prefix}_position",
                    'label' => esc_html__( 'Position', 'noo-umbra' ),
                    'type' => 'text',
                )

            )
        );
        $helper->add_meta_box($meta_box);

        $meta_box = array(
            'id' => "{$prefix}_meta_box_member_social",
            'title' => esc_html__('Media Data: Social', 'noo-umbra'),
            'fields' => array(
                array(
                    'id' => "{$prefix}_facebook",
                    'label' => esc_html__( 'Facebook', 'noo-umbra' ),
                    'type' => 'text',
                ),
                array(
                    'id' => "{$prefix}_twitter",
                    'label' => esc_html__( 'Twitter', 'noo-umbra' ),
                    'type' => 'text',
                ),
                array(
                    'id' => "{$prefix}_google",
                    'label' => esc_html__( 'Google +', 'noo-umbra' ),
                    'type' => 'text',
                ),
                array(
                    'id' => "{$prefix}_linkedin",
                    'label' => esc_html__( 'Linkedin', 'noo-umbra' ),
                    'type' => 'text',
                ),
                array(
                    'id' => "{$prefix}_flickr",
                    'label' => esc_html__( 'Flickr', 'noo-umbra' ),
                    'type' => 'text',
                ),
                array(
                    'id' => "{$prefix}_pinterest",
                    'label' => esc_html__( 'Pinterest', 'noo-umbra' ),
                    'type' => 'text',
                ),
                array(
                    'id' => "{$prefix}_instagram",
                    'label' => esc_html__( 'Instagram', 'noo-umbra' ),
                    'type' => 'text',
                ),
                array(
                    'id' => "{$prefix}_tumblr",
                    'label' => esc_html__( 'Tumblr', 'noo-umbra' ),
                    'type' => 'text',
                )
            )
        );
        $helper->add_meta_box($meta_box);
    }
endif;

add_action('add_meta_boxes', 'noo_umbra_member_meta_boxes');