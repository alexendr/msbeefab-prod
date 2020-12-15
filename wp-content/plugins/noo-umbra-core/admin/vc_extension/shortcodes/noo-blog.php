<?php

    if( !function_exists('noo_shortcode_blog') ){

        function noo_shortcode_blog($atts){
            extract(shortcode_atts(array(
                'title'             =>  '',
                'desc'              =>  '',
                'style'             =>  'style_1',
                'type_query'        =>  'cate',
                'categories'        =>  '',
                'tags'              =>  '',
                'include'           =>  '',
                'orderby'           =>  'latest',
                'posts_per_page'    =>  '',
                'limit_excerpt'     =>   20,
                'custom_link'       =>  ''
            ),$atts));
            ob_start();
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
            $args = array(
                'orderby'           =>   $orderby,
                'order'             =>   $order,
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
            <div class="noo_sh_blog_wraper">
                <div class="noo-shblog-header">
                    <h3><span><?php echo esc_html($title); ?></span></h3>
                    <p><?php echo esc_html($desc); ?></p>
                </div>
                <div class="noo-shblog-content noo-row">
                    <?php
                        $query = new WP_Query($args);
                        if( $style == 'style_1' ) {
                            if ($query->have_posts()):
                                while ($query->have_posts()):
                                    $query->the_post(); ?>
                                    <div class="noo-md-4 noo-sm-6 noo-shblog-meta-default">
                                        <div class="noo-shblog-thumbnail"><a
                                                href="<?php the_permalink() ?>"><?php the_post_thumbnail('large'); ?>
                                                <span class="view-link"></span></a></div>
                                        <div class="noo-shblog-meta">
                                            <?php

                                            printf('<span class="posted-on"><i class="icon_clock_alt"></i><a href="%1$s" rel="bookmark">%2$s</a></span>',
                                                esc_url(get_permalink()),
                                                get_the_date()
                                            );
                                            printf('<span class="author vcard"><i class="icon_pencil-edit"></i><a class="url fn n" href="%1$s">%2$s</a></span>',
                                                esc_url(get_author_posts_url(get_the_author_meta('ID'))),
                                                get_the_author()
                                            );
                                            if (!is_single() && !post_password_required() && (comments_open() || get_comments_number())) {
                                                echo '<span class="comments-link"><i class="icon_comment_alt"></i>';
                                                comments_popup_link(esc_html__('0', 'noo-umbra-core'), esc_html__('1', 'noo-umbra-core'), esc_html__('%', 'noo-umbra-core'));
                                                echo '</span>';
                                            }
                                            ?>
                                        </div>
                                        <h3><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h3>

                                        <p><?php
                                            $excerpt = get_the_excerpt();
                                            $trim_ex = wp_trim_words($excerpt, esc_attr($limit_excerpt), '...');
                                            echo esc_html($trim_ex);
                                            ?></p>
                                    </div>
                                <?php endwhile;
                                wp_reset_postdata();
                            endif;
                        }else{ ?>
                    <?php
                            if ($query->have_posts()):
                                $i = 0;
                                while ($query->have_posts()):
                                    $query->the_post();
                                    $url_img = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()),'full');
                                    $class = '';
                                    if( $i % 2 == 0 && $i != 0 ){
                                        $class = 'style_even';
                                    }
                                    if( $i % 4 == 0 && $i != 0 ){
                                        $class = '';
                                    }

                                    ?>
                                    <div class="noo-shblog-item <?php echo esc_attr($style.' '.$class) ?>">
                                        <a class="noo-shblog-thumbnail" href="<?php the_permalink() ?>" <?php if( isset($url_img[0]) && !empty($url_img[0])): ?>style="background-image: url('<?php echo esc_url($url_img[0]) ?>')"<?php endif; ?>><span class="view-link"></span></a>
                                        <div class="noo-shblog-entry">
                                            <span class="cat"><?php the_category(', ' ) ?></span>
                                            <span class="date">
                                                <span><?php echo get_the_date('d') ?></span>
                                                / <?php echo get_the_date('M') ?>
                                            </span>
                                            <h3><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h3>
                                            <div class="noo-shblog-meta">
                                                <?php

                                                printf('<span class="posted-on"><i class="icon_clock_alt"></i><a href="%1$s" rel="bookmark">%2$s</a></span>',
                                                    esc_url(get_permalink()),
                                                    get_the_date()
                                                );
                                                printf('<span class="author vcard"><i class="icon_pencil-edit"></i><a class="url fn n" href="%1$s">%2$s</a></span>',
                                                    esc_url(get_author_posts_url(get_the_author_meta('ID'))),
                                                    get_the_author()
                                                );
                                                if (!is_single() && !post_password_required() && (comments_open() || get_comments_number())) {
                                                    echo '<span class="comments-link"><i class="icon_comment_alt"></i>';
                                                    comments_popup_link(esc_html__('0', 'noo-umbra-core'), esc_html__('1', 'noo-umbra-core'), esc_html__('%', 'noo-umbra-core'));
                                                    echo '</span>';
                                                }
                                                ?>
                                            </div>
                                            <p><?php
                                                $excerpt = get_the_excerpt();
                                                $trim_ex = wp_trim_words($excerpt, esc_attr($limit_excerpt), '...');
                                                echo esc_html($trim_ex);
                                                ?></p>
                                            <a class="view_link" href="<?php the_permalink() ?>"><?php echo esc_html__('read more','noo-umbra-core'); ?><i class="fa fa-angle-right"></i></a>
                                        </div>

                                    </div>
                                <?php
                                    $i++;
                                    endwhile;
                                wp_reset_postdata();
                            endif;
                        }
                    ?>
                </div>
                <div class="text-center">
                    <?php
                    if( isset( $custom_link ) && !empty( $custom_link )){
                        $link = vc_build_link( $custom_link );
                        ?>
                        <a class="custom_link" href="<?php echo esc_url($link['url']) ?>" <?php if( isset($link['target']) && !empty( $link['target'] ) ): ?>target="_blank" <?php endif; ?>><?php echo esc_html($link['title']) ?><i class="fa fa-angle-right"></i></a>
                    <?php
                    }
                    ?>
                </div>
            </div>
            <?php
            $noo_shblog = ob_get_contents();
            ob_end_clean();
            return $noo_shblog;
        }
        add_shortcode('noo_blog','noo_shortcode_blog');

    }
