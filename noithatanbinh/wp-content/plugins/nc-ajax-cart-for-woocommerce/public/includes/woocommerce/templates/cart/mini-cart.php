<?php
/**
 * Mini-cart
 *
 * Contains the markup for the mini-cart, used by the cart widget
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$nc_ajax_cart_settings=get_option('nc_ajax_cart_settings');

?>

<div id="cart-data">
<?php do_action( 'woocommerce_before_mini_cart' ); ?>
<div  class="cart_list product_list_widget <?php echo $args['list_class']; ?>">

	<?php if ( ! WC()->cart->is_empty() ) : ?>
  <table>
		<?php
			foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
				$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
				$product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

				if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ) {

					$product_name  = apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key );
					$thumbnail     = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image('nc_ajax_cart_thumb'), $cart_item, $cart_item_key );
					$product_price = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
					?>
				<tr class="<?php echo esc_attr( apply_filters( 'woocommerce_mini_cart_item_class', 'mini_cart_item', $cart_item, $cart_item_key ) ); ?>">
                  <td class="remove-icon">
                    
						<?php
						echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
							'<a href="%s" id="nc_ajax_cart_remove"  class="remove" title="%s" data-product_id="%s" data-product_sku="%s" data-cart-key="%s">&times;</a>',
							'javascript:void(0)',
							__( 'Remove this item', 'nc-ajax-cart-for-woocommerce' ),
							esc_attr( $product_id ),
							esc_attr( $_product->get_sku() ),
							$cart_item_key
						), $cart_item_key );
						?>
                        </td>
                        <?php if($nc_ajax_cart_settings['ajax_cart_enable_image']==1){ ?>
                        <td>
						<?php
						
						 if ( ! $_product->is_visible() ) : ?>
							<?php echo str_replace( array( 'http:', 'https:' ), '', $thumbnail ) . '&nbsp;'; ?>
						<?php else : ?>
							<a href="<?php echo esc_url( $_product->get_permalink( $cart_item ) ); ?>">
								<?php echo str_replace( array( 'http:', 'https:' ), '', $thumbnail )  . '&nbsp;'; ?>
							</a>
						<?php 
								endif; 
								
						?>
                       </td>
                       <?php } ?>
                       <td>
                       <a href="<?php echo esc_url( $_product->get_permalink( $cart_item ) ); ?>">
                        <?php echo  $product_name  ?>
                        </a>
						<?php echo WC()->cart->get_item_data( $cart_item ); ?>
                        
                         </td>
                         <td class="item-price">

						<?php echo apply_filters( 'woocommerce_widget_cart_item_quantity', '<span class="quantity">' . sprintf( '%s &times; %s', $cart_item['quantity'], $product_price ) . '</span>', $cart_item, $cart_item_key ); ?>
                       
                    </td>
				 </tr>
					<?php
				}
			}
		?>
    </table>
	<?php else : ?>

		<div class="empty"><?php _e( 'No products in the cart.', 'nc-ajax-cart-for-woocommerce' ); ?></div>

	<?php endif; ?>

</div><!-- end product list -->

<?php if ( ! WC()->cart->is_empty() ) : ?>

	<p class="total"><strong><?php _e( 'Subtotal', 'nc-ajax-cart-for-woocommerce' ); ?>:</strong> <?php echo WC()->cart->get_cart_subtotal(); ?></p>

	<?php do_action( 'woocommerce_widget_shopping_cart_before_buttons' ); ?>
<div  class="woocommerce">
	<ul>
		<li><a href="<?php echo WC()->cart->get_cart_url(); ?>" class="button wc-forward"><?php _e( 'View Cart', 'nc-ajax-cart-for-woocommerce' ); ?></a>
        <a href="<?php echo WC()->cart->get_checkout_url(); ?>" class="button checkout wc-forward"><?php _e( 'Checkout', 'nc-ajax-cart-for-woocommerce' ); ?></a></li>
	</ul>
</div>
<?php endif; ?>


<?php do_action( 'woocommerce_after_mini_cart' ); ?>
</div>


