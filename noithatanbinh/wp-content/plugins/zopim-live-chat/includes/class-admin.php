<?php

class Zopim_Admin
{
  private static $_instance = NULL;

  private function __construct()
  {
    add_action( 'admin_enqueue_scripts', array( &$this, 'load_zopim_style' ) );
    add_action( 'admin_init', array( &$this, 'add_zopim_caps' ) );
    //call register settings function
    add_action( 'admin_init', array( &$this, 'register_zopim_plugin_settings' ) );
    add_action( 'admin_menu', array( &$this, 'zopim_create_menu' ) );
  }

  /**
   * [get_instance description]
   * @return [type] [description]
   */
  public static function get_instance()
  {
    if ( self::$_instance === NULL )
      self::$_instance = new self();

    return ( self::$_instance );
  }

  public function load_zopim_style()
  {
    wp_register_style( 'zopim_style', Zopim::get_asset( 'css/zopim.css' ) );
    wp_enqueue_style( 'zopim_style' );
    wp_register_script( 'zopim_js', Zopim::get_asset( 'js/zopim.js' ) );
    wp_enqueue_script( 'zopim_js' );
  }

  public function zopim_create_menu()
  {
    //create new top-level menu
    add_menu_page( __( 'Account Configuration', 'zopim-live-chat' ), __( 'Zopim Chat', 'zopim-live-chat' ), 'access_zopim', 'zopim_account_config', array( &$this, 'zopim_account_config' ), ZOPIM_SMALL_LOGO );
  }


  public function add_zopim_caps()
  {
    $role = get_role( 'administrator' );
    $role->add_cap( 'access_zopim' );
  }

  // Register the option settings we will be using
  public function register_zopim_plugin_settings()
  {
    // Authentication and codes
    register_setting( 'zopim-settings-group', Zopim_Options::ZOPIM_OPTION_CODE );
    register_setting( 'zopim-settings-group', Zopim_Options::ZOPIM_OPTION_USERNAME );
    register_setting( 'zopim-settings-group', Zopim_Options::ZOPIM_OPTION_SALT );
  }

  /**
   * Determines which page to display when viewing the plugin admin page and then displays it.
   */
  public function zopim_account_config()
  {
    $notices = Zopim_Notices::get_instance();
    $login = new Zopim_Login();
    $linkedView = new Zopim_Linked_View();
    ?>
    <div class="wrap">
    <?php
    if ( isset( $_GET[ 'action' ] ) && $_GET[ 'action' ] == 'deactivate' ) {
      update_option( Zopim_Options::ZOPIM_OPTION_SALT, '' );
      update_option( Zopim_Options::ZOPIM_OPTION_CODE, 'zopim' );
    }

    $authenticated = FALSE;

    if ( isset( $_POST[ 'action' ] ) && $_POST[ 'action' ] == 'login' ) {
      $login->do_login();
    }

    if ( get_option( Zopim_Options::ZOPIM_OPTION_CODE ) != '' && get_option( Zopim_Options::ZOPIM_OPTION_CODE ) != 'zopim' ) {
      $accountDetails = $this->zopim_get_account_details( get_option( Zopim_Options::ZOPIM_OPTION_SALT ) );

      if ( !isset( $accountDetails ) || isset( $accountDetails->error ) ) {
        $authError = '
	 <div class="metabox-holder">
	<div class="postbox">
		<h3 class="hndle"><span>' . __( 'Account no longer linked!', 'zopim-live-chat' ) . '</span></h3>
		<div class="zopim-auth-error-message">' .
          __( 'We could not verify your Zopim account. Please check your password and try again.', 'zopim-live-chat' )
          . '</div>
	</div>
	 </div>';
        $notices->add_notice( 'before_login', $authError, 'error' );
      } else {

        $authenticated = TRUE;
      }
    }

    if ( $authenticated ) {
      if ( isset( $_POST[ 'widget-options' ] ) ) {
        $linkedView->update_widget_options();
      }
      $linkedView->display_linked_view( $accountDetails );
    } else {
      $login->display_login_form();
    }
  }

  /**
   * Makes a POST request to the Zopim API.
   *
   * @param $url The full url endpoint to access.
   * @param $_data The data to pass to the request.
   * @return array|string
   */
  public function zopim_post_request( $url, $_data )
  {
    $args = array(
      'body' => $_data,
      'user-agent' => ZOPIM_USER_AGENT,
    );
    $response = wp_remote_post( $url, $args );
    if ( is_wp_error( $response ) ) {
      $error = array( 'wp_error' => $response->get_error_message() );

      return json_encode( $error );
    }

    return $response[ 'body' ];
  }

  /**
   * Gets the current user's Zopim account details.
   *
   * @return array|mixed
   */
  public function zopim_get_account_details()
  {
    $salty = array( "salt" => get_option( Zopim_Options::ZOPIM_OPTION_SALT ) );

    return json_decode( $this->zopim_post_request( ZOPIM_GETACCOUNTDETAILS_URL, $salty ) );
  }
}
