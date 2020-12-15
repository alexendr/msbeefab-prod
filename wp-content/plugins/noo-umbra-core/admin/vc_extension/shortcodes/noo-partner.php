<?php
    if( !function_exists('noo_shortcode_partner')){
        function noo_shortcode_partner($atts){
            extract(shortcode_atts(array(
                'style_border'      =>  'noo_border',
                'limit_oneslider'   =>  6,
                'images'            =>  '',
                'custom_link'       =>  '',
                'autoplay'          =>  'true',
                'target'            =>  'same'
            ), $atts));
            ob_start();
            wp_enqueue_script('carousel');
            if( isset($custom_link) ):
                $link = explode(',',$custom_link);
            endif;
            if( isset($images) ):
                $images_id = explode(',',$images);
            endif;

            if( isset($images_id) && !empty($images_id) ):
            ?>
            <div class="noo_partner-wrap <?php echo esc_attr($style_border); ?>">
                <ul class="noo_partner">
                    <?php
                    foreach($images_id as $i=>$id): ?>
                        <li class="noo_partner_item">
                            <?php if( ($i <= count($link) - 1) && isset($link) && count($link) > 1 ): ?>
                                <a <?php if( $target == 'new' ){ ?> target="_blank" <?php } ?> href="<?php echo esc_url($link[$i]); ?>">
                                    <?php echo wp_get_attachment_image(esc_attr($id));
                                            echo wp_get_attachment_image(esc_attr($id)); ?>
                                </a>
                            <?php else: ?>
                                <?php echo wp_get_attachment_image(esc_attr($id)); ?>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <script>
                jQuery(document).ready(function(){
                    jQuery('.noo_partner').each(function(){
                        jQuery(this).owlCarousel({
                            items : <?php echo esc_attr($limit_oneslider); ?>,
                            itemsDesktop : [1199,4],
                            itemsDesktopSmall : [979,3],
                            itemsTablet: [767, 2],
                            itemsMobile: [479, 1],
                            slideSpeed:500,
                            paginationSpeed:1000,
                            rewindSpeed:1000,
                            autoHeight: false,
                            addClassActive: true,
                            autoPlay: <?php echo esc_attr($autoplay) ?>,
                            loop:true,
                            pagination: false
                        });
                    });
                });
            </script>

            <?php
            endif;

            $clients = ob_get_contents();
            ob_end_clean();
            return $clients;
        }
        add_shortcode('noo_partner','noo_shortcode_partner');
    }
?>