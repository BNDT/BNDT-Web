<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 * * @since      1.0.1
 *
 * @package    nc-ajax-cart-for-woocommerce
 * @subpackage nc-ajax-cart-for-woocommerce/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 * * @since      1.0.1
 * @package    nc-ajax-cart-for-woocommerce
 * @subpackage nc-ajax-cart-for-woocommerce/includes
 * @author     Nabaraj Chapagain <nabarajc6@gmail.com>
 */
class NC_Ajax_Cart_i18n {

	/**
	 * The domain specified for this plugin.
	 * * @since      1.0.1
	 * @access   private
	 * @var      string    $domain    The domain identifier for this plugin.
	 */
	private $domain;

	/**
	 * Load the plugin text domain for translation.
	 * * @since      1.0.1
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			$this->domain,
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}

	/**
	 * Set the domain equal to that of the specified domain.
	 * * @since      1.0.1
	 * @param    string    $domain    The domain that represents the locale of this plugin.
	 */
	public function set_domain( $domain ) {
		$this->domain = $domain;
	}

}
