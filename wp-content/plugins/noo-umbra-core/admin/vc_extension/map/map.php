<?php
/**
 * NOO Visual Composer Add-ons
 *
 * Customize Visual Composer to suite NOO Framework
 *
 * @package    NOO Framework
 * @subpackage NOO Visual Composer Add-ons
 * @version    1.0.0
 * @author     Kan Nguyen <khanhnq@nootheme.com>
 * @copyright  Copyright (c) 2014, NooTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://nootheme.com
 */
//
// Variables.
//
$category_name                  = esc_html__( 'Umbra', 'noo-umbra-core' );

// custom [row]
vc_add_param('vc_row', array(
        "type"        =>  "checkbox",
        "admin_label" =>  true,
        "heading"     =>  "Using Container",
        "param_name"  =>  "container_width",
        "description" =>  esc_html__( 'If checked container will be set to width 1170px for content.','noo-umbra-core'),
        'weight'      => 1,
        'value'       => array( esc_html__( 'Yes', 'noo-umbra-core' ) => 'yes' )
    )
);



// [noo_product]
vc_map(array(
    'base'        => 'noo_product_grid',
    'name'        => esc_html__( 'Product Grid', 'noo-umbra-core' ),
    'class'       => 'noo-icon-product',
    'icon'        => 'icon-wpb-woocommerce',
    'category'    => $category_name,
    'description' => '',
    'params'      => array(
        array(
            'type'          => 'textfield',
            'heading'       => esc_html__( 'Title', 'noo-umbra-core' ),
            'param_name'    => 'title',
            'admin_label'   => true,
            'holder'        => '',
        ),
        array(
            'type'          => 'textfield',
            'heading'       => esc_html__( 'Sub title', 'noo-umbra-core' ),
            'param_name'    => 'sub_title',
            'admin_label'   => true,
            'holder'        => '',
        ),
        array(
            'param_name'    => 'style',
            'heading'       => esc_html__( 'Choose Style', 'noo-umbra-core' ),
            'description'   => '',
            'type'          => 'dropdown',
            'holder'        => '',
            'value'         => array(
                esc_html__( 'Style One', 'noo-umbra-core' )      =>  'one',
                esc_html__( 'Style Two', 'noo-umbra-core' )      => 'two',
                esc_html__( 'Style Three', 'noo-umbra-core' )      => 'three',
            )
        ),
        array(
            'param_name'    => 'masonry',
            'heading'       => esc_html__( 'Using Masonry', 'noo-umbra-core' ),
            'description'   => '',
            'type'          => 'dropdown',
            'holder'        => '',
            'value'         => array(
                esc_html__( 'Yes', 'noo-umbra-core' )      =>  'product_masonry',
                esc_html__( 'No', 'noo-umbra-core' )    => 'no_masonry',
            )
        ),
        array(
            'param_name'    => 'data',
            'heading'       => esc_html__('Choose Data', 'noo-umbra-core'),
            'description'   => '',
            'type'          => 'dropdown',
            'horder'        => '',
            'admin_label'   => true,
            'value'         => array(
                esc_html__('Recent Products','noo-umbra-core')         => 'recent',
                esc_html__('Featured products','noo-umbra-core')       => 'featured',
                esc_html__('Best Selling Products','noo-umbra-core')   => 'selling',
                esc_html__('Sale Products','noo-umbra-core')           => 'sale',
                esc_html__('By Categories','noo-umbra-core')           => 'cat',
            )
        ),
        array(
            'param_name'    => 'product_cat',
            'heading'       => __( 'Choose categories', 'noo-umbra-core' ),
            'description'   => '',
            'type'          => 'noo_product_cat',
            'admin_label'   => true,
            'holder'        => '',
            'dependency'    =>  Array('element' =>  'data', 'value'   =>  'cat')
        ),

        array(
            'param_name'    => 'filter',
            'heading'       => esc_html__( 'Choose Style', 'noo-umbra-core' ),
            'description'   => '',
            'type'          => 'dropdown',
            'holder'        => '',
            'value'         => array(
                esc_html__( 'No Filter', 'noo-umbra-core' )      =>  'no-filter',
                esc_html__( 'Style Filter', 'noo-umbra-core' )    => 'filter',
            ),
            'dependency'    =>  Array('element' =>  'data', 'value'   =>  'cat')
        ),
        array(
            'param_name'  => 'columns',
            'heading'     => esc_html__( 'Choose columns', 'noo-umbra-core' ),
            'description' => '',
            'type'        => 'dropdown',
            'holder'      => '',
            'value'       => array(
                esc_html__( '5 Columns', 'noo-umbra-core' )     => 'columns_5',
                esc_html__( '4 Columns', 'noo-umbra-core' )     => 'columns_4',
                esc_html__( '3 Columns', 'noo-umbra-core' )     => 'columns_3',
                esc_html__( '2 Columns', 'noo-umbra-core' )     => 'columns_2',
                esc_html__( '1 Columns', 'noo-umbra-core' )     => 'columns_1',
            )
        ),
        array(
            'param_name'    => 'orderby',
            'heading'       => esc_html__( 'Order By', 'noo-umbra-core' ),
            'description'   => '',
            'type'          => 'dropdown',
            'holder'        => '',
            'value'         => array(
                esc_html__( 'Recent First', 'noo-umbra-core' )             => 'latest',
                esc_html__( 'Older First', 'noo-umbra-core' )              => 'oldest',
                esc_html__( 'Title Alphabet', 'noo-umbra-core' )           => 'alphabet',
                esc_html__( 'Title Reversed Alphabet', 'noo-umbra-core' )  => 'ralphabet' )
        ),
        array(
            'param_name'  => 'posts_per_page',
            'heading'     => esc_html__( 'Limited', 'noo-umbra-core' ),
            'description' => '',
            'type'        => 'textfield',
            'holder'      => '',
            'value'       => 8
        ),

    )
));

// [noo_product_selling]
vc_map(array(
    'base'        => 'noo_shortoce_sale',
    'name'        => esc_html__( 'Product Group Sale', 'noo-umbra-core' ),
    'class'       => 'noo-icon-product',
    'icon'        => 'icon-wpb-woocommerce',
    'category'    => $category_name,
    'description' => '',
    'params'      => array(
        array(
            'type'          => 'textfield',
            'heading'       => esc_html__( 'Title', 'noo-umbra-core' ),
            'param_name'    => 'title',
            'admin_label'   => true,
            'holder'        => '',
        ),
        array(
            'type'          => 'attach_image',
            'heading'       => esc_html__( 'Image', 'noo-umbra-core' ),
            'param_name'    => 'image',
            'admin_label'   => true,
            'holder'        => '',
        ),
        array(
            'type'          => 'textfield',
            'heading'       => esc_html__( 'Sub title', 'noo-umbra-core' ),
            'param_name'    => 'sub_title',
            'admin_label'   => true,
            'holder'        => '',
        ),
        array(
            'type'          => 'textarea',
            'heading'       => esc_html__( 'Description', 'noo-umbra-core' ),
            'param_name'    => 'description',
            'admin_label'   => true
        ),
        array(
            'param_name'    => 'orderby',
            'heading'       => esc_html__( 'Order By', 'noo-umbra-core' ),
            'description'   => '',
            'type'          => 'dropdown',
            'holder'        => '',
            'value'         => array(
                esc_html__( 'Recent First', 'noo-umbra-core' )             => 'latest',
                esc_html__( 'Older First', 'noo-umbra-core' )              => 'oldest',
                esc_html__( 'Title Alphabet', 'noo-umbra-core' )           => 'alphabet',
                esc_html__( 'Title Reversed Alphabet', 'noo-umbra-core' )  => 'ralphabet' )
        ),
        array(
            'param_name'  => 'posts_per_page',
            'heading'     => esc_html__( 'Limited', 'noo-umbra-core' ),
            'description' => '',
            'type'        => 'textfield',
            'holder'      => '',
            'value'       => 8
        )


    )
));


//[noo_testimonial]
$cat = array();
$cat['All'] = 'all';
$categories = get_categories( array( 'taxonomy'  => 'testimonial_category' ) );
if ( isset( $categories ) && !empty( $categories ) ):
    foreach( $categories as $cate ):
        $cat[ $cate->name ] = $cate -> term_id;
    endforeach;
endif;
vc_map(array(
    'name'          =>  esc_html__('Noo Testimonial','noo-umbra-core'),
    'base'          =>  'noo_testimonial',
    'description'   =>  esc_html__('Display post type testimonial','noo-umbra-core'),
    'icon'          =>  'noo_icon_testimonial',
    'category'      =>   $category_name,
    'params'        =>  array(
        array(
            'param_name'  => 'style',
            'heading'     => esc_html__( 'Choose Style', 'noo-umbra-core' ),
            'description' => '',
            'type'        => 'dropdown',
            'holder'      => '',
            'value'       => array(
                esc_html__( 'Default', 'noo-umbra-core' )           => 'default',
                esc_html__( 'Thumbnail Control', 'noo-umbra-core' ) => 'thumb_click',)
        ),
        array(
            'param_name'  => 'categories',
            'heading'     => esc_html__( 'Categories', 'noo-umbra-core' ),
            'description' => '',
            'type'        => 'dropdown',
            'holder'      => '',
            'value'       =>  $cat
        ),

        array(
            'param_name'  => 'posts_per_page',
            'heading'     => esc_html__( 'Limited Testimonial', 'noo-umbra-core' ),
            'description' => '',
            'type'        => 'textfield',
            'holder'      => '',
            'value'       => 10
        ),
        array(
            'param_name'  => 'orderby',
            'heading'     => esc_html__( 'Order By', 'noo-umbra-core' ),
            'description' => '',
            'type'        => 'dropdown',
            'holder'      => '',
            'value'       => array(
                esc_html__( 'Recent First', 'noo-umbra-core' )             => 'latest',
                esc_html__( 'Older First', 'noo-umbra-core' )              => 'oldest',
                esc_html__( 'Title Alphabet', 'noo-umbra-core' )           => 'alphabet',
                esc_html__( 'Title Reversed Alphabet', 'noo-umbra-core' )  => 'ralphabet' )
        ),
        array(
            'param_name'  => 'autoplay',
            'heading'     => esc_html__( 'Auto Play', 'noo-umbra-core' ),
            'description' => '',
            'type'        => 'dropdown',
            'holder'      => '',
            'value'       =>  array(
                esc_html__( 'Yes', 'noo-umbra-core' )   =>  'true',
                esc_html__( 'No', 'noo-umbra-core' )    =>  'false'
            )
        )
    )
));


//[noo_mailchimp]

vc_map(array(
    'name'          =>  esc_html__('Noo Mailchimp','noo-umbra-core'),
    'base'          =>  'noo_mailchimp',
    'description'   =>  esc_html__('Displays your MailChimp for WordPress sign-up form','noo-umbra-core'),
    'icon'          =>  'noo_icon_mailchimp',
    'category'      =>   $category_name,
    'params'        =>  array(
        array(
            'param_name'  => 'style',
            'heading'     => esc_html__( 'Choose Style', 'noo-umbra-core' ),
            'description' => '',
            'type'        => 'dropdown',
            'holder'      => '',
            'value'       => array(
                esc_html__( 'Style one', 'noo-umbra-core' )     => 'style_one',
                esc_html__( 'Style two', 'noo-umbra-core' )     => 'style_two',
                esc_html__( 'Style three', 'noo-umbra-core' )   => 'style_three',
                esc_html__( 'Style four', 'noo-umbra-core' )    => 'style_four'
                )
        ),
        array(
            'type'          =>  'textfield',
            'holder'        =>  '',
            'heading'       =>  esc_html__('Title','noo-umbra-core'),
            'param_name'    =>  'title',
            'value'         =>  ''
        ),
        array(
            'type'          =>  'textfield',
            'holder'        =>  '',
            'heading'       =>  esc_html__('Description','noo-umbra-core'),
            'param_name'    =>  'desc',
            'value'         =>  ''
        ),

    )
));


//[noo_services]
vc_map(array(
    'name'          =>  esc_html__('Noo Services','noo-umbra-core'),
    'base'          =>  'noo_services',
    'description'   =>  esc_html__('Display Services','noo-umbra-core'),
    'icon'          =>  'noo_icon_services',
    'category'      =>   $category_name,
    'params'        =>  array(
       array(
           'param_name'  => 'style',
           'heading'     => esc_html__( 'Choose Style', 'noo-umbra-core' ),
           'description' => '',
           'type'        => 'dropdown',
           'holder'      => '',
           'value'       => array(
               esc_html__( 'Style Center', 'noo-umbra-core' )   => 'style_center',
               esc_html__( 'Style Left', 'noo-umbra-core' )     => 'style_left'
           )
       ),
        array(
            'param_name'  => 'style_icon',
            'heading'     => esc_html__( 'Choose Icon', 'noo-umbra-core' ),
            'description' => '',
            'type'        => 'dropdown',
            'holder'      => '',
            'value'       => array(
                esc_html__( 'Font', 'noo-umbra-core' )          => 'font',
                esc_html__( 'Image', 'noo-umbra-core' )         => 'image',
            )
        ),
        array(
            'type'          => 'attach_image',
            'heading'       => esc_html__( 'Image Icon', 'noo-umbra-core' ),
            'param_name'    => 'icon_image',
            'admin_label'   => true,
            'dependency'    =>  Array('element' =>  'style_icon', 'value'   =>  'image')
        ),
        array(
            'type'          => 'iconpicker',
            'heading'       => esc_html__( 'Icon', 'noo-umbra-core' ),
            'param_name'    => 'icon',
            'admin_label'   => true,
            'dependency'    =>  Array('element' =>  'style_icon', 'value'   =>  'font')
        ),
        array(
            'type'          => 'textfield',
            'heading'       => esc_html__( 'Title', 'noo-umbra-core' ),
            'param_name'    => 'title',
            'admin_label'   => true
        ),
        array(
            'type'          => 'textarea',
            'heading'       => esc_html__( 'Description', 'noo-umbra-core' ),
            'param_name'    => 'description',
            'admin_label'   => true
        )
    )
));



//[noo_partner]
vc_map(array(
    'name'          =>  esc_html__('Noo Partner','noo-umbra-core'),
    'base'          =>  'noo_partner',
    'description'   =>  esc_html__('Display Partner','noo-umbra-core'),
    'icon'          =>  'noo_icon_partner',
    'category'      =>   $category_name,
    'params'        =>  array(
        array(
            'param_name'  => 'style_border',
            'heading'     => esc_html__( 'Style Border ?', 'noo-umbra-core' ),
            'type'        => 'dropdown',
            'holder'      => '',
            'value'       =>  array(
                esc_html__( 'No Border', 'noo-umbra-core' )   =>  'noo_border',
                esc_html__( 'Yes Border', 'noo-umbra-core' )    =>  'border'
            )
        ),
        array(
            'param_name'  => 'limit_oneslider',
            'heading'     => esc_html__( 'Limited post of Slider',  'noo-umbra-core' ),
            'description' => '',
            'type'        => 'dropdown',
            'admin_label' => true,
            'holder'      => '',
            'value'       =>  array(
                '6'       =>  6,
                '5'       =>  5,
                '4'       =>  4
            )
        ),
        array(
            'param_name'  => 'images',
            'heading'     => esc_html__( 'Upload Images', 'noo-umbra-core' ),
            'description' => '',
            'type'        => 'attach_images',
            'holder'      => '',
        ),
        array(
            'param_name'  => 'custom_link',
            'heading'     => esc_html__( 'Custom links', 'noo-umbra-core' ),
            'description' => esc_html__('Enter links for each Clients here. Divide links with linebreaks (Enter) .', 'noo-umbra-core'),
            'type'        => 'exploded_textarea'
        ),
        array(
            'param_name'  => 'target',
            'heading'     => esc_html__( 'Custom link target', 'noo-umbra-core' ),
            'description' => esc_html__('Select where to open custom links.', 'noo-umbra-core'),
            'type'        => 'dropdown',
            'holder'      => '',
            'value'       => array(
                'Same window'   =>  'same',
                'New window'    =>  'new'
            )
        ),
        array(
            'param_name'  => 'autoplay',
            'heading'     => esc_html__( 'Auto Play', 'noo-umbra-core' ),
            'description' => '',
            'type'        => 'dropdown',
            'holder'      => '',
            'value'       =>  array(
                esc_html__( 'Yes', 'noo-umbra-core' )   =>  'true',
                esc_html__( 'No', 'noo-umbra-core' )    =>  'false'
            )
        )

    )
));


//[noo_banner]
vc_map(array(
    'name'          =>  esc_html__('Noo Banner','noo-umbra-core'),
    'base'          =>  'noo_banner',
    'description'   =>  esc_html__('Display Banner','noo-umbra-core'),
    'icon'          =>  'noo_icon_noo_banner',
    'category'      =>   $category_name,
    'params'        =>  array(
        array(
            'type' => 'param_group',
            'value' => '',
            'param_name' => 'banners',
            'params' => array(
                array(
                    'param_name'  => 'style',
                    'heading'     => esc_html__( 'Style item', 'noo-umbra-core' ),
                    'description' => '',
                    'type'        => 'dropdown',
                    'holder'      => '',
                    'value'       =>  array(
                        esc_html__( 'Default', 'noo-umbra-core' )       =>  'default',
                        esc_html__( 'Vertical', 'noo-umbra-core' )      =>  'vertical',
                        esc_html__( 'Horizontal', 'noo-umbra-core' )    =>  'horizontal'
                    )
                ),
                array(
                    'type'       => 'attach_image',
                    'value'      => '',
                    'heading'    => 'Upload image',
                    'param_name' => 'image',
                ),
                array(
                    'type'           => 'colorpicker',
                    'value'          => '',
                    'heading'        => esc_html__('Color','noo-umbra-core'),
                    'description'    => esc_html__('Color for title and link','noo-umbra-core'),
                    'param_name'     => 'color',
                    "dependency"    => Array('element' => "style", 'value' => array('vertical','horizontal'))
                ),
                array(
                    'type'        => 'textfield',
                    'value'       => '',
                    'heading'     => esc_html__('Title','noo-umbra-core'),
                    'param_name'  => 'title',
                    'holder'      => '',
                    'admin_label' => true,
                    "dependency"    => Array('element' => "style", 'value' => array('vertical','horizontal'))
                ),
                array(
                    'param_name'  => 'link',
                    'heading'     => esc_html__( 'Link', 'noo-umbra-core' ),
                    'description' => '',
                    'type'        => 'textfield',
                    'holder'      => ''
                ),
                array(
                    'param_name'  => 'link_text',
                    'heading'     => esc_html__( 'Link text', 'noo-umbra-core' ),
                    'description' => '',
                    'type'        => 'textfield',
                    'holder'      => '',
                    "dependency"    => Array('element' => "style", 'value' => array('vertical','horizontal'))
                ),
            )
        )
    )
));

//[noo_simple_banner]
vc_map(array(
    'name'          =>  esc_html__('Noo Simple Banner','noo-umbra-core'),
    'base'          =>  'noo_simple_banner',
    'description'   =>  esc_html__('Display Banner','noo-umbra-core'),
    'icon'          =>  'noo_icon_Banner',
    'category'      =>   $category_name,
    'params'        =>  array(
        array(
            'param_name'  => 'style_banner',
            'heading'     => esc_html__( 'Content position', 'noo-umbra-core' ),
            'description' => '',
            'type'        => 'dropdown',
            'holder'      => '',
            'value'       =>  array(
                esc_html__( 'Content right', 'noo-umbra-core' )   =>  'right',
                esc_html__( 'Content left', 'noo-umbra-core' )    =>  'left'
            )
        ),
        array(
            'type'          => 'attach_image',
            'heading'       => esc_html__( 'Image', 'noo-umbra-core' ),
            'param_name'    => 'icon_image',
            'admin_label'   => true,
        ),
        array(
            'type'          => 'textfield',
            'heading'       => esc_html__( 'Title', 'noo-umbra-core' ),
            'param_name'    => 'title',
            'admin_label'   => true
        ),
        array(
            'type'          => 'vc_link',
            'heading'       => esc_html__( 'Link', 'noo-umbra-core' ),
            'param_name'    => 'custom_link',
            'admin_label'   => true
        )
    )
));

// [noo_countdown]
vc_map(array(
    'base'        => 'noo_countdown',
    'name'        => esc_html__( 'Noo Simple Countdown', 'noo-umbra-core' ),
    'class'       => 'noo-icon-countdown',
    'icon'        => 'noo-icon-countdown',
    'category'    => $category_name,
    'description' => '',
    'params'      => array(
        array(
            'param_name'  => 'style',
            'heading'     => esc_html__( 'Style item', 'noo-umbra-core' ),
            'description' => '',
            'type'        => 'dropdown',
            'holder'      => '',
            'value'       =>  array(
                esc_html__( 'Simle countdow center', 'noo-umbra-core' ) =>  'countdown_center',
                esc_html__( 'Simle countdow left', 'noo-umbra-core' )   =>  'countdown_left'
            )
        ),
        array(
            'param_name'    => 'background_wrap',
            'heading'       => __( 'Background wraper', 'noo-umbra-core' ),
            'description'   => '',
            'type'          => 'attach_image',
            'admin_label'   => false,
            'holder'        => '',
            "dependency"    => Array('element' => "style", 'value' => array('countdown_left')),
            'group'         => esc_html__( 'Design options', 'noo-umbra-core' ),
        ),
        array(
            'param_name'    => 'title_wrap',
            'heading'       => __( 'Title wraper', 'noo-umbra-core' ),
            'description'   => '',
            'type'          => 'textfield',
            'admin_label'   => false,
            'holder'        => '',
            "dependency"    => Array('element' => "style", 'value' => array('countdown_left')),
            'group'         => esc_html__( 'Design options', 'noo-umbra-core' ),
        ),
        array(
            'param_name'    => 'desc_wrap',
            'heading'       => __( 'Description wraper', 'noo-umbra-core' ),
            'description'   => '',
            'type'          => 'textarea',
            'admin_label'   => false,
            'holder'        => '',
            "dependency"    => Array('element' => "style", 'value' => array('countdown_left')),
            'group'         => esc_html__( 'Design options', 'noo-umbra-core' ),
        ),
        array(
            'type'          => 'attach_image',
            'heading'       => esc_html__( 'Background ', 'noo-umbra-core' ),
            'param_name'    => 'background',
            'admin_label'   => true,
            'holder'        => '',
        ),
        array(
            'param_name'    => 'date',
            'heading'       => esc_html__( 'Choose Date', 'noo-umbra-core' ),
            'description'   => '',
            'type'          => 'noo_datepicker',
            'format'        => 'mm/dd/yy',
            'admin_label'   => true,
            'holder'        => '',
        ),
        array(
            'type'          => 'textfield',
            'heading'       => esc_html__( 'Title', 'noo-umbra-core' ),
            'param_name'    => 'title',
            'admin_label'   => true,
            'holder'        => '',
        ),
        array(
            'type'          => 'textarea',
            'heading'       => esc_html__( 'Description', 'noo-umbra-core' ),
            'param_name'    => 'description',
            'admin_label'   => true,
            'holder'        => '',
        ),
        array(
            'param_name'    => 'custom_link',
            'heading'       => esc_html__( 'Link', 'noo-umbra-core' ),
            'description'   => '',
            'type'          => 'vc_link',
            'admin_label'   => true,
            'holder'        => '',
            'value'         =>  '#'
        )
    )
));

// noo_product_countdown
vc_map(array(
    'base'        => 'noo_product_countdown',
    'name'        => __( 'Product Countdown', 'noo-umbra-core' ),
    'class'       => 'noo-icon-countdown',
    'icon'        => 'noo-icon-countdown',
    'category'    => $category_name,
    'description' => '',
    'params'      => array(
        array(
            'param_name'    => 'date',
            'heading'       => __( 'Choose date', 'noo-umbra-core' ),
            'description'   => '',
            'type'          => 'noo_datepicker',
            'format'        => 'mm/dd/yy',
            'admin_label'   => true,
            'holder'        => ''
        ),
        array(
            'type'          => 'autocomplete',
            'heading'       => esc_html__( 'Select identificator', 'noo-umbra-core' ),
            'param_name'    => 'id',
            'admin_label'   => true,
            'holder'        => '',
            'description'   => esc_html__( 'Input product ID or product SKU or product title to see suggestions', 'noo-umbra-core' ),
        )
    )
));

if( class_exists('Vc_Vendor_Woocommerce') ):
    $product_Woocommerce2 = new Vc_Vendor_Woocommerce();
    //Filters For autocomplete param:
    //For suggestion: vc_autocomplete_[shortcode_name]_[param_name]_callback
    add_filter( 'vc_autocomplete_noo_product_countdown_id_callback', array(
        $product_Woocommerce2,
        'productIdAutocompleteSuggester'
    ), 10, 1 ); // Get suggestion(find). Must return an array
    add_filter( 'vc_autocomplete_noo_product_countdown_id_render', array(
        $product_Woocommerce2,
        'productIdAutocompleteRender'
    ), 10, 1 ); // Render exact product. Must return an array (label,value)
    //For param: ID default value filter
    add_filter( 'vc_form_fields_render_field_noo_product_countdown_id_param_value', array(
        $product_Woocommerce2,
        'productIdDefaultValue'
    ), 10, 4 ); // Defines default value for param if not provided. Takes from other param value.
endif;


// [noo_blog]
add_filter( 'vc_autocomplete_noo_blog_include_callback',
    'vc_include_field_search', 10, 1 ); // Get suggestion(find). Must return an array
add_filter( 'vc_autocomplete_noo_blog_include_render',
    'vc_include_field_render', 10, 1 ); // Render exact product. Must return an array (label,value)
vc_map(array(
    'base'        => 'noo_blog',
    'name'        => esc_html__( 'Noo Blog', 'noo-umbra-core' ),
    'class'       => 'noo-icon-blog',
    'icon'        => 'noo-icon-blog',
    'category'    => $category_name,
    'description' => esc_html__( 'Display post with muti style', 'noo-umbra-core' ),
    'params'      => array(
        array(
            'type'          => 'textfield',
            'heading'       => esc_html__( 'Title', 'noo-umbra-core' ),
            'param_name'    => 'title',
            'admin_label'   => true,
            'holder'        => '',
        ),
        array(
            'type'          => 'textarea',
            'heading'       => esc_html__( 'Description', 'noo-umbra-core' ),
            'param_name'    => 'desc',
            'admin_label'   => true,
            'holder'        => '',
        ),
        array(
            'param_name'  => 'style',
            'heading'     => esc_html__( 'Style blog', 'noo-umbra-core' ),
            'description' => '',
            'type'        => 'dropdown',
            'holder'      => '',
            'value'       =>  array(
                esc_html__( 'Style 1', 'noo-umbra-core' )      =>  'style_1',
                esc_html__( 'Style 2', 'noo-umbra-core' )      =>  'style_2',
                esc_html__( 'Style 3', 'noo-umbra-core' )      =>  'style_3',
                esc_html__( 'Style 4', 'noo-umbra-core' )      =>  'style_4',
                esc_html__( 'Style 5', 'noo-umbra-core' )      =>  'style_5'
            )
        ),
        array(
            'param_name'    =>  'type_query',
            'heading'       =>  esc_html__('Data Source', 'noo-umbra-core'),
            'description'   =>  esc_html__('Select content type', 'noo-umbra-core'),
            'type'          =>  'dropdown',
            'admin_label'   => true,
            'holder'        =>  '',
            'value'         =>  array(
                'Category'      =>  'cate',
                'Tags'          =>  'tag',
                'Posts'         =>  'post_id'
            )
        ),
        array(
            'param_name'    => 'categories',
            'heading'       => esc_html__( 'Categories', 'noo-umbra-core' ),
            'description'   => esc_html__('Select categories.', 'noo-umbra-core' ),
            'type'          => 'post_categories',
            'admin_label'   => true,
            'holder'        => '',
            'dependency'    => array(
                'element'   => 'type_query',
                'value'     => array( 'cate' )
            ),
        ),
        array(
            'param_name'    => 'tags',
            'heading'       => esc_html__( 'Tags', 'noo-umbra-core' ),
            'description'   => esc_html__('Select Tags.', 'noo-umbra-core' ),
            'type'          => 'post_tags',
            'admin_label'   => true,
            'holder'        => '',
            'dependency'    => array(
                'element'   => 'type_query',
                'value'     => array( 'tag' )
            ),
        ),
        array(
            'type'        => 'autocomplete',
            'heading'     => esc_html__( 'Include only', 'noo-umbra-core' ),
            'param_name'  => 'include',
            'description' => esc_html__( 'Add posts, pages, etc. by title.', 'noo-umbra-core' ),
            'admin_label'   => true,
            'holder'        => '',
            'settings' => array(
                'multiple' => true,
                'sortable' => true,
                'groups'   => true,
            ),
            'dependency'    => array(
                'element'   => 'type_query',
                'value'     => array( 'post_id' )
            ),
        ),
        array(
            'param_name'  => 'orderby',
            'heading'     => esc_html__( 'Order By', 'noo-umbra-core' ),
            'description' => '',
            'type'        => 'dropdown',
            'holder'      => '',
            'value'       => array(
                esc_html__( 'Recent First', 'noo-umbra-core' ) => 'latest',
                esc_html__( 'Older First', 'noo-umbra-core' ) => 'oldest',
                esc_html__( 'Title Alphabet', 'noo-umbra-core' ) => 'alphabet',
                esc_html__( 'Title Reversed Alphabet', 'noo-umbra-core' ) => 'ralphabet' )
        ),
        array(
            'param_name'  => 'posts_per_page',
            'heading'     => esc_html__( 'Posts Per Page', 'noo-umbra-core' ),
            'description' => '',
            'type'        => 'textfield',
            'holder'      => '',
            'value'       => 10
        ),
        array(
            'param_name'   => 'limit_excerpt',
            'heading'      => esc_html__( 'Excerpt Length', 'noo-umbra-core' ),
            'description'  => '',
            'type'         => 'textfield',
            'holder'       => '',
            'value'        =>  15
        ),
        array(
            'param_name'    => 'custom_link',
            'heading'       => esc_html__( 'Link', 'noo-umbra-core' ),
            'description'   => '',
            'type'          => 'vc_link',
            'admin_label'   => true,
            'holder'        => '',
            'value'         =>  '#'
        )
    )
));


//[product_simple_slider]
vc_map(array(
    'name'          =>  esc_html__('Product Simple Slider','noo-umbra-core'),
    'base'          =>  'product_simple_slider',
    'description'   =>  esc_html__('Display product by slider','noo-umbra-core'),
    'icon'          =>  'noo_icon_slider',
    'category'      =>   $category_name,
    'params'        =>  array(
        array(
            'type'          =>  'noo_product_cat',
            'heading'       =>  esc_html__('Choose Categories','noo-umbra-core'),
            'description'   =>  esc_html__('Display product in categories','noo-umbra-core'),
            'holder'        =>  '',
            'param_name'    =>  'cat'
        ),
        array(
            'param_name'  => 'orderby',
            'heading'     => esc_html__( 'Order By', 'noo-umbra-core' ),
            'description' => '',
            'type'        => 'dropdown',
            'holder'      => '',
            'value'       => array(
                esc_html__( 'Recent First', 'noo-umbra-core' )             => 'latest',
                esc_html__( 'Older First', 'noo-umbra-core' )              => 'oldest',
                esc_html__( 'Title Alphabet', 'noo-umbra-core' )           => 'alphabet',
                esc_html__( 'Title Reversed Alphabet', 'noo-umbra-core' )  => 'ralphabet' )
        ),
        array(
            'type'          =>  'textfield',
            'holder'        =>  '',
            'class'         =>  '',
            'admin_label'   => true,
            'heading'       =>  esc_html__('Limit','noo-umbra-core'),
            'param_name'    =>  'posts_per_page',
            'value'         =>  10
        ),
        array(
            'type'          =>  'dropdown',
            'holder'        =>  '',
            'class'         =>  '',
            'heading'       =>  esc_html__('Config columns slider','noo-umbra-core'),
            'param_name'    =>  'columns',
            'admin_label'   => true,
            'value'         =>  array(
                esc_html__('3 columns','noo-umbra-core')     =>  '3',
                esc_html__('5 columns','noo-umbra-core')     =>  '5',
                esc_html__('4 columns','noo-umbra-core')     =>  '4',
                esc_html__('2 columns','noo-umbra-core')     =>  '2',
                esc_html__('1 columns','noo-umbra-core')     =>  '1'
            )
        ),
        array(
            'type'          =>  'dropdown',
            'holder'        =>  '',
            'class'         =>  '',
            'admin_label'   => true,
            'heading'       =>  esc_html__('Auto Slider','noo-umbra-core'),
            'param_name'    =>  'auto_slider',
            'value'         =>  array(
                esc_html__('False','noo-umbra-core')     =>  'false',
                esc_html__('True','noo-umbra-core')     =>  'true'
            )
        )
    )
));

//[noo_simple_product]
vc_map(array(
    'name'          =>  esc_html__('Product Simple','noo-umbra-core'),
    'base'          =>  'noo_simple_product',
    'description'   =>  esc_html__('Display product','noo-umbra-core'),
    'icon'          =>  'noo_icon_simple_product',
    'category'      =>   $category_name,
    'params'        =>  array(
        array(
            'type'          =>  'noo_product_cat',
            'heading'       =>  esc_html__('Choose Categories','noo-umbra-core'),
            'description'   =>  esc_html__('Display product in categories','noo-umbra-core'),
            'holder'        =>  '',
            'param_name'    =>  'product_cat'
        ),
        array(
            'param_name'  => 'orderby',
            'heading'     => esc_html__( 'Order By', 'noo-umbra-core' ),
            'description' => '',
            'type'        => 'dropdown',
            'holder'      => '',
            'value'       => array(
                esc_html__( 'Recent First', 'noo-umbra-core' )             => 'latest',
                esc_html__( 'Older First', 'noo-umbra-core' )              => 'oldest',
                esc_html__( 'Title Alphabet', 'noo-umbra-core' )           => 'alphabet',
                esc_html__( 'Title Reversed Alphabet', 'noo-umbra-core' )  => 'ralphabet' )
        ),
        array(
            'type'          =>  'textfield',
            'holder'        =>  '',
            'class'         =>  '',
            'heading'       =>  esc_html__('Limit','noo-umbra-core'),
            'param_name'    =>  'posts_per_page',
            'value'         =>  4
        ),
        array(
            'param_name'  => 'banner_style',
            'heading'     => esc_html__( 'Banner style', 'noo-umbra-core' ),
            'description' => '',
            'type'        => 'dropdown',
            'holder'      => '',
            'value'       => array(
                esc_html__( 'Banner left', 'noo-umbra-core' )             => 'banner_left',
                esc_html__( 'Banner right', 'noo-umbra-core' )            => 'banner_right',
            ),
            'group'         => esc_html__( 'Banner options', 'noo-umbra-core' )

        ),
        array(
            'param_name'  => 'content_style',
            'heading'     => esc_html__( 'Content style', 'noo-umbra-core' ),
            'description' => '',
            'type'        => 'dropdown',
            'holder'      => '',
            'value'       => array(
                esc_html__( 'Bottom right', 'noo-umbra-core' )             => 'bottom_right',
                esc_html__( 'Top left', 'noo-umbra-core' )                 => 'top_left',
                esc_html__( 'Center center', 'noo-umbra-core' )            => 'center_center',
            ),
            'group'         => esc_html__( 'Banner options', 'noo-umbra-core' )

        ),
        array(
            'type'          =>  'attach_image',
            'holder'        =>  '',
            'class'         =>  '',
            'heading'       =>  esc_html__('Upload banner','noo-umbra-core'),
            'param_name'    =>  'banner_id',
            'value'         =>  10,
            'group'         => esc_html__( 'Banner options', 'noo-umbra-core' ),
        ),
        array(
            'type'          => 'textfield',
            'heading'       => esc_html__( 'Title', 'noo-umbra-core' ),
            'param_name'    => 'title',
            'admin_label'   => true,
            'holder'        => '',
            'group'         => esc_html__( 'Banner options', 'noo-umbra-core' ),
        ),
        array(
            'type'          => 'textarea_html',
            'heading'       => esc_html__( 'Description', 'noo-umbra-core' ),
            'param_name'    => 'content',
            'admin_label'   => true,
            'holder'        => '',
            'group'         => esc_html__( 'Banner options', 'noo-umbra-core' ),
        ),
        array(
            'param_name'    => 'custom_link',
            'heading'       => __( 'Link', 'noo-umbra-core' ),
            'description'   => '',
            'type'          => 'vc_link',
            'admin_label'   => true,
            'holder'        => '',
            'value'         =>  '#',
            'group'         => esc_html__( 'Banner options', 'noo-umbra-core' ),
        )

    )
));


//[noo_short_image]
vc_map(array(
    'name'          =>  esc_html__('Short Image','noo-umbra-core'),
    'base'          =>  'noo_short_image',
    'description'   =>  esc_html__('Display image','noo-umbra-core'),
    'icon'          =>  'noo_icon_slider',
    'category'      =>   $category_name,
    'params'        =>  array(
        array(
            'type'          =>  'dropdown',
            'holder'        =>  '',
            'class'         =>  '',
            'heading'       =>  esc_html__('Style','noo-umbra-core'),
            'param_name'    =>  'style',
            'value'         =>  array(
                esc_html__('Style left','noo-umbra-core')     =>  'left',
                esc_html__('Style right','noo-umbra-core')     =>  'right'
            )
        ),
        array(
            'type'          =>  'attach_image',
            'holder'        =>  '',
            'class'         =>  '',
            'heading'       =>  esc_html__('Image','noo-umbra-core'),
            'param_name'    =>  'image_id',
        ),
        array(
            'type'          =>  'textfield',
            'holder'        =>  '',
            'class'         =>  '',
            'heading'       =>  esc_html__('Title','noo-umbra-core'),
            'param_name'    =>  'title'
        )
    )
));



// [noo_blog_masonry]
add_filter( 'vc_autocomplete_noo_blog_masonry_include_callback',
    'vc_include_field_search', 10, 1 ); // Get suggestion(find). Must return an array
add_filter( 'vc_autocomplete_noo_blog_masonry_include_render',
    'vc_include_field_render', 10, 1 ); // Render exact product. Must return an array (label,value)
vc_map(array(
    'base'        => 'noo_blog_masonry',
    'name'        => esc_html__( 'Noo Blog Masonry', 'noo-umbra-core' ),
    'class'       => 'noo-icon-blog',
    'icon'        => 'noo-icon-blog',
    'category'    => $category_name,
    'description' => esc_html__( 'Display post with _masonry style', 'noo-umbra-core' ),
    'params'      => array(
        array(
            'param_name'    =>  'type_query',
            'heading'       =>  esc_html__('Data Source', 'noo-umbra-core'),
            'description'   =>  esc_html__('Select content type', 'noo-umbra-core'),
            'type'          =>  'dropdown',
            'admin_label'   => true,
            'holder'        =>  '',
            'value'         =>  array(
                'Category'      =>  'cate',
                'Tags'          =>  'tag',
                'Posts'         =>  'post_id'
            )
        ),
        array(
            'param_name'    => 'categories',
            'heading'       => esc_html__( 'Categories', 'noo-umbra-core' ),
            'description'   => esc_html__('Select categories.', 'noo-umbra-core' ),
            'type'          => 'post_categories',
            'admin_label'   => true,
            'holder'        => '',
            'dependency'    => array(
                'element'   => 'type_query',
                'value'     => array( 'cate' )
            ),
        ),
        array(
            'param_name'    => 'tags',
            'heading'       => esc_html__( 'Tags', 'noo-umbra-core' ),
            'description'   => esc_html__('Select Tags.', 'noo-umbra-core' ),
            'type'          => 'post_tags',
            'admin_label'   => true,
            'holder'        => '',
            'dependency'    => array(
                'element'   => 'type_query',
                'value'     => array( 'tag' )
            ),
        ),
        array(
            'type'        => 'autocomplete',
            'heading'     => esc_html__( 'Include only', 'noo-umbra-core' ),
            'param_name'  => 'include',
            'description' => esc_html__( 'Add posts, pages, etc. by title.', 'noo-umbra-core' ),
            'admin_label'   => true,
            'holder'        => '',
            'settings' => array(
                'multiple' => true,
                'sortable' => true,
                'groups'   => true,
            ),
            'dependency'    => array(
                'element'   => 'type_query',
                'value'     => array( 'post_id' )
            ),
        ),
        array(
            'param_name'  => 'columns',
            'heading'     => esc_html__( 'Columns', 'noo-umbra-core' ),
            'description' => '',
            'type'        => 'dropdown',
            'holder'      => '',
            'value'       => array(
                esc_html__( 'Columns 4', 'noo-umbra-core' ) => '3',
                esc_html__( 'Columns 3', 'noo-umbra-core' ) => '4',
                esc_html__( 'Columns 2', 'noo-umbra-core' ) => '6',
            )
        ),
        array(
            'param_name'  => 'orderby',
            'heading'     => esc_html__( 'Order By', 'noo-umbra-core' ),
            'description' => '',
            'type'        => 'dropdown',
            'holder'      => '',
            'value'       => array(
                esc_html__( 'Recent First', 'noo-umbra-core' ) => 'latest',
                esc_html__( 'Older First', 'noo-umbra-core' ) => 'oldest',
                esc_html__( 'Title Alphabet', 'noo-umbra-core' ) => 'alphabet',
                esc_html__( 'Title Reversed Alphabet', 'noo-umbra-core' ) => 'ralphabet' )
        ),
        array(
            'param_name'  => 'posts_per_page',
            'heading'     => esc_html__( 'Posts Per Page', 'noo-umbra-core' ),
            'description' => '',
            'type'        => 'textfield',
            'holder'      => '',
            'value'       => 10
        ),
        array(
            'param_name'   => 'limit_excerpt',
            'heading'      => esc_html__( 'Excerpt Length', 'noo-umbra-core' ),
            'description'  => '',
            'type'         => 'textfield',
            'holder'       => '',
            'value'        =>  15
        ),
        array(
            'param_name'  => 'pagination',
            'heading'     => esc_html__( 'Choose pagination', 'noo-umbra-core' ),
            'description' => '',
            'type'        => 'dropdown',
            'holder'      => '',
            'value'       => array(
                esc_html__( 'Infinitescroll', 'noo' )           => 'infinitescroll',
                esc_html__( 'Ajax Button', 'noo' )              => 'ajax_button'
            )
        )
    )
));

//[noo_custom_link]
vc_map(array(
    'name'          =>  esc_html__('Custom Link','noo-umbra-core'),
    'base'          =>  'noo_custom_link',
    'description'   =>  esc_html__('Display Link','noo-umbra-core'),
    'icon'          =>  'noo_icon_product_categories',
    'category'      =>   $category_name,
    'params'        =>  array(
        array(
            'type'          =>  'dropdown',
            'holder'        =>  '',
            'class'         =>  '',
            'heading'       =>  esc_html__('Style','noo-umbra-core'),
            'param_name'    =>  'style',
            'value'         =>  array(
                esc_html__('Content Top','noo-umbra-core')        =>  'content_top',
                esc_html__('Content Bottom','noo-umbra-core')     =>  'content_bottom'
            )
        ),
        array(
            'type'          =>  'attach_image',
            'holder'        =>  '',
            'class'         =>  '',
            'heading'       =>  esc_html__('Image','noo-umbra-core'),
            'param_name'    =>  'image_id',
        ),
        array(
            'type'          =>  'textfield',
            'holder'        =>  '',
            'class'         =>  '',
            'heading'       =>  esc_html__('Title','noo-umbra-core'),
            'param_name'    =>  'title'
        ),
        array(
            'type'          => 'textarea',
            'heading'       => esc_html__( 'Description', 'noo-umbra-core' ),
            'param_name'    => 'desc',
            'admin_label'   => true,
            'holder'        => '',
        ),
        array(
            'param_name'    => 'custom_link',
            'heading'       => __( 'Link', 'noo-umbra-core' ),
            'description'   => '',
            'type'          => 'vc_link',
            'admin_label'   => true,
            'holder'        => '',
            'value'         =>  '#',
        )
    )
));

// [noo_member]
$cat = array();
$categories = get_categories( array( 'taxonomy'  => 'team_member_category' ) );
if ( isset( $categories ) && !empty( $categories ) ):
    foreach( $categories as $cate ):
        $cat[ $cate->name ] = $cate -> term_id;
    endforeach;
endif;
vc_map(array(
    "name"          =>  esc_html__("Noo Team", "noo"),
    "base"          =>  "noo_member",
    'description'   =>  esc_html__('Display post type team member ','noo-umbra-core'),
    "category"      =>  $category_name,
    "icon"          =>  "noo_team_icon",
    "params"        =>  array(
        array(
            'type'          => 'textfield',
            'heading'       => esc_html__( 'Title', 'noo-umbra-core' ),
            'param_name'    => 'title',
            'admin_label'   => true,
            'holder'        => '',
        ),
        array(
            'type'          => 'textarea',
            'heading'       => esc_html__( 'Description', 'noo-umbra-core' ),
            'param_name'    => 'desc',
            'admin_label'   => true,
            'holder'        => '',
        ),
        array(
            'type'          =>  'dropdown',
            'holder'        =>  '',
            'class'         =>  '',
            'heading'       =>  esc_html__('Categories','noo-umbra-core'),
            'param_name'    =>  'categories',
            'value'         =>  $cat
        ),
        array(
            'param_name'  => 'orderby',
            'heading'     => esc_html__( 'Order By', 'noo-umbra-core' ),
            'description' => '',
            'type'        => 'dropdown',
            'holder'      => '',
            'value'       => array(
                esc_html__( 'Recent First', 'noo-umbra-core' )              => 'latest',
                esc_html__( 'Older First', 'noo-umbra-core' )               => 'oldest',
                esc_html__( 'Title Alphabet', 'noo-umbra-core' )            => 'alphabet',
                esc_html__( 'Title Reversed Alphabet', 'noo-umbra-core' )   => 'ralphabet' )
        ),
        array(
            'param_name'  => 'posts_per_page',
            'heading'     => esc_html__( 'Posts Per Page', 'noo-umbra-core' ),
            'description' => '',
            'type'        => 'textfield',
            'holder'      => '',
            'value'       => 10
        )
    )
));

//[noo_introduce]
vc_map(array(
    "name"          =>  esc_html__("Noo Introduce", "noo"),
    "base"          =>  "noo_introduce",
    'description'   =>  esc_html__('Display Introduce ','noo-umbra-core'),
    "category"      =>  $category_name,
    "icon"          =>  "noo_team_icon",
    "params"        =>  array(
        array(
            'type'          => 'attach_image',
            'heading'       => esc_html__( 'Image', 'noo-umbra-core' ),
            'param_name'    => 'image_id',
            'admin_label'   => true,
            'holder'        => '',
        ),
        array(
            'type'          => 'textfield',
            'heading'       => esc_html__( 'Title', 'noo-umbra-core' ),
            'param_name'    => 'title',
            'admin_label'   => true,
            'holder'        => '',
        ),
        array(
            'type'       => 'textarea_html',
            'holder'     => '',
            'heading'    => esc_html__( 'Text', 'js_composer' ),
            'param_name' => 'content',
        )
    )
));