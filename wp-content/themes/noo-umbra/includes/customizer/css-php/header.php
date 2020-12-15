<?php

// navigation
$noo_header_custom_nav_font   =     noo_umbra_get_option( 'noo_header_custom_nav_font', false );
$noo_header_nav_font          =     noo_umbra_get_option( 'noo_header_nav_font', '' );
$noo_header_nav_font_weight   =     noo_umbra_get_option( 'noo_header_nav_font_weight', 'bold' );
$noo_header_nav_color         =     noo_umbra_get_option( 'noo_header_nav_link_color', '#000' );
$noo_header_nav_hover_color   =     noo_umbra_get_option( 'noo_header_nav_link_hover_color');
$noo_header_nav_font_size     =     noo_umbra_get_option( 'noo_header_nav_font_size', 14 );
$noo_header_nav_uppercase     =     noo_umbra_get_option( 'noo_header_nav_uppercase', false ) ? 'uppercase': 'normal';

// logo text
$noo_header_use_image_logo    =     noo_umbra_get_option( 'noo_header_use_image_logo', false );
$noo_header_logo_font         =     noo_umbra_get_option( 'noo_header_logo_font', noo_umbra_get_theme_default( 'logo_font_family' ) );
$noo_header_logo_font_size    =     noo_umbra_get_option( 'noo_header_logo_font_size', '50' );
$noo_header_logo_font_color   =     noo_umbra_get_option( 'noo_header_logo_font_color', noo_umbra_get_theme_default( 'logo_color' ) );
$noo_header_logo_font_style   =     noo_umbra_get_option( 'noo_header_logo_font_style', 'normal' );
$noo_header_logo_font_weight  =     noo_umbra_get_option( 'noo_header_logo_font_weight', '700' );
$noo_header_logo_font_subset  =     noo_umbra_get_option( 'noo_header_logo_font_subset', 'latin' );
$noo_header_logo_uppercase    =     noo_umbra_get_option( 'noo_header_logo_uppercase', false ) ? 'uppercase': 'normal';

// header attr
$noo_header_nav_height        =     noo_umbra_get_option( 'noo_header_nav_height', '70' );
$noo_header_nav_link_spacing  =     noo_umbra_get_option( 'noo_header_nav_link_spacing', 20);

$noo_header_logo_image_height =     noo_umbra_get_option( 'noo_header_logo_image_height', '40' );

?>


/*
* Typography for menu
* ===============================
*/

.noo-main-menu .navbar-nav > li > .sub-menu li a,
header .noo-main-menu .navbar-nav li > a{
    font-size:       <?php echo esc_attr( $noo_header_nav_font_size ) . 'px'; ?>;
    <?php if( $noo_header_custom_nav_font ): ?>
        <?php if($noo_header_nav_font != ''): ?> font-family: "<?php echo esc_html($noo_header_nav_font); ?>", sans-serif; <?php endif; ?>
        font-weight:  <?php echo esc_html($noo_header_nav_font_weight); ?>;
        color:        <?php echo esc_attr( $noo_header_nav_color ) ; ?>;
    <?php endif; ?>
}
header .noo-main-menu .navbar-nav li > a{
    text-transform:  <?php echo esc_attr( $noo_header_nav_uppercase ) ; ?>;
}
header .noo-main-menu .navbar-nav > li{
    margin-left:    <?php echo esc_attr( $noo_header_nav_link_spacing ).'px'; ?>;
    margin-right:   <?php echo esc_attr( $noo_header_nav_link_spacing ).'px'; ?>;
}
<?php if( $noo_header_custom_nav_font && $noo_header_nav_hover_color != '' ): ?>
    header .noo-main-menu .navbar-nav li > a:hover,
    header .noo-main-menu .navbar-nav li > a:focus,
    header .noo-main-menu .navbar-nav li > a:active{
        color: <?php echo esc_attr( $noo_header_nav_hover_color ) ; ?>;
    }
    header .noo-main-menu .navbar-nav li > .sub-menu li a:hover{
        color: <?php echo esc_attr( $noo_header_nav_hover_color ) ; ?>;
    }
<?php endif; ?>


/*
* Typography for Logo text
* ===============================
*/

header .navbar-brand{ 
    <?php if( $noo_header_use_image_logo == false): ?>
        font-family:    <?php echo esc_attr( $noo_header_logo_font ); ?>, sans-serif;
        font-size:      <?php echo esc_attr( $noo_header_logo_font_size ) .'px'; ?>;
        color:          <?php echo esc_attr( $noo_header_logo_font_color ); ?>;
        font-style:     <?php echo esc_attr( $noo_header_logo_font_style ); ?>;
        text-transform: <?php echo esc_attr( $noo_header_logo_uppercase ); ?>;
        font-weight:    <?php echo esc_attr( $noo_header_logo_font_weight ); ?>;
    <?php endif; ?>
}

header .navbar-logo .custom-logo{
    height: <?php echo esc_attr( $noo_header_logo_image_height ). 'px'; ?>;
    width: auto;
    max-width: initial;
}