<?php
// Use Custom Font
$noo_typo_use_custom_fonts       = noo_umbra_get_option( 'noo_typo_use_custom_fonts', false );
$noo_typo_use_custom_fonts_color = noo_umbra_get_option( 'noo_typo_use_custom_fonts_color', false );

if( $noo_typo_use_custom_fonts ) :
    $noo_typo_headings_uppercase  = noo_umbra_get_option( 'noo_typo_headings_uppercase', false );
    $noo_typo_text_transform      = !empty( $noo_typo_headings_uppercase ) ? 'uppercase' : 'none';
    $noo_typo_headings_font       = noo_umbra_get_option( 'noo_typo_headings_font', noo_umbra_get_theme_default( 'headings_font_family' ) );
    $noo_typo_headings_font_color =  noo_umbra_get_option( 'noo_typo_headings_font_color', noo_umbra_get_theme_default( 'headings_color' ) );
    
    $noo_typo_body_font           = noo_umbra_get_option( 'noo_typo_body_font', noo_umbra_get_theme_default( 'font_family' ) );
    $noo_typo_body_font_color     = noo_umbra_get_option( 'noo_typo_body_font_color', noo_umbra_get_theme_default( 'text_color' ) );
    $noo_typo_body_font_size      = noo_umbra_get_option( 'noo_typo_body_font_size', noo_umbra_get_theme_default( 'font_size' ) );
?>
    /**
     * Body style
     */
    body {
        font-family: "<?php echo esc_html( $noo_typo_body_font ); ?>", sans-serif !important;
        font-size:    <?php echo esc_html( $noo_typo_body_font_size ) . 'px'; ?> !important;
    }

    /**
     * Headings
     */
    h1, h2, h3, h4, h5, h6,
    h1 a, h2 a, h3 a, h4 a, h5 a, h6 a,
    .h1 a, .h2 a, .h3 a, .h4 a, .h5 a, .h6 a,
    .h1, .h2, .h3, .h4, .h5, .h6 {
        font-family:    "<?php echo esc_html( $noo_typo_headings_font ); ?>", sans-serif !important;
        <?php if ( !empty( $noo_typo_use_custom_fonts_color ) ) : ?>
            color:          <?php echo esc_html( $noo_typo_headings_font_color ); ?> !important;
        <?php endif; ?>
        text-transform: <?php echo esc_html( $noo_typo_text_transform ); ?> !important;
    }

    
<?php endif; ?>