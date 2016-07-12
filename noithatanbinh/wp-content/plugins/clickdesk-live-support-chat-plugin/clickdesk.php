<?php
/*
Plugin Name: ClickDesk Live Chat, Help Desk & Voice Chat
Plugin URI: http://www.clickdesk.com
Description: Add the fastest <strong>live chat, help desk, voice chat & social toolbar</strong> service to your website for FREE. Receive live chats & calls on your Wordpress dashboard, Gtalk or Skype. This plugin comes with a free plan.
Version: 4.4
Author: ClickDesk
Author URI: http://www.clickdesk.com
License: GPL2
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

// Constants
define('LIVILY_SERVER_URL', "https://my.clickdesk.com/");
define('LIVILY_DASHBOARD_URL', LIVILY_SERVER_URL.'widgets-wp.jsp?cdplugin=wordpress&wpurl=');
define('LIVILY_ICON_URL', "https://contactuswidget.appspot.com/images/getfavicon.png");
// WebChat Panel URL
define('LIVILY_WEBCHAT_PANEL_URL', LIVILY_SERVER_URL.'webchat-plugins.jsp?cdplugin=wordpress&wpurl=');

// Wordpress DB
define( 'LIVILY_DB_OPTION_NAME', 'livily_livechat_option' );

// Save widgetid
function livily_livechat_save_options( $widgetid ) {

	return update_option( LIVILY_DB_OPTION_NAME, $widgetid );

}

//  Get widgetid
function livily_livechat_get_options() {

	$widgetid = get_option( LIVILY_DB_OPTION_NAME );
	return $widgetid;

}

// Remove dbs while Uninstalling
function livily_livechat_uninstall() {
	// Delete all options for db
	delete_option( LIVILY_DB_OPTION_NAME );
}


function lastIndexOf($string,$item){
    $index=strpos(strrev($string),strrev($item));
    if ($index){
        $index=strlen($string)-strlen($item)-$index;
        return $index;
    }
        else
        return -1;
}

function clickdesk_widget_add_scripts() {

	$cdwidgetid = livily_livechat_get_options();

	// If null
    if(strlen($cdwidgetid) == 0)
		return;

	$cdwidgetid = livily_sanatize_widget_id($cdwidgetid);

    wp_enqueue_script('push2call_script_client', plugins_url('/js/widget.js', __FILE__), array('jquery'), '1.0.1',true);

	?>
	<!-- Start of ClickDesk.com live chat Widget -->
	<script  type="text/javascript">

	var _glc =_glc || [];
	_glc.push('<?php echo $cdwidgetid ?>');
	</script>
	<!-- End of ClickDesk.com live chat Widget -->

<?php



}


/******************* ClickDesk Live-Chat Widget Install *******************************************/
if ( ! is_admin() )
	add_action("wp_print_scripts", "clickdesk_widget_add_scripts");

    register_deactivation_hook(__FILE__, 'livily_livechat_uninstall');

/******************* End of ClickDesk Live-Chat Widget Install ************************************/


/********************* Start of Menu Options ***********/

// create custom plugin menu
add_action('admin_menu', 'livily_create_menu');


// Create admin menu
function livily_create_menu() {

   // Create new top-level menu
   add_menu_page('Account Configuration', 'ClickDesk', 'administrator', 'landing', 'livily_dashboard_1',LIVILY_ICON_URL, '79');

   // Dummy menu for
   add_submenu_page('landing1', 'ClickDesk Live-Chat', 'ClickDesk Live-Chat', 'administrator', 'livily_dashboard', 'livily_dashboard');

   // Create submenu for webchat
   add_submenu_page( 'landing', 'ClickDesk Webchat', 'ClickDesk Webchat', 'administrator', 'clickdesk-submenu-page', 'clickdesk_webchat_dashboard' );

}

// ClickDesk Webchat Dashboard
function clickdesk_webchat_dashboard(){

    // Get widgetid from url
    $cdwidgetid = livily_livechat_get_options();

	// Check configuration of ClickDesk
    if(!isset($cdwidgetid) || empty($cdwidgetid)){

		// Show error page for configure
        include ('cd-authentication.php');
		return;

	}

    // Get blog url
    $Path = livily_get_blog_url();

	// Pass this as query param to webchat-plugins page
	$webchatURL = ((isset($cdwidgetid)) && (!empty($cdwidgetid))) ? $cdwidgetid : "";

	$webchatURL = LIVILY_WEBCHAT_PANEL_URL.$Path."&widgetid=".$webchatURL;

    // Add iframe for webchat
    echo '<div id="webchatdashboarddiv"><iframe id="webchatdashboardiframe" src='.livily_sanatize_widget_id($webchatURL).''.' height=800 width=100% scrolling="yes"></iframe></div>';
}

function livily_dashboard_1() {
    include ('cd-landing.php');
}

function livily_sanatize_widget_id($str){
	$str =  htmlspecialchars($str);
    $str = str_replace("&amp;","&",$str);

	return  $str;
}

// ClickDesk Dashboard
function livily_dashboard() {

   $Path = livily_get_blog_url();

   $cdURL= LIVILY_DASHBOARD_URL.$Path;

   $cdwidgetid = $_GET["cdwidgetid"];

   if(strlen($cdwidgetid) != 0){
      $result = livily_livechat_save_options( $cdwidgetid );

	  $mssg = urlencode("Plugin has been installed successfully.");

	  $cdURL = $cdURL."&mssg=".$mssg;

   }

   echo '<div id="dashboarddiv"><iframe id="dashboardiframe" src='.livily_sanatize_widget_id($cdURL).''.' height=700 width=100% scrolling="yes"></iframe></div>';
}

function livily_get_blog_url(){

   $blogURL = get_bloginfo('url');

   $lastindex = lastIndexOf($blogURL,"/");

   $requestURI = $_SERVER['REQUEST_URI'];

   if($lastindex > 8){
      $blogURL = substr($blogURL,0,$lastindex);

   }

   $Path = $blogURL.$requestURI;

   $Path = urlencode($Path);

   return $Path;

}

?>
