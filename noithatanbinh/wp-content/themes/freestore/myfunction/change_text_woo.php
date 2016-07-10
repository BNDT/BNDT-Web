<?php
/**
 * Change text strings
 *
 * @link http://codex.wordpress.org/Plugin_API/Filter_Reference/gettext
 */
function my_text_strings( $translated_text, $text, $domain ) {
    switch ( $translated_text ) {
        case 'View Cart' :
            $translated_text = __( 'Xem Giỏ Hàng', 'woocommerce' );
            break;
    }
    return $translated_text;
}
add_filter( 'gettext', 'my_text_strings', 20, 3 );
?>