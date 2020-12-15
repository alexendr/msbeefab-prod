<?php

    /*
     * Display member
     */
    if( !function_exists('noo_shortcode_membder') ){
        function noo_shortcode_member($atts){
            extract(shortcode_atts(array(
                'title'          =>  '',
                'desc'           =>  '',
                'categories'     =>  '',
                'orderby'        =>  '',
                'posts_per_page' =>  ''
            ),$atts));
            ob_start();
            ?>
            <?php if( $title != '' || $desc != '' ): ?>
                <div class="noo-shblog-header noo-shmember-header">
                    <h3><span><?php echo esc_html($title); ?></span></h3>
                    <p><?php echo esc_html($desc); ?></p>
                </div>
            <?php endif; ?>
            <?php
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
                'post_type'         =>  'team_member',
                'orderby'           =>   $orderby,
                'order'             =>   $order,
                'posts_per_page'    =>  $posts_per_page
            );
            if(isset($categories) && !empty($categories) ):
                $args['tax_query'][] = array(
                    'taxonomy'      =>  'team_member_category',
                    'field'         =>  'term_id',
                    'terms'         =>  array($categories)
                );
            endif;
            $socail  = array('facebook','twitter','google','linkedin','flickr','pinterest','instagram','tumblr');
            $query = new WP_Query( $args );
            if( $query->have_posts() ):
                echo '<div class="noo-row">';
                while( $query->have_posts() ):
                    $query->the_post();
                    $image    = noo_umbra_get_post_meta(get_the_ID(),'_noo_wp_team_member_image','');
                    $name     = noo_umbra_get_post_meta(get_the_ID(),'_noo_wp_team_member_name');
                    $position = noo_umbra_get_post_meta(get_the_ID(),'_noo_wp_team_member_position');
                    ?>
                    <div class="noo-md-4 noo-sm-6 noo-team-member">
                        <figure>
                            <?php if(isset($image) && !empty($image)):
                                    echo '<div class="noo-teamm-image">';
                                    echo wp_get_attachment_image($image,'full');
                                    echo '</div>';
                               endif; ?>
                            <figcaption>
                                <div class="noo-team-content">
                                    <h4><?php echo esc_html($name); ?></h4>
                                    <span class="position"><?php echo esc_html($position); ?></span>
                                    <span class="noo-team-social">
                                        <?php for( $i=0; $i < count( $socail ); $i++ ): ?>
                                            <?php
                                            $social_key = '_noo_wp_team_member_'.$socail[$i];
                                            $social_url = noo_umbra_get_post_meta(get_the_ID(),$social_key,'');
                                            if( isset($social_url) && !empty($social_url) ): ?>
                                                <a href="<?php echo esc_url($social_url); ?>" class="fa fa-<?php echo esc_attr($socail[$i]); ?>"></a>
                                            <?php endif; ?>
                                        <?php endfor; ?>
                                    </span>
                                </div>
                            </figcaption>
                        </figure>
                    </div>
                <?php endwhile;
                echo '</div>';
            endif;
            wp_reset_postdata();

            $member = ob_get_contents();
            ob_end_clean();
            return $member;
        }
        add_shortcode('noo_member','noo_shortcode_member');
    }
?>