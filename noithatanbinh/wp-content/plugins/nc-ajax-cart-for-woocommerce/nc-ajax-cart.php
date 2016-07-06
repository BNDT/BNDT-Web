<?php

/**
 * @wordpress-plugin
 * Plugin Name:       NC Ajax Cart for Woocommerce
 * Plugin URI:        http://www.dovecreation.com
 * Description:       Ajax driven cart widget for woocommerce
 * Version:           1.0.2
 * Author:            Nabaraj Chapagain
 * Author URI:        http://www.dovecreation.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       nc-ajax-cart-for-woocommerce
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) )  ) { 
/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-nc-ajax-cart-activator.php
 */
function activate_NC_Ajax_Cart() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-nc-ajax-cart-activator.php';
	NC_Ajax_Cart_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-nc-ajax-cart-deactivator.php
 */
function deactivate_NC_Ajax_Cart() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-nc-ajax-cart-deactivator.php';
	NC_Ajax_Cart_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_NC_Ajax_Cart' );
register_deactivation_hook( __FILE__, 'deactivate_NC_Ajax_Cart' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-nc-ajax-cart.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.1
 */
function run_NC_Ajax_Cart() {

	$plugin = new NC_Ajax_Cart();
	$plugin->run();

}
run_NC_Ajax_Cart();


/**
 * ajax cart settings page link * @since      1.0.0
*/	

 function NC_Ajax_Cart_add_settings_link( $links ) 
		{
   			$settings_link = '<a href="admin.php?page=nc_ajax_cart">' . __( 'Configure Cart Settings' ) . '</a>';
   			array_push( $links, $settings_link );
  			return $links;
		}
				$plugin = plugin_basename( __FILE__ );
add_filter( "plugin_action_links_$plugin", 'NC_Ajax_Cart_add_settings_link');
}
