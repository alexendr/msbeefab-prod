<?php
/**
 * Style Functions for NOO Framework.
 * This file contains functions for calculating style (normally it's css class) base on settings from admin side.
 *
 * @package    NOO Framework
 * @version    1.0.0
 * @author     Kan Nguyen <khanhnq@nootheme.com>
 * @copyright  Copyright (c) 2014, NooTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://nootheme.com
 */

if (!function_exists('noo_umbra_body_class')):
	function noo_umbra_body_class($output) {
		global $wp_customize;
		if (isset($wp_customize)) {
			$output[] = 'is-customize-preview';
		}

		// Preload
		if( noo_umbra_get_option( 'noo_preload', false ) ) {
			$output[] = 'enable-preload';
		}

		$page_layout = noo_umbra_get_page_layout();
		if ($page_layout == 'fullwidth') {
			$output[] = ' page-fullwidth';
		} elseif ($page_layout == 'left_sidebar') {
			$output[] = ' page-left-sidebar';
		} else {
			$output[] = ' page-right-sidebar';
		}
		
		switch (noo_umbra_get_option('noo_site_layout', 'fullwidth')) {
			case 'boxed':
				// if(get_page_template_slug() != 'page-full-width.php')
				$output[] = 'boxed-layout';
			break;
			default:
				$output[] = 'full-width-layout';
			break;
		}
		
		return $output;
	}
endif;
add_filter('body_class', 'noo_umbra_body_class');

if (!function_exists('noo_umbra_header_class')):
	function noo_umbra_header_class() {
        $class = '';
        $navbar_position = noo_umbra_get_option('noo_header_nav_position', 'fixed_scroll');
        $menu_style  = noo_umbra_get_option('noo_header_nav_style','header-1');

        if( is_page() ){
            $headerpage   = noo_umbra_get_post_meta(get_the_ID(),'_noo_wp_page_header_style');
            if( !empty($headerpage) && $headerpage != 'default' ){
                $menu_style = $headerpage;
            }

            $page_nav_position = noo_umbra_get_post_meta(get_the_ID(), '_noo_wp_page_nav_position');
            if ('default' != $page_nav_position && '' != $page_nav_position){
                $navbar_position = $page_nav_position;
            }
        }

        if ('fixed_top' == $navbar_position) {
            $class = 'fixed_top ';
        } elseif ('fixed_scroll' == $navbar_position) {
            $class = 'fixed_scroll ';
        }

        if( $menu_style == 'header-1' ){
            $class .= 'header-1 header-eff';
        }elseif( $menu_style == 'header-2' ){
            $class .= 'header-2';
        }elseif( $menu_style == 'header-3' ){
            $class .= 'header-3 header-eff';
        }elseif( $menu_style == 'header-4' or $menu_style == 'transparent' ){
            $class .= 'header-1 header-transparent header-eff';
        }
        if( is_page_template('page-revolution.php') ){
            $class = 'header-1 header-revolution';
        }
        echo $class;
	}
endif;


if (!function_exists('noo_umbra_main_class')):
	function noo_umbra_main_class() {
		$class = 'noo-main';
		$page_layout = noo_umbra_get_page_layout();

		if ($page_layout == 'fullwidth') {
			$class.= ' noo-md-12';
		} elseif ($page_layout == 'left_sidebar') {
			$class.= ' noo-md-9 pull-right';
		} else {
			$class.= ' noo-md-9';
		}
		
		echo $class;
	}
endif;

if (!function_exists('noo_umbra_sidebar_class')):
	function noo_umbra_sidebar_class() {
		$class = ' noo-sidebar noo-md-3';
		$page_layout = noo_umbra_get_page_layout();
		
		if ( $page_layout == 'left_sidebar' ) {
			$class .= ' noo-sidebar-left pull-left';
		}
		
		echo $class;
	}
endif;

if (!function_exists('noo_umbra_post_class')):
	function noo_umbra_post_class($output) {
		if (noo_umbra_has_featured_content()) {
			$output[] = 'has-featured';
		} else {
			$output[] = 'no-featured';
		}
		
		return $output;
	}
	
	add_filter('post_class', 'noo_umbra_post_class');
endif;
