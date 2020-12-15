<?php


if( !function_exists('noo_shortcode_introduce') ){

    function noo_shortcode_introduce($atts,$content = null){
        extract(shortcode_atts(array(
            'image_id'      =>  '',
            'title'         =>  ''
        ),$atts));
        ob_start();
        ?>
            <div class="noo-introduce">
                <div class="noo-introduce-icon">
                    <?php if( isset($image_id) && !empty($image_id)): echo wp_get_attachment_image($image_id,'full'); endif; ?>
                </div>
                <div class="noo-introduce-content">
                    <h3><?php echo esc_html($title); ?></h3>
                    <?php echo wpb_js_remove_wpautop( $content , true ); ?>
                </div>
            </div>
        <?php
        $introduce = ob_get_contents();
        ob_end_clean();
        return $introduce;
    }
    add_shortcode('noo_introduce','noo_shortcode_introduce');

}