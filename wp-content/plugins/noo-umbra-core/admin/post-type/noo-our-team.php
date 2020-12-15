<?php
/**
 * Register NOO team.
 * This file register Item and Category for NOO team.
 *
 * @package    NOO Framework
 * @subpackage NOO team
 * @version    1.0.0
 * @author     Kan Nguyen <khanhnq@nootheme.com>
 * @copyright  Copyright (c) 2015, NooTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://nootheme.com
 */

if( !class_exists('Noo_Our_Team') ):

    class Noo_Our_Team{

        public function __construct(){
            add_action('init', array($this,'register_post_type'));
        }
        public function register_post_type(){

            // Text for NOO team.
            $team_labels = array(
                'name'          => esc_html__('Team Member', 'noo-umbra-core') ,
                'singular_name' => esc_html__('Team Member', 'noo-umbra-core') ,
                'menu_name'     => esc_html__('Team Member', 'noo-umbra-core') ,
                'add_new'       => esc_html__('Add New', 'noo-umbra-core') ,
                'add_new_item'  => esc_html__('Add New team Item', 'noo-umbra-core') ,
                'edit_item'     => esc_html__('Edit team Item', 'noo-umbra-core') ,
                'new_item'      => esc_html__('Add New team Item', 'noo-umbra-core') ,
                'view_item'     => esc_html__('View team', 'noo-umbra-core') ,
                'search_items'  => esc_html__('Search team', 'noo-umbra-core') ,
                'not_found'     => esc_html__('No team items found', 'noo-umbra-core') ,
                'not_found_in_trash' => esc_html__('No team items found in trash', 'noo-umbra-core') ,
                'parent_item_colon'  => ''
            );

            $admin_icon     = '';
            if ( floatval( get_bloginfo( 'version' ) ) >= 3.8 ) {
                $admin_icon = 'dashicons-businessman';
            }

            $team_slug = 'team_member';

            // Options
            $team_args = array(
                'labels' => $team_labels,
                'public' => false,
                'publicly_queryable' => true,
                'show_ui' => true,
                'show_in_menu' => true,
                'menu_position' => 5,
                'menu_icon' => $admin_icon,
                'capability_type' => 'post',
                'hierarchical' => false,
                'supports' => array(
                    'title',
                    'revisions'
                ) ,
                'has_archive' => true,
                'rewrite' => array(
                    'slug' => $team_slug,
                    'with_front' => false
                )
            );

            register_post_type('team_member', $team_args);

            // Register a taxonomy for Project Categories.
            $category_labels = array(
                'name' => esc_html__('Categories', 'noo-umbra-core') ,
                'singular_name' => esc_html__('Category', 'noo-umbra-core') ,
                'menu_name' => esc_html__('Categories', 'noo-umbra-core') ,
                'all_items' => esc_html__('All Categories', 'noo-umbra-core') ,
                'edit_item' => esc_html__('Edit Category', 'noo-umbra-core') ,
                'view_item' => esc_html__('View Category', 'noo-umbra-core') ,
                'update_item' => esc_html__('Update Category', 'noo-umbra-core') ,
                'add_new_item' => esc_html__('Add New Category', 'noo-umbra-core') ,
                'new_item_name' => esc_html__('New Category Name', 'noo-umbra-core') ,
                'parent_item' => esc_html__('Parent Category', 'noo-umbra-core') ,
                'parent_item_colon' => esc_html__('Parent Category:', 'noo-umbra-core') ,
                'search_items' => esc_html__('Search Categories', 'noo-umbra-core') ,
                'popular_items' => esc_html__('Popular Categories', 'noo-umbra-core') ,
                'separate_items_with_commas' => esc_html__('Separate Categories with commas', 'noo-umbra-core') ,
                'add_or_remove_items' => esc_html__('Add or remove Categories', 'noo-umbra-core') ,
                'choose_from_most_used' => esc_html__('Choose from the most used Categories', 'noo-umbra-core') ,
                'not_found' => esc_html__('Categories found', 'noo-umbra-core') ,
            );

            $category_args = array(
                'labels' => $category_labels,
                'public' => false,
                'show_ui' => true,
                'show_in_nav_menus' => false,
                'show_tagcloud' => false,
                'show_admin_column' => true,
                'hierarchical' => true,
                'query_var' => true,
                'rewrite' => array(
                    'slug' => 'team_category',
                    'with_front' => false
                ) ,
            );

            register_taxonomy('team_member_category', array(
                'team_member'
            ) , $category_args);
        }



    }
    new Noo_Our_Team();
endif;








