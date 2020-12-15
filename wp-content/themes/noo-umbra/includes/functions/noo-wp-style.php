<?php
/**
 * WP Element Functions.
 * This file contains functions related to Wordpress base elements.
 * It mostly contains functions for improving trivial issue on Wordpress.
 *
 * @package    NOO Framework
 * @version    1.0.0
 * @author     Kan Nguyen <khanhnq@nootheme.com>
 * @copyright  Copyright (c) 2014, NooTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://nootheme.com
 */


// Excerpt Length
// --------------------------------------------------------

if ( ! function_exists( 'noo_umbra_excerpt_length' ) ) :
	function noo_umbra_excerpt_length( $length ) {
		$excerpt_length = noo_umbra_get_option('noo_blog_excerpt_length', 60);

		return (empty($excerpt_length) ? 60 : $excerpt_length); 
	}
	add_filter( 'excerpt_length', 'noo_umbra_excerpt_length' );
endif;


if(!function_exists('noo_umbra_the_excerpt')){
	function noo_umbra_the_excerpt($excerpt=''){
		return str_replace('&nbsp;', '', $excerpt);
	}
	add_filter('the_excerpt', 'noo_umbra_the_excerpt');
}




