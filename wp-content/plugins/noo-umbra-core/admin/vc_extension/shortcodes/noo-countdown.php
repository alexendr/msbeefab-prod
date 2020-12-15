<?php

    if( !function_exists('noo_shortcode_countdown') ){

        function noo_shortcode_countdown($atts){
            extract(shortcode_atts(array(
                'style'             =>      'countdown_center',
                'background_wrap'   =>      '',
                'title_wrap'        =>      '',
                'desc_wrap'         =>      '',
                'background'        =>      '',
                'date'              =>      '',
                'title'             =>      '',
                'description'       =>      '',
                'custom_link'       =>      '',
            ),$atts));

            wp_enqueue_script('countdown-plugin');
            wp_enqueue_script('countdown-js');

            ob_start();
            $random = wp_rand(0,10000);
            $date_time = '';
            if( isset($date) && $date != '' ){
                $date_time = explode('/',$date);
            }
            if( isset($background) && !empty($background) ):
                $background_url = wp_get_attachment_image_src($background,'full');
            endif;

            if( isset($background_wrap) && !empty($background_wrap) ):
                $background_urlwrap = wp_get_attachment_image_src($background_wrap,'full');
            endif;
            $class_style = '';
            if( $style == 'countdown_left' ):
                $class_style = 'noo_countdown_left';
            endif;
            ?>
            <?php if( $style == 'countdown_left' ): ?>
                <div class="noo_countdow_background" <?php if( isset($background_urlwrap) && !empty($background_urlwrap) ): ?>style="background-image: url('<?php echo esc_url($background_urlwrap[0]) ?>')"<?php endif; ?>>
                    <?php if( isset($title) && !empty($title) ): ?><h2><?php echo esc_html($title); ?></h2><?php endif; ?>
                    <?php if( isset($description) && !empty($description) ): ?><p><?php echo noo_umbra_html_content_filter($description); ?></p><?php endif; ?>
                </div>
            <?php endif; ?>
            <div class="noo_countdown <?php echo esc_attr($class_style); ?>" <?php if( isset($background_url) && !empty($background_url) ): ?>style="background-image: url('<?php echo esc_url($background_url[0]) ?>')"<?php endif; ?>>
                <div class="noo_countdown_content">
                    <?php if( $style == 'countdown_left' ): ?>
                        <div class="noo_countdown_date noo_date_<?php echo esc_attr($random); ?>"></div>
                    <?php endif; ?>
                    <?php if( isset($title) && !empty($title) ): ?><h2><?php echo esc_html($title); ?></h2><?php endif; ?>
                    <?php if( isset($description) && !empty($description) ): ?><p><?php echo noo_umbra_html_content_filter($description); ?></p><?php endif; ?>
                    <?php if( $style == 'countdown_center' ): ?>
                        <div class="noo_countdown_date noo_date_<?php echo esc_attr($random); ?>"></div>
                    <?php endif; ?>
                    <?php
                    if( isset( $custom_link ) && !empty( $custom_link )){
                        $link = vc_build_link( $custom_link );
                        ?>
                        <a class="custom_link" href="<?php echo esc_url($link['url']) ?>" <?php if( isset($link['target']) && !empty( $link['target'] ) ): ?>target="_blank" <?php endif; ?>><?php echo esc_html($link['title']) ?></a>
                    <?php
                    }
                    ?>
                </div>
            </div>
            <script>
                jQuery(document).ready(function(){
                    austDay = new Date(<?php if( isset($date_time) && $date_time[2] !=''){ echo esc_attr($date_time[2]); } ?>, <?php if( isset($date_time) && $date_time[0] !=''){ echo esc_attr($date_time[0]); } ?> - 1,  <?php if( isset($date_time) && $date_time[1] !=''){ echo esc_attr($date_time[1]); } ?>);
                    jQuery('.noo_date_<?php echo esc_attr($random); ?>').countdown({labels: ['<?php echo esc_html__('Years','noo-umbra-core') ?>', '<?php echo esc_html__('Months','noo-umbra-core') ?>', '<?php echo esc_html__('Weeks','noo-umbra-core') ?>', '<?php echo esc_html__('Days','noo-umbra-core') ?>', '<?php echo esc_html__('Hours','noo-umbra-core') ?>', '<?php echo esc_html__('Minutes','noo-umbra-core') ?>', '<?php echo esc_html__('Seconds','noo-umbra-core') ?>'], until: austDay});
                });
            </script>


            <?php
            $c_content = ob_get_contents();
            ob_end_clean();
            return $c_content;
        }
        add_shortcode('noo_countdown','noo_shortcode_countdown');

    }

?>