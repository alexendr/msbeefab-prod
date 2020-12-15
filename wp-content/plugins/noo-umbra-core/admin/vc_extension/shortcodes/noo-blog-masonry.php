<?php

    if( !function_exists('noo_shortcode_blog_masonry') ){

        function noo_shortcode_blog_masonry($atts){
            extract(shortcode_atts(array(
                'type_query'        =>  'cate',
                'categories'        =>  '',
                'tags'              =>  '',
                'include'           =>  '',
                'orderby'           =>  'latest',
                'columns'           =>  '3',
                'posts_per_page'    =>  '',
                'limit_excerpt'     =>  15,
                'pagination'        =>  'infinitescroll'
            ),$atts));
            ob_start();
            wp_enqueue_script('imagesloaded');
            wp_enqueue_script( 'infinitescroll' );
            wp_enqueue_script('isotope');
            $order = 'DESC';
            switch ($orderby) {
                case 'latest':
                    $orderby = 'date';
                    break;

                case 'oldest':
                    $orderby = 'date';
                    $order = 'ASC';
                    break;

                case 'alphabet':
                    $orderby = 'title';
                    $order = 'ASC';
                    break;

                case 'ralphabet':
                    $orderby = 'title';
                    break;

                default:
                    $orderby = 'date';
                    break;
            }
            if( is_front_page() || is_home()) {
                $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : ( ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1 );
            } else {
                $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
            }
            $args = array(
                'orderby'           =>   $orderby,
                'order'             =>   $order,
                'paged'             =>   $paged,
                'posts_per_page'    =>   $posts_per_page,
            );
            if($type_query == 'cate'){
                $args['cat']   =  $categories ;
            }
            if($type_query == 'tag'){
                if($tags != 'all'):
                    $tag_id = explode (',' , $tags);
                    $args['tag__in'] = $tag_id;
                endif;
            }
            if($type_query == 'post_id'){
                $posts_var = '';
                if ( isset($include) && !empty($include) ){
                    $posts_var = explode (',' , $include);
                }
                $args['post__in'] = $posts_var;
            }
            ?>
                <div class="noo-blog-masonry-wraper">
                    <div class="noo-row noo-blog-masonry">
                    <?php $query = new WP_Query($args) ;
                        if( $query->have_posts() ):
                            while( $query->have_posts() ): $query->the_post();
                            ?>
                            <div id="post-<?php the_ID(); ?>" class="noo-blog-masonry-item noo-sm-6 noo-md-<?php echo esc_attr($columns); ?>">
                                <?php include(locate_template("content-masonry.php")); ?>
                            </div>
                    <?php
                            endwhile;
                            wp_reset_postdata();
                     endif;
                    ?>
                    </div>
                    <div class="blog-pagination">
                        <div class="noo-load-image"></div>
                        <?php
                        if( function_exists('noo_umbra_pagination_normal') ):
                            noo_umbra_pagination_normal(array(),$query);
                        endif;
                        ?>
                        <?php if( $pagination == 'ajax_button' ){ ?>
                            <button class="noo-loadmore-ajax"><?php esc_html_e('Load more','noo-umbra-core'); ?></button> 
                        <?php } ?>
                    </div>
                </div>
            <?php
            $noo_blog_masonry = ob_get_contents();
            ob_end_clean();
            return $noo_blog_masonry;
        }
        add_shortcode('noo_blog_masonry','noo_shortcode_blog_masonry');

    }
