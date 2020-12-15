<?php

$lang = $this->cmp_get_current_lang() ? '_'.$this->cmp_get_current_lang() : '';
$content = stripslashes( get_option('niteoCS_body'.$lang, '') );
$wpautop = get_option('niteoCS_wpautop', '1');

if ( isset($GLOBALS['wp_embed']) ) {
    $html = $GLOBALS['wp_embed']->autoembed( $content );
}

$html = $wpautop == "1" ? wpautop( do_shortcode( $content ) ) : do_shortcode( $content );