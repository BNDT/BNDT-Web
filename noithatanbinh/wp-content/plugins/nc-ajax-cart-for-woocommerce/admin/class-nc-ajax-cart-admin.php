<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    nc-ajax-cart-for-woocommerce
 * @subpackage nc-ajax-cart-for-woocommerce/admin
 * @author     Nabaraj Chapagain <nabarajc6@gmail.com>
 */
class NC_Ajax_Cart_Admin {

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
	 * @access   private
	 * @var      string    $version    The current version of the plugin.
	 */	
		
		private $ajax_cart_settings;

	/**
	 * Initialize the class and set its properties.
	 * * @since      1.0.1
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		if(get_option( 'nc_ajax_cart_settings' ))
		{
			$this->ajax_cart_settings=get_option( 'nc_ajax_cart_settings' );
		}
		else
		{
			$this->nc_ajax_cart_default_settings();
		}
		

	}
	
     /**
	 * Register the stylesheets for the admin area.
	 * * @since      1.0.1
	 */	
     public function nc_ajax_cart_default_settings (){

     	$this->ajax_cart_settings=array();
     	$this->ajax_cart_settings['ajax_cart_layout']='default';
     	$this->ajax_cart_settings['ajax_cart_width']='300px';
     	$this->ajax_cart_settings['ajax_cart_enable_image']='1';
     	$this->ajax_cart_settings['ajax_cart_radius']='10';
     	$this->ajax_cart_settings['ajax_cart_padding']='10';
     	$this->ajax_cart_settings['ajax_cart_item_name']='Item';
     	$this->ajax_cart_settings['ajax_cart_item_name_plural']='Items';
     	$this->ajax_cart_settings['ajax_cart_icon_color']='#333333';
     	$this->ajax_cart_settings['ajax_cart_icon_font']='a';
     	$this->ajax_cart_settings['ajax_cart_text_color']='#ffffff';
     	$this->ajax_cart_settings['ajax_cart_link_color']='#ffffff';
     	$this->ajax_cart_settings['ajax_cart_button_text_color']='#ffffff';
     	$this->ajax_cart_settings['ajax_cart_background_color']='#333333';
     	
     	update_option( "nc_ajax_cart_settings", $this->ajax_cart_settings );
     	
     }

	/**
	 * Register the stylesheets for the admin area.
	 * * @since      1.0.1
	 */
	public function nc_ajax_cart_enqueue_styles() {

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
		wp_enqueue_style( 'wp-color-picker' ); 
		wp_enqueue_style( $this->plugin_name.'-slider', plugin_dir_url( __FILE__ )."css/slider.css",array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 * * @since      1.0.1
	 */
	public function nc_ajax_cart_enqueue_scripts() {

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
		wp_enqueue_style( 'wp-color-picker' ); 
		wp_enqueue_script( $this->plugin_name.'-custom-script', plugins_url( 'js/custom-script.js', __FILE__ ), array( 'jquery','wp-color-picker' ), false, true ); 

		

	}
	

	/**
	 * Register new thUmbnail for ajax cart
	 * of the plugin.
	 * * @since      1.0.1
	 * @access   private
	 */		
	
	public  function nc_ajax_cart_register_thumb(){
		
		add_image_size ( "nc_ajax_cart_thumb", "50", "50");
		
	}
	
	/**
	 * Register admin menu for the plugin
	 * of the plugin.
	 * * @since      1.0.1
	 * @access   private
	 */	
	
	public function  nc_ajax_cart_menu(){
		$settings=add_submenu_page('woocommerce', 'Ajax Cart Settings', 'Ajax Cart Settings', 'manage_options', 'nc_ajax_cart',
			array($this, 'nc_ajax_cart_settings_form'));
		add_action( "load-{$settings}", array($this,'nc_ajax_cart_settings_page') );
	}
	
	
	/**
	 * ajax cart settings and redirection
	 * of the plugin.
	 * * @since      1.0.1
	 * @access   private
	 */				
	
	public function nc_ajax_cart_settings_page() {
		if ( isset($_POST["nc_ajax_cart_submit"])) {
			check_admin_referer( "nc_ajax_cart_page" );
			$this->nc_ajax_cart_save_settings();
			$param = isset($_GET['tab'])? 'updated=true&tab='.$_GET['tab'] : 'updated=true';
			wp_redirect(admin_url('admin.php?page=nc_ajax_cart&'.$param));
			exit;
		}
	}		
	
	
	
	/**
	 * ajax cart settings form
	 * of the plugin.
	 * * @since      1.0.1
	 * @access   private
	 */		
	public function nc_ajax_cart_settings_form(){
		
		include_once('includes/nc-ajax-cart-settings-form.php');
	}
	

	/**
	 * ajax cart POST values and update options
	 * of the plugin.
	 * * @since      1.0.1
	 * @access   private
	 */			
	
	public function nc_ajax_cart_save_settings(){
		
		$this->ajax_cart_settings=array();
		if ( isset ( $_GET['page'] )=='nc_ajax_cart') {
			$this->ajax_cart_settings['ajax_cart_layout']=esc_attr($_POST['ajax_cart_layout']);
			$this->ajax_cart_settings['ajax_cart_width']=str_replace('px',' ',esc_attr($_POST['ajax_cart_width']));
			$this->ajax_cart_settings['ajax_cart_enable_image']=esc_attr($_POST['ajax_cart_enable_image']);
			$this->ajax_cart_settings['ajax_cart_radius']=esc_attr($_POST['ajax_cart_radius']);
			$this->ajax_cart_settings['ajax_cart_padding']=esc_attr($_POST['ajax_cart_padding']);
			$this->ajax_cart_settings['ajax_cart_item_name']=esc_attr($_POST['ajax_cart_item_name']);
			$this->ajax_cart_settings['ajax_cart_item_name_plural']=esc_attr($_POST['ajax_cart_item_name_plural']);
			$this->ajax_cart_settings['ajax_cart_icon_color']=esc_attr($_POST['ajax_cart_icon_color']);
			$this->ajax_cart_settings['ajax_cart_icon_font']=esc_attr($_POST['ajax_cart_icon_font']);
			$this->ajax_cart_settings['ajax_cart_text_color']=esc_attr($_POST['ajax_cart_text_color']);
			$this->ajax_cart_settings['ajax_cart_link_color']=esc_attr($_POST['ajax_cart_link_color']);
			$this->ajax_cart_settings['ajax_cart_button_text_color']=esc_attr($_POST['ajax_cart_button_text_color']);
			$this->ajax_cart_settings['ajax_cart_background_color']=esc_attr($_POST['ajax_cart_background_color']);

			
		 //update option
			update_option( "nc_ajax_cart_settings", $this->ajax_cart_settings );

		}	
	}

}
