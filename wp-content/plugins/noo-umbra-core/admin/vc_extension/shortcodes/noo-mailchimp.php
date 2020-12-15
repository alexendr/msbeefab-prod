<?php

    if( !function_exists('noo_shortcode_mailchimp') ){
        function noo_shortcode_mailchimp($atts){
            extract(shortcode_atts(array(
                'style' =>  'style_one',
                'title' =>  '',
                'desc'  =>  ''
            ),$atts));
            ob_start();
            echo '<div class="noo-sh-mailchimp '.esc_attr($style).'">';
             echo '<div class="noo-mailchimp-header">';
             if( isset($title) && !empty($title) ): ?><h3 class="noo-mail-title"><?php echo esc_html($title); ?></h3><?php endif;
             if( isset($desc) && !empty($desc) ): ?><p class="noo-mail-desc"><?php echo esc_html($desc); ?></p><?php endif;
            echo '</div>';
             if( function_exists('mc4wp_show_form') ){
                mc4wp_show_form();
             }
            echo '</div>';
            $noo_mailch = ob_get_contents();
            ob_end_clean();
            return $noo_mailch;

        }
        add_shortcode('noo_mailchimp','noo_shortcode_mailchimp');
    }

?>