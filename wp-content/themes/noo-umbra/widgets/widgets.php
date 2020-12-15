<?php
if( !class_exists('Noo_Umbra_Infomation') ):
    class Noo_Umbra_Infomation extends  WP_Widget{

        public function __construct(){
            parent::__construct(
                'noo_infomation',
                'Noo Infomation',
                array('description', esc_html__('Noo Infomation', 'noo-umbra'))
            );
        }

        public function widget($args, $instance){
            extract( $args );
            extract( $instance );
            echo $before_widget;
            if ( ! empty( $instance['title'] ) ) {
                $title = apply_filters( 'widget_title', $instance['title'] );
            }
            if ( ! empty( $title ) ) {
                echo $before_title . $title . $after_title;
            }
            ?>
            <?php if( isset($desc) && !empty($desc) ) echo '<p class="info-desc">' . esc_html($desc) . '</p>'; ?>
            <ul class="noo-infomation-attr">
                <li>
                    <span class="text-icon"><?php esc_html_e('A','noo-umbra'); ?></span>
                    <address>
                        <?php if( isset($address) && !empty($address) ) echo esc_html($address); ?>
                    </address>
                </li>
                <li>
                    <span class="text-icon"><?php esc_html_e('T','noo-umbra'); ?></span>
                    <a href="tel:<?php echo esc_attr(str_replace(' ','',$phone)); ?>"><?php if( isset($phone) && !empty($phone) ) echo esc_html($phone); ?></a>
                </li>
                <li>
                    <span class="text-icon"><?php esc_html_e('M','noo-umbra'); ?></span>
                    <a class="phone-text" href="mailto:<?php echo esc_url($mail); ?>" target="_top"><?php if( isset($mail) && !empty($mail) )  echo esc_html($mail); ?></a>
                </li>
            </ul>


            <?php
            echo $after_widget;
        }

        public function form( $instance ){
            $instance = wp_parse_args( $instance, array(
                'title'           =>  esc_html__('Information', 'noo-umbra' ),
                'desc'            =>  '',
                'address'         =>  '',
                'phone'           =>  '',
                'mail'            =>  ''
            ) );
            extract($instance);
            ?>
            <p>
                <label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e('Title:', 'noo-umbra'); ?></label>
                <input type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title') ?>" class="widefat" value="<?php echo esc_attr($title); ?>">
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('desc'); ?>"><?php esc_html_e('Link Image:', 'noo-umbra'); ?></label>
                <textarea name="<?php echo $this->get_field_name('desc'); ?>" id="<?php echo $this->get_field_id('desc') ; ?>" cols="10" rows="5" class="widefat"><?php echo esc_attr($desc); ?></textarea>
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('address'); ?>"><?php esc_html_e('Address', 'noo-umbra') ; ?></label>
                <textarea name="<?php echo $this->get_field_name('address'); ?>" id="<?php echo $this->get_field_id('address') ; ?>" cols="10" rows="5" class="widefat"><?php echo esc_attr($address); ?></textarea>
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('phone'); ?>"><?php esc_html_e('Phone:', 'noo-umbra'); ?></label>
                <input type="text" id="<?php echo $this->get_field_id('phone'); ?>" name="<?php echo $this->get_field_name('phone') ?>" class="widefat" value="<?php echo esc_attr($phone); ?>">
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('mail'); ?>"><?php esc_html_e('Mail', 'noo-umbra') ; ?></label>
                <input class="widefat" type="text" name="<?php echo $this->get_field_name('mail'); ?>" id="<?php echo $this->get_field_id('mail') ; ?>" value="<?php echo esc_attr($mail); ?>">
            </p>

        <?php
        }
        // method update
        public function update( $new_instance, $old_instance ){
            $instance                 =   $old_instance;
            $instance['title']        =   ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : ''  ;
            $instance['desc']         =   $new_instance['desc'];
            $instance['address']      =   $new_instance['address'];
            $instance['phone']        =   $new_instance['phone'];
            $instance['mail']         =   $new_instance['mail'];
            return $instance;
        }
    }
    register_widget('Noo_Umbra_Infomation');
endif;
class Noo_Umbra_Widget_Categories extends WP_Widget {

	public function __construct() {
		$widget_ops = array( 'classname' => 'widget_noo_categories', 'description' => __( "A list or dropdown of categories.",'noo-umbra' ) );
		parent::__construct('noo_categories', esc_html__( 'Noo Categories','noo-umbra'), $widget_ops);
	}

	public function widget( $args, $instance ) {

		/** This filter is documented in wp-includes/default-widgets.php */
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? esc_html__( 'Categories','noo-umbra' ) : $instance['title'], $instance, $this->id_base );
		$c = ! empty( $instance['count'] ) ? '1' : '0';
		$h = ! empty( $instance['hierarchical'] ) ? '1' : '0';
		$p = ! empty( $instance['parent'] ) ? 0 : '';
		echo $args['before_widget'];
		if ( $title ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}

		$cat_args = array('orderby' => 'name', 'show_count' => $c, 'parent' => $p, 'hierarchical' => $h);
?>
		<ul>
<?php
		$cat_args['title_li'] = '';

		/**
		 * Filter the arguments for the Categories widget.
		 *
		 * @since 2.8.0
		 *
		 * @param array $cat_args An array of Categories widget options.
		 */
		wp_list_categories( apply_filters( 'widget_noo_categories_args', $cat_args ) );
?>
		</ul>
<?php

		echo $args['after_widget'];
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['count'] = !empty($new_instance['count']) ? 1 : 0;
		$instance['hierarchical'] = !empty($new_instance['hierarchical']) ? 1 : 0;
		$instance['parent'] = !empty($new_instance['parent']) ? 1 : 0;

		return $instance;
	}

	public function form( $instance ) {
		//Defaults
		$instance = wp_parse_args( (array) $instance, array( 'title' => '') );
		$title = esc_attr( $instance['title'] );
		$count = isset($instance['count']) ? (bool) $instance['count'] :false;
		$hierarchical = isset( $instance['hierarchical'] ) ? (bool) $instance['hierarchical'] : false;
		$parent = isset( $instance['parent'] ) ? (bool) $instance['parent'] : false;
?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php echo esc_html__( 'Title:','noo-umbra' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>"<?php checked( $count ); ?> />
		<label for="<?php echo $this->get_field_id('count'); ?>"><?php echo esc_html__( 'Show post counts','noo-umbra' ); ?></label><br />

		<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('hierarchical'); ?>" name="<?php echo $this->get_field_name('hierarchical'); ?>"<?php checked( $hierarchical ); ?> />
		<label for="<?php echo $this->get_field_id('hierarchical'); ?>"><?php echo esc_html__( 'Show hierarchy','noo-umbra' ); ?></label></p>

		<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('parent'); ?>" name="<?php echo $this->get_field_name('parent'); ?>"<?php checked( $parent ); ?> />
		<label for="<?php echo $this->get_field_id('parent'); ?>"><?php echo esc_html__( 'Only Show Parent','noo-umbra' ); ?></label></p>
<?php
	}
}

register_widget('Noo_Umbra_Widget_Categories');

class Noo_Umbra_Recent_News extends WP_Widget {

	public function __construct() {
		$widget_ops = array('classname' => 'widget_recent_news', 'description' => __( "Your site&#8217;s most recent Posts.",'noo-umbra') );
		parent::__construct('recent-news', esc_html__( 'Recent News','noo-umbra'), $widget_ops);
		$this->alt_option_name = 'widget_recent_news';
	}

	public function widget($args, $instance) {
		$cache = array();
		if ( ! $this->is_preview() ) {
			$cache = wp_cache_get( 'widget_recent_news', 'widget' );
		}

		if ( ! is_array( $cache ) ) {
			$cache = array();
		}

		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		if ( isset( $cache[ $args['widget_id'] ] ) ) {
			echo $cache[ $args['widget_id'] ];
			return;
		}

		ob_start();

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : esc_html__( 'Recent News','noo-umbra' );

		/** This filter is documented in wp-includes/default-widgets.php */
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

		$number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
		if ( ! $number )
			$number = 5;
		$show_date = isset( $instance['show_date'] ) ? $instance['show_date'] : false;

		/**
		 * Filter the arguments for the Recent Posts widget.
		 *
		 * @since 3.4.0
		 *
		 * @see WP_Query::get_posts()
		 *
		 * @param array $args An array of arguments used to retrieve the recent posts.
		 */
		$r = new WP_Query( apply_filters( 'widget_news_args', array(
			'posts_per_page'      => $number,
			'no_found_rows'       => true,
			'post_status'         => 'publish',
			'ignore_sticky_posts' => true,
			'meta_key' => '_noo_feature',
			'meta_value' 		=> '1',
		) ) );

		if ($r->have_posts()) :
?>
		<?php echo $args['before_widget']; ?>
		<?php if ( $title ) {
			echo $args['before_title'] . $title . $args['after_title'];
		} ?>
		<ul>
		<?php while ( $r->have_posts() ) : $r->the_post(); ?>
			<li>
			 <?php if ( has_post_thumbnail() ):
	            the_post_thumbnail(array(70, 70));
	        else: ?>
	            <img width="70" height="70" src="<?php echo get_template_directory_uri().'/assets/images/no-image.jpg' ; ?>" alt="<?php the_title_attribute(); ?>" />
	        <?php endif;  ?>
				<h5><a href="<?php the_permalink(); ?>"><?php get_the_title() ? the_title() : the_ID(); ?></a></h5>
			<?php if ( $show_date ) : ?>
				<span class="post-date"><?php echo get_the_date(); ?></span>
			<?php endif; ?>
			</li>
		<?php endwhile; ?>
		</ul>
		<?php echo $args['after_widget']; ?>
<?php
		// Reset the global $the_post as this query will have stomped on it
		wp_reset_postdata();

		endif;

		if ( ! $this->is_preview() ) {
			$cache[ $args['widget_id'] ] = ob_get_flush();
			wp_cache_set( 'widget_recent_news', $cache, 'widget' );
		} else {
			ob_end_flush();
		}
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['number'] = (int) $new_instance['number'];
		$instance['show_date'] = isset( $new_instance['show_date'] ) ? (bool) $new_instance['show_date'] : false;

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['widget_recent_entries']) )
			delete_option('widget_recent_entries');

		return $instance;
	}


	public function form( $instance ) {
		$title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
		$show_date = isset( $instance['show_date'] ) ? (bool) $instance['show_date'] : false;
?>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php echo esc_html__( 'Title:','noo-umbra' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php echo esc_html__( 'Number of posts to show:','noo-umbra' ); ?></label>
		<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>

		<p><input class="checkbox" type="checkbox" <?php checked( $show_date ); ?> id="<?php echo $this->get_field_id( 'show_date' ); ?>" name="<?php echo $this->get_field_name( 'show_date' ); ?>" />
		<label for="<?php echo $this->get_field_id( 'show_date' ); ?>"><?php echo esc_html__( 'Display post date?','noo-umbra' ); ?></label></p>
<?php
	}
}

register_widget('Noo_Umbra_Recent_News');

class Noo_Umbra_Tabs_Widget extends  WP_Widget{

    /**
     * Resister widget width WordPress
     */
    function __construct(){
       parent::__construct(
            'noo_tabs',
            esc_html__( 'Tabs Widget', 'noo-umbra'),
           array('description'  =>  esc_html__( 'Display post buy style tabs', 'noo-umbra'))
       );
    }

    /**
     * Front-end display of widget
     */
     public function widget( $args, $instance ){

         $limit = $instance['limit'];
         ?>
                <div class="noo-widgettab widget">
                    <div class="widget-tabs-header">
                        <h6 data-option-value='noo_topview' class="box-title">
                            <span>
                                <?php echo esc_html__( 'TRENDING', 'noo-umbra') ?>
                            </span>
                        </h6>
                        <h6 data-option-value='noo_recent' class="box-title noo_widgetab">
                            <span>
                                <?php echo esc_html__( 'RECENT', 'noo-umbra') ?>
                            </span>
                        </h6>
                        <h6 data-option-value='noo_comment' class="box-title noo_widgetab">
                            <span>
                                <?php echo esc_html__( 'COMMENT', 'noo-umbra') ?>
                            </span>
                        </h6>
                    </div>
                    <div class="widget_tabs_content">
                        <div class="noo_topview noo_widget_content">
                            <ul>
                                <?php
                                    $args = array(
                                        'posts_per_page' => $limit,
                                        'meta_key'       => 'post_count_indate',
                                        'orderby'        => 'meta_value_num',
                                        'order'          => 'DESC',
                                        'tax_query'      => array(
                                            array(
                                                'taxonomy' => 'post_format',
                                                'field'    => 'slug',
                                                'terms' => array(
                                                    'post-format-aside',
                                                    'post-format-chat',
                                                    'post-format-audio',
                                                    'post-format-link',
                                                    'post-format-quote',
                                                    'post-format-status'
                                                ),
                                                'operator' => 'NOT IN'
                                            )
                                        )
                                    );
                                    $top_query = new WP_Query( $args );
                                    if ( $top_query -> have_posts() ):
                                        while( $top_query -> have_posts() ): $top_query -> the_post();
                                ?>
                                <li>
                                    <?php the_post_thumbnail('thumbnail') ?>
                                    <div class="noo_tb">
                                        <?php echo NooPost::get_category_label( 'cat', true ); ?>
                                        <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                    </div>
                                </li>

                                <?php
                                        endwhile;
                                    endif;
                                    wp_reset_postdata();
                                ?>
                            </ul>
                        </div>
                        <div class="noo_recent noo_widget_content">
                            <ul>
                                <?php
                                    $args = array(
                                        'posts_per_page' => $limit,
                                        'orderby'        => 'date',
                                        'order'          => 'DESC',
                                        'tax_query'      => array(
                                            array(
                                                'taxonomy' => 'post_format',
                                                'field'    => 'slug',
                                                'terms' => array(
                                                    'post-format-aside',
                                                    'post-format-chat',
                                                    'post-format-audio',
                                                    'post-format-link',
                                                    'post-format-quote',
                                                    'post-format-status'
                                                ),
                                                'operator' => 'NOT IN'
                                            )
                                        )
                                    );
                                    $top_query = new WP_Query( $args );
                                    if ( $top_query -> have_posts() ):
                                        while( $top_query -> have_posts() ): $top_query -> the_post();
                                ?>
                                <li>
                                    <?php the_post_thumbnail('thumbnail') ?>
                                    <div class="noo_tb">
                                        <?php echo NooPost::get_category_label( 'cat', true ); ?>
                                        <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                    </div>
                                </li>

                                <?php
                                        endwhile;
                                    endif;
                                    wp_reset_postdata();
                                ?>
                            </ul>
                        </div>
                        <div class="noo_comment noo_widget_content">
                            <?php
                            $comments = get_comments( apply_filters( 'widget_comments_args', array(
                                'number'      => $limit,
                                'status'      => 'approve',
                                'post_status' => 'publish'
                            ) ) );

                            $output = '';

                            $output .= '<ul class="recentcomments">';
                            if ( $comments ) {
                                // Prime cache for associated posts. (Prime post term cache if we need it for permalinks.)
                                $post_ids = array_unique( wp_list_pluck( $comments, 'comment_post_ID' ) );
                                _prime_post_caches( $post_ids, strpos( get_option( 'permalink_structure' ), '%category%' ), false );

                                foreach ( (array) $comments as $comment) {
                                    $output .= '<li class="recentcomments">';
                                    /* translators: comments widget: 1: comment author, 2: post link */
                                    $output .= sprintf( _x( '%1$s on %2$s', 'widgets','noo-umbra' ),
                                        '<span class="comment-author-link">' . get_comment_author_link($comment->comment_ID) . '</span>',
                                        '<a href="' . esc_url( get_comment_link( $comment->comment_ID ) ) . '">' . get_the_title( $comment->comment_post_ID ) . '</a>'
                                    );
                                    $output .= '</li>';
                                }
                            }
                            $output .= '</ul>';
                            echo $output;
                            ?>
                        </div>
                    </div>
                    <script>

                        jQuery(document).ready(function(){
                            "use strict";
                            jQuery('.noo-widgettab').each(function(){
                                jQuery(this).find('.noo_widget_content:first').show();
                                jQuery(this).find('.widget-tabs-header h6:first').addClass('tab-active');
                            });

                            jQuery('.widget-tabs-header h6').click(function(){
                                jQuery(this).parent().find('h6').removeClass('tab-active');
                                jQuery(this).addClass('tab-active');
                                var $id = jQuery(this).attr('data-option-value');
                                jQuery(this).parent().parent().find('.noo_widget_content').fadeOut(0);
                                jQuery('.'+$id).fadeIn(0);

                            }) ;
                        });
                    </script>
                </div>
     <?php



     }

     /**
      * Back-end widget form
      */
     public function form($instance){
            extract(wp_parse_args($instance,array(
                'limit' =>  5
            )));
     ?>
        <p>
            <label for="<?php echo $this -> get_field_id('limit') ?>"><?php echo esc_html__( 'Limit post', 'noo-umbra') ?></label>
            <input type="text" name="<?php echo $this -> get_field_name('limit') ; ?>" id="<?php echo $this -> get_field_id('limit') ?>" class="widefat" value="<?php echo esc_attr($limit); ?>" />
        </p>
     <?php
     }

    /**
     * Update
     */
    public  function update($new_instance, $old_instance){
        $instance = array();
        $instance['limit']  =   ( !empty($new_instance['limit']) ) ? strip_tags($new_instance['limit']) : '';
        return $instance;
    }

}

register_widget('Noo_Umbra_Tabs_Widget');

class Noo_Umbra_Post_Slider extends WP_Widget {

	public function __construct() {
		$widget_ops = array('classname' => 'widget_post_slider', 'description' => __( "Your site&#8217;s most recent Posts.",'noo-umbra') );
		parent::__construct('post-slider', esc_html__( 'Post Slider','noo-umbra'), $widget_ops);
		$this->alt_option_name = 'widget_post_slider';
	}

	public function widget($args, $instance) {
		$cache = array();
		if ( ! $this->is_preview() ) {
			$cache = wp_cache_get( 'widget_post_slider', 'widget' );
		}

		if ( ! is_array( $cache ) ) {
			$cache = array();
		}

		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		if ( isset( $cache[ $args['widget_id'] ] ) ) {
			echo $cache[ $args['widget_id'] ];
			return;
		}

		ob_start();

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : esc_html__( 'Post Slider','noo-umbra' );

		/** This filter is documented in wp-includes/default-widgets.php */
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

		$number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
		if ( ! $number )
			$number = 5;
		$show_date = isset( $instance['show_date'] ) ? $instance['show_date'] : false;

		/**
		 * Filter the arguments for the Recent Posts widget.
		 *
		 * @since 3.4.0
		 *
		 * @see WP_Query::get_posts()
		 *
		 * @param array $args An array of arguments used to retrieve the recent posts.
		 */

		$ar =  array(
			'posts_per_page'      => $number,
			'no_found_rows'       => true,
			'post_status'         => 'publish',
			'ignore_sticky_posts' => true
		);
		$ar['tax_query'][]= array(
			'taxonomy' => 'post_format',
			'field'    => 'slug',
			'terms'    => 'post-format-gallery'
		);
		$r = new WP_Query( $ar );
		wp_enqueue_script('vendor-imagesloaded');
		wp_enqueue_script('noo-carousel');
		$posts_in_column = 1;
		$columns = 1;
		$noo_post_uid  		= uniqid('noo_post_');
		$class = '';
		$class .= ' '.$noo_post_uid;
		$class = ( $class != '' ) ? ' class="' . esc_attr( $class ) . '"' : '';
		if ($r->have_posts()) :
		?>
		<?php echo $args['before_widget']; ?>
		<?php if ( $title ) {
			echo $args['before_title'] . $title . $args['after_title'];
		} ?>
		<div <?php echo $class?>>

			<div class="row">
				<div class="widget-post-slider-content gallery">

					<?php $i=0; ?>
					<?php while ($r->have_posts()): $r->the_post(); global $post;
                    ?>

						<?php if($i++ % $posts_in_column == 0 ): ?>
						<div class="noo-post-slider-item col-sm-<?php echo absint((12 / $columns)) ?>">
						<?php endif; ?>
							<div class="noo-post-slider-inner">
								<div class="post-slider-featured" >
									<?php the_post_thumbnail('noo-thumbnail-square')?>
							    </div>
								<div class="post-slider-content">
									<h5 class="post-slider-title">
										<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( esc_html__( 'Permanent link to: "%s"','noo-umbra' ), the_title_attribute( 'echo=0' ) ) ); ?>"><?php the_title(); ?></a>
									</h5>
								</div>
							</div>
						<?php if($i % $posts_in_column == 0  || $i == $r->post_count): ?>
						</div>
						<?php endif;?>

					<?php endwhile;?>
				</div>
			</div>
			<div class="noo-post-navi">
				<div class="noo_slider_prev"><i class="fa fa-caret-left"></i></div>
				<div class="noo_slider_next"><i class="fa fa-caret-right"></i></div>
			</div>
		</div>
			<script type="text/javascript">
				jQuery('document').ready(function ($) {
					var postSliderOptions = {
					    infinite: true,
					    circular: true,
					    responsive: true,
					    debug : false,
						width: '100%',
					    height: 'variable',
					    scroll: {
					      items: <?php echo $columns;?>,
					      duration: 600,
					      pauseOnHover: "resume",
					      fx: "scroll"
					    },
					    auto: {
					      timeoutDuration: 3000,
					      play: false
					    },

					    prev : {button:".<?php echo $noo_post_uid ?> .noo_slider_prev"},
    					next : {button:".<?php echo $noo_post_uid ?> .noo_slider_next"},
					    swipe: {
					      onTouch: true,
					      onMouse: true
					    },
					    items: {
					        visible: {
						      min: 1,
						      max: <?php echo $columns;?>
						    },
						    height:'variable'
						}
					};
					jQuery('.<?php echo $noo_post_uid ?> .widget-post-slider-content').carouFredSel(postSliderOptions);
					imagesLoaded('<?php echo $noo_post_uid ?> .widget-post-slider-content',function(){
						jQuery('.<?php echo $noo_post_uid ?> .widget-post-slider-content').trigger('updateSizes');
					});
					jQuery(window).resize(function(){
						jQuery('.<?php echo $noo_post_uid ?> .widget-post-slider-content').trigger("destroy").carouFredSel(postSliderOptions);
					});
				});
			</script>
		<?php echo $args['after_widget']; ?>
<?php
		// Reset the global $the_post as this query will have stomped on it
		wp_reset_postdata();

		endif;

		if ( ! $this->is_preview() ) {
			$cache[ $args['widget_id'] ] = ob_get_flush();
			wp_cache_set( 'widget_post_slider', $cache, 'widget' );
		} else {
			ob_end_flush();
		}
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['number'] = (int) $new_instance['number'];
		$instance['show_date'] = isset( $new_instance['show_date'] ) ? (bool) $new_instance['show_date'] : false;

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['widget_recent_entries']) )
			delete_option('widget_recent_entries');

		return $instance;
	}

	public function form( $instance ) {
		$title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
		$show_date = isset( $instance['show_date'] ) ? (bool) $instance['show_date'] : false;
?>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php echo esc_html__( 'Title:','noo-umbra' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php echo esc_html__( 'Number of posts to show:','noo-umbra' ); ?></label>
		<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>

		<p><input class="checkbox" type="checkbox" <?php checked( $show_date ); ?> id="<?php echo $this->get_field_id( 'show_date' ); ?>" name="<?php echo $this->get_field_name( 'show_date' ); ?>" />
		<label for="<?php echo $this->get_field_id( 'show_date' ); ?>"><?php echo esc_html__( 'Display post date?','noo-umbra' ); ?></label></p>
<?php
	}
}

register_widget('Noo_Umbra_Post_Slider');

class Noo_Umbra_Latest_Ratting extends WP_Widget {

	public function __construct() {
		$widget_ops = array('classname' => 'widget_latest_ratting', 'description' => __( "Your site&#8217;s most recent Posts.",'noo-umbra') );
		parent::__construct('latest-rating', esc_html__( 'Latest Ratting','noo-umbra'), $widget_ops);
		$this->alt_option_name = 'widget_latest_ratting';
	}

	public function widget($args, $instance) {
		$cache = array();
		if ( ! $this->is_preview() ) {
			$cache = wp_cache_get( 'widget_latest_ratting', 'widget' );
		}

		if ( ! is_array( $cache ) ) {
			$cache = array();
		}

		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		if ( isset( $cache[ $args['widget_id'] ] ) ) {
			echo $cache[ $args['widget_id'] ];
			return;
		}

		ob_start();

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : esc_html__( 'Latest Rating','noo-umbra' );

		/** This filter is documented in wp-includes/default-widgets.php */
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

		$number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
		if ( ! $number )
			$number = 5;
		$show_date = isset( $instance['show_date'] ) ? $instance['show_date'] : false;

		/**
		 * Filter the arguments for the Recent Posts widget.
		 *
		 * @since 3.4.0
		 *
		 * @see WP_Query::get_posts()
		 *
		 * @param array $args An array of arguments used to retrieve the recent posts.
		 */
		$r = new WP_Query( apply_filters( 'widget_latest_rating_args', array(
			'posts_per_page'      => $number,
			'no_found_rows'       => true,
			'post_status'         => 'publish',
			'ignore_sticky_posts' => true,
			'meta_key'           =>  'noo_date_rating',
            'orderby'            =>  'meta_value',
            'order'              =>  'DESC',
		) ) );
		wp_enqueue_script('vendor-imagesloaded');
		wp_enqueue_script('noo-carousel');

		$posts_in_column = 1;
		$columns = 1;
		$noo_post_uid  		= uniqid('noo_post_');
		$class = '';
		$class .= ' '.$noo_post_uid;
		$class = ( $class != '' ) ? ' class="' . esc_attr( $class ) . '"' : '';
		if ($r->have_posts()) :
		?>
		<?php echo $args['before_widget']; ?>
		<?php if ( $title ) {
			echo $args['before_title'] . $title . $args['after_title'];
		} ?>
		<div <?php echo $class?>>

			<div class="row">
				<div class="widget-latest_ratting-content ">

					<?php $i=0; ?>
					<?php while ($r->have_posts()): $r->the_post(); global $post;
                    ?>

						<?php if($i++ % $posts_in_column == 0 ): ?>
						<div class="noo-latest_ratting-item col-sm-<?php echo absint((12 / $columns)) ?>">
						<?php endif; ?>
							<div class="noo-latest_ratting-inner">
								<div class="latest_ratting-featured" >
									<?php the_post_thumbnail('noo-thumbnail-square')?>
									<?php echo NooPost::get_category_label( 'noo-tncat' ); ?>
									<span class="noo_rating_point"><?php echo esc_html(noo_umbra_get_post_meta(get_the_ID(),'noo_total_point_rating',0)) ?></span>
							    </div>
								<div class="post-slider-content">
									<h4 class="post-slider-title">
										<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( esc_html__( 'Permanent link to: "%s"','noo-umbra' ), the_title_attribute( 'echo=0' ) ) ); ?>"><?php the_title(); ?></a>
									</h4>
									<div class="noo-ratting-meta">
				                        <span class="noo-post-date"><i class="fa fa-calendar"></i><?php echo get_the_date(); ?></span>
				                        <span class="noo-post-comment"><i class="fa fa-comments-o"></i><?php comments_number('0',1,'%') ?></span>
				                    </div>
				                    <?php
				                    $excerpt = get_the_excerpt();
				                    $excerpt_ex = explode(' ', $excerpt);
				                    $excerpt_slice = array_slice($excerpt_ex,0,15);
				                    $excerpt_content = implode(' ',$excerpt_slice);
				                    ?>
				                    <p><?php echo esc_html($excerpt_content); ?></p>
								</div>
							</div>
						<?php if($i % $posts_in_column == 0  || $i == $r->post_count): ?>
						</div>
						<?php endif;?>

					<?php endwhile;?>
				</div>
			</div>
			<div class="noo-post-navi">
				<div class="noo_slider_prev"><i class="fa fa-caret-left"></i></div>
				<div class="noo_slider_next"><i class="fa fa-caret-right"></i></div>
			</div>
		</div>
			<script type="text/javascript">
				jQuery('document').ready(function ($) {
					var postSliderOptions = {
					    infinite: true,
					    circular: true,
					    responsive: true,
					    debug : false,
						width: '100%',
					    height: 'variable',
					    scroll: {
					      items: <?php echo $columns;?>,
					      duration: 600,
					      pauseOnHover: "resume",
					      fx: "scroll"
					    },
					    auto: {
					      timeoutDuration: 3000,
					      play: false
					    },

					    prev : {button:".<?php echo $noo_post_uid ?> .noo_slider_prev"},
    					next : {button:".<?php echo $noo_post_uid ?> .noo_slider_next"},
					    swipe: {
					      onTouch: true,
					      onMouse: true
					    },
					    items: {
					        visible: {
						      min: 1,
						      max: <?php echo $columns;?>
						    },
						    height:'variable'
						}
					};
					jQuery('.<?php echo $noo_post_uid ?> .widget-latest_ratting-content').carouFredSel(postSliderOptions);
					imagesLoaded('<?php echo $noo_post_uid ?> .widget-latest_ratting-content',function(){
						jQuery('.<?php echo $noo_post_uid ?> .widget-latest_ratting-content').trigger('updateSizes');
					});
					jQuery(window).resize(function(){
						jQuery('.<?php echo $noo_post_uid ?> .widget-latest_ratting-content').trigger("destroy").carouFredSel(postSliderOptions);
					});
				});
			</script>
		<?php echo $args['after_widget']; ?>
<?php
		// Reset the global $the_post as this query will have stomped on it
		wp_reset_postdata();

		endif;

		if ( ! $this->is_preview() ) {
			$cache[ $args['widget_id'] ] = ob_get_flush();
			wp_cache_set( 'widget_latest_ratting', $cache, 'widget' );
		} else {
			ob_end_flush();
		}
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['number'] = (int) $new_instance['number'];
		$instance['show_date'] = isset( $new_instance['show_date'] ) ? (bool) $new_instance['show_date'] : false;

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['widget_recent_entries']) )
			delete_option('widget_recent_entries');

		return $instance;
	}

	public function form( $instance ) {
		$title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
		$show_date = isset( $instance['show_date'] ) ? (bool) $instance['show_date'] : false;
?>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php echo esc_html__( 'Title:','noo-umbra' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php echo esc_html__( 'Number of posts to show:','noo-umbra' ); ?></label>
		<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>

		<p><input class="checkbox" type="checkbox" <?php checked( $show_date ); ?> id="<?php echo $this->get_field_id( 'show_date' ); ?>" name="<?php echo $this->get_field_name( 'show_date' ); ?>" />
		<label for="<?php echo $this->get_field_id( 'show_date' ); ?>"><?php echo esc_html__( 'Display post date?','noo-umbra' ); ?></label></p>
<?php
	}
}

register_widget('Noo_Umbra_Latest_Ratting');

if( !class_exists('Noo_Umbra_Widget_Instagram') ):
    class Noo_Umbra_Widget_Instagram extends  WP_Widget{

        public function __construct(){
            parent::__construct(
                'noo_widget_instagram',
                'Noo Instagram',
                array(
                    'description', 
                    esc_html__('Noo Instagram', 'noo-umbra')
                )
            );
        }

        public function widget($args, $instance){
            extract( $args );
            extract( $instance );
            echo $before_widget;
            if ( ! empty( $instance['title'] ) ) {
                $title = apply_filters( 'widget_title', $instance['title'] );
            }
            if ( ! empty( $title ) ) {
                echo $before_title . $title . $after_title;
            }
            ?>

            <div class="noo-instagram">
                <ul>
                    <?php
                    $data = noo_umbra_get_instagram_data( $instagram_username, $refresh_hour, $number, 'standard_resolution', $randomise );

                    if( isset($data) && is_array($data) && !empty($data)){
                        foreach ($data as $value) {

                            $link = '';
                            $image = '';
                            $text = '';
                            if( isset($value['link']) && !empty($value['link']) ){
                                $link = $value['link'];
                            }
                            if( isset($value['text']) && !empty($value['text']) ){
                                $text = $value['text'];
                            }
                            if( isset($value['image']) && !empty($value['image']) ){
                                $image = $value['image'];
                            }
                            echo '<li><a target="_blank" href="'.esc_url($link).'"><img src="'.esc_url($image).'" alt="'.esc_attr($text).'"></a></li>';
                        }
                    }
                    ?>
                </ul>
            </div>

            <?php
            echo $after_widget;
        }

        public function form( $instance ){
            $instance = wp_parse_args( $instance, array(
                'title'                         =>  esc_html__('instagram photos', 'noo-umbra' ),
                'instagram_username'            =>  '',
                'number'                        =>  '8',
                'refresh_hour'                  =>  '4',
                'randomise'                     =>  'true'
            ) );
            extract($instance);
            ?>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id('title') ); ?>"><?php esc_html_e('Title:', 'noo-umbra'); ?></label>
                <input type="text" id="<?php echo esc_attr( $this->get_field_id('title') ); ?>" name="<?php echo esc_attr( $this->get_field_name('title') ); ?>" class="widefat" value="<?php echo esc_attr($title); ?>">
            </p>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id('instagram_username') ); ?>"><?php esc_html_e('Instagram username:', 'noo-umbra'); ?></label>
                <input type="text" id="<?php echo esc_attr( $this->get_field_id('instagram_username') ); ?>" name="<?php echo esc_attr( $this->get_field_name('instagram_username') ); ?>" class="widefat" value="<?php echo esc_attr($instagram_username); ?>">
            </p>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id('number') ); ?>"><?php esc_html_e('Number:', 'noo-umbra'); ?></label>
                <input type="text" id="<?php echo esc_attr( $this->get_field_id('number') ); ?>" name="<?php echo esc_attr( $this->get_field_name('number') ); ?>" class="widefat" value="<?php echo esc_attr($number); ?>">
            </p>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id('refresh_hour') ); ?>"><?php esc_html_e('Refresh hour:', 'noo-umbra'); ?></label>
                <input type="text" id="<?php echo esc_attr( $this->get_field_id('refresh_hour') ); ?>" name="<?php echo esc_attr( $this->get_field_name('refresh_hour') ); ?>" class="widefat" value="<?php echo esc_attr($refresh_hour); ?>">
            </p>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id('randomise') ); ?>"><?php esc_html_e('Randomise:', 'noo-umbra'); ?></label>
                <input type="text" id="<?php echo esc_attr( $this->get_field_id('randomise') ); ?>" name="<?php echo esc_attr( $this->get_field_name('randomise') ) ?>" class="widefat" value="<?php echo esc_attr($randomise); ?>">
            </p>

        <?php
        }
        // method update
        public function update( $new_instance, $old_instance ){
            $instance                             =   $old_instance;
            $instance['title']                    =   ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : ''  ;
            $instance['instagram_username']       =   ( ! empty( $new_instance['instagram_username'] ) ) ? strip_tags( $new_instance['instagram_username'] ) : ''  ;
            $instance['number']                   =   ( ! empty( $new_instance['number'] ) ) ? strip_tags( $new_instance['number'] ) : ''  ;
            $instance['refresh_hour']             =   ( ! empty( $new_instance['refresh_hour'] ) ) ? strip_tags( $new_instance['refresh_hour'] ) : ''  ;
            $instance['randomise']                =   ( ! empty( $new_instance['randomise'] ) ) ? strip_tags( $new_instance['randomise'] ) : ''  ;
            return $instance;
        }
    }
    register_widget('Noo_Umbra_Widget_Instagram');
endif;