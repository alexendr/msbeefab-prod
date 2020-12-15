(function(jQuery){
    "use strict";

    function NooScrollTop(){

        // @var
        var _top          = jQuery(window).scrollTop();
        var $_height      = jQuery('.fixed_top').height();


        //==============================
        // jQuery scroll for template revolution
        //==============================
        var _height_slider    = jQuery('.rev_slider_wrapper').height();

        if( _top >= _height_slider ){
            jQuery('.page-template-page-revolution .noo-header').addClass('eff');
        }else{
            jQuery('.page-template-page-revolution .noo-header').removeClass('eff');
        }

        //------- End template revolution

        //==============================
        // jQuery scroll for header 1
        //==============================

        if( _top > $_height   ){
            if( !jQuery('.fixed_top').hasClass('eff') ){
                jQuery('.fixed_top').addClass('eff').animate({
                    'marginTop':0
                });
            }
        }
        if(jQuery('.fixed_top').hasClass('header-2') && _top < 177 && jQuery('.fixed_top').hasClass('eff')){
            jQuery('.fixed_top').removeClass('eff').css('opacity','0.5').animate({
                'opacity':1
            });
        }

        if( _top == 0 && !jQuery('.fixed_top').hasClass('header-2') ){
            jQuery('.fixed_top').removeClass('eff');
        }



    }

    //==============================
    // jQuery hover menu
    //==============================
    function hover_menu_ipad(){
        if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ){
            if ( jQuery( window ).width() > 991 ) {

            jQuery('.menu-item-has-children > a').on("touchstart", function (e) {
                    "use strict"; //satisfy the code inspectors
                    var link = jQuery(this); //preselect the link
                    if (link.hasClass('hover')) {
                        return true;
                    } else {
                        jQuery('.menu-item-has-children > a').removeClass("hover");
                        link.addClass("hover");
                        e.preventDefault();
                        return false; //extra, and to make sure the function has consistent return points
                    }
                });

            }
        }
    }

    //==============================
    // jQuery hover item on device
    //==============================
    function noo_hover_on_device(){
        if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ){

            jQuery('.hover-device').on("touchstart", function (e) {
                var link = jQuery(this); //preselect the link
                if (link.hasClass('hover')) {
                    return true;
                } else {
                    jQuery('.hover-device').removeClass("hover");
                    link.addClass("hover");
                    e.preventDefault();
                    return false; //extra, and to make sure the function has consistent return points
                }
            });

        }
    }

    //==============================
    // jQuery for product
    //==============================
    function noo_shortcode_product_slider(){

        if( jQuery('div').hasClass("noo-product-slider")){
            jQuery(".noo-product-slider").each(function(){
                jQuery(this).owlCarousel({
                    navigation : false,
                    slideSpeed : 600,
                    pagination: true,
                    paginationSpeed : 400,
                    autoHeight : true,
                    addClassActive: true,
                    autoPlay: false,
                    singleItem : true

                });
            });
        }
    }


    // ==============
    // Blog Masonry
    function noo_blog_masonry(){

        var $container = jQuery('.noo-blog-masonry');
        $container.imagesLoaded(function(){
            $container.isotope({
                itemSelector : '.noo-blog-masonry-item',
                transitionDuration : '0.8s',
                masonry : {
                    'gutter' : 0
                }
            });

        });

    }

    // ==============
    // Banner Masonry
    function noo_banner_masonry(){
        jQuery('.noo-banner-wrap').each(function () {
            var $this = jQuery(this);
            $this.imagesLoaded(function(){
                $this.isotope({
                    itemSelector : '.banner-item',
                    transitionDuration : '0.8s',
                    masonry : {
                        'gutter' : 0
                    }
                });

            });
        })
    }



    //==============================
    // jQuery for  responsive header shop
    //==============================
    function noo_responsive_header_shop() {

        var $data       = jQuery('<div class="noo_responsive_header_shop"></div>').appendTo('.noo-catalog');
        var $ordering   = jQuery('.woocommerce-ordering').clone() ;
        var $catalog    =  jQuery('.noo-shop-filter').clone();
        jQuery($ordering).appendTo($data);
        jQuery($catalog).appendTo($data);


        jQuery('.shop-meta-icon').click(function () {
            if( jQuery('.noo_responsive_header_shop').hasClass('eff') ){
                jQuery('.noo_responsive_header_shop').removeClass('eff');
            }else{
                jQuery('.noo_responsive_header_shop').addClass('eff');
            }
        });

        jQuery(".woocommerce-ordering").on("change","select.orderby",function(){jQuery(this).closest("form").submit()});
        jQuery("body").on("change","select.noo-woo-filter",function(){jQuery(this).closest("form").submit()});

    }


    jQuery(document).ready(function(){

        //search form
        jQuery('.noo-search').click(function(){
            jQuery('.search-header').fadeIn(1).addClass('search-header-eff');
            jQuery('.search-header').find('input[type="search"]')
                .val('')
                .attr('placeholder', '')
                .select();
            return false;
        });
        jQuery('.remove-form').click(function(){
            jQuery('.search-header').fadeOut(1).removeClass('search-header-eff');
        });

        // add html brefore header
        if( jQuery('.noo-header').hasClass('fixed_top') && !jQuery('.noo-header').hasClass('header-transparent') ){

            var $html_fixed    = '<div class="height-fixed"></div>';
            var $height_header = jQuery('.fixed_top').height();
            jQuery('.fixed_top').before($html_fixed);
            jQuery('.height-fixed').height($height_header);

        }

        // call function noo_responsive_header_shop
        noo_responsive_header_shop();

        // call function hover ipad
        hover_menu_ipad();

        // call function hover device
        noo_hover_on_device();

        NooScrollTop();


        jQuery('.noo-product-filter li:first-child a').addClass('active');

        jQuery('.noo-product-filter li a').on('click',function(event){
            event.preventDefault();
            var $parent = jQuery(this).closest('.noo-product-filter');
            $parent.find('a').removeClass('active');
            jQuery(this).addClass('active');

            var $parent_wrap = jQuery(this).closest('.noo-shortcode-product-wrap');
            var $height = $parent_wrap.find('.noo-sh-product-grid').height();
            $parent_wrap.find('.noo-sh-product-html').css('min-height',$height+'px');
            $parent_wrap.find('.noo-sh-product-html').find('.noo-product-item').css({opacity: 0.3});
            var $cat_id = jQuery(this).data('id');
            var $limit  = jQuery(this).data('limit');
            var $style  = jQuery(this).data('style');
            var $config = jQuery.parseJSON(jQuery(this).attr('data-config'));

            $parent_wrap.find('.spinner').addClass('eff');
            jQuery.ajax({
                url: noo_new.ajax_url,
                type: 'POST',
                data: ({
                    action      : 'noo_umbra_product_ajax',
                    catid       : $config.id,
                    limit       : $config.per_page,
                    style       : $config.style,
                    orderby     : $config.orderby,
                    order       : $config.order,
                    masonry     : $config.masonry
                }),
                success: function(data){
                    if(data){
                        $parent_wrap.find('.spinner').removeClass('eff');
                        $parent_wrap.find('.noo-sh-product-html').html(data).find('.noo-product-item').css('opacity',0.6).animate({opacity: 1},500,function(){
                            $parent_wrap.find('.noo-sh-product-html').css('min-height','auto');
                        });

                        noo_shortcode_product_slider();

                    }
                }
            })

        });

        // jQuery product slider
        noo_shortcode_product_slider();


        // jQuery banner

        if( jQuery('.noo-banner-wrap').length > 0 ) {
            noo_banner_masonry();
        }

        // jQuery blog
        var $blog_list = jQuery('.noo-blog-masonry');
        if( $blog_list.length > 0 ){
            noo_blog_masonry();
            jQuery(function($){
                $blog_list.infinitescroll({
                        navSelector  : '.pagination a.page-numbers',    // selector for the paged navigation
                        nextSelector : '.pagination a.next',            // selector for the NEXT link (to page 2)
                        itemSelector : '.noo-blog-masonry-item',           // selector for all items you'll retrieve
                        loading: {
                            msgText:'',
                            finishedMsg: '',
                            img: noo_new.image_loading,
                            selector:'.noo-load-image'
                        }

                    },
                    // call Isotope as a callback
                    function( newElements ) {
                        $blog_list.isotope( 'appended', newElements);
                        noo_blog_masonry();
                        $('.noo-loadmore-ajax').show();
                    }
                );


                if( $('.blog-pagination .noo-loadmore-ajax').length > 0 ){
                    $(window).unbind('.infscr');
                    $('.noo-loadmore-ajax').on('click',function(){
                        $('.noo-loadmore-ajax').hide();
                        $blog_list.infinitescroll('retrieve');
                        return false;
                    });
                }
            });
        }

        //===================

        //quick view
        jQuery('.noo-quick-view').live('click',function(event){
            event.preventDefault();
            var p_id  = jQuery(this).data('id');
            var $html = '';
            $html += '<div class="quick-view-wrap">';
            $html += '<p class="quick-loading">loading...</p>';
            $html += '<div class="quick-content woocommerce">';
            $html +=  '<button title="Close (Esc)" class="quickview-close"></button>';
            $html += '</div>';
            $html += '</div>';
            jQuery('body').append($html);

            jQuery.ajax({
                type: 'post',
                url : noo_new.ajax_url,
                data: ({
                    action: 'noo_umbra_product_quick_view',
                    p_id: p_id
                }),
                success: function(data){
                    if(data){
                        jQuery('.quick-loading').remove();
                        jQuery('.quick-content').append(data).addClass('eff');

                    }

                }
            })

        });

        jQuery(document).keyup(function (e) {

            if( e.keyCode == 27 ){
                jQuery('.quick-content').removeClass('eff');
                var myvar ;
                myvar = setTimeout(function(){
                    jQuery('.quick-view-wrap').remove();
                }, 400);
            }
        });

        jQuery('body').on('click','.quickview-close',function(){
            jQuery('.quick-content').removeClass('eff');
            var myvar ;
            myvar = setTimeout(function(){
                jQuery('.quick-view-wrap').remove();
            }, 400);
        });
    });

    jQuery(window).scroll(function(){

        NooScrollTop();
    });

    jQuery(document).on('noo-layout-changed',function () {
        noo_banner_masonry();
    })

    jQuery('body').bind('added_to_cart', function(event, fragments, cart_hash) {

        if( nooL10n.show_added_popup == 'yes' ) {
            var html = [
                '<div class="added-to-cart">',
                '<p>' + nooL10n.added_to_cart + '</p>',
                '<a href="#" class="btn close-popup">' + nooL10n.continue_shopping + '</a>',
                '<a href="' + nooL10n.cart_url + '" class="btn view-cart">' + nooL10n.view_cart + '</a>',
                '</div>',
            ].join("");

            jQuery.magnificPopup.open({
                items: {
                    src: '<div class="white-popup add-to-cart-popup popup-added_to_cart">' + html + '</div>',
                    type: 'inline'
                }
            });

            jQuery('.white-popup').on('click', '.close-popup', function(e) {
                e.preventDefault();
                jQuery.magnificPopup.close();
            });
        }

    });


})(jQuery);
