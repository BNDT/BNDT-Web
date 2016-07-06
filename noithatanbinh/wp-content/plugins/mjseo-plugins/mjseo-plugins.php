<?php
/**
 * Plugin Name: mjseo plugins // Tên c?a plugin
 * Plugin URI: http://hocwp.net // Ð?a ch? trang ch? c?a plugin
 * Description: Ðây là plugin d?u tiên mà tôi vi?t dành riêng cho WordPress, ch? d? h?c t?p mà thôi. // Ph?n mô t? cho plugin
 * Version: 1.0 // Ðây là phiên b?n d?u tiên c?a plugin
 * Author: Sau Hi // Tên tác gi?, ngu?i th?c hi?n plugin này
 * Author URI: http://sauhi.com // Ð?a ch? trang ch? c?a tác gi?
 * License: GPLv2 or later // Thông tin license c?a plugin, n?u không quan tâm thì b?n c? d? GPLv2 vào dây
 */
 ?>
 <?php
 if(!class_exists('My_First_Plugin_Demo')) {
        class My_First_Plugin_Demo {
                function __construct() {
                        if(!function_exists('add_shortcode')) {
                                return;
                        }
                        add_shortcode( 'hello' , array(&$this, 'hello_func') );
                }
 
                function hello_func($atts = array(), $content = null) {
                        extract(shortcode_atts(array('name' => 'World'), $atts));
                        return '<div><p>Hello111 '.$name.'!!!</p></div>';
                }
        }
}
function mfpd_load() {
        global $mfpd;
        $mfpd = new My_First_Plugin_Demo();
}
add_action( 'plugins_loaded', 'mfpd_load' );
?>
