<?php

    if( !function_exists('noo_shortcode_product_grid') ){

        function noo_shortcode_product_grid($atts)
        {
            extract(shortcode_atts(array(
                'title'         => '',
                'sub_title'     => '',
                'style'         => 'one',
                'masonry'       => 'product_masonry',
                'filter'        => 'no-filter',
                'data'          => 'recent',
                'product_cat'   => '',
                'columns'       => 'columns_5',
                'orderby'        => 'latest',
                'posts_per_page' => 8
            ), $atts));
            ob_start();
            if( $masonry == 'product_masonry' ):
                wp_enqueue_script('imagesloaded');
                wp_enqueue_script('isotope');
            endif;

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



            ?>
            <div class="noo-shortcode-product-wrap">
            <div class="noo-product-header">
                <h3><span><?php echo esc_html($title); ?></span></h3>

                <p><?php echo esc_html($sub_title); ?></p>
            </div>
            <?php

            $cat_id = '';

            $args_cat = array(
                'type' => 'product',
                'taxonomy' => 'product_cat'
            );

            if (isset($product_cat) && !empty($product_cat) && $data == 'cat' && $filter == 'filter') {
                $args_cat['include'] = $product_cat;
                ?>
                <ul class="noo-product-filter">
                    <?php
                    $categories = get_categories($args_cat);
                    if (isset($categories) && !empty($categories)):

                        foreach ($categories as $key => $cats):
                            if ($key == 0) {
                                $cat_id = $cats->term_id;
                            }

                            $config = array(
                                'id'            =>  $cats->term_id,
                                'style'         =>  $style,
                                'per_page'      =>  $posts_per_page,
                                'orderby'       => $orderby,
                                'order'         =>  $order,
                                'masonry'       =>  $masonry
                            );
                            ?>
                            <li>
                                <a href="#" data-config="<?php echo esc_attr(json_encode($config)); ?>">
                                    <?php echo esc_html($cats->name); ?>
                                </a>
                            </li>
                        <?php endforeach;
                    endif;
                    ?>
                </ul>
            <?php } ?>
            <div class="noo-sh-product-grid woocommerce ">
            <div class="spinner">
                <div class="bounce1"></div>
                <div class="bounce2"></div>
                <div class="bounce3"></div>
            </div>
            <div class="noo-sh-product-html <?php echo esc_attr($columns.' '.$masonry.' '.$style); ?>">
            <?php

            $args = array(
                'post_type'      => 'product',
                'orderby'        => $orderby,
                'order'          => $order,
                'posts_per_page' => $posts_per_page
            );

            if ($filter == 'filter' && $data == 'cat') {
                if (isset($cat_id) && !empty($cat_id)) {
                    $args['tax_query'][] = array(
                        'taxonomy' => 'product_cat',
                        'field' => 'term_id',
                        'terms' => $cat_id
                    );
                }
            } elseif ($filter == 'no-filter' && $data == 'cat') {
                if (isset($product_cat) && !empty($product_cat)) {
                    $new_id = explode(',', $product_cat);
                    $new_cat = array();
                    foreach ($new_id as $id) {
                        $new_cat[] = intval($id);
                    }
                    $args['tax_query'][] = array(
                        'taxonomy' => 'product_cat',
                        'field' => 'term_id',
                        'terms' => $new_cat
                    );
                }
            } else {
                switch ($data):
                    case 'featured':
                        $args['meta_query'][] = array(
                            'key' => '_featured',
                            'value' => 'yes'
                        );
                        break;
                    case 'selling':
                        $args['meta_key'] = 'total_sales';
                        $args['orderby'] = 'meta_value_num';
                        break;
                    case 'sale':
                        if (function_exists('wc_get_product_ids_on_sale')):
                            $product_ids_on_sale = wc_get_product_ids_on_sale();
                            $args['post__in'] = array_merge(array(0), $product_ids_on_sale);
                        endif;
                        break;
                endswitch;
            }
            $col_num = explode('_', $columns);
            $col_num = $col_num[1];

            global $woocommerce_loop;
            $query = new WP_Query($args);
            $woocommerce_loop['columns'] = $col_num;
            if ($query->have_posts()):
                    if ($style == 'one') {
                        while ($query->have_posts()): $query->the_post();

                            wc_get_template_part('content', 'product');
                        endwhile;
                        wp_reset_postdata();
                    } elseif ( $style == 'two' || $style == 'three' ) {
                        while ($query->have_posts()): $query->the_post();
                            $noo_featured = noo_umbra_get_post_meta(get_the_ID(),'_featured');
                            if( $masonry == 'product_masonry' && $noo_featured == 'yes'){
                                remove_action( 'woocommerce_before_shop_loop_item_title2', 'noo_umbra_template_loop_product_thumbnail2', 10 );
                                remove_action( 'woocommerce_before_shop_loop_item_title2', 'noo_umbra_template_loop_product_thumbnail', 10 );
                                add_action( 'woocommerce_before_shop_loop_item_title2', 'noo_umbra_template_loop_product_thumbnail3', 10 );
                            }elseif( $style == 'three'){
                                remove_action( 'woocommerce_before_shop_loop_item_title2', 'noo_umbra_template_loop_product_thumbnail3', 10 );
                                remove_action( 'woocommerce_before_shop_loop_item_title2', 'noo_umbra_template_loop_product_thumbnail', 10 );
                                add_action( 'woocommerce_before_shop_loop_item_title2', 'noo_umbra_template_loop_product_thumbnail2', 10 );
                            }elseif( $style == 'two'){
                                remove_action( 'woocommerce_before_shop_loop_item_title2', 'noo_umbra_template_loop_product_thumbnail3', 10 );
                                remove_action( 'woocommerce_before_shop_loop_item_title2', 'noo_umbra_template_loop_product_thumbnail2', 10 );
                                add_action( 'woocommerce_before_shop_loop_item_title2', 'noo_umbra_template_loop_product_thumbnail', 10 );
                            }
                            wc_get_template_part('content', 'product2');
                        endwhile;
                        wp_reset_postdata();
                    }
            endif;
                    ?>
                    </div><!--end .noo-sh-product-html-->
                </div><!--end .noo-sh-product-grid-->
            </div><!--end .noo-shortcode-product-wrap-->
            <?php if( $masonry == 'product_masonry' ): ?>
            <script>
                jQuery(document).ready(function(){
                    "use strict";
                    jQuery('.product_masonry').each(function(){
                        var $this = jQuery(this);
                        $this.imagesLoaded(function(){
                            $this.isotope({
                                itemSelector : '.noo-product-item',
                                transitionDuration : '0.8s',
                                masonry : {
                                    'gutter' : 0
                                }
                            });

                        });
                    });
                })
            </script>
            <?php endif; ?>
            <?php $noo_product = ob_get_contents();
            ob_end_clean();
            return $noo_product;
        }
        add_shortcode('noo_product_grid','noo_shortcode_product_grid');

    }

