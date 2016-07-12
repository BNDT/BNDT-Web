<?php

class Zopim_Linked_View extends Zopim_Base_View
{
  protected function set_messages()
  {
    $this->_messages = array(
      'options-updated'        => __( 'Widget options updated.', 'zopim-live-chat' ),
      'trial'                  => __( 'Trial Plan with 14 Days Full-features', 'zopim-live-chat' ),
      'plan'                   => __( ' Plan', 'zopim-live-chat' ),
      'deactivate'             => __( 'Deactivate', 'zopim-live-chat' ),
      'current-account-label'  => __( 'Currently Activated Account', 'zopim-live-chat' ),
      'dashboard-access-label' => __( 'To start using Zopim chat, launch our dashboard for access to all features, including widget customization!', 'zopim-live-chat' ),
      'launch-dashboard'       => __( 'Launch Dashboard', 'zopim-live-chat' ),
      'open-tab-label'         => __( 'This will open up a new browser tab', 'zopim-live-chat' ),
      'textarea-label'         => __( 'Optional code for customization with Zopim API:', 'zopim-live-chat' ),
      'page-header'            => __( 'Set up your Zopim Account', 'zopim-live-chat' ),
    );
  }

  /**
   * Handles POST request when saving the Widget Options form.
   */
  public function update_widget_options()
  {
    $notices = Zopim_Notices::get_instance();

    if (!( isset($_POST['_wpnonce'] ) ) || (! wp_verify_nonce($_POST['_wpnonce'], 'zopim_widget_options'))) {
      update_option( Zopim_Options::ZOPIM_OPTION_SALT, 'wronglogin' );
      $notices->add_notice( 'before_udpate_widget_textarea', 'Invalid CSRF token. Please try re-sending the request.', 'error' );
    } else {
      $opts = $_POST[ 'widget-options' ];
      update_option( Zopim_Options::ZOPIM_OPTION_WIDGET, $opts );
      $notices->add_notice( 'before_udpate_widget_textarea', '<i>' . $this->get_message( 'options-updated' ) . '<br/></i>', 'notice' );
    }

  }

  /**
   * Renders the Zopim update options form.
   *
   * @param object Account details retrieved from the Zopim API
   */
  public function display_linked_view( $accountDetails )
  {
    if ( $accountDetails->package_id == 'trial' ) {
      $accountDetails->package_id = $this->get_message( 'trial' );
    } else {
      $accountDetails->package_id .= $this->get_message( 'plan' );
    }

    Zopim_Template::load_template( 'linked-view', array_merge( array( 'messages' => $this->_messages ), (array)$accountDetails ) );
  }
}
