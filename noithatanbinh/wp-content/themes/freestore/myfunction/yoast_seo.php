<?php
add_action( 'init', 'hook_breadcrumbs' );
function hook_breadcrumbs() {
    remove_action( 'woocommerce_before_main_content','woocommerce_breadcrumb', 20 );
    add_action( 'woocommerce_before_main_content','hook_yoast_breadcrumb', 20, 0);
    function hook_yoast_breadcrumb() {
        if ( function_exists('yoast_breadcrumb')  && !is_front_page() ) {
            yoast_breadcrumb('<p class="breadcrumbs">','</p>');
        }
    }
}
?>