<?php

    if( !function_exists('noo_shortcode_simple_product') ){

        function noo_shortcode_simple_product($atts, $content = null){
            extract(shortcode_atts(array(
                'product_cat'    =>  '',
                'orderby'        =>  'latest',
                'posts_per_page' =>  4,
                'banner_style'    => 'banner_left',
                'content_style'   => 'bottom_right',
                'banner_id'      => '',
                'title'          => '',
                'description'    => '',
                'custom_link'    => '',
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
                'post_type'         =>  'product',
                'orderby'           =>   $orderby,
                'order'             =>   $order,
                'posts_per_page'    =>   $posts_per_page
            );
            if( isset($product_cat)  && !empty($product_cat) ){
                $new_id = explode(',',$product_cat);
                $new_cat = array();
                foreach($new_id as $id){
                    $new_cat[] = intval($id);
                }
                $args['tax_query'][] = array(
                    'taxonomy'  =>  'product_cat',
                    'field'     =>  'term_id',
                    'terms'     =>   $new_cat
                );
            }
            add_action('noo_simple_product_entry','woocommerce_template_loop_price');
            add_action('noo_simple_product_entry','noo_umbra_woocommerce_template_loop_more_meta');
            ?>
            <div class="noo-simple-product <?php echo esc_attr($banner_style); ?>">
                <?php
                    if( isset($banner_id) && !empty($banner_id) ){
                        $url_banner = wp_get_attachment_image_src($banner_id,'full');
                    }
                ?>
                <div class="simple-banner-left <?php echo esc_attr($content_style); ?>" <?php if( isset($url_banner) && !empty($url_banner) ): ?> style="background-image: url('<?php echo esc_url($url_banner[0]) ?>')" <?php endif; ?>>
                    <div class="banner-left-content">
                        <h3>
                            <?php echo esc_html($title); ?>
                        </h3>
                        <?php echo wpb_js_remove_wpautop( $content , true ); ?>
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
                <div class="noo-simple-content">
                    <?php
                    $query = new WP_Query($args) ;
                    if( $query->have_posts() ):
                        while( $query->have_posts() ):
                            $query->the_post();  global $product;
                            if( $product->is_type( 'simple' ) ){
                                add_action('noo_simple_product_cart','woocommerce_template_loop_add_to_cart',30);
                            }
                            ?>
                            <div class="noo-inner woocommerce">
                                    <a href="<?php the_permalink() ?>" class="hover-device">
                                        <?php the_post_thumbnail('noo-thumbnail-product') ?>
                                    </a>
                                    <div class="noo-loop-cart">
                                        <?php do_action('noo_simple_product_cart'); ?>
                                    </div>
                                    <div class="simple-product-entry">
                                        <?php do_action('noo_simple_product_entry'); ?>
                                        <h3><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h3>
                                    </div>

                            </div>

                    <?php    endwhile; wp_reset_postdata();
                    endif;
                    ?>
                </div>
            </div>
            <?php $simple_product = ob_get_contents();
            ob_end_clean();
            return $simple_product;
        }
        add_shortcode('noo_simple_product','noo_shortcode_simple_product');

    }