<?php
/**
 * Plugin Name: mjseo plugins // T�n c?a plugin
 * Plugin URI: http://hocwp.net // �?a ch? trang ch? c?a plugin
 * Description: ��y l� plugin d?u ti�n m� t�i vi?t d�nh ri�ng cho WordPress, ch? d? h?c t?p m� th�i. // Ph?n m� t? cho plugin
 * Version: 1.0 // ��y l� phi�n b?n d?u ti�n c?a plugin
 * Author: Sau Hi // T�n t�c gi?, ngu?i th?c hi?n plugin n�y
 * Author URI: http://sauhi.com // �?a ch? trang ch? c?a t�c gi?
 * License: GPLv2 or later // Th�ng tin license c?a plugin, n?u kh�ng quan t�m th� b?n c? d? GPLv2 v�o d�y
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
