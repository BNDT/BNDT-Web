<?php
require_once( "woocommerce-cart-count-shortcode.php" );

class WooCommerce {
    public $cart;
}

class Fake_WC_Cart {
    public function get_cart_contents_count() {
        return 3;
    }

    public function get_cart_url() {
        return '/cart/';
    }
}

class Fake_WC_Empty_Cart {
    public function get_cart_contents_count() {
        return 0;
    }
}

function wc_get_page_permalink( $page ) {
    return "/" . $page . "/";
}

class WooCommerce_Cart_Count_Shortcode_Test extends WP_UnitTestCase {
    public function setUp() {
        global $woocommerce;

        $woocommerce = new WooCommerce;
        $woocommerce->cart = new Fake_WC_Cart;

        $this->shop_url = wc_get_page_permalink( "shop" );
    }

    public function tearDown() {
        parent::tearDown();
    }

    public function test_woocommerce_cart_count_shortcode_is_registered_to_shortcode_handler() {
        global $shortcode_tags;

        $this->assertTrue( array_key_exists(
            "cart_button",
            $shortcode_tags
        ) );

        $expected = "woocommerce_cart_count_shortcode";

        $this->assertEquals( $expected, $shortcode_tags["cart_button"]);
    }

    public function test_cart_icon_should_render_cart_icon_html_as_default_correctly() {
        $expected = "<a href=\"/cart/\"><i class=\"fa fa-shopping-cart\"></i> </a>";
        $actual = do_shortcode( '[cart_button]' );

        $this->assertEquals( $expected, $actual );
    }

    public function test_basket_icon_should_render_cart_icon_html_as_default_correctly() {
        $expected = "<a href=\"/cart/\"><i class=\"fa fa-shopping-basket\"></i> </a>";
        $actual = do_shortcode( '[cart_button icon="basket"]' );

        $this->assertEquals( $expected, $actual );
    }

    public function test_put_any_icon_should_render_any_icon_html_correctly() {
        $expected = "<a href=\"/cart/\"><i class=\"fa fa-truck\"></i> </a>";
        $actual = do_shortcode( '[cart_button icon="truck"]' );

        $this->assertEquals( $expected, $actual );
    }

    public function test_if_no_put_icon_should_not_render_icon_html() {
        $expected = "<a href=\"/cart/\"><i class=\"fa fa-\"></i> </a>";
        $actual = do_shortcode( '[cart_button icon=""]' );

        $this->assertNotEquals( $expected, $actual );
    }

    public function test_show_items_in_the_cart_if_set_show_items_as_true() {
        $expected = "<a href=\"/cart/\"><i class=\"fa fa-shopping-cart\"></i>  (3)</a>";
        $actual = do_shortcode( '[cart_button show_items="true"]' );

        $this->assertEquals( $expected, $actual );
    }

    public function test_not_show_items_in_the_cart_if_set_show_items_as_false() {
        $expected = "<a href=\"/cart/\"><i class=\"fa fa-shopping-cart\"></i> Cart (3)</a>";
        $actual = do_shortcode( '[cart_button show_items="false"]' );

        $this->assertNotEquals( $expected, $actual );
    }

    public function test_show_cart_if_has_item_in_cart_and_set_items_in_cart_text() {
        $expected = "<a href=\"/cart/\"><i class=\"fa fa-shopping-cart\"></i> Cart (3)</a>";
        $actual = do_shortcode( '[cart_button show_items="true" items_in_cart_text="Cart"]' );

        $this->assertEquals( $expected, $actual );
    }

    public function test_should_not_show_cart_text_if_no_item_in_cart() {
        global $woocommerce;
        $woocommerce->cart = new Fake_WC_Empty_Cart;

        $expected = "<a href=\"/cart/\"><i class=\"fa fa-shopping-cart\"></i> Cart (0)</a>";
        $actual = do_shortcode( '[cart_button show_items="true" items_in_cart_text="Cart"]' );

        $this->assertNotEquals( $expected, $actual );
    }

    public function test_put_empty_cart_text_as_store_should_show_text_if_no_product_in_cart() {
        global $woocommerce;

        $woocommerce->cart = new Fake_WC_Empty_Cart;

        $expected = "<a href=\"/shop/\"><i class=\"fa fa-shopping-cart\"></i> Store (0)</a>";
        $actual = do_shortcode( '[cart_button show_items="true" empty_cart_text="Store"]' );

        $this->assertEquals( $expected, $actual );
    }

    public function test_put_custom_class_should_render_html_correctly() {
        $expected = "<a href=\"/cart/\" class=\"custom\"><i class=\"fa fa-shopping-cart\"></i> Cart</a>";
        $actual = do_shortcode( '[cart_button items_in_cart_text="Cart" custom_css="custom"]' );

        $this->assertEquals( $expected, $actual );
    }

    public function test_show_link_to_shop_if_has_no_product_in_cart() {
        global $woocommerce;

        $woocommerce->cart = new Fake_WC_Empty_Cart;

        $expected = "<a href=\"" . $this->shop_url . "\"><i class=\"fa fa-shopping-cart\"></i> Store</a>";
        $actual = do_shortcode( '[cart_button empty_cart_text="Store"]' );

        $this->assertEquals( $expected, $actual );
    }

    public function test_show_link_to_cart_if_has_product_in_cart() {
        $expected = "<a href=\"/cart/\"><i class=\"fa fa-shopping-cart\"></i> Cart</a>";
        $actual = do_shortcode( '[cart_button items_in_cart_text="Cart"]' );

        $this->assertEquals( $expected, $actual );
    }
}
