<?php
/**
 * Plugin Name: WooCommerce Product Categories Selection
 * Plugin Script: product-categories-selection.php
 * Plugin URI: http://pluginforage.com/shop/products/woocommerce-product-categories-selection-widget/
 * Description: The default WooCommerce product categories widget displays all product categories. This WooCommerce Product Categories Selection Plugin allows you to choose which product categores show up in your sidebar widget. Multiple instances can be installed with different WooCommerce product categories showing in each widget installation. Also added is an +/- Expand and Collapse category showing.
 * Author: PluginForage.com
 * Author URI: https://pluginforage.com/100.html
 * Version: 2.0
 *
 * Text Domain: Product Categories
 */

/*  Copyright 2015  PluginForage.com

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
	http://www.gnu.org/licenses/gpl-3.0.en.html
*/
		// Exit if accessed directly
		if ( ! defined( 'ABSPATH' ) ) {
			exit;
		}
		register_activation_hook( __FILE__, 'productcategories_activate');
		register_deactivation_hook( __FILE__, 'productcategories_deactivate');
		register_uninstall_hook( __FILE__, 'productcategories_uninstall');

		add_action( 'plugins_loaded','true_load_plugin_textdomain');


		function true_load_plugin_textdomain() {
			load_plugin_textdomain( 'opentracker-en', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
		}

		/**
		Plugin Install Functions
		*/

		function productcategories_activate() {

		}

		function productcategories_deactivate() {
		    global $wpdb;
            $q = 'DELETE FROM ' . $wpdb->options . '
			WHERE option_name = "widget_woocommerce_product_categories2"';
	        $r = $wpdb->query($q);
		}

		function productcategories_uninstall() {
		}
		include_once(dirname(dirname(__FILE__)). "/woocommerce/includes/abstracts/abstract-wc-widget.php");
		// include_once($_SERVER['DOCUMENT_ROOT']. "/wp-content/plugins/woocommerce/includes/abstracts/abstract-wc-widget.php");
		include_once("class-wc-widget-product-categories2.php");

		function wc_widget_product_categories2_load() {
			register_widget( 'WC_Widget_Product_Categories2' );
		}
		add_action( 'widgets_init', 'wc_widget_product_categories2_load' );

		add_action('admin_menu', 'plugin_admin_add_page');

		function plugin_admin_add_page() {

			add_menu_page( __( "Product Categories Widget",'opentracker'), __( "Product Categories Widget",'opentracker'), 'manage_options', 'productcat');
			add_submenu_page( 'Product Categories Widget', __( "Product Categories Widget",'opentracker'),__( "Product Categories Widget",'opentracker'), 'manage_options', 'productcat', 'add_settings');

		}

		function add_settings() {
            global $wpdb;
           $arr = array();
			echo "<h2>Product Categories Widget Instances</h2>";
            $checked = '';

			$q = 'SELECT option_value
			FROM ' . $wpdb->options . '
			WHERE option_name = "widget_woocommerce_product_categories2"';

	        $r = $wpdb->get_results($q);
	        if($r[0]->option_value) $arr = unserialize($r[0]->option_value);

			$action = isset($_GET['action']) ?  $_GET['action'] : '';
			$id = isset($_REQUEST['id']) ?  $_REQUEST['id'] : '';
			$save = isset($_POST['save']) ?  $_POST['save'] : '';
            $selcat = isset($_POST['selcat']) ?  $_POST['selcat'] : '';

            // echo "<pre>"; print_r($r);

            $qa = 'SELECT meta_value,meta_id,post_id
			FROM ' . $wpdb->postmeta . '
			WHERE meta_key = "panels_data" and post_id IN (SELECT ID
				FROM ' . $wpdb->posts . '
				WHERE post_type = "page")';

				
			
			$res  = $wpdb->get_results($qa);
			if($res > 0)
			{
			foreach($res as $data_for_delete){

			$check_if_page  = $wpdb->get_row('SELECT post_type,post_status
					FROM ' . $wpdb->posts . '
					WHERE ID = "'.$data_for_delete->post_id.'"');
									
					if($check_if_page->post_type == 'revision'  || $check_if_page->post_status == 'trash'){
						$wpdb->query('DELETE FROM ' . $wpdb->postmeta . '
						WHERE meta_key = "panels_data"');
					}
			}
			}			
			$res  = $wpdb->get_results($qa);
// echo "<pre>";print_r($res);
			if($res > 0)
			{
				
				
				
				foreach($res as $data){
					
					$arra = unserialize($data->meta_value);
					
					for($i=0;$i<count($arra);$i++){
						$arra['widgets'][$i]['post_id']=$data->post_id;
					}
					 
					foreach($arra as $ar){
						$arr = array_merge($arr,$ar);
						
					}
				}
				 // echo "<pre>"; print_r($arr);
			}
			
			

			if(!$action) {
		 	  print '<div class="wrap">';

					print '
					<table class="wp-list-table widefat fixed books" style="width:60%;float:left;">
						<thead>
						<tr>
							<th scope="col" id="id" class="manage-column column-id sortable desc" style=""><a href=""><span>WIDGET TITLE</span></a></th></tr>
						</thead>

						<tbody id="the-list" data-wp-lists="list:book">';

                        if(isset($arr) && count($arr) > 0) {
				            foreach($arr as $rec){
						$link = !empty($rec['post_id'])?"&builder=builder":"";
				               print '<tr class="alternate"><td class="name column-name"><a href="?page=' . $_REQUEST['page'] . '&amp;action=edit&amp;id=' . str_replace(" ","_",$rec['title']).$rec['post_id'].$link. '">' . $rec['title']. '</a>
				               </td></tr>';
							}
                         }
					print '</tbody>
					</table>
					<div style="float:right;margin-right:15%;">
						<a href="https://pluginforage.com/100.html" target="_blank"><img src="' .  plugins_url( '/', __FILE__ )  . 'assets/images/PluginForage-ad.png" />
					</div>
					';

			  print '</div>';
			} else {

				

		       if($action == 'edit') {
					if(isset($_GET['builder'])){
					$nam = '';
					$name = explode('_',$id); 
					for($i=0;$i < count($name)-1;$i++ ){
					$nam .=  $name[$i].' ';
					}
					print '<h3>' . $nam . '</h3>';
					}else{
					print '<h3>' . str_replace("_"," ",$id) . '</h3>';
					}

					print '<form action="?page=productcat" method="post">
					<input type="hidden" name="id" value="' . $id . '">';

					$query = 'SELECT option_value
					FROM ' . $wpdb->options . '
					WHERE option_name LIKE "taxonomy_' . $id . '"';

			        $res = $wpdb->get_results($query);

                    $checked_val = unserialize($res[0]->option_value);
                    if(count($checked_val) > 0 && is_array($checked_val)) $keysR = array_keys($checked_val);

					$q = 'SELECT tt.term_id, t.name
					FROM ' . $wpdb->term_taxonomy . ' tt
					LEFT JOIN ' . $wpdb->terms . ' t ON tt.term_id = t.term_id
					WHERE tt.taxonomy = "product_cat" AND tt.parent = 0';
			        $r = $wpdb->get_results($q);

                    $ar = array();
                    if(count($r) > 0) {
	                    foreach($r as $res) {

								if((count($keysR) > 0) && in_array($res->term_id,$keysR)) $checked = 'checked';
                                else $checked = '';

								print "<div style='margin-top:5px;'><input type='checkbox' name='selcat[" . $res->term_id . "]' " . $checked . ">" . $res->name . "</div>";

								$qq = 'SELECT tt.term_id, t.name
								FROM ' . $wpdb->term_taxonomy . ' tt
								LEFT JOIN ' . $wpdb->terms . ' t ON tt.term_id = t.term_id
								WHERE taxonomy = "product_cat" AND parent = '. $res->term_id;
						        $rr = $wpdb->get_results($qq);

                                if(count($rr) > 0) {
	                                foreach($rr as $res) {

                                       if((count($keysR) > 0) && in_array($res->term_id,$keysR)) $checked2 = 'checked';
                                	   else $checked2 = '';

                                       print "<div style='margin-top:5px;padding-left:30px;'><input type='checkbox' name='selcat[" . $res->term_id . "]' " . $checked2 . ">" . $res->name . "</div>";

										$qqq = 'SELECT tt.term_id, t.name
										FROM ' . $wpdb->term_taxonomy . ' tt
										LEFT JOIN ' . $wpdb->terms . ' t ON tt.term_id = t.term_id
										WHERE taxonomy = "product_cat" AND parent = '. $res->term_id;
								        $rrr = $wpdb->get_results($qqq);

		                                if(count($rrr) > 0) {
			                                foreach($rrr as $res) {

                                       			if((count($keysR) > 0) && in_array($res->term_id,$keysR)) $checked3 = 'checked';
                                	  			else $checked3 = '';

		                                       print "<div style='margin-top:5px;padding-left:60px;'><input type='checkbox' name='selcat[" . $res->term_id . "]' " . $checked3 . ">" . $res->name . "</div>";

		                                    }
		                                }

	                                }
                                }
	                    }
                    }

					print '<br />
					<div id="action">
					<span class="spinner"></span>
					<input name="save" type="submit" class="button button-primary button-large" id="save" accesskey="p" value="' . __( "Save",'opentracker') . '" />
					</div>
					<div class="clear"></div>';

			        print '</form>';

				}
			}

			if($save) {

                $selcat_serialize = serialize($selcat);

				$qqq = "DELETE FROM " . $wpdb->prefix . "options
				WHERE option_name = 'taxonomy_". $id .$post_id. "'";
		        $wpdb->query($qqq);


				$qqq = "INSERT INTO " . $wpdb->prefix . "options (`option_name`, `option_value`)
				VALUES('taxonomy_". $id. "','" . $selcat_serialize . "')";
		        $wpdb->query($qqq);
			}
	    }
?>