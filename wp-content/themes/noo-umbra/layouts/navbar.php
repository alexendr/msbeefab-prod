<?php

$header_style = noo_umbra_get_option('noo_header_nav_style','header-1');
if( is_page() ) {
    $headerpage = noo_umbra_get_post_meta(get_the_ID(), '_noo_wp_page_header_style');
    if (!empty($headerpage) && $headerpage != 'default') {
        $header_style = $headerpage;
    }
}
if( is_page_template('page-revolution.php') ){
    $header_style = 'header-1';
}
?>
<?php
if( $header_style == 'header-2' ){
    get_template_part('layouts/heade-style/style','2');
}elseif( $header_style == 'header-3' ){
    get_template_part('layouts/heade-style/style','3');
}else{
    get_template_part('layouts/heade-style/style','1');
}
?>
<div class="search-header">
    <div class="remove-form"></div>
    <div class="noo-container">
        <?php noo_umbra_get_from_product(); ?>
    </div>
</div>



