<?php
/**
 * Utilities Functions for NOO Framework.
 * This file contains various functions for getting and preparing data.
 *
 * @package    NOO Framework
 * @version    1.0.0
 * @author     Kan Nguyen <khanhnq@nootheme.com>
 * @copyright  Copyright (c) 2014, NooTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://nootheme.com
 */
if( !function_exists('noo_umbra_new_heading') ){
    function noo_umbra_new_heading(){
        $varible        = array();
        $image          = '';
        $title          = '';
        $sub_title      = '';
        $parallax       = true;
        $height_heading = '360';
        $status         = 'show';
        if( ! noo_umbra_get_option( 'noo_page_heading', true ) ) {
            return array();
        }
        if( NOO_WOOCOMMERCE_EXIST && ( is_shop()  || is_product_category() || is_product_tag() )) {

            $image          =   noo_umbra_get_image_option('noo_shop_heading_image', '');
            $title          =   noo_umbra_get_option('noo_shop_heading_title');
            $sub_title      =   noo_umbra_get_option('noo_shop_heading_sub_title');
            $parallax       =   noo_umbra_get_option('noo_shop_heading_parallax',true);
            $height_heading =   noo_umbra_get_option('noo_shop_heading_height',360);
            $status         =   noo_umbra_get_option('noo_shop_heading_status','show');

        }elseif(  NOO_WOOCOMMERCE_EXIST && is_product() ) {
        	$image_post   = noo_umbra_get_post_meta( get_the_ID(),'single_product_heading_image');
            $option = noo_umbra_get_option('noo_product_single_header', 1);
            $image = noo_umbra_get_image_option('noo_shop_heading_image', '');
            if (isset($image_post) && !empty($image_post)) {
				$thumb = wp_get_attachment_image_src($image_post, 'full');
				if (isset($thumb) && !empty($thumb)) {
					$image = $thumb[0];
				}
            }

            // $thumb = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'full');
            // if (isset($thumb) && !empty($thumb) && $option != 1) {
            //     $image = $thumb[0];
            // }
            $title = get_the_title();

        }elseif( is_search() ) {

            $image = noo_umbra_get_image_option('noo_blog_heading_image', '');
            $title = get_search_query();

        }elseif( is_home() || is_category() || is_tag() || is_date() ) {

            $image          =   noo_umbra_get_image_option('noo_blog_heading_image', '');
            $title          =   noo_umbra_get_option('noo_blog_heading_title', esc_html__('Blog', 'noo-umbra'));
            $sub_title      =   noo_umbra_get_option('noo_blog_heading_sub_title');
            $parallax       =   noo_umbra_get_option('noo_blog_heading_parallax',true);
            $height_heading =   noo_umbra_get_option('noo_blog_heading_height',360);
            $status         =   noo_umbra_get_option('noo_blog_heading_status','show');

        }elseif( is_singular('noo_project') ){

            $thumb = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'full');
            if (isset($thumb) && !empty($thumb)) {
                $image = $thumb[0];
            }
            $title = get_the_title();

        }elseif ( is_single()) {

            $image_post   = noo_umbra_get_post_meta( get_the_ID(),'single_post_heading_image');
			$image 		  = noo_umbra_get_option('noo_blog_single_heading_image');
            if (isset($image_post) && !empty($image_post)) {
				$thumb = wp_get_attachment_image_src($image_post, 'full');
				if (isset($thumb) && !empty($thumb)) {
					$image = $thumb[0];
				}
            }
			$sub_title      =   noo_umbra_get_option('noo_blog_single_heading_sub_title');
			$parallax       =   noo_umbra_get_option('noo_blog_single_heading_parallax',true);
			$height_heading =   noo_umbra_get_option('noo_blog_single_heading_height',360);
			$status         =   noo_umbra_get_option('noo_blog_single_heading_status','show');
            $title = get_the_title();

        }elseif( is_page() ){

            $id_image = noo_umbra_get_post_meta(get_the_ID(),'_heading_image');
            if( isset($id_image) && !empty($id_image) ){
                $image = wp_get_attachment_url($id_image,'full');
            }
            $title          = get_the_title();
            $sub_title      = noo_umbra_get_post_meta(get_the_ID(),'_heading_sub_title');
            $parallax       = noo_umbra_get_post_meta(get_the_ID(),'noo_parallax_heading');
            $height_heading = noo_umbra_get_post_meta(get_the_ID(),'_heading_height',360);
            $status         = noo_umbra_get_post_meta(get_the_ID(),'_noo_wp_page_status_heading','show');

        }
        $varible['img']             =   $image;
        $varible['title']           =   $title;
        $varible['sub_title']       =   $sub_title;
        $varible['parallax']        =   $parallax;
        $varible['height']          =   $height_heading;
        $varible['status']          =   $status;
        return $varible;
    }
}

if (!function_exists('noo_umbra_get_page_heading')):
	function noo_umbra_get_page_heading() {
		$heading = '';
		$archive_title = '';
		$archive_desc = '';
		if( ! noo_umbra_get_option( 'noo_page_heading', true ) ) {
			return array($heading, $archive_title, $archive_desc);
		}
		if ( is_home() ) {
			$heading = noo_umbra_get_option( 'noo_blog_heading_title', esc_html__( 'Blog', 'noo-umbra' ) );
		} elseif ( NOO_WOOCOMMERCE_EXIST && is_shop() ) {
			if( is_search() ) {
				$heading =__( 'Search', 'noo-umbra' );
			} else {
				$heading = noo_umbra_get_option( 'noo_shop_heading_title', esc_html__( 'Shop', 'noo-umbra' ) );
			}
		} elseif ( is_search() ) {
			$heading = esc_html__( 'Search', 'noo-umbra' );
		} elseif ( is_author() ) {
			$curauth = (get_query_var('author_name')) ? get_user_by('slug', get_query_var('author_name')) : get_userdata(get_query_var('author'));
			$heading = esc_html__( 'Author Archive','noo-umbra');
		} elseif ( is_year() ) {
    		$heading = esc_html__( 'Post Archive by Year: ', 'noo-umbra' ) . get_the_date( 'Y' );
		} elseif ( is_month() ) {
    		$heading = esc_html__( 'Post Archive by Month: ', 'noo-umbra' ) . get_the_date( 'F,Y' );
		} elseif ( is_day() ) {
    		$heading = esc_html__( 'Post Archive by Day: ', 'noo-umbra' ) . get_the_date( 'F j, Y' );
		} elseif ( is_404() ) {
    		$heading = esc_html__( 'Oops! We could not find anything to show to you.', 'noo-umbra' );
    		$archive_title =  esc_html__( 'Would you like going else where to find your stuff.', 'noo-umbra' );
		} elseif ( is_archive() ) {
			$heading        = single_cat_title( '', false );
			// $archive_desc   = term_description();
		} elseif ( is_singular( 'product' ) ) {
			$heading = noo_umbra_get_option( 'noo_woocommerce_product_disable_heading', true ) ? '' : get_the_title();
		}  elseif ( is_single() ) {
			$heading = get_the_title();
		} elseif( is_page() ) {
			if( ! noo_umbra_get_post_meta(get_the_ID(), '_noo_wp_page_hide_page_title', false) ) {
				$heading = get_the_title();
			}
		}

		return array($heading, $archive_title, $archive_desc);
	}
endif;

if (!function_exists('noo_umbra_get_page_heading_image')):
	function noo_umbra_get_page_heading_image() {
		$image = '';
		if( ! noo_umbra_get_option( 'noo_page_heading', true ) ) {
			return $image;
		}
		if( NOO_WOOCOMMERCE_EXIST && is_shop() ) {
			$image = noo_umbra_get_image_option( 'noo_shop_heading_image', '' );
		} elseif ( is_home() ) {
			$image = noo_umbra_get_image_option( 'noo_blog_heading_image', '' );
		} elseif( is_category() || is_tag() ) {
			$queried_object = get_queried_object();
			$image			= noo_umbra_get_term_meta( $queried_object->term_id, 'heading_image', '' );
			$image			= empty( $image ) ? noo_umbra_get_image_option( 'noo_blog_heading_image', '' ) : $image;
		} elseif( NOO_WOOCOMMERCE_EXIST && ( is_product_category() || is_product_tag() ) ) {
			$queried_object = get_queried_object();
			$image			= noo_umbra_get_term_meta( $queried_object->term_id, 'heading_image', '' );
			$image			= empty( $image ) ? noo_umbra_get_image_option( 'noo_shop_heading_image', '' ) : $image;
		} elseif ( is_singular('product' ) || is_page() ) {
			$image = noo_umbra_get_post_meta(get_the_ID(), '_heading_image', '');
		} elseif ( is_single()) {
			$image = noo_umbra_get_image_option( 'noo_blog_heading_image', '' );
		}

		if( !empty( $image ) && is_numeric( $image ) ) $image = wp_get_attachment_url( $image );

		return $image;
	}
endif;

if (!function_exists('noo_umbra_has_featured_content')):
	function noo_umbra_has_featured_content($post_id = null) {
		$post_id = (null === $post_id) ? get_the_ID() : $post_id;

		$post_type = get_post_type($post_id);
		$prefix = '';
		$post_format = '';
		
		if ($post_type == 'post') {
			$prefix = '_noo_wp_post';
			$post_format = get_post_format($post_id);
		}
		
		switch ($post_format) {
			case 'image':
				$main_image = noo_umbra_get_post_meta($post_id, "{$prefix}_main_image", 'featured');
				if( $main_image == 'featured') {
					return has_post_thumbnail($post_id);
				}

				return has_post_thumbnail($post_id) || ( (bool)noo_umbra_get_post_meta($post_id, "{$prefix}_image", '') );
			case 'gallery':
				if (!is_singular()) {
					$preview_content = noo_umbra_get_post_meta($post_id, "{$prefix}_gallery_preview", 'slideshow');
					if ($preview_content == 'featured') {
						return has_post_thumbnail($post_id);
					}
				}
				
				return (bool)noo_umbra_get_post_meta($post_id, "{$prefix}_gallery", '');
			case 'video':
				if (!is_singular()) {
					$preview_content = noo_umbra_get_post_meta($post_id, "{$prefix}_preview_video", 'both');
					if ($preview_content == 'featured') {
						return has_post_thumbnail($post_id);
					}
				}
				
				$m4v_video = (bool)noo_umbra_get_post_meta($post_id, "{$prefix}_video_m4v", '');
				$ogv_video = (bool)noo_umbra_get_post_meta($post_id, "{$prefix}_video_ogv", '');
				$embed_video = (bool)noo_umbra_get_post_meta($post_id, "{$prefix}_video_embed", '');
				
				return $m4v_video || $ogv_video || $embed_video;
			case 'link':
			case 'quote':
				return false;
				
			case 'audio':
				$mp3_audio = (bool)noo_umbra_get_post_meta($post_id, "{$prefix}_audio_mp3", '');
				$oga_audio = (bool)noo_umbra_get_post_meta($post_id, "{$prefix}_audio_oga", '');
				$embed_audio = (bool)noo_umbra_get_post_meta($post_id, "{$prefix}_audio_embed", '');
				return $mp3_audio || $oga_audio || $embed_audio;
			default: // standard post format
				return has_post_thumbnail($post_id);
		}
		
		return false;
	}
endif;

// Get allowed HTML tag.
if( !function_exists('noo_umbra_allowed_html') ) :
	function noo_umbra_allowed_html() {
		return apply_filters( 'noo_umbra_allowed_html', array(
			'a' => array(
				'href' => array(),
				'target' => array(),
				'title' => array(),
				'rel' => array(),
				'class' => array(),
				'style' => array(),
			),
			'img' => array(
				'src' => array(),
				'class' => array(),
				'style' => array(),
				'alt'	=>	array()
			),
			'h1' => array(),
			'h2' => array(),
			'h3' => array(),
			'h4' => array(),
			'h5' => array(),
			'p' => array(
				'class' => array(),
				'style' => array()
			),
			'br' => array(
				'class' => array(),
				'style' => array()
			),
			'hr' => array(
				'class' => array(),
				'style' => array()
			),
			'span' => array(
				'class' => array(),
				'style' => array()
			),
			'em' => array(
				'class' => array(),
				'style' => array()
			),
			'strong' => array(
				'class' => array(),
				'style' => array()
			),
			'small' => array(
				'class' => array(),
				'style' => array()
			),
			'b' => array(
				'class' => array(),
				'style' => array()
			),
			'i' => array(
				'class' => array(),
				'style' => array()
			),
			'u' => array(
				'class' => array(),
				'style' => array()
			),
			'ul' => array(
				'class' => array(),
				'style' => array()
			),
			'ol' => array(
				'class' => array(),
				'style' => array()
			),
			'li' => array(
				'class' => array(),
				'style' => array()
			),
			'blockquote' => array(
				'class' => array(),
				'style' => array()
			),
		) );
	}
endif;

// Allow only unharmed HTML tag.
if( !function_exists('noo_umbra_html_content_filter') ) :
	function noo_umbra_html_content_filter( $content = '' ) {
		return wp_kses( $content, noo_umbra_allowed_html() );
	}
endif;

// escape language with HTML.
if( !function_exists('noo_umbra_kses') ) :
	function noo_umbra_kses( $text = '' ) {
		return wp_kses( $text, noo_umbra_allowed_html() );
	}
endif;

/* -------------------------------------------------------
 * Create functions noo_umbra_get_page_id_by_template
 * ------------------------------------------------------- */

if ( ! function_exists( 'noo_umbra_get_page_id_by_template' ) ) :
	
	function noo_umbra_get_page_id_by_template( $page_template = '' ) {

		$pages = get_pages(array(
			'meta_key' => '_wp_page_template',
			'meta_value' => $page_template
		));

		if( $pages ){
			return $pages[0]->ID;
		}
		return false;

	}

endif;

/** ====== END noo_umbra_get_page_id_by_template ====== **/

/**
 * Function process string
 *
 * @package     Noo_Umbra
 * @author      KENT <tuanlv@vietbrain.com>
 * @version     1.0
 */

if ( ! function_exists( 'noo_umbra_content_limit' ) ) :
    
    function noo_umbra_content_limit( $text, $chars = 120 ) {

        $text = wp_strip_all_tags( $text );
        $text = $text . ' ';
        $text = mb_substr( $text , 0 , $chars , 'UTF-8');
        $text = $text . '&#8230;';
        return $text;

    }

endif;

/**
 * Get thumb src
 *
 * @package     Noo_Umbra
 * @author      KENT <tuanlv@vietbrain.com>
 * @version     1.0
 */

if ( ! function_exists( 'noo_umbra_thumb_src' ) ) :
    
    function noo_umbra_thumb_src( $post_id = '', $size = 'umbra-small' ) {

        if ( empty( $post_id ) ) :
            global $post;
            $post_id = $post->ID;
        endif;

        $image_id   = get_post_thumbnail_id( $post_id );  
        $image_url  = wp_get_attachment_image_src( $image_id, $size );  
        return $image_url[0];

    }

endif;

/* -------------------------------------------------------
 * Create functions noo_umbra_relative_time
 * 
 * ------------------------------------------------------- */

if ( ! function_exists( 'noo_umbra_relative_time' ) ) :
	
	function noo_umbra_relative_time() {

		return human_time_diff(get_comment_time('U'), current_time('timestamp'));

	}

endif;

/** ====== END noo_umbra_relative_time ====== **/

if( !function_exists('noo_umbra_get_instagram_data') ) :
    // using standard_resolution / thumbnail / low_resolution
    function noo_umbra_get_instagram_data($username = 'nootheme', $cache_hours = '5', $nr_images = '4', $resolution = 'thumbnail', $randomise = false) {
        $opt_name    = 'noo_insta_'.md5( $username );
        $instaData 	 = get_transient( $opt_name );
        $user_opt    = get_option( $opt_name );

        if( !in_array($resolution, array( 'low_resolution', 'thumbnail', 'standard_resolution' ) ) ) $resolution = 'thumbnail';
        if ( false === $instaData
            || $user_opt['username']    != $username
            || $user_opt['cache_hours'] != $cache_hours
            || $user_opt['nr_images']   != $nr_images
            || $user_opt['resolution']  != $resolution
        ) {
            $instaData    = array();
            $insta_url    = 'https://instagram.com/';
            $user_profile = $insta_url.$username;
            $json     	  = wp_remote_get( $user_profile, array( 'sslverify' => false, 'timeout'=> 60 ) );
            if ( !is_wp_error( $json ) && $json['response']['code'] == 200 ) {
                $json 	  = $json['body'];
                $json     = strstr( $json, 'window._sharedData = ' );
                $json     = str_replace('window._sharedData = ', '', $json);

                // Compatibility for version of php where strstr() doesnt accept third parameter
                if ( version_compare( phpversion(), '5.3.10', '<' ) ) {
                    $json = substr( $json, 0, strpos($json, '</script>' ) );
                } else {
                    $json = strstr( $json, '</script>', true );
                }

                $json     = rtrim( $json, ';' );

                // Function json_last_error() is not available before PHP * 5.3.0 version
                if ( function_exists( 'json_last_error' ) ) {

                    ( $results = json_decode( $json, true ) ) && json_last_error() == JSON_ERROR_NONE;

                } else {

                    $results = json_decode( $json, true );
                }

                if ( ( $results ) && is_array( $results ) && isset( $results['entry_data']['ProfilePage'] ) && is_array( $results['entry_data']['ProfilePage'] ) ) {

                    foreach( $results['entry_data']['ProfilePage'][0]['user']['media']['nodes'] as $result ) {
                        $caption      = '';
                        if( isset($result['caption']) && !empty($result['caption']) ){
                            $caption      = $result['caption'];
                        }
                        $image        = $result['display_src'];
                        $id           = $result['id'];
                        $link         = 'https://instagram.com/p/'.$result['code'];
                        $text         = noo_umbra_utf8_4byte_to_3byte($caption);
                        $filename_data= explode( '.', $image );

                        if ( is_array( $filename_data ) ) {

                            $fileformat   = end( $filename_data );

                            if ( $fileformat !== false ){

                                array_push( $instaData, array(
                                    'id'           => $id,
                                    'user_name'	   => $username,
                                    'user_url'	   => $user_profile,
                                    'text'         => $text,
                                    'image'        => $image,
                                    'link'         => $link
                                ));

                            } // end -> if $fileformat !== false

                        } // end -> is_array( $filename_data )

                    } // end -> foreach

                } // end -> ( $results ) && is_array( $results ) )
                if ( $instaData ) {
                    set_transient( $opt_name, $instaData, $cache_hours * 60 * 60 );
                    $user_options = compact('username', 'cache_hours', 'nr_images', 'resolution');
                    update_option( $opt_name, $user_options );
                } else {
                    delete_option( $opt_name );
                    delete_transient( $opt_name );
                }// end -> true $instaData
            } else {
                delete_option( $opt_name );
                delete_transient( $opt_name );
            }
        }

        if( $randomise ) shuffle( $instaData );
        return array_slice($instaData, 0, $nr_images, true);
    }
endif;

if ( !function_exists( 'noo_umbra_utf8_4byte_to_3byte' ) ) :
function noo_umbra_utf8_4byte_to_3byte( $input ) {

    if (!empty($input)) {
        $utf8_2byte = 0xC0 /*1100 0000*/; $utf8_2byte_bmask = 0xE0 /*1110 0000*/;
        $utf8_3byte = 0xE0 /*1110 0000*/; $utf8_3byte_bmask = 0XF0 /*1111 0000*/;
        $utf8_4byte = 0xF0 /*1111 0000*/; $utf8_4byte_bmask = 0xF8 /*1111 1000*/;

        $sanitized = "";
        $len = strlen($input);
        for ($i = 0; $i < $len; ++$i) {
            $mb_char = $input[$i]; // Potentially a multibyte sequence
            $byte = ord($mb_char);
            if (($byte & $utf8_2byte_bmask) == $utf8_2byte) {
                $mb_char .= $input[++$i];
            }
            else if (($byte & $utf8_3byte_bmask) == $utf8_3byte) {
                $mb_char .= $input[++$i];
                $mb_char .= $input[++$i];
            }
            else if (($byte & $utf8_4byte_bmask) == $utf8_4byte) {
                // Replace with ? to avoid MySQL exception
                $mb_char = '?';
                $i += 3;
            }

            $sanitized .=  $mb_char;
        }

        $input= $sanitized;
    }

    return $input;
}
endif;