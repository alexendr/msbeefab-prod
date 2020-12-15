(function($, document) {

    var noo_woo = {

        setup_var: function() {

            noo_woo.els  = {};
            noo_woo.vars = {};
            noo_woo.tpl  = {};

            noo_woo.els.images                       = $('.noo-woo-images');
            noo_woo.els.images_wrap                  = $('.noo-woo-images-wrap');
            noo_woo.els.thumbnails                   = $('.noo-woo-thumbnails');
            noo_woo.els.thumbnails_wrap              = $('.noo-woo-thumbnails-wrap');
            noo_woo.els.variations_form              = $('form.variations_form');
            noo_woo.els.all_images_wrap              = $('.noo-woo-all-images-wrap');
            noo_woo.els.variation_id_field           = noo_woo.els.variations_form.find('input[name=variation_id]');
            noo_woo.els.gallery                      = false;

            noo_woo.vars.is_dragging_image_slide     = false;
            noo_woo.vars.images_slider_data          = false;
            noo_woo.vars.thumbnails_slider_data      = false;
            noo_woo.vars.loading_class               = "noo-woo-loading";
            noo_woo.vars.reset_class                 = "noo-woo-reset";
            noo_woo.vars.thumbnails_active_class     = "noo-woo-thumbnails__slide--active";
            noo_woo.vars.thumbnails_count            = $('body').hasClass('page-fullwidth') ? 5 : 4;
            noo_woo.vars.images_active_class         = "noo-woo-images__slide--active";
            noo_woo.vars.is_touch_device             = !!('ontouchstart' in window);
            noo_woo.vars.variations_json             = noo_woo.els.variations_form.attr('data-product_variations');
            noo_woo.vars.variations                  = noo_woo.vars.variations_json ? $.parseJSON( noo_woo.vars.variations_json ) : false;
            noo_woo.vars.product_id                  = noo_woo.els.variations_form.data('product_id');
            noo_woo.vars.show_variation_trigger      = "noo_woo_show_variation";
            noo_woo.vars.loading_variation_trigger   = "noo_woo_loading_variation";
            noo_woo.vars.default_images              = $.parseJSON( noo_woo.els.all_images_wrap.attr('data-default') );

            noo_woo.tpl.temp_images_container        = '<div class="noo-woo-temp"><div class="noo-woo-temp__images"/><div class="noo-woo-icon noo-woo-temp__thumbnails"/></div>';
            noo_woo.tpl.image_slide                  = '<div class="noo-woo-images__slide {{slide_class}}"><img class="noo-woo-images__image" src="{{image_src}}" data-srcset="{{image_src}}{{image_src_retina}}" data-large-image="{{large_image_src}}" data-large-image-width="{{large_image_width}}" data-large-image-height="{{large_image_height}}" width="{{image_width}}" height="{{image_height}}" title="{{title}}" alt="{{alt}}"></div>';
            noo_woo.tpl.thumbnail_slide              = '<div class="noo-woo-thumbnails__slide {{slide_class}}" data-index="{{index}}"><img class="noo-woo-thumbnails__image" src="{{image_src}}" data-srcset="{{image_src}}{{image_src_retina}}" title="{{title}}" alt="{{alt}}" width="{{image_width}}" height="{{image_height}}"></div>';
            noo_woo.tpl.retina_img_src               = ', {{image_src}} 2x';

        },

        lazy_load_images: function() {

            var $images = $('img');

            if( $images.length > 0 ) {

                $images.each(function( index, el ){
                    var $image = $(el),
                        data_src = $image.attr('data-noo-woo-src');

                    if( typeof data_src !== "undefined" ) {

                        var $image_clone = $image.clone();

                        $image_clone.attr('src', data_src).css({paddingTop: "", height: ""});
                        $image.replaceWith( $image_clone );

                    }
                });

            }

        },

        images_slider_args: function() {

            return {
                mode: 'horizontal', //' horizontal', 'vertical', 'fade'
                speed: 250,
                controls: ( noo_woo.els.images.children().length > 1 ) ? true : false,
                infiniteLoop: ( noo_woo.els.images.children().length > 1 ) ? true : false,
                adaptiveHeight: true,
                pager: false,
                prevText: '<i class="icon ion-ios-arrow-back"></i>',
                nextText: '<i class="icon ion-ios-arrow-forward"></i>',
                onSliderLoad: function(){

                    noo_woo.setup_srcset();

                    if( this.getSlideCount() <= 1 ) {
                        noo_woo.els.images_wrap.find('.bx-controls').hide();
                    }
                },
                onSlideBefore: function($slide_element, old_index, new_index){

                    noo_woo.go_to_thumbnail( new_index );

                    // add active class
                    $('.'+noo_woo.vars.images_active_class).removeClass( noo_woo.vars.images_active_class );
                    $slide_element.addClass( noo_woo.vars.images_active_class );

                }
            };

        },

        thumbnails_slider_args: function() {

            return {
                mode: "vertical",// "vertical",
                infiniteLoop: false,
                speed: 250,
                minSlides: parseInt(noo_woo.vars.thumbnails_count),
                maxSlides: parseInt(noo_woo.vars.thumbnails_count),
                slideWidth: 800,
                moveSlides: 1,
                pager: false,
                controls: false,
                slideMargin: 20,
                onSliderLoad: function() {

                    noo_woo.setup_srcset();

                    noo_woo.els.thumbnails_wrap.css({ opacity:1, height: 'auto' });
                    noo_woo.set_thumbnail_controls_visibility( this );

                },
                onSlideAfter: function($slide_element, old_index, new_index) {

                    noo_woo.set_thumbnail_controls_visibility( this );

                }
            };

        },

        setup_sliders: function() {

            // setup main images slider

            noo_woo.els.images.imagesLoaded( function() {

                noo_woo.vars.images_slider_data = noo_woo.els.images.bxSlider( noo_woo.images_slider_args() );
                noo_woo.lazy_load_images();

            });

            // setup thumbnails slider

            if( noo_woo.els.thumbnails.length > 0  ) {

                noo_woo.els.thumbnails.imagesLoaded( function() {

                    noo_woo.vars.thumbnails_slider_data = noo_woo.els.thumbnails.bxSlider( noo_woo.thumbnails_slider_args() );

                });

                // setup click thumbnail control action

                $(document).on('click', ".noo-woo-thumbnails__control", function(){

                    if( !noo_woo.els.all_images_wrap.hasClass( noo_woo.vars.loading_class ) ) {

                        var dir = $(this).attr('data-direction');

                        if( dir === "next" ) {
                            noo_woo.vars.thumbnails_slider_data.goToNextSlide();
                        } else {
                            noo_woo.vars.thumbnails_slider_data.goToPrevSlide();
                        }

                    }

                });

            }

            // setup click thumbnail action

            $(document).on('click', ".noo-woo-thumbnails__slide", function(){

                if( !noo_woo.els.all_images_wrap.hasClass( noo_woo.vars.loading_class ) ) {

                    var new_index = parseInt( $(this).attr('data-index') );

                    noo_woo.set_active_thumbnail( new_index );
                    noo_woo.vars.images_slider_data.goToSlide( new_index );

                }

            });

        },

        set_thumbnail_controls_visibility: function( thumbnails_slider_data ) {

            var last_thumbnail_index = noo_woo.get_last_thumbnail_index(),
                current_thumbnail_index = thumbnails_slider_data.getCurrentSlide(),
                $next_controls = $('.noo-woo-thumbnails__control--right, .noo-woo-thumbnails__control--down'),
                $prev_controls = $('.noo-woo-thumbnails__control--left, .noo-woo-thumbnails__control--up');

            if( thumbnails_slider_data.getSlideCount() <= 1 || thumbnails_slider_data.getSlideCount() <= parseInt(noo_woo.vars.thumbnails_count) ) {
                $('.noo-woo-thumbnails__control').hide();
                return;
            }

            if( current_thumbnail_index === 0 ) {
                $next_controls.show();
                $prev_controls.hide();
            } else if( current_thumbnail_index === last_thumbnail_index ) {
                $next_controls.hide();
                $prev_controls.show();
            } else {
                $('.noo-woo-thumbnails__control').show();
            }

        },

        set_active_thumbnail: function( index ) {

            $(".noo-woo-thumbnails__slide").removeClass( noo_woo.vars.thumbnails_active_class );
            $(".noo-woo-thumbnails__slide[data-index="+index+"]").addClass( noo_woo.vars.thumbnails_active_class );

        },

        go_to_thumbnail: function( index ) {

            if( noo_woo.vars.thumbnails_slider_data ) {
                var thumbnail_index = noo_woo.get_thumbnail_index( index );
                noo_woo.vars.thumbnails_slider_data.goToSlide( thumbnail_index );
            }

            noo_woo.set_active_thumbnail( index );

        },

        get_thumbnail_index: function( index ) {

            if( parseInt(noo_woo.vars.thumbnails_count) === 1 ) {
                return index;
            }

            var last_thumbnail_index = noo_woo.get_last_thumbnail_index(),
                new_thumbnail_index = ( index > last_thumbnail_index ) ? last_thumbnail_index : ( index === 0 ) ? 0 : index - 1;

            return new_thumbnail_index;

        },

        get_last_thumbnail_index: function() {

            var thumbnail_count = noo_woo.els.thumbnails.children().length,
                last_slide_index = thumbnail_count - noo_woo.vars.thumbnails_count;

            return last_slide_index;

        },

        watch_variations: function() {

            noo_woo.els.variation_id_field.on('change', function() {

                var variation_id = parseInt( $(this).val() ),
                    currently_showing = parseInt( noo_woo.els.all_images_wrap.attr('data-showing') );

                if( !isNaN(variation_id) && variation_id !== currently_showing ) {

                    noo_woo.get_variation_data( variation_id );

                }

                if( isNaN(variation_id) ) {

                    setTimeout(function(){

                        if( noo_woo.els.variation_id_field.val() === "" && currently_showing !== noo_woo.vars.product_id ) {

                            noo_woo.reset_images();

                        }

                    }, 250);

                }

            });

            $(document).on(noo_woo.vars.loading_variation_trigger, function( event ){

                noo_woo.els.all_images_wrap.addClass( noo_woo.vars.loading_class );

            });

            $(document).on(noo_woo.vars.show_variation_trigger, function( event, variation ){

                noo_woo.load_images( variation );

            });

            $(document).on( 'change', '.noo_variations input[type="checkbox"]', function() {
                $input   = $(this);
                $pa_item = $input.closest('.pa_item');
                $attribute = $pa_item.attr('data-attribute_name');

                $pa_item
                    .find('input[type="checkbox"]').not(this)
                        .prop( 'checked', false );

                if ( $input.prop( 'checked' ) ) {
                    $('table.variations select#' + $attribute)
                        .val( $input.val() )
                        .change();
                }
            });

            $(document).on( 'click', '.reset_variations', function( event ) {
                $noo_variations = $('.noo_variations');
                $noo_variations
                    .find('input[type="checkbox"]')
                        .prop( 'checked', false );
            });

        },

        load_images: function( variation ) {

            if( variation ) {

                noo_woo.els.all_images_wrap.attr('data-showing', variation.variation_id);

                if( variation.other_images ) {

                    var image_count = variation.other_images.length;

                    if( image_count > 0 ) {

                        noo_woo.els.all_images_wrap.removeClass( noo_woo.vars.reset_class );
                        noo_woo.els.thumbnails_wrap.removeClass (function (index, css) {
                            return (css.match (/\bnumber-\S+/g) || []).join(' ');
                        });
                        
                        noo_woo.els.thumbnails_wrap.addClass('number-' + image_count);

                        noo_woo.replace_images( variation.other_images, function(){

                            $(document).trigger( 'noo_woo_images_loaded', [ variation ] );

                        });

                    }

                }

            }

        },

        replace_images: function( images, callback ) {

            var temp_images = noo_woo.create_temporary_images( images );

            temp_images.container.imagesLoaded( function() {

                // replace images

                noo_woo.els.images.html( temp_images.images.html() );
                noo_woo.els.thumbnails.html( temp_images.thumbnails.html() );

                // reload sliders

                if( noo_woo.vars.images_slider_data ) { noo_woo.vars.images_slider_data.reloadSlider( noo_woo.images_slider_args() ); }
                if( noo_woo.vars.thumbnails_slider_data ) { noo_woo.vars.thumbnails_slider_data.reloadSlider( noo_woo.thumbnails_slider_args() ); }

                // remove temp images

                temp_images.container.remove();

                // remove loading icon

                noo_woo.els.all_images_wrap.removeClass( noo_woo.vars.loading_class );

                // run a callback, if required

                if(callback !== undefined) {
                    callback();
                }

            });

        },

        prepare_retina_srcset: function( retina_src ) {

            return noo_woo.tpl.retina_img_src.replace('{{image_src}}', retina_src);

        },

        setup_srcset: function() {

            $('[data-srcset]').each(function(){

                $(this)
                    .attr('srcset', $(this).attr('data-srcset'))
                    .removeAttr('data-srcset');

            });

        },

        create_temporary_images: function( images ) {

            // add temp images container
            $('body').append( noo_woo.tpl.temp_images_container );

            var image_count = images.length,
                temp_images = {
                    'container': $('.noo-woo-temp'),
                    'images': $('.noo-woo-temp__images'),
                    'thumbnails': $('.noo-woo-temp__thumbnails')
                };

            // loop through additional images
            $.each( images, function( index, image_data ){

                // add images to temp div

                var has_retina_single = typeof image_data.single.retina !== "undefined" ? true : false,
                    has_retina_thumb = typeof image_data.thumb.retina !== "undefined" ? true : false;

                var slide_html =
                        noo_woo.tpl.image_slide
                        .replace( /{{image_src}}/g, image_data.single[0] )
                        .replace( /{{image_src_retina}}/g, has_retina_single ? noo_woo.prepare_retina_srcset( image_data.single.retina[0] ) : "" )
                        .replace( "{{large_image_src}}", image_data.large[0] )
                        .replace( "{{large_image_width}}", image_data.large[1] )
                        .replace( "{{large_image_height}}", image_data.large[2] )
                        .replace( "{{image_width}}", image_data.single[1] )
                        .replace( "{{image_height}}", image_data.single[2] )
                        .replace( "{{alt}}", image_data.alt )
                        .replace( "{{title}}", image_data.title )
                        .replace( "{{slide_class}}", index === 0 ? noo_woo.vars.images_active_class  : "" );

                temp_images.images.append( slide_html );

                // add thumbnails to temp div

                if( image_count > 1 ) {

                    var thumbnail_html =
                            noo_woo.tpl.thumbnail_slide
                            .replace( /{{image_src}}/g, image_data.thumb[0] )
                            .replace( /{{image_src_retina}}/g, has_retina_thumb ? noo_woo.prepare_retina_srcset( image_data.thumb.retina[0] ) : "" )
                            .replace( "{{index}}", index )
                            .replace( "{{image_width}}", image_data.thumb[1] )
                            .replace( "{{image_height}}", image_data.thumb[2] )
                            .replace( "{{alt}}", image_data.alt )
                            .replace( "{{title}}", image_data.title )
                            .replace( "{{slide_class}}", index === 0 ? noo_woo.vars.thumbnails_active_class  : "" );

                    temp_images.thumbnails.append( thumbnail_html );

                }

            });

            // pad out the thumbnails if there is less than the
            // amount that are meant to be displayed.

            if( image_count !== 1 && image_count < noo_woo.vars.thumbnails_count ) {

                var empty_count = noo_woo.vars.thumbnails_count - image_count;

                i = 0; while( i < empty_count ) {

                    temp_images.thumbnails.append( '<div/>' );

                    i++;

                }

            }

            return temp_images;

        },

        reset_images: function(){

            if( !noo_woo.els.all_images_wrap.hasClass( noo_woo.vars.reset_class ) && !noo_woo.els.all_images_wrap.hasClass( noo_woo.vars.loading_class ) ) {

                $(document).trigger( noo_woo.vars.loading_variation_trigger );

                noo_woo.els.all_images_wrap.attr('data-showing', noo_woo.vars.product_id);

                // set reset class

                noo_woo.els.all_images_wrap.addClass( noo_woo.vars.reset_class );

                // replace images

                noo_woo.replace_images( noo_woo.vars.default_images );

            }

        },

        get_variation_data: function( variation_id ) {

            $(document).trigger( noo_woo.vars.loading_variation_trigger );

            var variation_data = false;

            // variation data available

            if( noo_woo.vars.variations ) {

                $.each(noo_woo.vars.variations, function( index, variation ){

                    if( variation.variation_id === variation_id ) {
                        variation_data = variation;
                    }

                });

                $(document).trigger( noo_woo.vars.show_variation_trigger, [ variation_data ] );

            // variation data not available, look it up via ajax

            } else {

                $.ajax({
                    type:        "GET",
                    url:         nooWooVars.ajaxurl,
                    cache:       false,
                    dataType:    "jsonp",
                    crossDomain: true,
                    data: {
                        'action': 'noo_woo_get_variation',
                        'variation_id': variation_id,
                        'product_id': noo_woo.vars.product_id
                    },
                    success: function( response ) {

                        if( response.success ) {
                            if( response.variation ) {

                                variation_data = response.variation;

                                $(document).trigger( noo_woo.vars.show_variation_trigger, [ variation_data ] );

                            }
                        }

                    }
                });

            }

        },

        setup_fullscreen: function() {

        	//.noo-woo-images__slide, .noo-woo-images__image";
            $(document).on('click', '.noo-woo-images__slide', function(){

                var pswpElement = $('.noo-woo-pswp')[0];

	            var items = noo_woo.get_gallery_items();

	            var options = {
	                index: items.index,
	                shareEl: false,
	                closeOnScroll: false,
	                history: false
	            };

	            noo_woo.els.gallery = new PhotoSwipe( pswpElement, PhotoSwipeUI_Default, items.items, options);
	            noo_woo.els.gallery.init();

            });

        },

        get_gallery_items: function() {

            var $slides = noo_woo.els.images.children().not('.bx-clone'),
                items = [],
                index = $slides.filter("."+noo_woo.vars.images_active_class).index();

            index = index-1;

            if( $slides.length > 0 ) {
                $slides.each(function( i, el ){

                    var img = $(el).find('img'),
                        large_image_src = img.attr('data-large-image'),
                        large_image_w = img.attr('data-large-image-width'),
                        large_image_h = img.attr('data-large-image-height'),
                        item = {
                            src: large_image_src,
                            w: large_image_w,
                            h: large_image_h
                        };

                    items.push( item );

                });
            }

            return {
                index: index,
                items: items
            };

        },

        init: function() {

            noo_woo.setup_var();
            noo_woo.setup_sliders();
            noo_woo.watch_variations();
            noo_woo.setup_fullscreen();

        },

    };

	$(window).load( noo_woo.init() );

}(jQuery, document));