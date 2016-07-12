<?php
/*
 * Plugin Name: WooCommerce Cart Count Shortcode
 * Plugin URI: https://github.com/prontotools/woocommerce-cart-count-shortcode
 * Description: Display a link to your shopping cart with the item count anywhere on your site with a customizable shortcode.
 * Version: 1.0.0
 * Author: Pronto Tools
 * Author URI: http://www.prontotools.io
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

function woocommerce_cart_count_shortcode( $atts ) {
    $defaults = array(
        "icon"               => "cart",
        "empty_cart_text"    => "",
        "items_in_cart_text" => "",
        "show_items"         => "",
        "custom_css"         => ""
    );

    $atts = shortcode_atts( $defaults, $atts );

    $icon_html = "";
    if ( $atts["icon"] ) {
        if ( "cart" == $atts["icon"] ) {
            $icon_html = '<i class="fa fa-shopping-cart"></i> ';
        } elseif ( $atts["icon"] == "basket" ) {
            $icon_html = '<i class="fa fa-shopping-basket"></i> ';
        } else {
            $icon_html = '<i class="fa fa-' . $atts["icon"] . '"></i> ';
        }
    }

    $cart_count = "";
    if ( class_exists( "WooCommerce" ) ) {
        global $woocommerce;

        $cart_count = $woocommerce->cart->get_cart_contents_count();

        $cart_count_html = "";
        if ( "true" == $atts["show_items"] ) {
            $cart_count_html = " (" . $cart_count . ")";
        }

        $cart_text_html = "";
        $link_to_page = "";
        if ( $cart_count > 0 ) {
            if ( "" != $atts["items_in_cart_text"] ) {
                $cart_text_html = $atts["items_in_cart_text"];
            }
            $link_to_page = ' href="' . $woocommerce->cart->get_cart_url() . '"';
        } else {
            if ( "" != $atts["empty_cart_text"] ) {
                $cart_text_html = $atts["empty_cart_text"];
            }
            $link_to_page = ' href="' . wc_get_page_permalink( 'shop' ) . '"';
        }
    }

    $custom_css = "";
    if ( $atts["custom_css"] ) {
        $custom_css = ' class="' . $atts["custom_css"] . '"';
    }

    $html  = "<a" . $link_to_page . $custom_css . ">";
    $html .= $icon_html . $cart_text_html . $cart_count_html;
    $html .= "</a>";

    return $html;
}

add_shortcode( "cart_button", "woocommerce_cart_count_shortcode" );
