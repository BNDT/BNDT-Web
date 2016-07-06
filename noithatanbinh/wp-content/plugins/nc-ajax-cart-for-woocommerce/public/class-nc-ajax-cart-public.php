<?php

/**
 * The public-facing functionality of the plugin.
 * * @since      1.0.1
 *
 * @package    nc-ajax-cart-for-woocommerce
 * @subpackage nc-ajax-cart-for-woocommerce/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    nc-ajax-cart-for-woocommerce
 * @subpackage nc-ajax-cart-for-woocommerce/public
 * @author     Nabaraj Chapagain <nabarajc6@gmail.com>
 */
class NC_Ajax_Cart_Public {

	/**
	 * The ID of this plugin.
	 * * @since      1.0.1
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 * * @since      1.0.1
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;
	
			/**
	 * The ajax cart settings
	 * * @since      1.0.1
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */	

			private $ajax_cart_settings;

	/**
	 * Initialize the class and set its properties.
	 * * @since      1.0.1
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->ajax_cart_settings=get_option( 'nc_ajax_cart_settings' );
		add_shortcode( 'nc_ajax_cart', array(&$this,'nc_ajax_cart_display_shortcode'));

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 * * @since      1.0.1
	 */
	public function nc_ajax_cart_public_enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in nc-ajax-cart-for-woocommerce_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The nc-ajax-cart-for-woocommerce_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name.'default-css', plugin_dir_url( __FILE__ )."css/nc_ajax_cart_style_default.css", array(), $this->version, 'all' ); 

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 * * @since      1.0.1
	 */
	public function nc_ajax_cart_public_enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in nc-ajax-cart-for-woocommerce_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The nc-ajax-cart-for-woocommerce_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

	//	wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/plugin-name-public.js', array( 'jquery' ), $this->version, false );

	}
	
	
	/**
	 * register shortcode for ajax cart
	 * * @since      1.0.1
	 */
	
	function nc_ajax_cart_display_shortcode( ) {
		global $woocommerce;  
		$settings=$this->ajax_cart_settings;
		$font=!empty($settings['ajax_cart_icon_font']) ? $settings['ajax_cart_icon_font'] : 'a';
		$singular=!empty($settings['ajax_cart_item_name']) ? $settings['ajax_cart_item_name'] : 'Item';
		$plural=!empty($settings['ajax_cart_item_name_plural']) ? $settings['ajax_cart_item_name_plural'] : 'Items';
		$item_count=WC()->cart->cart_contents_count;
		?>
		<a id="nc_ajax_cart_snippet" href="javascript:void(0)">
			<span class="nc_ajax_cart_icon_font"><?php  echo $font; ?></span>
			<?php echo sprintf (_n( '%d '.$singular, '%d '.$plural,$item_count,$this->plugin_name), $item_count); ?> - 
			<?php echo WC()->cart->get_cart_total(); ?></a>
			<?php
			if ($item_count == 0 ) {

				echo '<div id="nc_ajax_cart_mini_cart" style="display:none">No Item found on your cart::</div>';
			}
			else{
				echo '<div id="nc_ajax_cart_mini_cart" style="display:none">';
				include_once('woocommerce/templates/cart/mini-cart.php') ;		
				echo '</div>';
			}
		}

	/**
	 * nc ajax cart custom script
	 * * @since      1.0.1
	 */			
	function nc_ajax_cart_custom_script() {	
		$this->ajax_cart_settings=get_option('nc_ajax_cart_settings');
		if($this->ajax_cart_settings['ajax_cart_layout']=='custom'){ ?>      
			<style type='text/css'>@font-face{font-family:CartFont;src:url(<?php echo plugin_dir_url( __FILE__ )?>fonts/cartographer-webfont.eot);src:url(<?php echo  plugin_dir_url( __FILE__ )?>fonts/cartographer-webfont.eot?#iefix) format('embedded-opentype'),url(<?php echo  plugin_dir_url( __FILE__ )?>fonts/cartographer-webfont.woff) format('woff'),url(<?php echo  plugin_dir_url( __FILE__ )?>fonts/cartographer-webfont.ttf) format('truetype'),url(<?php echo  plugin_dir_url( __FILE__ )?>fonts/cartographer-webfont.svg#cartographer-webfont) format('svg')}#nc_ajax_cart_mini_cart{z-index:99999;width:<?php echo trim($this->ajax_cart_settings['ajax_cart_width'])?>px;color:<?php echo $this->ajax_cart_settings['ajax_cart_text_color']?>;position:absolute;background:<?php echo $this->ajax_cart_settings['ajax_cart_background_color'];?>;border-radius:<?php echo $this->ajax_cart_settings['ajax_cart_radius']?>px;padding:<?php echo $this->ajax_cart_settings['ajax_cart_padding']?>px;}a#nc_ajax_cart_snippet{color:#333}#nc_ajax_cart_mini_cart table{width:100%}#nc_ajax_cart_mini_cart table,#nc_ajax_cart_mini_cart table tr,#nc_ajax_cart_mini_cart table tr td{color:<?php echo !empty($this->ajax_cart_settings['ajax_cart_text_color']) ? $this->ajax_cart_settings['ajax_cart_text_color'] : '#333333'?>;vertical-align:middle;font-size:14px;text-align:center}#nc_ajax_cart_mini_cart p.total,#nc_ajax_cart_mini_cart td.item-price{text-align:right}.icon-font{cursor:pointer}.nc_ajax_cart_icon_font{font-family:CartFont;padding-right:10px;font-size:20px;color:<?php echo !empty($this->ajax_cart_settings['ajax_cart_icon_color']) ? $this->ajax_cart_settings['ajax_cart_icon_color'] : '#333333' ?>}a#nc_ajax_cart_snippet{text-decoration:none;font-size:16px}.mini_cart_item a,.mini_cart_item a:hover,.mini_cart_item a:visited{color:<?php echo !empty($this->ajax_cart_settings['ajax_cart_link_color']) ? $this->ajax_cart_settings['ajax_cart_link_color'].'!important' : '#333333' ?>;text-decoration:none}#nc_ajax_cart_mini_cart .woocommerce ul li{list-style:none;display:inline;margin:0!important;padding:0!important;float:right}#nc_ajax_cart_mini_cart a.button{color:<?php echo !empty($this->ajax_cart_settings['ajax_cart_button_text_color']) ? $this->ajax_cart_settings['ajax_cart_button_text_color'] : '#333333'?>;}#nc_ajax_cart_mini_cart .woocommerce ul::after{clear:both}#nc_ajax_cart_mini_cart tr.mini_cart_item td{border:none!important}tr.mini_cart_item td img{max-width:50px;height:auto}#nc_ajax_cart_mini_cart dl.variation dt,#nc_ajax_cart_mini_cart dl.variation p{font-size:11px}#nc_ajax_cart_mini_cart td.remove-icon a{font-size:20px;color:red;font-weight:700}</style>
			<?php 	} ?>
			<script type="text/javascript">
				jQuery.noConflict();
				jQuery(document).ready(function($){	
					$(document).on("click","#nc_ajax_cart_snippet",function()
					{
						$("#nc_ajax_cart_mini_cart").slideToggle();

					});		
					$(document).on("click","tr.mini_cart_item td a",function(){
						$(this).html('<img src="<?php echo plugin_dir_url( __FILE__ ); ?>/images/ajax-loader.gif" />');
						var cart_item_key = $(this).attr("data-cart-key");
						jQuery.ajax({
							type: 'POST',
							dataType: 'json',
							url: "<?php echo admin_url('admin-ajax.php'); ?>",
							data: { action: "nc_ajax_cart_product_remove", 
							cart_item_key: cart_item_key
						},
						success: function(response){
							fragments = response.fragments;
							if ( fragments ) {
								$.each(fragments, function(key, value) {
									$(key).replaceWith(value);
									$("#nc_ajax_cart_mini_cart").show();
								});

							}
						}
					});
					});

				});
			</script>
			<?php
			

		}


	/**
	 * ajax cart add to cart fragments	
	 * * @since      1.0.1
	 */



	function nc_ajax_cart_add_to_cart_fragment( $fragments ) {
		global $woocommerce;
		$settings=$this->ajax_cart_settings;
		$font=!empty($settings['ajax_cart_icon_font']) ? $settings['ajax_cart_icon_font'] : 'a';
		$singular=!empty($settings['ajax_cart_item_name']) ? $settings['ajax_cart_item_name'] : 'Item';
		$plural=!empty($settings['ajax_cart_item_name_plural']) ? $settings['ajax_cart_item_name_plural'] : 'Items';
		$item_count=WC()->cart->cart_contents_count;
		ob_start();
		?>
		<a id="nc_ajax_cart_snippet" href="javascript:void(0)">
			<span class="nc_ajax_cart_icon_font"><?php  echo $font; ?></span>
			<?php echo sprintf (_n( '%d '.$singular, '%d '.$plural,$item_count,$this->plugin_name),$item_count); ?> - 
			<?php echo WC()->cart->get_cart_total(); ?></a>
			<?php

			$fragments['a#nc_ajax_cart_snippet'] = ob_get_clean(); 
			if ( WC()->cart->get_cart_contents_count() == 0 ) {

				echo '<div id="nc_ajax_cart_mini_cart" style="display:none">No Item found on your cart::</div>';
			}
			else{
				echo '<div id="nc_ajax_cart_mini_cart" style="display:none">';
				include_once('includes/woocommerce/templates/cart/mini-cart.php') ;		
				echo '</div>';
			}
			$fragments['div#nc_ajax_cart_mini_cart'] = ob_get_clean();

			return $fragments;
		}

	/**
	 *  ajax cart product remove fragements
	 * * @since      1.0.1
	 */	
	
	function nc_ajax_cart_product_remove(){
		global $woocommerce;
		$ajax=new WC_AJAX();
		$cart = WC()->instance()->cart;
		$item_key = $_POST['cart_item_key'];
		$woocommerce->cart->set_quantity( $item_key , 0 );
		$ajax->get_refreshed_fragments();			
	}

}
