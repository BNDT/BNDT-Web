<?php

/*
 * Plugin Name: WooDiscuz - WooCommerce Comments
 * Description: WooCommerce product comments and discussion Tab. Allows your customers to discuss about your products and ask pre-sale questions. Adds a new "Discussions" Tab next to "Reviews" Tab. Your shop visitors will thank you for ability to discuss about your products directly on your website product page. WooDiscuz also allows to vote for comments and share products.
 * Version: 2.0.10
 * Author: gVectors Team (A. Chakhoyan, G. Zakaryan, H. Martirosyan)
 * Author URI: http://gvectors.com/
 * Plugin URI: http://woodiscuz.com/
 * Text Domain: wpdiscuz
 * Domain Path: /languages/
 */

define('WOODISCUZDS', DIRECTORY_SEPARATOR);

include_once 'options' . WOODISCUZDS . 'wpc-options.php';
include_once 'options' . WOODISCUZDS . 'wpc-options-serialize.php';
include_once 'includes' . WOODISCUZDS . 'wpc-helper.php';
include_once 'includes' . WOODISCUZDS . 'wpc-db-helper.php';
include_once 'comment-form' . WOODISCUZDS . 'tpl-comment.php';
include_once 'dto' . WOODISCUZDS . 'wpc-comment.php';
include_once 'wpc-css.php';
include_once 'widgets' . WOODISCUZDS . 'widget-woocommerce-reviews.php';
include_once 'widgets' . WOODISCUZDS . 'widget-woodiscuz-comments.php';

class WPC_Core {

    private $wpc_options;
    private $wpc_options_serialized;
    private $comment_types;
    private $reviews_count;
    private $wpc_db_helper;
    private $wpc_helper;
    private $comment_tpl_builder;
    private $wpc_css;
    private $wpc_parent_comments_count;
    public $commetns_count = 0;
    private $comment_count_text;
    public static $PLUGIN_DIRECTORY;
    public $woodiscuz_version = 'woodiscuz_version';
    public $wpc_user_agent = '';

    function __construct() {
        $this->wpc_user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
        add_action('plugins_loaded', array(&$this, 'load_woodiscuz_text_domain'));
        add_action('init', array(&$this, 'init_plugin_dir_name'), 1);

        $this->wpc_db_helper = new WPC_DB_Helper();
        $this->wpc_options_serialized = new WPC_Options_Serialize($this->wpc_db_helper);
        $this->wpc_options = new WPC_Options($this->wpc_options_serialized, $this->wpc_db_helper);

        register_activation_hook(__FILE__, array($this, 'db_operations'));

        $this->wpc_helper = new WPC_Helper($this->wpc_options_serialized);
        $this->wpc_css = new WPC_CSS($this->wpc_options_serialized);
        $this->comment_tpl_builder = new WPC_Comment_Template_Builder($this->wpc_helper, $this->wpc_db_helper, $this->wpc_options_serialized);

        add_action('admin_init', array(&$this, 'wpc_plugin_new_version'), 2);
        if (!$this->wpc_options_serialized->wpc_captcha_show_hide) {
            add_action('init', array(&$this, 'register_session'), 2);
        }
        add_action('admin_notices', array($this, 'woop_disscus_requirements'));

        add_action('admin_enqueue_scripts', array(&$this, 'admin_page_styles_scripts'), 2315);
        add_action('wp_enqueue_scripts', array(&$this, 'front_end_styles_scripts'));
        add_action('wp_enqueue_scripts', array(&$this->wpc_css, 'init_styles'));

        add_action('admin_menu', array(&$this, 'add_plugin_options_page'), -191);

        add_action('wp_ajax_wpc_comms_via_ajax', array(&$this, 'comment_submit_via_ajax'));
        add_action('wp_ajax_nopriv_wpc_comms_via_ajax', array(&$this, 'comment_submit_via_ajax'));

        add_action('wp_ajax_wpc_load_more_comments', array(&$this, 'load_more_comments'));
        add_action('wp_ajax_nopriv_wpc_load_more_comments', array(&$this, 'load_more_comments'));

        add_action('wp_ajax_wpc_vote_via_ajax', array(&$this, 'vote_on_comment'));
        add_action('wp_ajax_nopriv_wpc_vote_via_ajax', array(&$this, 'vote_on_comment'));

        add_action('wp_ajax_wpc_check_notification_type', array(&$this, 'wpc_check_notification_type'));
        add_action('wp_ajax_nopriv_wpc_check_notification_type', array(&$this, 'wpc_check_notification_type'));
        add_action('comment_post', array(&$this, 'wpc_check_notification_type_admin_panel'),157,2);

        add_action('wp_ajax_woodiscuz_comment_redirect', array(&$this, 'woodiscuz_comment_redirect'));
        add_action('wp_ajax_nopriv_woodiscuz_comment_redirect', array(&$this, 'woodiscuz_comment_redirect'));

        if ($this->wpc_options_serialized->wpc_comment_editable_time) {
            add_action('wp_ajax_wpc_get_editable_comment_content', array(&$this, 'wpc_get_editable_comment_content'));
            add_action('wp_ajax_nopriv_wpc_get_editable_comment_content', array(&$this, 'wpc_get_editable_comment_content'));
            add_action('wp_ajax_wpc_save_edited_comment', array(&$this, 'wpc_save_edited_comment'));
            add_action('wp_ajax_nopriv_wpc_save_edited_comment', array(&$this, 'wpc_save_edited_comment'));
        }

        add_action('get_avatar_comment_types', array(&$this, 'woodiscuz_review_avatar'));
        add_action('widgets_init', array(&$this, 'init_widgets'));

        add_filter('woocommerce_product_tabs', array(&$this, 'add_comment_tab'), 90);

        if ($this->wpc_options_serialized->wpc_tab_show_hide) {
            add_filter('woocommerce_product_tabs', array(&$this, 'woo_hide_reviews_tab'), 98);
        }
        add_filter('admin_comment_types_dropdown', array(&$this, 'add_comment_type'));
        add_filter('wp_list_comments_args', array(&$this, 'wpc_list_comments_args'), 15);
        add_filter('preprocess_comment', array(&$this, 'wpc_new_comment'));

        add_filter('woocommerce_product_reviews_tab_title', array(&$this, 'wpc_rename_reviews_tab'));
        $plugin = plugin_basename(__FILE__);
        add_filter("plugin_action_links_$plugin", array(&$this, 'wpc_add_plugin_settings_link'));

        if ($this->wpc_options_serialized->wpc_request_for_comment) {
            add_action('woocommerce_order_status_completed', array(&$this, 'email_request_for_comment'));
        }

        add_filter('woocommerce_product_review_count', array(&$this, 'woodiscuz_get_reviews_count'), 1234);
        add_action('transition_comment_status', array(&$this, 'wpc_notify_to_subscriber'), 265, 3);
        add_filter('comments_clauses', array(&$this, 'getCommentsArgs'), 265, 2);
        add_action('init', array(&$this->wpc_options_serialized, 'init_phrases_on_load'), 126);
    }

    public function getCommentsArgs($args, $obj) {
        global $post;
        if (isset($post) && $obj->query_vars['type'] != 'woodiscuz' && $post->post_type == 'product') {
            $args['where'] .= " AND `comment_type` = 'woodiscuz_review' ";
        }
        return $args;
    }

    public function woodiscuz_get_reviews_count() {
        global $post;
        $this->reviews_count = $this->wpc_db_helper->get_reviews_count('woodiscuz_review', $post->ID);
        return $this->reviews_count;
    }

    public function load_woodiscuz_text_domain() {
        load_plugin_textdomain('woodiscuz', false, dirname(plugin_basename(__FILE__)) . '/languages/');
    }

    public function woop_disscus_requirements() {
        if (!is_plugin_active('woocommerce/woocommerce.php')) {
            echo "<div class='error'><p>" . __('WooDiscuz requires Woocommerce to be installed!', 'woodiscuz') . "</p></div>";
        }
        if ($this->wpc_db_helper->get_empty_comment_types()) {
            echo "<div class='update-nag woocommerce-message wc-connect' style='width:95%'>
						Please click on this button to start using WooDiscuz&nbsp; -&nbsp; <a class='woodiscuz_update_reviews button-primary' href='" . admin_url() . "admin.php?page=woodiscuz_options_page&woodiscuz_update_reviews=s3wc8fs4x1erg5'>Synchronize with WooCommerce</a>
				  		<br /><span style=\"font-size:12px;\">WooCommerce doesn't have its own comment type for product reviews, this synchronization will not allow any conflicts with WooDiscuz comments.</span>
				  </div>";
        }
    }

    /**
     * create table
     * updates the comments to set comment type review if comment id is exists in comment meta table
     */
    public function db_operations() {
        $this->wpc_db_helper->create_tables();
    }

    public function wpc_plugin_new_version() {
        $wpc_version = (!get_option($this->woodiscuz_version) ) ? '1.0.0' : get_option($this->woodiscuz_version);
        $wpc_plugin_data = get_plugin_data(__FILE__);
        if (version_compare($wpc_plugin_data['Version'], $wpc_version, '>')) {
            $this->wpc_add_new_options();
            $this->wpc_add_new_phrases();
            if ($wpc_version === '1.0.0') {
                add_option($this->woodiscuz_version, $wpc_plugin_data['Version']);
            } else {
                update_option($this->woodiscuz_version, $wpc_plugin_data['Version']);
            }

            if (version_compare($wpc_version, '1.2.0', '<') && version_compare($wpc_version, '1.0.0', '!=')) {
                $this->wpc_db_helper->wpc_alter_voting_phrases_tables();
            }
        }
    }

    private function wpc_add_new_options() {
        $this->wpc_options_serialized->init_options(get_option($this->wpc_options_serialized->wpc_options_slug));
        $wpc_new_options = $this->wpc_options_serialized->to_array();
        update_option($this->wpc_options_serialized->wpc_options_slug, serialize($wpc_new_options));
    }

    private function wpc_add_new_phrases() {
        if ($this->wpc_db_helper->is_phrase_exists('wpc_discuss_tab')) {
            $wpc_saved_phrases = $this->wpc_db_helper->get_phrases();
            $this->wpc_options_serialized->init_phrases();
            $wpc_phrases = $this->wpc_options_serialized->wpc_phrases;
            $wpc_new_phrases = array_merge($wpc_phrases, $wpc_saved_phrases);
            $this->wpc_db_helper->update_phrases($wpc_new_phrases);
        }
    }

    /*
     * register new session
     */

    public function register_session() {
        if (!session_id() && !is_user_logged_in()) {
            @session_start();
        }
    }

    /**
     * Register widgets
     */
    public function init_widgets() {
        register_widget('WooDiscuz_Reviews_Widget');
        register_widget('WooDiscuz_Comments_Widget');
    }

    public function wpc_rename_reviews_tab() {
        return _e('Reviews', 'woocommerce') . '(' . $this->reviews_count . ')';
    }

    /*
     * add comment tab 
     */

    public function add_comment_tab($tabs) {
        global $post;
        $this->commetns_count = $this->wpc_db_helper->get_comment_count($post->ID);
        $this->comment_count_text = ($this->commetns_count > 0) ? "(" . $this->commetns_count . ")" : "";
        $priority = abs(intval($this->wpc_options_serialized->wpc_comment_tab_priority)) ? abs(intval($this->wpc_options_serialized->wpc_comment_tab_priority)) : 1000;
        $priority = $this->wpc_helper->wpc_set_priorities($tabs, $priority);
        $wpc_comment_tab = array(
            'title' => $this->wpc_options_serialized->wpc_phrases['wpc_discuss_tab'] . $this->comment_count_text,
            'priority' => $priority,
            'callback' => array(&$this, 'wpc_comment_tab_content')
        );
        $tabs['wpc_comment_tab'] = $wpc_comment_tab;
        return $tabs;
    }

    public function wpc_comment_tab_content() {
        include 'comment-form/form.php';
    }

    /*
     * Hide WooCommerce Review Tab 
     */

    function woo_hide_reviews_tab($tabs) {
        if (isset($tabs['reviews'])) {
            unset($tabs['reviews']);    // Remove the reviews tab
        }
        return $tabs;
    }

    /*
     * add new comment type 
     */

    public function add_comment_type($args) {
        $this->comment_types = $args;
        $args['woodiscuz'] = __('WooDiscuz', 'woodiscuz');
        $args['woodiscuz_review'] = __('Woocomerce Review', 'woodiscuz');
        return $args;
    }

    /**
     * change comment type 
     */
    public function wpc_new_comment($commentdata) {
        $commentdata['comment_type'] = isset($commentdata['comment_type']) ? $commentdata['comment_type'] : '';
        $comment_post = get_post($commentdata['comment_post_ID']);
        if ($comment_post->post_type === 'product' && $commentdata['comment_type'] != 'woodiscuz') {
            $com_parent = $commentdata['comment_parent'];
            if ($com_parent != 0) {
                $parent_comment = get_comment($com_parent);
                if ($parent_comment->comment_type == 'woodiscuz') {
                    $commentdata['comment_type'] = 'woodiscuz';
                } else {
                    $commentdata['comment_type'] = 'woodiscuz_review';
                }
            } else {
                $commentdata['comment_type'] = 'woodiscuz_review';
            }
        }
        return $commentdata;
    }

    /**
     * register options page for plugin
     */
    public function add_plugin_options_page() {
        if (function_exists('add_options_page')) {
            add_menu_page('WooDiscuz', 'WooDiscuz', 'manage_options', 'woodiscuz_options_page', array(&$this->wpc_options, 'main_options_form'), plugins_url(WPC_Core::$PLUGIN_DIRECTORY . '/files/img/plugin-icon/plugin-icon-20.png'), 1245);
            if (!$this->wpc_options_serialized->wpc_is_use_po_mo) {
                add_submenu_page('woodiscuz_options_page', 'Phrases', 'Phrases', 'manage_options', 'woodiscuz_phrases_page', array(&$this->wpc_options, 'phrases_options_form'));
            }
        }
    }

    /**
     * Styles and scripts registration to use on front page
     */
    public function front_end_styles_scripts() {


        $u_agent = $_SERVER['HTTP_USER_AGENT'];

        if (preg_match('/MSIE/i', $u_agent)) {
            wp_enqueue_script('woodiscuz-html5-js', plugins_url(WPC_Core::$PLUGIN_DIRECTORY . '/files/third-party/tooltipster/js/html5.js'), array('jquery'), '1.2', false);

            wp_register_style('woodiscuz-modal-css-ie', plugins_url(WPC_Core::$PLUGIN_DIRECTORY . '/files/third-party/modal-box/modal-box-ie.css'), null, get_option($this->woodiscuz_version));
            wp_enqueue_style('woodiscuz-modal-css-ie');
        }

        wp_register_style('woodiscuz-modal-box-css', plugins_url(WPC_Core::$PLUGIN_DIRECTORY . '/files/third-party/modal-box/modal-box.css'), null, get_option($this->woodiscuz_version));
        wp_enqueue_style('woodiscuz-modal-box-css');

        wp_enqueue_script('woodiscuz-validator-js', plugins_url(WPC_Core::$PLUGIN_DIRECTORY . '/files/js/validator.js'), array('jquery'), '1.0.0', false);

        wp_register_style('woodiscuz-validator-style', plugins_url(WPC_Core::$PLUGIN_DIRECTORY . '/files/css/fv.css'), null, get_option($this->woodiscuz_version));
        wp_enqueue_style('woodiscuz-validator-style');

        wp_enqueue_script('woodiscuz-ajax-js', plugins_url(WPC_Core::$PLUGIN_DIRECTORY . '/files/js/wpc-ajax.js'), array('jquery'), get_option($this->woodiscuz_version), false);
        wp_localize_script('woodiscuz-ajax-js', 'wpc_ajax_obj', array('url' => admin_url('admin-ajax.php')));

        wp_enqueue_script('woodiscuz-cookie-js', plugins_url(WPC_Core::$PLUGIN_DIRECTORY . '/files/js/jquery.cookie.js'), array('jquery'), '1.4.1', false);

        wp_register_style('woodiscuz-tooltipster-style', plugins_url(WPC_Core::$PLUGIN_DIRECTORY . '/files/third-party/tooltipster/css/tooltipster.css'), null, get_option($this->woodiscuz_version));
        wp_enqueue_style('woodiscuz-tooltipster-style');

        wp_enqueue_script('woodiscuz-tooltipster-js', plugins_url(WPC_Core::$PLUGIN_DIRECTORY . '/files/third-party/tooltipster/js/jquery.tooltipster.min.js'), array('jquery'), '1.2', false);
        wp_enqueue_script('woodiscuz-footer-js', plugins_url(WPC_Core::$PLUGIN_DIRECTORY . '/files/js/wpc-footer-script.js'), array('jquery'), '1.2', true);

        wp_enqueue_script('woodiscuz-autogrowtextarea-js', plugins_url(WPC_Core::$PLUGIN_DIRECTORY . '/files/js/jquery.autogrowtextarea.min.js'), array('jquery'), '3.0', false);

        wp_register_style('woodiscuz-frontend-css', plugins_url(WPC_Core::$PLUGIN_DIRECTORY . '/files/css/woodiscuz-frontend.css'), null, get_option($this->woodiscuz_version));
        wp_enqueue_style('woodiscuz-frontend-css');
    }

    /**
     * Scripts and styles registration on administration pages
     */
    public function admin_page_styles_scripts() {

        $u_agent = $_SERVER['HTTP_USER_AGENT'];
        if (preg_match('/MSIE/i', $u_agent)) {
            wp_register_style('woodiscuz-modal-css-ie', plugins_url(WPC_Core::$PLUGIN_DIRECTORY . '/files/third-party/modal-box/modal-box-ie.css'), null, get_option($this->woodiscuz_version));
            wp_enqueue_style('woodiscuz-modal-css-ie');
        }

        wp_register_style('woodiscuz-modal-box-css', plugins_url(WPC_Core::$PLUGIN_DIRECTORY . '/files/third-party/modal-box/modal-box.css'), null, get_option($this->woodiscuz_version));
        wp_enqueue_style('woodiscuz-modal-box-css');

        wp_register_style('woodiscuz-colorpicker-css', plugins_url(WPC_Core::$PLUGIN_DIRECTORY . '/files/third-party/colorpicker/css/colorpicker.css'), null, get_option($this->woodiscuz_version));
        wp_enqueue_style('woodiscuz-colorpicker-css');

        wp_register_script('woodiscuz-colorpicker-js', plugins_url(WPC_Core::$PLUGIN_DIRECTORY . '/files/third-party/colorpicker/js/colorpicker.js'), array('jquery'), '2.0.0.9', false);
        wp_enqueue_script('woodiscuz-colorpicker-js');

        wp_register_style('woodiscuz-options-css', plugins_url(WPC_Core::$PLUGIN_DIRECTORY . '/files/css/options-css.css'), null, get_option($this->woodiscuz_version));
        wp_enqueue_style('woodiscuz-options-css');

        wp_register_script('woodiscuz-scripts-js', plugins_url(WPC_Core::$PLUGIN_DIRECTORY . '/files/js/wpc-scripts.js'), array('jquery'));
        wp_enqueue_script('woodiscuz-scripts-js');


        wp_register_style('woodiscuz-easy-responsive-tabs-css', plugins_url(WPC_Core::$PLUGIN_DIRECTORY . '/files/third-party/easy-responsive-tabs/css/easy-responsive-tabs.css'), true);
        wp_enqueue_style('woodiscuz-easy-responsive-tabs-css');

        wp_register_script('woodiscuz-easy-responsive-tabs-js', plugins_url(WPC_Core::$PLUGIN_DIRECTORY . '/files/third-party/easy-responsive-tabs/js/easy-responsive-tabs.js'), array('jquery'), '1.0.0', true);
        wp_enqueue_script('woodiscuz-easy-responsive-tabs-js');
    }

    /*
     * post comment via ajax
     */

    public function comment_submit_via_ajax() {

        $message_array = array();
        $comment_post_ID = intval(filter_input(INPUT_POST, 'comment_post_ID'));
        $comment_parent = intval(filter_input(INPUT_POST, 'comment_parent'));
        $comment_depth = intval(filter_input(INPUT_POST, 'comment_depth'));
        $is_comment_subscribed = intval(filter_input(INPUT_POST, 'is_comment_subscribed'));
        $is_in_same_container = 1;
        if ($comment_depth > $this->wpc_options_serialized->wpc_comments_max_depth) {
            $comment_depth = $this->wpc_options_serialized->wpc_comments_max_depth;
            $is_in_same_container = 0;
        }
        $notification_type = isset($_POST['notification_type']) ? $_POST['notification_type'] : '';
        if (!$this->wpc_options_serialized->wpc_captcha_show_hide) {
            if (!is_user_logged_in()) {
                $sess_captcha = $_SESSION['wpc_captcha'][$comment_post_ID . '-' . $comment_parent];
                $captcha = filter_input(INPUT_POST, 'captcha');
                if (md5(strtolower($captcha)) !== $sess_captcha) {
                    $message_array['code'] = -1;
                    $message_array['message'] = $this->wpc_options_serialized->wpc_phrases['wpc_invalid_captcha'];
                    echo json_encode($message_array);
                    exit;
                }
            }
        }
        $comment = filter_input(INPUT_POST, 'comment');

        if (is_user_logged_in()) {
            $user_id = get_current_user_id();
            $user = get_userdata($user_id);
            $name = $user->display_name;
            $email = $user->user_email;
            $user_url = $user->user_url;
        } else {
            if ($this->wpc_options_serialized->wpc_is_name_field_required) {
                $name = filter_input(INPUT_POST, 'name');
            } else {
                $name = !(filter_input(INPUT_POST, 'name')) ? __('anonymous', 'woodiscuz') : filter_input(INPUT_POST, 'name');
            }
            if ($this->wpc_options_serialized->wpc_is_email_field_required) {
                $email = filter_input(INPUT_POST, 'email');
            } else {
                $email = !(filter_input(INPUT_POST, 'email')) ? 'autogen_' . md5(uniqid() . time()) . '@example.com' : filter_input(INPUT_POST, 'email');
            }
            $user_id = 0;
            $user_url = '';
        }

        $comment = wp_kses($comment, $this->wpc_helper->wpc_allowed_tags);

        if ($name && filter_var($email, FILTER_VALIDATE_EMAIL) && $comment && filter_var($comment_post_ID)) {
            $comment = addslashes($comment);
            $new_commentdata = array(
                'user_id' => $user_id,
                'comment_post_ID' => $comment_post_ID,
                'comment_parent' => $comment_parent,
                'comment_author' => $name,
                'comment_author_email' => $email,
                'comment_content' => $comment,
                'comment_author_url' => $user_url,
                'comment_type' => 'woodiscuz',
                'comment_agent' => $this->wpc_user_agent
            );
            $new_comment_id = wp_new_comment($new_commentdata);
            $new_comment = new WPC_Comment(get_comment($new_comment_id, OBJECT));
            $held_moderate = 1;
            if ($new_comment->comment_approved) {
                $held_moderate = 0;
            }
            $wpc_notification_inserted_id = 0;
            if ($notification_type == 'reply' && !$this->wpc_db_helper->wpc_has_comment_notification($comment_post_ID, $new_comment_id, $email)) {
                $wpc_notification_inserted_id = $this->wpc_db_helper->wpc_add_email_notification($new_comment_id, $comment_post_ID, $email);
            }

            if ($wpc_notification_inserted_id) {
                $this->wpc_confirm_email_sender($wpc_notification_inserted_id, $email, $comment_post_ID, $new_comment_id);
            }

            if ($held_moderate) {
                $message_array['code'] = -2;
                $message_array['message'] = $this->wpc_options_serialized->wpc_phrases['wpc_held_for_moderate'];
            } else {
                $message_array['code'] = 1;
                $message_array['message'] = $this->comment_tpl_builder->get_comment_template($new_comment, null, $comment_depth);
                $message_array['is_in_same_container'] = $is_in_same_container;
            }
            $message_array['wpc_new_comment_id'] = $new_comment_id;

            $wpc_notification_inserted_id = 0;
            if ($is_comment_subscribed && !$this->wpc_db_helper->wpc_has_comment_notification($comment_post_ID, $new_comment_id, $email)) {
                $wpc_notification_inserted_id = $this->wpc_db_helper->wpc_add_email_notification($new_comment_id, $comment_post_ID, $email);
            }

            if ($wpc_notification_inserted_id) {
                $this->wpc_confirm_email_sender($wpc_notification_inserted_id, $email, $comment_post_ID, $new_comment_id);
            }
        } else {
            $message_array['code'] = -1;
            $message_array['wpc_new_comment_id'] = -1;
            $message_array['message'] = $this->wpc_options_serialized->wpc_phrases['wpc_invalid_field'];
        }
        echo json_encode($message_array);
        exit;
    }

    /**
     * redirect first commenter to the selected page from options
     */
    public function woodiscuz_comment_redirect() {
        $message_array = array();
        $wpc_comment_id = intval(filter_input(INPUT_POST, 'wpc_new_comment_id'));
        if ($wpc_comment_id) {
            $comment = get_comment($wpc_comment_id);
            if ($comment->comment_ID) {
                $wpc_user_comment_count = get_comments(array('author_email' => $comment->comment_author_email, 'count' => true));
                if ($this->wpc_options_serialized->woodiscuz_redirect_page && $wpc_user_comment_count == 1) {
                    $message_array['code'] = 1;
                    $message_array['redirect_to'] = get_permalink($this->wpc_options_serialized->woodiscuz_redirect_page);
                }
            }
        } else {
            $message_array['code'] = -1;
        }
        echo json_encode($message_array);
        exit();
    }

    /**
     * Check notification type and send email to post new comments subscribers
     */
    public function wpc_check_notification_type() {
        $comment_id = intval($_POST['wpc_comment_id']);
        $post_id = intval($_POST['wpc_post_id']);
        $current_user = wp_get_current_user();


        if ($current_user->user_email) {
            $email = $current_user->user_email;
        } else {
            $email = isset($_POST['wpc_email']) ? $_POST['wpc_email'] : '';
        }

        if ($comment_id && $email && $post_id) {
            $comment = get_comment($comment_id);
            $parent_comment_id = $comment->comment_parent;
            if ($comment->comment_approved && $parent_comment_id) {
                $this->wpc_notify_on_new_reply($parent_comment_id, $comment->comment_ID, $email);
            }
        }
        exit();
    }
    
    public function wpc_check_notification_type_admin_panel($commentID,$comment_approved){
        if(isset($_POST['action']) && $_POST['action'] == 'replyto-comment' && $comment_approved){
            $comment = get_comment($commentID);
            if($comment->comment_parent){
                $this->wpc_notify_on_new_reply($comment->comment_parent, $commentID, $comment->comment_author_email);
            }
        }
    }

    /**
     * request customer for comment on purchased product
     */
    public function email_request_for_comment($order_id) {
        $comment_author_email = get_post_meta($order_id, '_billing_email');
        if ($comment_author_email) {
            $request_subject = $this->wpc_options_serialized->wpc_phrases['wpc_request_reply_subject'];
            $request_message = $this->wpc_options_serialized->wpc_phrases['wpc_request_reply_message'];

            $wpc_order = new WC_Order($order_id);
            $wpc_order_items = $wpc_order->get_items();
            $wpc_items_links = "<br/>";
            foreach ($wpc_order_items as $wpc_item) {
                $wpc_items_links .= "<a href='" . get_permalink($wpc_item['product_id']) . "'>" . $wpc_item['name'] . "</a><br/>";
            }
            $request_message .= $wpc_items_links;
            $headers = array();
            $content_type = apply_filters('wp_mail_content_type', 'text/html');
            $from_name = apply_filters('wp_mail_from_name', get_option('woocommerce_email_from_name'));
            $from_email = apply_filters('wp_mail_from', get_option('woocommerce_email_from_address'));
            $headers[] = "Content-Type:  $content_type; charset=UTF-8";
            $headers[] = "From: " . $from_name . " <" . $from_email . "> \r\n";
            wp_mail($comment_author_email, $request_subject, $request_message, $headers);
        }
    }

    /**
     * vote on comment via ajax
     */
    public function vote_on_comment() {
        if ($this->wpc_options_serialized->wpc_voting_buttons_show_hide) {
            exit();
        }
        if ($this->wpc_db_helper->is_phrase_exists('wpc_discuss_tab')) {
            $this->wpc_options_serialized->wpc_phrases = $this->wpc_db_helper->get_phrases();
        }
        $messageArray = array();
        $messageArray['code'] = -1;
        $comment_id = '';
        if (!$this->wpc_options_serialized->wpc_is_guest_can_vote && !is_user_logged_in()) {
            $messageArray['message'] = $this->wpc_options_serialized->wpc_phrases['wpc_login_to_vote'];
            echo json_encode($messageArray);
            exit();
        }
        if (isset($_POST['comment_ID']) && isset($_POST['vote_type']) && intval($_POST['comment_ID']) && intval($_POST['vote_type'])) {
            $comment_id = $_POST['comment_ID'];
            $user_id_or_ip = is_user_logged_in() ? get_current_user_id() : WPC_Helper::get_real_ip_addr();
            $vote_type = $_POST['vote_type'];

            $is_user_voted = $this->wpc_db_helper->is_user_voted($user_id_or_ip, $comment_id);
            $comment = get_comment($comment_id);

            if (!is_user_logged_in() && $comment->comment_author_IP == $user_id_or_ip) {
                $messageArray['message'] = $this->wpc_options_serialized->wpc_phrases['wpc_deny_voting_from_same_ip'];
                echo json_encode($messageArray);
                exit();
            }

            if ($comment->user_id == $user_id_or_ip) {
                $messageArray['message'] = $this->wpc_options_serialized->wpc_phrases['wpc_self_vote'];
                echo json_encode($messageArray);
                exit();
            }

            if ($is_user_voted != '') {
                $vote = intval($is_user_voted) + intval($vote_type);
                if ($vote >= -1 && $vote <= 1) {
                    $this->wpc_db_helper->update_vote_type($user_id_or_ip, $comment_id, $vote);
                    $vote_count = intval(get_comment_meta($comment_id, 'woodiscuz_votes', true)) + intval($vote_type);
                    update_comment_meta($comment_id, 'woodiscuz_votes', '' . $vote_count);
                    $messageArray['code'] = 1;
                    $messageArray['message'] = $this->wpc_options_serialized->wpc_phrases['wpc_vote_counted'];
                } else {
                    $messageArray['message'] = $this->wpc_options_serialized->wpc_phrases['wpc_vote_only_one_time'];
                }
            } else {
                $this->wpc_db_helper->add_vote_type($user_id_or_ip, $comment_id, $vote_type);
                $vote_count = get_comment_meta($comment_id, 'woodiscuz_votes', true);
                if ($vote_count == '') {
                    add_comment_meta($comment_id, 'woodiscuz_votes', '' . $vote_type);
                } else {
                    $vote_count = intval($vote_count) + intval($vote_type);
                    update_comment_meta($comment_id, 'woodiscuz_votes', '' . $vote_count);
                }
                $messageArray['code'] = 1;
                $messageArray['message'] = $this->wpc_options_serialized->wpc_phrases['wpc_vote_counted'];
            }
        } else {
            $messageArray['message'] = $this->wpc_options_serialized->wpc_phrases['wpc_voting_error'];
        }

        echo json_encode($messageArray);
        exit();
    }

    /**
     * get comments by comment type
     */
    public function get_comments_by_type($comments_offset, $post_id = null) {
        global $post,$wp_query;
        
        if (!$post_id) {
            $post_id = $post->ID;
        }
        $wpc_comment_count = $this->wpc_options_serialized->wpc_comment_count;
        $wpc_comment_list_order = $this->wpc_options_serialized->wpc_comment_list_order ? $this->wpc_options_serialized->wpc_comment_list_order : 'desc';
        $wpc_comments_max_depth = $this->wpc_options_serialized->wpc_comments_max_depth ? $this->wpc_options_serialized->wpc_comments_max_depth : 3;

        $comm_list_args = array(
            'callback' => array(&$this, 'wpc_comment_callback'),
            'style' => 'div',
            'page' => 1,
            'type' => 'woodiscuz',
            'per_page' => $comments_offset * $wpc_comment_count,
            'max_depth' => $wpc_comments_max_depth,
            'reverse_top_level' => false,
        );

        $comments = get_comments(array(
            'type' => 'woodiscuz',
            'post_id' => $post_id,
            'status' => 'approve',
            'order' => $wpc_comment_list_order
        ));

        $wpc_comments = $this->init_wpc_comments($comments);
        $cpage = get_query_var( 'cpage' );
        $wp_query->query_vars['cpage'] = 1;
        wp_list_comments($comm_list_args, $wpc_comments);
        $wp_query->query_vars['cpage'] = $cpage;
        return $this->wpc_parent_comments_count;
    }

    /**
     * load more comments by offset
     */
    public function load_more_comments() {
        $c_offset = intval($_POST['comments_offset']);
        $c_offset = ($c_offset) ? $c_offset : 1;
        $post_id = intval($_POST['wpc_post_id']);
        if ($c_offset && $post_id) {
            $this->get_comments_by_type($c_offset, $post_id);
        }
        exit();
    }

    /**
     * initialize WPC comments 
     */
    public function init_wpc_comments($comments) {
        $wpc_comments = array();
        if ($comments) {
            foreach ($comments as $comment) {
                if (!$comment->comment_parent) {
                    $this->wpc_parent_comments_count++;
                }
                $wpc_comments[] = new WPC_Comment($comment);
            }
        }
        return $wpc_comments;
    }

    public function wpc_list_comments_args($args) {
        if ($args['type'] == 'all' && get_post_type() == 'product') {
            $args['type'] = 'woodiscuz_review';
        }
        return $args;
    }

    public function wpc_comment_callback($comment, $args, $depth) {
        $GLOBALS['comment'] = $comment;
        echo $this->comment_tpl_builder->get_comment_template($comment, $args, $depth);
    }

    public function is_guest_can_comment() {
        $user_can_comment = TRUE;
        if ($this->wpc_options_serialized->wpc_user_must_be_registered) {
            if (!is_user_logged_in()) {
                $user_can_comment = FALSE;
            }
        }
        return $user_can_comment;
    }

    public function update_product_comments() {
        $this->wpc_db_helper->update_comments_types();
    }

    public function init_plugin_dir_name() {
        $plugin_dir_path = plugin_dir_path(__FILE__);
        $path_array = array_values(array_filter(explode(DIRECTORY_SEPARATOR, $plugin_dir_path)));
        $path_last_part = $path_array[count($path_array) - 1];
        WPC_Core::$PLUGIN_DIRECTORY = untrailingslashit($path_last_part);
    }

    /**
     * check comment types and return arguments
     * by default comment type is comment
     */
    public function woodiscuz_review_avatar($args) {
        $args[] = 'woodiscuz_review';
        return $args;
    }

// Add settings link on plugin page
    public function wpc_add_plugin_settings_link($links) {
        $settings_link = '<a href="' . admin_url() . 'admin.php?page=woodiscuz_options_page">' . __('Settings', 'default') . '</a>';
        if (!$this->wpc_options_serialized->wpc_is_use_po_mo) {
            $settings_link .= ' | <a href="' . admin_url() . 'admin.php?page=woodiscuz_phrases_page">' . __('Phrases', 'default') . '</a>';
        }
        array_unshift($links, $settings_link);
        return $links;
    }

    /**
     * get comment text from db
     */
    public function wpc_get_editable_comment_content() {
        $message_array = array();
        $comment_ID = intval(filter_input(INPUT_POST, 'comment_id'));
        $current_user = wp_get_current_user();
        if ($comment_ID) {
            $comment = get_comment($comment_ID);
            if (isset($current_user) && $comment->user_id == $current_user->ID && $this->wpc_helper->is_comment_editable($comment)) {
                $message_array['code'] = 1;
                $message_array['message'] = $comment->comment_content;
            } else {
                $message_array['code'] = -1;
                $message_array['phrase_message'] = $this->wpc_options_serialized->wpc_phrases['wpc_comment_edit_not_possible'];
            }
        } else {
            $message_array['code'] = -1;
            $message_array['phrase_message'] = $this->wpc_options_serialized->wpc_phrases['wpc_comment_edit_not_possible'];
        }
        echo json_encode($message_array);
        exit();
    }

    /**
     * save edited comment via ajax
     */
    public function wpc_save_edited_comment() {
        $message_array = array();
        $comment_ID = intval(filter_input(INPUT_POST, 'comment_id'));
        $comment_content = filter_input(INPUT_POST, 'comment_content');
        $comment = get_comment($comment_ID);
        $current_user = wp_get_current_user();
        $trimmed_comment_content = trim($comment_content);
        // Change messages in next version - shoud be diff. messages for each specific error
        if ($trimmed_comment_content && isset($current_user) && $comment->user_id == $current_user->ID) {
            if ($trimmed_comment_content != $comment->comment_content) {
                $comment_content = wp_kses($comment_content, $this->wpc_helper->wpc_allowed_tags);

                $author_ip = WPC_Helper::get_real_ip_addr();
                $this->wpc_user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
                $comment_content = addslashes($comment_content);
                $commentarr = array(
                    'comment_ID' => $comment_ID,
                    'comment_content' => apply_filters('pre_comment_content', $comment_content),
                    'comment_author_IP' => apply_filters('pre_comment_user_ip', $author_ip),
                    'comment_agent' => apply_filters('pre_comment_user_agent', $this->wpc_user_agent),
                    'comment_approved' => $comment->comment_approved
                );
                if (wp_update_comment($commentarr)) {
                    $message_array['code'] = 1;
                    $message_array['message'] = $this->wpc_helper->make_clickable($comment_content);
                } else {
                    $message_array['code'] = -1;
                    $message_array['phrase_message'] = $this->wpc_options_serialized->wpc_phrases['wpc_comment_not_updated'];
                }
            } else {
                $message_array['code'] = -2;
                $message_array['phrase_message'] = $this->wpc_options_serialized->wpc_phrases['wpc_comment_not_edited'];
            }
        } else {
            $message_array['code'] = -1;
            $message_array['phrase_message'] = $this->wpc_options_serialized->wpc_phrases['wpc_comment_edit_not_possible'];
        }
        echo json_encode($message_array);
        exit;
    }

    public function wpc_confirm_email_sender($subscribe_id, $email, $post_id, $new_comment_id) {
        $curr_post = get_post($post_id);
        $curr_post_author = get_userdata($curr_post->post_author);

        $subject = isset($this->wpc_options_serialized->wpc_phrases['wpc_confirm_email_subject']) ? $this->wpc_options_serialized->wpc_phrases['wpc_confirm_email_subject'] : __('Subscribe Confirmation', 'woodiscuz');
        $message = isset($this->wpc_options_serialized->wpc_phrases['wpc_confirm_email_message']) ? $this->wpc_options_serialized->wpc_phrases['wpc_confirm_email_message'] : __('Hi, <br/> You just subscribed for new comments on our website. This means you will receive an email when new comments are posted according to subscription option you\'ve chosen. <br/> To activate, click confirm below. If you believe this is an error, ignore this message and we\'ll never bother you again.', 'woodiscuz');

        $confirm_url = $this->wpc_db_helper->wpc_confirm_link($subscribe_id);
        $unsubscribe_url = $this->wpc_db_helper->wpc_unsubscribe_link($new_comment_id, $email);
        $post_permalink = get_permalink($post_id);
        $message .= "<br/><br/><a href='$post_permalink'>$post_permalink</a>";
        $message .= "<br/><br/><a href='$confirm_url'>" . $this->wpc_options_serialized->wpc_phrases['wpc_confirm_email'] . "</a>";
        $message .= "<br/><br/><a href='$unsubscribe_url'>" . $this->wpc_options_serialized->wpc_phrases['wpc_ignore_subscription'] . "</a>";
        $headers = array();
        $content_type = apply_filters('wp_mail_content_type', 'text/html');
        $from_name = apply_filters('wp_mail_from_name', get_option('woocommerce_email_from_name'));
        $from_email = apply_filters('wp_mail_from', get_option('woocommerce_email_from_address'));
        $headers[] = "Content-Type:  $content_type; charset=UTF-8";
        $headers[] = "From: " . $from_name . " <" . $from_email . "> \r\n";
        wp_mail($email, $subject, $message, $headers);
    }

    /**
     * notify on comment new replies
     */
    public function wpc_notify_on_new_reply($parent_comment_id, $new_comment_id, $email) {
        $emails_array = $this->wpc_db_helper->wpc_get_post_new_reply_notification($parent_comment_id, $email);
        $subject = ($this->wpc_options_serialized->wpc_phrases['wpc_new_reply_email_subject']) ? $this->wpc_options_serialized->wpc_phrases['wpc_new_reply_email_subject'] : __('New Reply', 'woodiscuz');
        $message = ($this->wpc_options_serialized->wpc_phrases['wpc_new_reply_email_message']) ? $this->wpc_options_serialized->wpc_phrases['wpc_new_reply_email_message'] : __('New reply on the discussion section you\'ve been interested in', 'woodiscuz');
        foreach ($emails_array as $e_row) {
            $this->wpc_email_sender($e_row, $new_comment_id, $subject, $message);
        }
    }

    /**
     * send email
     */
    public function wpc_email_sender($email_data, $wpc_new_comment_id, $subject, $message) {
        $comment = get_comment($wpc_new_comment_id);
        $curr_post = get_post($comment->comment_post_ID);
        $curr_post_author = get_userdata($curr_post->post_author);

        if ($email_data['email'] == $curr_post_author->user_email) {
            if (get_option('moderation_notify') && !$comment->comment_approved) {
                return;
            } else if (get_option('comments_notify') && $comment->comment_approved) {
                return;
            }
        }

        $wpc_new_comment_content = $comment->comment_content;
        $permalink = esc_url(get_permalink($comment->comment_post_ID)) . '#wpc-comment-' . $wpc_new_comment_id;
        $unsubscribe_url = get_permalink($comment->comment_post_ID) . "?wooDiscuzSubscribeID=" . $email_data['id'] . "&key=" . $email_data['activation_key'] . '&#wpc_unsubscribe_message';
        $message .= "<br/><br/><a href='$permalink'>$permalink</a>";
        $message .= "<br/><br/>$wpc_new_comment_content";
        $message .= "<br/><br/><a href='$unsubscribe_url'>" . $this->wpc_options_serialized->wpc_phrases['wpc_unsubscribe'] . "</a>";
        $headers = array();
        $content_type = apply_filters('wp_mail_content_type', 'text/html');
        $from_name = apply_filters('wp_mail_from_name', get_option('woocommerce_email_from_name'));
        $from_email = apply_filters('wp_mail_from', get_option('woocommerce_email_from_address'));
        $headers[] = "Content-Type:  $content_type; charset=UTF-8";
        $headers[] = "From: " . $from_name . " <" . $from_email . "> \r\n";
        wp_mail($email_data['email'], $subject, $message, $headers);
    }

    public function wpc_notify_to_subscriber($new_status, $old_status, $comment) {
        if ($old_status != $new_status) {
            if ($new_status == 'approved') {
                $comment_id = $comment->comment_ID;
                $email = $comment->comment_author_email;
                $parent_comment = get_comment($comment->comment_parent);
                if ($parent_comment) {
                    $this->wpc_notify_on_new_reply($parent_comment->comment_ID, $comment_id, $email);
                }
            }
        }
    }

    public function wpc_unsubscribe($id, $activation_key) {
        $this->wpc_db_helper->wpc_unsubscribe($id, $activation_key);
    }

}

$wpc = new WPC_Core();
if (isset($_GET['woodiscuz_update_reviews'])) {
    $wpc->update_product_comments();
    unset($_GET['woodiscuz_update_reviews']);
}
?>