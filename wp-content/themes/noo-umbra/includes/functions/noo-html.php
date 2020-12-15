<?php
/**
 * HTML Functions for NOO Framework.
 * This file contains various functions used for rendering site's small layouts.
 *
 * @package    NOO Framework
 * @version    1.0.0
 * @author     Kan Nguyen <khanhnq@nootheme.com>
 * @copyright  Copyright (c) 2014, NooTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://nootheme.com
 */

// Featured Content
require_once get_template_directory() . '/includes/functions/noo-html-featured.php';

// Pagination
require_once get_template_directory() . '/includes/functions/noo-html-pagination.php';

if (!function_exists('noo_umbra_get_readmore_link')):
	function noo_umbra_get_readmore_link() {
		return '<a href="' . get_permalink() . '" class="read-more">'
		. '<i class="fa fa-arrow-circle-o-right"></i>'
		. '<span>'
		. esc_html__( 'Continue Reading', 'noo-umbra' )
		. '</span>'
		. '</a>';
	}
endif;

if (!function_exists('noo_umbra_readmore_link')):
	function noo_umbra_readmore_link() {
		if( noo_umbra_get_option('noo_blog_show_readmore', 1 ) ) {
			echo noo_umbra_get_readmore_link();
		} else {
			echo '';
		}
	}
endif;

if (!function_exists('noo_umbra_list_comments')):
	function noo_umbra_list_comments($comment, $args, $depth) {
		$GLOBALS['comment'] = $comment;
		GLOBAL $post;
		$avatar_size = isset($args['avatar_size']) ? $args['avatar_size'] : 60;
		?>
		<li id="li-comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
			<div class="comment-wrap">
				<div class="comment-img">
					<div class="img-thumbnail">
						<?php echo get_avatar($comment, $avatar_size); ?>
					</div>
				</div>
				<div id="comment-<?php comment_ID(); ?>" class="comment-block">
					<header class="comment-header">
						
						<cite class="comment-author"><?php echo get_comment_author_link(); ?></cite>

						<time datetime="<?php echo get_the_date('c'); ?>">
							<?php echo noo_umbra_relative_time() . esc_html__( ' ago','noo-umbra' ); ?>
						</time>
						<span class="comment-edit">
							<?php edit_comment_link('<i class="fa fa-edit"></i> ' . esc_html__( 'Edit', 'noo-umbra')); ?>
						</span>

						<span class="pull-right">
							<?php comment_reply_link(array_merge($args, array(
								'reply_text' => ( '<i class="arrow_back"></i> ' . esc_html__('Reply', 'noo-umbra')) ,
								'depth' => $depth,
								'max_depth' => $args['max_depth']
							))); ?>
						</span>

					</header>
					<div class="comment-content">
						<?php comment_text(); ?>
					</div>
				</div>
			</div>
		<?php
	}
endif;

if ( ! function_exists( 'noo_umbra_comment_form' ) ) :
	function noo_umbra_comment_form( $args = array(), $post_id = null ) {
	    global $id;
	    $user = wp_get_current_user();
	    $user_identity = $user->exists() ? $user->display_name : '';

	    if ( null === $post_id ) {
	        $post_id = $id;
	    }
	    else {
	        $id = $post_id;
	    }

	    if ( comments_open( $post_id ) ) :
	    ?>
	    <div id="respond-wrap">
	        <?php 
				$commenter   = wp_get_current_commenter();
				$req         = get_option( 'require_name_email' );
				$aria_req    = ( $req ? " aria-required='true'" : '' );
				
				/**
				 * Process title reply
				 * @var [type]
				 */
				$title_reply    = esc_html__( 'Leave your thought', 'noo-umbra' );

	            $fields =  array(
	                'author' => '<div class="noo-row comment-form-head"><div class="comment-form-author noo-md-6"><input id="author" name="author" type="text" placeholder="' . esc_html__( 'Your name *', 'noo-umbra' ) . '" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' /></div>',
	                'email' => '<div class="comment-form-email noo-md-6"><input id="email" name="email" type="text" placeholder="' . esc_html__( 'Your email *', 'noo-umbra' ) . '" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' /></div>',
	                'url' => '<div class="comment-form-url noo-md-12"><input id="url" name="url" type="text" placeholder="' . esc_html__( 'Website', 'noo-umbra' ) . '" value="' . esc_attr( $commenter['comment_author_url'] ) .
						    '" size="30" /></div></div>',
	                'comment_field'        => '<div class="comment-form-comment"><textarea placeholder="' . esc_html__( 'Your comment *', 'noo-umbra' ) . '" id="comment" name="comment" cols="40" rows="6" aria-required="true"></textarea></div>'
	            );
	            $comments_args = array(
	                    'fields'               => apply_filters( 'comment_form_default_fields', $fields ),
	                    'logged_in_as'         => '<p class="logged-in-as">' . sprintf( wp_kses( __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>', 'noo-umbra' ), noo_umbra_allowed_html() ), admin_url( 'profile.php' ), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink( ) ) ) ) . '</p>',
	                    'title_reply'          => sprintf('<span>%s</span>', $title_reply ),
	                    'title_reply_to'       => sprintf('<span>%s</span>', esc_html__( 'Leave a reply to %s', 'noo-umbra' )),
	                    'cancel_reply_link'    => esc_html__( 'Click here to cancel the reply', 'noo-umbra' ),
	                    'comment_notes_before' => '',
	                    'comment_notes_after'  => '',
	                    'label_submit'         => esc_html__( 'Post comment', 'noo-umbra' ),
	                    'comment_field'        =>'',
	                    'must_log_in'          => ''
	            );
	            if(is_user_logged_in()){
	                $comments_args['comment_field'] = '<p class="comment-form-comment"><textarea class="form-control" placeholder="' . esc_html__( 'Your comment *', 'noo-umbra' ) . '" id="comment" name="comment" cols="40" rows="6" aria-required="true"></textarea></p>';
	            }
	        comment_form($comments_args); 
	        ?>
	    </div>

	    <?php
	    endif;
	}
endif;

if ( ! function_exists( 'noo_umbra_social_share' ) ) :
	function noo_umbra_social_share( $post_id = null ) {
		$post_id = (null === $post_id) ? get_the_id() : $post_id;
		$post_type =  get_post_type($post_id);
		$prefix = 'noo_blog';

		if(noo_umbra_get_option("{$prefix}_social", true ) === false) {
			return '';
		}

		$share_url     = urlencode( get_permalink() );
		$share_title   = urlencode( get_the_title() );
		$share_source  = urlencode( get_bloginfo( 'name' ) );
		$share_content = urlencode( get_the_content() );
		$share_media   = wp_get_attachment_thumb_url( get_post_thumbnail_id() );
		$popup_attr    = 'resizable=0, toolbar=0, menubar=0, status=0, location=0, scrollbars=0';

		$share_title  = noo_umbra_get_option( "{$prefix}_social_title", '' );
		$facebook     = noo_umbra_get_option( "{$prefix}_social_facebook", true );
		$twitter      = noo_umbra_get_option( "{$prefix}_social_twitter", true );
		$google		  = noo_umbra_get_option( "{$prefix}_social_google", true );
		$pinterest    = noo_umbra_get_option( "{$prefix}_social_pinterest", false );
		$linkedin     = noo_umbra_get_option( "{$prefix}_social_linkedin", false );
		$html = array();

		if ( $facebook || $twitter || $google || $pinterest || $linkedin ) {
			$html[] = '<div class="content-share">';
			if( $share_title !== '' ) {
				$html[] = '<p class="social-title">';
				$html[] = '  ' . $share_title;
				$html[] = '</p>';
			}
			$html[] = '<div class="noo-social social-share">';

			if($facebook) {
				$html[] = '<a href="#share" data-toggle="tooltip" data-placement="bottom" data-trigger="hover" class="noo-share"'
							. ' title="' . esc_html__( 'Share on Facebook', 'noo-umbra' ) . '"'
							. ' onclick="window.open(' 
								. "'http://www.facebook.com/sharer.php?u={$share_url}&amp;t={$share_title}','popupFacebook','width=650,height=270,{$popup_attr}');"
								. ' return false;">';
				$html[] = '<i class="fa fa-facebook"></i>';
				$html[] = '</a>';
			}

			if($twitter) {
				$html[] = '<a href="#share" class="noo-share"'
							. ' title="' . esc_html__( 'Share on Twitter', 'noo-umbra' ) . '"'
							. ' onclick="window.open('
								. "'https://twitter.com/intent/tweet?text={$share_title}&amp;url={$share_url}','popupTwitter','width=500,height=370,{$popup_attr}');"
								. ' return false;">';
				$html[] = '<i class="fa fa-twitter"></i></a>';
			}

			if($google) {
				$html[] = '<a href="#share" class="noo-share"'
							. ' title="' . esc_html__( 'Share on Google+', 'noo-umbra' ) . '"'
								. ' onclick="window.open('
								. "'https://plus.google.com/share?url={$share_url}','popupGooglePlus','width=650,height=226,{$popup_attr}');"
								. ' return false;">';
				$html[] = '<i class="fa fa-google-plus"></i></a>';
			}

			if($pinterest) {
				$html[] = '<a href="#share" class="noo-share"'
							. ' title="' . esc_html__( 'Share on Pinterest', 'noo-umbra' ) . '"'
							. ' onclick="window.open('
								. "'http://pinterest.com/pin/create/button/?url={$share_url}&amp;media={$share_media}&amp;description={$share_title}','popupPinterest','width=750,height=265,{$popup_attr}');"
								. ' return false;">';
				$html[] = '<i class="fa fa-pinterest"></i></a>';
			}

			if($linkedin) {
				$html[] = '<a href="#share" class="noo-share"'
							. ' title="' . esc_html__( 'Share on LinkedIn', 'noo-umbra' ) . '"'
							. ' onclick="window.open('
								. "'http://www.linkedin.com/shareArticle?mini=true&amp;url={$share_url}&amp;title={$share_title}&amp;summary={$share_content}&amp;source={$share_source}','popupLinkedIn','width=610,height=480,{$popup_attr}');"
								. ' return false;">';
				$html[] = '<i class="fa fa-linkedin"></i></a>';
			}

			$html[] = '</div>'; // .noo-social.social-share
			$html[] = '</div>'; // .share-wrap
		}

		echo implode("\n", $html);
	}
endif;

if ( ! function_exists( 'noo_umbra_social_share_product' ) ) :
    function noo_umbra_social_share_product( $post_id = null ) {
        $post_id = (null === $post_id) ? get_the_id() : $post_id;
        $post_type =  get_post_type($post_id);
        $prefix = 'noo_blog';

        if(noo_umbra_get_option("{$prefix}_social", true ) === false) {
            return '';
        }

        $share_url     = urlencode( get_permalink() );
        $share_title   = urlencode( get_the_title() );
        $share_media   = wp_get_attachment_thumb_url( get_post_thumbnail_id() );
        $popup_attr    = 'resizable=0, toolbar=0, menubar=0, status=0, location=0, scrollbars=0';


        $html = array();


        $html[] = '<div class="noo-social-share">';

        $html[] = '<span class="share-name"><i class="icon-share"></i>'.esc_html__('Share:','noo-umbra').'</span>';

        $html[] = '<a href="#share" data-toggle="tooltip" data-placement="bottom" data-trigger="hover" class="noo-share"'
            . ' title="' . esc_html__( 'Share on Facebook', 'noo-umbra' ) . '"'
            . ' onclick="window.open('
            . "'http://www.facebook.com/sharer.php?u={$share_url}&amp;t={$share_title}','popupFacebook','width=650,height=270,{$popup_attr}');"
            . ' return false;">';
        $html[] = '<i class="fa fa-facebook"></i>';
        $html[] = '</a>';

        $html[] = '<a href="#share" class="noo-share"'
            . ' title="' . esc_html__( 'Share on Twitter', 'noo-umbra' ) . '"'
            . ' onclick="window.open('
            . "'https://twitter.com/intent/tweet?text={$share_title}&amp;url={$share_url}','popupTwitter','width=500,height=370,{$popup_attr}');"
            . ' return false;">';
        $html[] = '<i class="fa fa-twitter"></i></a>';

        $html[] = '<a href="#share" class="noo-share"'
            . ' title="' . esc_html__( 'Share on Google+', 'noo-umbra' ) . '"'
            . ' onclick="window.open('
            . "'https://plus.google.com/share?url={$share_url}','popupGooglePlus','width=650,height=226,{$popup_attr}');"
            . ' return false;">';
        $html[] = '<i class="fa fa-google-plus"></i></a>';

        $html[] = '<a href="#share" class="noo-share"'
            . ' title="' . esc_html__( 'Share on Pinterest', 'noo-umbra' ) . '"'
            . ' onclick="window.open('
            . "'http://pinterest.com/pin/create/button/?url={$share_url}&amp;media={$share_media}&amp;description={$share_title}','popupPinterest','width=750,height=265,{$popup_attr}');"
            . ' return false;">';
        $html[] = '<i class="fa fa-pinterest"></i></a>';


        $html[] = '</div>'; // .noo-social.social-share


        echo implode("\n", $html);
    }
endif;

if (!function_exists('noo_umbra_social_icons')):
	function noo_umbra_social_icons($position = 'topbar', $direction = '') {
		if ($position == 'topbar') {
			// Top Bar social
		} else {
			// Bottom Bar social
		}
		
		$class = isset($direction) ? $direction : '';
		$html = array();
		$html[] = '<div class="noo-social social-icons ' . $class . '">';
		
		$social_list = array(
			'facebook' => esc_html__( 'Facebook', 'noo-umbra') ,
			'twitter' => esc_html__( 'Twitter', 'noo-umbra') ,
			'google-plus' => esc_html__( 'Google+', 'noo-umbra') ,
			'pinterest' => esc_html__( 'Pinterest', 'noo-umbra') ,
			'linkedin' => esc_html__( 'LinkedIn', 'noo-umbra') ,
			'rss' => esc_html__( 'RSS', 'noo-umbra') ,
			'youtube' => esc_html__( 'YouTube', 'noo-umbra') ,
			'instagram' => esc_html__( 'Instagram', 'noo-umbra') ,
		);
		
		$social_html = array();
		foreach ($social_list as $key => $title) {
			$social = noo_umbra_get_option("noo_social_{$key}", '');
			if ($social) {
				$social_html[] = '<a href="' . $social . '" title="' . $title . '" target="_blank">';
				$social_html[] = '<i class="fa fa-' . $key . '"></i>';
				$social_html[] = '</a>';
			}
		}
		
		if(empty($social_html)) {
			$social_html[] = esc_html__( 'No Social Media Link','noo-umbra');
		}
		
		$html[] = implode($social_html, "\n");
		$html[] = '</div>';
		
		echo implode($html, "\n");
	}
endif;

if ( ! function_exists( 'noo_umbra_entry_meta' ) ) :
    /**
     * Prints HTML with meta information for the categories, tags.
     */
    function noo_umbra_entry_meta() {

    	if ( !is_single() ) return;
        
        if ( 'post' == get_post_type() ) {
            // $categories_list = get_the_category_list( ', ' );
            // if ( $categories_list) {
            //     printf( '<span class="cat-links"><i class="fa fa-briefcase"></i>%1$s</span>',
            //         $categories_list
            //     );
            // }
            $tags_list = get_the_tag_list( '', ', ' );
            if ( $tags_list ) {
                printf( '<span class="tags-links"><b>%1$s</b> %2$s</span>',
                	esc_html__( 'Tags: ','noo-umbra' ),
                    $tags_list
                );
            }
        }

        // if( noo_umbra_get_option('noo_blog_social', false) != false) : 
        ?>
            <div class="single-social">
                <span><?php echo esc_html__( 'Share: ','noo-umbra'); ?></span>
                <?php noo_umbra_social_share(); ?>
            </div>
        <?php //endif;

    }

endif;

/**
 * Show meta info post
 *
 * @package 	Noo_Umbra
 * @author 		KENT <tuanlv@vietbrain.com>
 * @version 	1.0
 */

if ( ! function_exists( 'noo_umbra_meta_info' ) ) :
	
	function noo_umbra_meta_info() {

		$enable_meta = noo_umbra_get_option( 'noo_blog_post_show_post_meta', '' );

		if ( empty( $enable_meta ) ) return;

		printf( '<span class="posted-on"><i class="icon_clock_alt"></i><a href="%1$s" rel="bookmark">%2$s</a></span>',
            esc_url( get_permalink() ),
            get_the_date()
        );

        if ( 'post' == get_post_type() ) {

            printf( '<span class="author vcard"><i class="icon_pencil-edit"></i><a class="url fn n" href="%1$s">%2$s</a></span>',
                esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
                get_the_author()
            );

        }

        if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
            echo '<span class="comments-link"><i class="icon_comment_alt"></i>';
            comments_popup_link( 0, 1, esc_html__( '%', 'noo-umbra' ) );
            echo '</span>';
        }

	}

endif;

if(!function_exists('noo_umbra_gototop')):
	function noo_umbra_gototop(){
		if( noo_umbra_get_option( 'noo_back_to_top', true ) ) {
			echo '<a href="#" class="go-to-top hidden-print"><i class="fa fa-angle-up"></i></a>';
		}
		return ;
	}
	add_action('wp_footer','noo_umbra_gototop');
endif;


if ( ! function_exists( 'noo_umbra_the_custom_logo' ) ) :
    /**
     * Displays the optional custom logo.
     *
     * Does nothing if the custom logo is not available.
     *
     * @since Twenty Fifteen 1.5
     */
    function noo_umbra_the_custom_logo() {

		$logo_text = noo_umbra_get_option('blogname');
		$status = noo_umbra_get_option('noo_header_use_image_logo');
		if( $status == true ){
			if ( function_exists( 'the_custom_logo' ) &&  get_theme_mod( 'custom_logo' ) != '') {
				the_custom_logo();
			}else{
				$custom_logo_id = noo_umbra_get_option( 'noo_header_logo_image' );

				// We have a logo. Logo is go.
				if ( $custom_logo_id ) {
					echo $html = sprintf( '<a href="%1$s" class="custom-logo-link" rel="home">%2$s</a>',
						esc_url( home_url( '/' ) ),
						wp_get_attachment_image( $custom_logo_id, 'full', false, array(
							'class'    => 'custom-logo'
						) )
					);
				}
			}
		}else{ ?>
			<a href="<?php echo esc_url(home_url( '/' )); ?>" class="navbar-brand navbar-logo-text" title="<?php echo esc_attr(get_bloginfo( 'description' )); ?>">
				<?php
				if( isset($logo_text) && !empty($logo_text) ) {
					echo esc_html($logo_text);
				}else{
					echo esc_html(get_bloginfo('name'));
				}
				?>
			</a>
		<?php }
    }
endif;

/**
 * Function show all related post
 *
 * @package 	Noo_Umbra
 * @author 		KENT <tuanlv@vietbrain.com>
 * @version 	1.0
 */

if ( ! function_exists( 'noo_umbra_related_post' ) ) :
	
	function noo_umbra_related_post( $title = '', $number = 3 ) {

		$enable_related_posts = noo_umbra_get_option( 'noo_blog_post_related', '' );

		if ( empty( $enable_related_posts ) ) return;

		global $post;

		echo '<div class="noo-related-post-container">';

			if ( empty( $title ) ) $title = esc_html__( 'Related posts', 'noo-umbra' );


			$tags = wp_get_post_tags( $post->ID );
	 
	        if ( $tags ) :

				echo '<h3 class="noo-title">' . esc_html( $title ) . '</h3>';

	            $tag_ids = array();

		        foreach( $tags as $individual_tag ) $tag_ids[] = $individual_tag->term_id;

	            $args = array(
					'tag__in'          => $tag_ids,
					'post__not_in'     => array( $post->ID ),
					'posts_per_page'   => $number
	            );
		 
		        $wp_query = new wp_query( $args );
		 
		        echo '<div class="noo-related-post-wrap noo-row">';

		        while( $wp_query->have_posts() ) : $wp_query->the_post();
		        	
			        ?>
			        <div class="noo-related-post-item noo-md-4">

				        <h4 class="noo-title">

				        	<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
				        		
				        		<span class="noo-thumbnail">
						        	<img src="<?php echo noo_umbra_thumb_src( get_the_id(), 'noo-thumbnail-medium' ); ?>" alt="<?php the_title(); ?>" />
						        	<span class="view-link"></span>
					        	</span>
					        	<span class="noo-title"><?php the_title(); ?></span>

				        	</a>

				        </h4>
				        <div class="meta-info">
					        <?php
					        	if ( 'post' == get_post_type() ) {

						            printf( '<span class="author vcard"><i class="icon_pencil-edit"></i><a class="url fn n" href="%1$s">%2$s</a></span>',
						                esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
						                get_the_author()
						            );

						        }

						        if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
						            echo '<span class="comments-link"><i class="icon_comment_alt"></i>';
						            comments_popup_link( 0, 1, esc_html__( '%', 'noo-umbra' ) );
						            echo '</span>';
						        }
					        ?>
				        </div>

				    </div><!-- /.noo-related-post-item --><?php

	        	endwhile;

			    echo '</div><!-- /.noo-related-post-wrap -->';
	        
	        endif;

	    echo '</div><!-- /.noo-related-post-container -->';
        wp_reset_query();

	}

endif;