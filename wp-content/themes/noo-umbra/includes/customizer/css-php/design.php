<?php
// Variables

$primary_color                  =   noo_umbra_get_option( 'noo_site_primary_color', noo_umbra_get_theme_default( 'primary_color' ) );
$secondary_color                =   noo_umbra_get_option( 'noo_site_secondary_color', noo_umbra_get_theme_default( 'secondary_color' ) );

$noo_site_link_color_lighten_10 =   noo_umbra_css_lighten( $primary_color, '10%' );
$noo_site_link_color_darken_5   =   noo_umbra_css_darken( $primary_color, '5%' );
$noo_site_link_color_darken_15  =   noo_umbra_css_darken( $primary_color, '15%' );
$noo_site_link_color_fade_50    =   noo_umbra_css_fade( $primary_color, '50%' );


$secondary_color_lighten_10 =   noo_umbra_css_lighten( $primary_color, '10%' );
$secondary_color_darken_5   =   noo_umbra_css_darken( $primary_color, '5%' );
$secondary_color_darken_15  =   noo_umbra_css_darken( $primary_color, '15%' );
$secondary_color_fade_50    =   noo_umbra_css_fade( $primary_color, '50%' );
$secondary_color_fade_90    =   noo_umbra_css_fade( $primary_color, '90%' );

$noo_footer_bk                  =   noo_umbra_get_option( 'noo_footer_background_image','' );

if( $primary_color != '#d2a637' || $secondary_color != '#4666a3' ) {

?>
h1 a:hover, h2 a:hover, h3 a:hover, h4 a:hover, h5 a:hover, h6 a:hover,
.h1 a:hover, .h2 a:hover, .h3 a:hover, .h4 a:hover, .h5 a:hover, .h6 a:hover,
a:hover,
a:focus{
    color: <?php echo esc_html($primary_color); ?>;
}

input:focus, textarea:focus, keygen:focus, select:focus,
.widget_product_search form input[type='search']:focus {
    outline-color: <?php echo esc_attr( $primary_color ); ?>;
}

.pagination .page-numbers.current,
.pagination a.page-numbers:hover{
    background: <?php echo esc_html($primary_color); ?>;
    border-color: <?php echo esc_html($primary_color); ?>;
}

.hentry.sticky:after,
#comments #respond .form-submit input:hover{
    background: <?php echo esc_html($primary_color); ?>;
}

.hentry.sticky{
    border-color: <?php echo esc_html($primary_color); ?>;
}

/**
 * Heading
 */
    .noo-main-menu .navbar-nav > li > a:before,
    .navbar-meta ul > li.noo-menu-item-cart .cart-item .cart-count,
    .navbar-meta ul > li.noo-menu-item-cart .noo-minicart .minicart-footer .minicart-actions a:hover, .navbar-meta ul > li.noo-menu-item-cart .noo-minicart .minicart-footer .minicart-actions a:focus {
        background: <?php echo esc_attr( $primary_color ); ?>
    }

    .navbar-meta ul > li.noo-menu-item-cart .noo-minicart .minicart-body .cart-product-details .cart-product-price,
    .navbar-meta ul > li.noo-menu-item-cart .noo-minicart .minicart-footer .minicart-total .amount,
    .navbar-meta ul > li > a:hover,
    .noo-cart-simple .cart-item:hover i {
        color: <?php echo esc_attr( $primary_color ); ?>
    }

    .navbar-meta ul > li.noo-menu-item-cart .noo-minicart .minicart-footer .minicart-actions a:hover, .navbar-meta ul > li.noo-menu-item-cart .noo-minicart .minicart-footer .minicart-actions a:focus {
        border-color: <?php echo esc_attr( $primary_color ); ?>
    }


/*
* Footer Background
* ===============================
*/
<?php if( isset($noo_footer_bk) && !empty($noo_footer_bk) ): ?>
    .wrap-footer{
        background-image: url('<?php echo esc_url($noo_footer_bk); ?>');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    }
<?php endif; ?>


/**
 * Primary color
 */
    .noo-product-header h3 span,
    .noo-shblog-header h3 span {
        border-left: 3px solid <?php echo esc_attr( $primary_color ); ?>;
        border-right: 3px solid <?php echo esc_attr( $primary_color ); ?>;
    }

    .woocommerce div.noo-product-item .noo-product-inner .noo-loop-cart:before,
    .noo-simple-product .noo-simple-content .noo-inner .noo-loop-cart:before {
        border-left: 70px solid <?php echo esc_attr( $primary_color ); ?>;
    }

    .woocommerce div.noo-product-item .noo-product-inner span.price,
    .noo-shblog-item .noo-shblog-entry .cat a,
    .noo-shblog-item .noo-shblog-entry h3 a:hover,
    .noo-shblog-content h3 a:hover,
    .noo-simple-product-slider .noo-simple-slider-item .noo-simple-content .price,
    .noo_testimonial-wrap .noo_testimonial .owl-controls .owl-buttons div.owl-next:hover:before,
    .noo-product-filter li a.active, .noo-product-filter li a:hover,
    .noo-services.style_center .noo-service-icon i,
    .widget_nav_menu ul li a:before,
    .noo-shblog-item.style_4 .noo-shblog-entry .date, .noo-shblog-item.style_5 .noo-shblog-entry .date,
    .noo-simple-product .noo-simple-content .noo-inner:hover .yith-wcwl-add-to-wishlist .add_to_wishlist:before, .noo-simple-product .noo-simple-content .noo-inner:hover .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistexistsbrowse:before, .noo-simple-product .noo-simple-content .noo-inner:hover .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistaddedbrowse:before,
    .noo-countdown-product .price,
    .noo-shblog-meta span:hover a,
    .woocommerce .star-rating:before,
    .noo-shblog-meta span:hover i,
    .woocommerce .star-rating span,
    .page-template-page-left-menu .noo-navbar-wrapper .navbar-entry-meta .meta-icon li a:hover,
    .single-social .content-share a:hover,
    .noo-blog-inner .noo-blog-content .noo-blog-meta span:hover i,
    .noo-blog-inner .noo-blog-content .noo-blog-meta span:hover a,
    .noo-page-heading .noo-page-breadcrumb a:hover,
    .woocommerce-cart .cart-collaterals .cart_totals table td[data-title='Total'],
    .woocommerce-cart table.cart td .quantity button:hover,
    .noo-team-member figure figcaption .noo-team-social a:hover,
    .content-404 h1,
    .woocommerce div.product div.entry-summary .price,
    .woocommerce div.product div.entry-summary form.cart .quantity .noo-quantity-attr button:hover,
    .woocommerce div.product .woocommerce-tabs ul.tabs li:hover a, .woocommerce div.product .woocommerce-tabs ul.tabs li.active a,
    .woocommerce div.product .woocommerce-tabs .entry-content-wrap .entry-content #reviews #review_form form .comment-form-rating .stars,
    .woocommerce div.product .woocommerce-tabs .entry-content-wrap .entry-content #reviews #review_form form .comment-form-rating .stars a {
        color: <?php echo esc_attr( $primary_color ); ?>
    }
    .noo-product-filter li a:before,
    .noo-services .noo-service-content:before,
    .noo-shblog-item.style_5 div.noo-shblog-entry:before,
    .widget_recent_entries ul li:hover:before,
    .widget_categories ul li:hover:before,
    .noo-related-post-container > .noo-title:before,
    #comments #respond .comment-reply-title:before,
    .noocart-coupon label:before,
    .cart_totals > h2:before,
    .woocommerce-billing-fields > h3:before, .woocommerce-shipping-fields > h3:before,
    #order_review_heading:before,
    .woocommerce div.product .woocommerce-tabs ul.tabs li a:before,
    .woocommerce div.product .woocommerce-tabs .entry-content-wrap .entry-content #reviews #review_form form .form-submit input,
    .woocommerce .related .title-related:before {
        background: <?php echo esc_attr( $primary_color ); ?>
    }
    #comments #respond .form-submit input[type="submit"]:hover,
    .woocommerce div.product .woocommerce-tabs .entry-content-wrap .entry-content #reviews #review_form form .form-submit input:hover {
        background: <?php echo esc_attr( $noo_site_link_color_darken_15 ); ?>
    }
    .noo_simple_banner a span {
        border-bottom: 2px solid <?php echo esc_attr( $primary_color ); ?>; 
    }

/**
 * Secondary color
 */
    .woocommerce div.noo-product-item .noo-product-inner .noo-product-thumbnail .noo-product-meta .compare-button a:hover,
    .woocommerce div.noo-product-item .noo-product-inner .noo-product-thumbnail .noo-product-meta .yith-wcwl-add-to-wishlist .add_to_wishlist:hover,
    .woocommerce div.noo-product-item .noo-product-inner .noo-product-thumbnail .noo-product-meta .noo-quick-view:hover,
    .woocommerce div.noo-product-item .noo-product-inner .noo-product-thumbnail .noo-product-meta .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistexistsbrowse:hover,
    .woocommerce .owl-theme .owl-controls .owl-page.active span,
    .woocommerce .owl-theme .owl-controls .owl-page span:hover,
    .noo_countdown .custom_link:hover, .noo_countdown .custom_link:focus,
    .woocommerce span.onsale,
    .noo_countdown.noo_countdown_left .noo_countdown_content .noo_countdown_date .countdown-section,
    .noo-shblog-item.style_3 .noo-shblog-entry .view_link:hover,
    .noo-shblog-item.style_3 .noo-shblog-entry .view_link,
    .noo-countdown-product a.add_to_cart_button,
    .noo-sh-mailchimp.style_three form input[type='submit'],
    #comments #respond .form-submit input[type="submit"],
    .woocommerce-cart table.cart th,
    .woocommerce-cart table.cart td.actions .continue,
    .woocommerce-cart table.cart td.actions .empty-cart:hover, .woocommerce-cart table.cart td.actions .continue:hover, .woocommerce-cart table.cart td.actions .button:hover,
    .noocart-coupon .noo-apply-coupon,
    .woocommerce-cart .wc-proceed-to-checkout a.checkout-button,
    .woocommerce-checkout #payment .place-order #place_order,
    .button-404,
    .noo-custom-form-7 input[type='submit'],
    .woocommerce div.product div.entry-summary form.cart .button,
    .woocommerce div.product div.entry-summary .yith-wcwl-add-to-wishlist .add_to_wishlist:hover,
    .woocommerce div.product div.entry-summary .compare:hover,
    .quick-view-wrap .quick-content .quick-right .price,
    .woocommerce div.product div.entry-summary .noo-social-share .noo-share {
        background: <?php echo esc_attr( $secondary_color ); ?>
    }

    .noo-countdown-product a.add_to_cart_button:hover,
    .woocommerce-cart table.cart td.actions .continue:hover,
    .noocart-coupon .noo-apply-coupon:hover,
    .woocommerce-cart .wc-proceed-to-checkout a.checkout-button:hover,
    .woocommerce-checkout #payment .place-order #place_order:hover,
    .button-404:hover,
    .noo-custom-form-7 input[type='submit']:hover,
    .woocommerce div.product div.entry-summary form.cart .button:hover,
    .noo-sh-mailchimp.style_three form input[type='submit']:hover,
    .quick-view-wrap .quick-content .quick-right form.cart .button,
    .woocommerce div.product div.entry-summary .noo-social-share .noo-share:hover {
        background: <?php echo esc_attr( $secondary_color_darken_15 ); ?>
    }

    .noo_countdown.noo_countdown_left .noo_countdown_content .custom_link:hover, .noo_countdown.noo_countdown_left .noo_countdown_content .custom_link:focus,
    body .vc_tta-color-grey.vc_tta-style-classic.vc_tta-tabs .vc_tta-tabs-list .vc_tta-tab.vc_active > a,
    body .vc_toggle_size_md.vc_toggle_default .vc_toggle_title .vc_toggle_icon {
        background-color: <?php echo esc_attr( $secondary_color ); ?>
    }

    .woocommerce .owl-theme .owl-controls .owl-page.active span,
    .woocommerce .owl-theme .owl-controls .owl-page span:hover,
    .noo_countdown .custom_link:hover, .noo_countdown .custom_link:focus,
    .noo_countdown.noo_countdown_left .noo_countdown_content .custom_link:hover, .noo_countdown.noo_countdown_left .noo_countdown_content .custom_link:focus,
    .woocommerce-cart table.cart td.actions .continue,
    .woocommerce-cart table.cart td.actions .empty-cart:hover, .woocommerce-cart table.cart td.actions .continue:hover, .woocommerce-cart table.cart td.actions .button:hover,
    body .vc_tta-color-grey.vc_tta-style-classic.vc_tta-tabs .vc_tta-tabs-list .vc_tta-tab.vc_active > a {
        border-color: <?php echo esc_attr( $secondary_color ); ?>
    }

    .woocommerce .woocommerce-info {
        border-top-color: <?php echo esc_attr( $secondary_color ); ?>
    }
    
    .noo_countdown .noo_countdown_date .countdown-section,
    .woocommerce .three div.noo-product-item .noo-product-inner.noo-product-inner2 .noo-loop-cart a:before,
    .woocommerce .woocommerce-info:before {
        color: <?php echo esc_attr( $secondary_color ); ?>;
    }
    .noo_countdown.noo_countdown_left .noo_countdown_content .noo_countdown_date .countdown-section{
        -webkit-box-shadow: 0 5px 0 0 <?php echo esc_attr( noo_umbra_css_fade($secondary_color, '30%') ); ?>;
        box-shadow: 0 5px 0 0 <?php echo esc_attr( noo_umbra_css_fade($secondary_color, '30%') ); ?>;
    }

/**
 * Widget
 */
    /**
     * Primary color
     */
        .widget-title:before,
        .woocommerce .widget_price_filter .ui-slider .ui-slider-range,
        .woocommerce .widget_price_filter .price_slider_amount .button,
        .woocommerce .widget_product_tag_cloud .tagcloud a:hover {
            background: <?php echo esc_attr( $primary_color ); ?>;
        }
        .woocommerce .widget_price_filter .price_slider_amount .button:hover {
            background: <?php echo esc_attr( $noo_site_link_color_darken_15 ); ?>;
        }
        .widget_nav_menu ul li a:hover,
        .text-primary,
        .woocommerce .widget_products .product_list_widget li {
            color: <?php echo esc_attr( $primary_color ); ?>;
        }

        .woocommerce .widget_price_filter .ui-slider .ui-state-default {
            border: 2px solid <?php echo esc_attr( $primary_color ); ?>;
        }

        .woocommerce .widget_product_tag_cloud .tagcloud a:hover {
            border-color: <?php echo esc_attr( $primary_color ); ?>;
        }
<?php };