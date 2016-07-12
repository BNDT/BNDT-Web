WooCommerce Cart Count Shortcode
================================

[![Build Status](https://travis-ci.org/prontotools/woocommerce-cart-count-shortcode.svg?branch=develop)](https://travis-ci.org/prontotools/woocommerce-cart-count-shortcode)

Display a link to your shopping cart with the item count anywhere on your site with a customizable shortcode.

Usage
-----

**Parameters:**
* `icon`
* `empty_cart_text`
* `items_in_cart_text`
* `show_items`
* `custom_css`

**Examples:**
* `[cart_button]`
* `[cart_button icon="basket"]`
* `[cart_button show_items="true"]`
* `[cart_button show_items="true" items_in_cart_text="Cart"]`
* `[cart_button show_items="true" empty_cart_text="Store"]`
* `[cart_button items_in_cart_text="Cart" custom_css="custom"]`

Developer Guide
---------------

To run, test, and develop the Simple Login-Logout Shortcode plugin with Docker container, please simply follow these steps:

1. Build the container:

  `$ docker build -t wptest .`
 
2. Test running the PHPUnit on this plugin:

  `$ docker run -it -v $(pwd):/app wptest /bin/bash -c "service mysql start && phpunit"`

Changelog
----------

= 1.0.0 =
- First release!
- Tested with WordPress 4.4.2 and WooCommerce 2.5.5.
