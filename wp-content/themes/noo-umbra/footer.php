<?php
if( !is_page_template('page-left-menu.php') ):
        $num = ( noo_umbra_get_option( 'noo_footer_widgets', '4' ) == '' ) ? '4' : noo_umbra_get_option( 'noo_footer_widgets', '4' );
        $noo_bottom_bar_content = noo_umbra_get_option( 'noo_bottom_bar_content', '' );
        $footer_layout          = noo_umbra_get_option( 'noo_footer_layout', 'boxed' );
        $class_layout = 'noo-container';
        if( $footer_layout == 'fullwidth'){
            $class_layout = 'noo-container-fluid';
        }
    ?>
    <footer class="wrap-footer">
        <?php if ( $num != 0 ) : ?>
            <!--Start footer widget-->
            <div class="colophon wigetized">
                <div class="<?php echo esc_attr($class_layout); ?>">
                    <div class="noo-row">
                        <?php

                        $i = 0; while ( $i < $num ) : $i ++;
                            switch ( $num ) {
                                case 4 : $class = 'noo-md-3 noo-sm-6 footer-item';  break;
                                case 3 :
                                    $class = 'noo-md-4 noo-sm-4 footer-item';
                                    break;
                                case 2 : $class = 'noo-md-6 noo-sm-12 footer-item';  break;
                                case 1 : $class = 'noo-md-12'; break;
                            }
                            echo '<div class="' . esc_attr($class) . '">';
                            dynamic_sidebar( 'noo-footer-' . esc_attr($i) );
                            echo '</div>';
                        endwhile;

                        ?>
                    </div>
                </div>
            </div>
            <!--End footer widget-->
        <?php endif; ?>

        <?php if ( !empty( $noo_bottom_bar_content ) ) : ?>
            <div class="noo-bottom-bar-content">
               <div class="<?php echo esc_attr($class_layout); ?>">
                   <?php echo noo_umbra_html_content_filter($noo_bottom_bar_content); ?>
               </div>
            </div>
        <?php endif; ?>
    </footer>
<?php endif; ?>
</div>
<!--End .site -->

<?php wp_footer(); ?>

</body>
</html>
