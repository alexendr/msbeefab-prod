<?php
 if( !function_exists('noo_shortcode_banner') ){
     function noo_shortcode_banner($atts){
         extract(shortcode_atts(array(
             'banners'       =>  ''
         ),$atts));
         ob_start();
         wp_enqueue_script('imagesloaded');
         wp_enqueue_script('isotope');
         if( empty( $banners ) ) return false;
         $new_banners = vc_param_group_parse_atts( $banners );
         ?>
         <div class="noo-banner-wrap">
         <?php
         if(isset($new_banners) && !empty($new_banners) && is_array($new_banners)){
             foreach( $new_banners as $banner_attr ){
                 $banner_class = 'default';
                 if(isset( $banner_attr['style'] ) && !empty( $banner_attr['style'] ) ) {
                     $banner_class = $banner_attr['style'];
                 }

                 ?>
                 <div class="banner-item <?php echo esc_attr($banner_class) ?>">
                     <a href="<?php echo esc_url($banner_attr['link']) ?>">
                        <?php if( isset($banner_attr['image']) && !empty($banner_attr['image']) ): echo wp_get_attachment_image( esc_attr($banner_attr['image']),'full' );  endif; ?>
                     </a>
                     <?php if( $banner_class != 'default' ): ?>
                     <div class="banner-content">
                         <div>
                             <?php if( isset($banner_attr['title']) && !empty($banner_attr['title']) ):?>
                                <h3 <?php if( isset($banner_attr['color']) && !empty($banner_attr['color']) ){ ?>style="color : <?php echo esc_attr($banner_attr['color']); ?>"<?php } ?>><?php echo esc_html($banner_attr['title']); ?></h3>
                             <?php endif; ?>
                             <?php if( isset($banner_attr['link_text']) && !empty($banner_attr['link_text']) ): ?>
                                  <a href="<?php echo esc_url($banner_attr['link']) ?>"  <?php if( isset($banner_attr['color']) && !empty($banner_attr['color']) ): ?>style="color : <?php echo esc_attr($banner_attr['color']); ?>"<?php endif; ?>>
                                     <?php echo esc_html($banner_attr['link_text']) ?>
                                     <i class="arrow_right"></i>
                                  </a>
                             <?php endif; ?>
                         </div>
                     </div>
                     <?php endif; ?>
                 </div>
             <?php }
         }
         ?>
         </div>
         <?php
         $banner = ob_get_contents();
         ob_end_clean();
         return $banner;
     }
     add_shortcode('noo_banner','noo_shortcode_banner');
 }