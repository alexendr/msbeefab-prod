<?php

    if( !function_exists('noo_shortcode_product_countdown')){

        function noo_shortcode_product_countdown($atts){
            extract(shortcode_atts(array(
                'date'              =>  '',
                'id'                =>  '',
                'style'             =>  'default'
            ),$atts));
            ob_start();
            wp_enqueue_script('countdown-plugin');
            wp_enqueue_script('countdown-js');
            if( $id == '' ){
                return false;
            }
            $date_time = '';
            if( isset($date) && $date != '' ){
                $date_time = explode('/',$date);
            }
            $args = array(
                'post_type' => 'product',
                'p'         => esc_attr($id)
            );
            add_action('noo_countdown_product','woocommerce_template_loop_price');
            add_action('noo_countdown_product','noo_umbra_template_noo_single_excerpt');
            add_action('noo_countdown_product','woocommerce_template_loop_add_to_cart');
            $query = new WP_Query( $args );
            if( $query->have_posts() ): ?>
                <div class="noo-countdown-product woocommerce">
                    <div>
                        <div class="defaultCountdown"></div>
                        <?php while( $query->have_posts() ):
                            $query->the_post();
                             the_post_thumbnail('full');
                            ?>
                            <div class="noo-content-countdow">
                                <h3><a href="<?php the_permalink(); ?>"><?php the_title() ?></a></h3>

                                <?php do_action('noo_countdown_product'); ?>
                            </div>

                            <?php if(function_exists('noo_umbra_template_loop_add_to_cart')):  noo_umbra_template_loop_add_to_cart(get_the_ID()); endif; ?>
                        <?php  endwhile;  ?>
                        <script>
                            jQuery(document).ready(function(){
                                austDay = new Date(<?php if( isset($date_time) && $date_time[2] !=''){ echo esc_attr($date_time[2]); } ?>, <?php if( isset($date_time) && $date_time[0] !=''){ echo esc_attr($date_time[0]); } ?> - 1,  <?php if( isset($date_time) && $date_time[1] !=''){ echo esc_attr($date_time[1]); } ?>);
                                jQuery('.defaultCountdown').countdown({until: austDay});
                                jQuery('#year').text(austDay.getFullYear());
                            });
                        </script>
                    </div>
                </div><!--end .noo-countdown-product-->
            <?php endif; wp_reset_postdata(); ?>
            <?php
            $countdown = ob_get_contents();
            ob_end_clean();
            return $countdown;


        }
        add_shortcode('noo_product_countdown','noo_shortcode_product_countdown');

    }