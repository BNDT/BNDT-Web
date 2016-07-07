<?php

class WPC_Options_Serialize {

    public $wpc_options_slug = 'wpc_options';

    /*
     * Type - Input number
     * Available Values - Integer values
     * Description - Comment Tab priority
     * Default Value - 1000 for initializing comment tab last
     */
    public $wpc_comment_tab_priority;

    /*
     * Type - Checkbox
     * Available Values - Checked/Unchecked
     * Description - Show/Hide WooCommerce Review Tab
     * Default Value - Unchecked
     */
    public $wpc_tab_show_hide;

    /* Type - Checkbox
     * Available Values - Checked/Unchecked
     * Description - Show/Hide Voting buttons
     * Default Value - Unchecked
     */
    public $wpc_voting_buttons_show_hide;

    /*
     * Type - Checkbox
     * Available Values - Checked/Unchecked
     * Description - Show/Hide Share Buttons
     * Default Value - Unchecked
     */
    public $wpc_share_buttons_show_hide;

    /*
     * Type - Checkbox
     * Available Values - Checked/Unchecked
     * Description - Show/Hide the  CAPTCHA field
     * Default Value - Unchecked
     */
    public $wpc_captcha_show_hide;

    /*
     * Type - Radiobutton
     * Available Values - Yes/No
     * Description - User Must be registered to comment
     *      (If this option is set “Yes”, the comment form will be hidden, 
     *      instead of the form there will be a link to registration page.)
     * Default Value - No
     */
    public $wpc_user_must_be_registered;

    /**
     * Type - Checkbox
     * Available Values - Checked/Unchecked
     * Description - If checked user must fill this field
     * Default Value - Checked
     */
    public $wpc_is_name_field_required;

    /**
     * Type - Checkbox
     * Available Values - Checked/Unchecked
     * Description - If checked user must fill this field
     * Default Value - Checked
     */
    public $wpc_is_email_field_required;

    /*
     * Type - Checkbox
     * Available Values - Checked/Unchecked
     * Description - Show/Hide Reply button for Guests 
     * Default Value - Unchecked
     */
    public $wpc_reply_button_guests_show_hide;

    /*
     * Type - Checkbox
     * Available Values - Checked/Unchecked
     * Description - Show/Hide Reply button for Customers 
     * Default Value - Unchecked
     */
    public $wpc_reply_button_customers_show_hide;


    /*
     * Type - Checkbox
     * Available Values - Checked/Unchecked
     * Description - Show Reply button only for product author
     * Default Value - Unchecked
     */
    public $wpc_reply_button_only_author_show;

    /*
     * Type - Checkbox
     * Available Values - Checked/Unchecked
     * Description - Show/Hide Author Titles
     * Default Value - Unchecked   
     */
    public $wpc_author_titles_show_hide;

    /*
     * Type - Checkbox (Group)
     * Available Values - Admin, Editor, Author, Contributor, Shop Manager
     * Description - Usergroups for User Title “Support”
     * Default Value - Admin, Shop Manager
     */
    public $wpc_usergroups_for_support_title;

    /*
     * Type - Input
     * Available Values - Integer
     * Description - Comment count per click
     * Default Value - 5
     */
    public $wpc_comment_count;

    /**
     * Type - Dropdown menu
     * Available Values - 1, 2, 3, 4, 5
     * Description - Define comments depth value in comment list
     * Default Value - 3
     */
    public $wpc_comments_max_depth;

    /**
     * Type - Dropdown menu
     * Available Values - list of pages (ids)
     * Description - Redirect first commenter to the selected page
     * Default Value - 0
     */
    public $woodiscuz_redirect_page;

    /**
     * Type - Dropdown menu
     * Available Values - Not Allow(0), 900s(15 minutes)  1800s(30 minutes), 3600s(1 hour), 10800s(3 hours), 86400(24 hours)
     * Description - Allow commnet editing after comment subimt
     * Default Value - Editable comment time value
     */
    public $wpc_comment_editable_time;

    /**
     * Type - Checkbox
     * Available Values - Checked/Unchecked
     * Description - Allow guests to vote on comments
     * Default Value - Checked
     */
    public $wpc_is_guest_can_vote;

    /**
     * Type - Checkbox
     * Available Values - Checked/Unchecked
     * Description - Comment date format - 20-01-2015
     * Default Value - Checked
     */
    public $wpc_simple_comment_date;

    /**
     * Type - Radio Button
     * Available Values - Top / Bottom
     * Description - Comment list order
     * Default Value - Top
     */
    public $wpc_comment_list_order;

    /*
     * Type - Checkbox
     * Available Values - Checked/Unchecked
     * Description - Request for comment 
     * Default Value - Checked
     */
    public $wpc_request_for_comment;

    /**
     * Type - Select
     * Available Values - 12px-16px
     * Description - Comment Text Size
     * Default Value - 14px
     */
    public $wpc_comment_text_size;

    /**
     * Type - Input
     * Available Values - color codes
     * Description - Form Background Color
     * Default Value - #F9F9F9
     */
    public $wpc_form_bg_color;

    /*
     * Type - Input
     * Available Values - color codes
     * Description - Comment Background Color
     * Default Value - #fefefe
     */
    public $wpc_comment_bg_color;

    /*
     * Type - Input
     * Available Values - color codes
     * Description - Reply Background Color
     * Default Value - #f8f8f8
     */
    public $wpc_reply_bg_color;

    /*
     * Type - Input
     * Available Values - color codes
     * Description - Comment Text Color
     * Default Value - #555
     */
    public $wpc_comment_text_color;

    /*
     * Type - HTML elements array
     * Available Values - Text
     * Description - Phrases for form elements texts
     * Default Value - 
     */
    public $wpc_phrases;

    /**
     * Type - Checkbox
     * Available Values - Checked/Unchecked
     * Description - Use .PO/.MO files
     * Default Value - Unchecked
     */
    public $wpc_is_use_po_mo;
    public $wpc_db_helper;

    /**
     * Type - Checkbox
     * Available Values - Checked/Unchecked
     * Description - On/Off subscription
     * Default Value - Unchecked
     */
    public $wpc_reply_subscription_on_off;
    
    public $wpc_show_plugin_powered_by;

    function __construct($wpc_db_helper) {
        $this->wpc_db_helper = $wpc_db_helper;
        $this->init_phrases();
        $this->add_options();
        $this->init_options(get_option($this->wpc_options_slug));
        $this->wpc_user_must_be_registered = get_option('comment_registration');
        $this->wpc_comment_count = get_option('comments_per_page');
        $this->wpc_comments_max_depth = get_option('thread_comments_depth');
        $this->wpc_comment_list_order = get_option('comment_order');
    }

    public function init_options($serialize_options) {
        $options = unserialize($serialize_options);
        $this->wpc_comment_tab_priority = $options['wpc_comment_tab_priority'];
        $this->wpc_tab_show_hide = $options['wpc_tab_show_hide'];
        $this->wpc_voting_buttons_show_hide = $options['wpc_voting_buttons_show_hide'];
        $this->wpc_share_buttons_show_hide = $options['wpc_share_buttons_show_hide'];
        $this->wpc_captcha_show_hide = $options['wpc_captcha_show_hide'];
        $this->wpc_is_name_field_required = isset($options['wpc_is_name_field_required']) ? $options['wpc_is_name_field_required'] : 1;
        $this->wpc_is_email_field_required = isset($options['wpc_is_email_field_required']) ? $options['wpc_is_email_field_required'] : 1;
        $this->wpc_reply_button_guests_show_hide = $options['wpc_reply_button_guests_show_hide'];
        $this->wpc_reply_button_customers_show_hide = $options['wpc_reply_button_customers_show_hide'];
        $this->wpc_reply_button_only_author_show = $options['wpc_reply_button_only_author_show'];
        $this->wpc_author_titles_show_hide = $options['wpc_author_titles_show_hide'];
        $this->wpc_usergroups_for_support_title = $options['wpc_usergroups_for_support_title'];
        $this->woodiscuz_redirect_page = isset($options['woodiscuz_redirect_page']) ? $options['woodiscuz_redirect_page'] : 0;
        $this->wpc_comment_editable_time = isset($options['wpc_comment_editable_time']) ? $options['wpc_comment_editable_time'] : 900;
        $this->wpc_is_guest_can_vote = isset($options['wpc_is_guest_can_vote']) ? $options['wpc_is_guest_can_vote'] : 0;
        $this->wpc_simple_comment_date = isset($options['wpc_simple_comment_date']) ? $options['wpc_simple_comment_date'] : 0;
        $this->wpc_request_for_comment = $options['wpc_request_for_comment'];
        $this->wpc_comment_text_size = $options['wpc_comment_text_size'];
        $this->wpc_form_bg_color = $options['wpc_form_bg_color'];
        $this->wpc_comment_bg_color = $options['wpc_comment_bg_color'];
        $this->wpc_reply_bg_color = $options['wpc_reply_bg_color'];
        $this->wpc_comment_text_color = $options['wpc_comment_text_color'];
        $this->wpc_is_use_po_mo = isset($options['wpc_is_use_po_mo']) ? $options['wpc_is_use_po_mo'] : 0;
        $this->wpc_reply_subscription_on_off = isset($options['wpc_reply_subscription_on_off']) ? $options['wpc_reply_subscription_on_off'] : 0;
        $this->wpc_show_plugin_powered_by = isset($options['wpc_show_plugin_powered_by']) ? $options['wpc_show_plugin_powered_by'] : 0;
    }

    /**
     * initialize default phrases
     */
    public function init_phrases() {
        $this->wpc_phrases = array(
            'wpc_discuss_tab' => __('Discussions', 'woodiscuz'),
            'wpc_header_text' => __('Got something to discuss?', 'woodiscuz'),
            'wpc_comment_start_text' => __('Start the discussion', 'woodiscuz'),
            'wpc_comment_join_text' => __('Join the discussion', 'woodiscuz'),
            'wpc_email_text' => __('Email', 'woodiscuz'),
            'wpc_name_text' => __('Name', 'woodiscuz'),
            'wpc_captcha_text' => __('Please insert the code above to comment', 'woodiscuz'),
            'wpc_submit_text' => __('Post Comment', 'woodiscuz'),
            'wpc_load_more_submit_text' => __('Load More Comments', 'woodiscuz'),
            'wpc_reply_text' => __('Reply', 'woodiscuz'),
            'wpc_share_text' => __('Share', 'woodiscuz'),
            'wpc_edit_text' => __('Edit', 'woodiscuz'),
            'wpc_comment_edit_cancel_button' => __('Cancel', 'woodiscuz'),
            'wpc_comment_edit_save_button' => __('Save', 'woodiscuz'),
            'wpc_share_facebook' => __('Share On Facebook', 'woodiscuz'),
            'wpc_share_twitter' => __('Share On Twitter', 'woodiscuz'),
            'wpc_share_google' => __('Share On Google', 'woodiscuz'),
            'wpc_share_vk' => __('Share On VKontakte', 'woodiscuz'),
            'wpc_share_ok' => __('Share On Odnoklassniki', 'woodiscuz'),
            'wpc_hide_replies_text' => __('Hide Replies', 'woodiscuz'),
            'wpc_show_replies_text' => __('Show Replies', 'woodiscuz'),
            'wpc_user_title_guest_text' => __('Guest', 'woodiscuz'),
            'wpc_user_title_member_text' => __('Member', 'woodiscuz'),
            'wpc_user_title_customer_text' => __('Customer', 'woodiscuz'),
            'wpc_user_title_support_text' => __('Support', 'woodiscuz'),
            'wpc_email_subject' => __('New Comment', 'woodiscuz'),
            'wpc_email_message' => __('New comment on the product discussion section you\'ve been interested in', 'woodiscuz'),
            'wpc_request_reply_subject' => __('Leave a Reply', 'woodiscuz'),
            'wpc_request_reply_message' => __('Please, leave a reply on', 'woodiscuz'),
            'wpc_error_empty_text' => __('please fill out this field to comment', 'woodiscuz'),
            'wpc_error_email_text' => __('email address is invalid', 'woodiscuz'),
            'wpc_year_text' => array('datetime' => array(__('year', 'woodiscuz'), 1)),
            'wpc_year_text_plural' => array('datetime' => array(__('years', 'woodiscuz'), 1)), // PLURAL
            'wpc_month_text' => array('datetime' => array(__('month', 'woodiscuz'), 2)),
            'wpc_month_text_plural' => array('datetime' => array(__('months', 'woodiscuz'), 2)), // PLURAL
            'wpc_day_text' => array('datetime' => array(__('day', 'woodiscuz'), 3)),
            'wpc_day_text_plural' => array('datetime' => array(__('days', 'woodiscuz'), 3)), // PLURAL
            'wpc_hour_text' => array('datetime' => array(__('hour', 'woodiscuz'), 4)),
            'wpc_hour_text_plural' => array('datetime' => array(__('hours', 'woodiscuz'), 4)), // PLURAL
            'wpc_minute_text' => array('datetime' => array(__('minute', 'woodiscuz'), 5)),
            'wpc_minute_text_plural' => array('datetime' => array(__('minutes', 'woodiscuz'), 5)), // PLURAL
            'wpc_second_text' => array('datetime' => array(__('second', 'woodiscuz'), 6)),
            'wpc_second_text_plural' => array('datetime' => array(__('seconds', 'woodiscuz'), 6)), // PLURAL
            'wpc_plural_text' => __('s', 'woodiscuz'),
            'wpc_right_now_text' => __('right now', 'woodiscuz'),
            'wpc_ago_text' => __('ago', 'woodiscuz'),
            'wpc_posted_today_text' => __('today', 'woodiscuz'),
            'wpc_you_must_be_text' => __('You must be', 'woodiscuz'),
            'wpc_logged_in_text' => __('logged in', 'woodiscuz'),
            'wpc_to_post_comment_text' => __('to post a comment.', 'woodiscuz'),
            'wpc_vote_up' => __('Vote Up', 'woodiscuz'),
            'wpc_vote_down' => __('Vote Down', 'woodiscuz'),
            'wpc_vote_counted' => __('Vote Counted', 'woodiscuz'),
            'wpc_vote_only_one_time' => __("You've already voted for this comment", 'woodiscuz'),
            'wpc_voting_error' => __('Voting Error', 'woodiscuz'),
            'wpc_login_to_vote' => __('You Must Be Logged In To Vote', 'woodiscuz'),
            'wpc_self_vote' => __('You cannot vote for your comment', 'woodiscuz'),
            'wpc_deny_voting_from_same_ip' => __('You are not allowed to vote for this comment', 'woodiscuz'),
            'wpc_invalid_captcha' => __('Invalid Captcha Code', 'woodiscuz'),
            'wpc_invalid_field' => __('Some of field value is invalid', 'woodiscuz'),
            'wpc_held_for_moderate' => __('Your Comment awaiting moderation', 'woodiscuz'),
            'wpc_comment_not_updated' => __('Sorry, the comment was not updated', 'woodiscuz'),
            'wpc_comment_edit_not_possible' => __('Sorry, this comment no longer possible to edit', 'woodiscuz'),
            'wpc_comment_not_edited' => __('You\'ve not made any changes', 'woodiscuz'),
            'wpc_notify_on_new_reply' => __('Notify of new replies to this comment', 'woodiscuz'),
            'wpc_confirm_email_subject' => __('Subscribe Confirmation', 'woodiscuz'),
            'wpc_confirm_email_message' => __('Hi, <br/> You just subscribed for new comments on our website. This means you will receive an email when new comments are posted according to subscription option you\'ve chosen. <br/> To activate, click confirm below. If you believe this is an error, ignore this message and we\'ll never bother you again.', 'woodiscuz'),
            'wpc_confirm_email' => __('Confirm Subscription', 'woodiscuz'),
            'wpc_ignore_subscription' => __('Ignore Subscription', 'woodiscuz'),
            'wpc_unsubscribe_message' => __('You\'ve successfully unsubscribed.', 'woodiscuz'),
            'wpc_confirm_success_message' => __('You\'ve successfully confirmed your subscription.', 'woodiscuz'),
            'wpc_unsubscribe' => __('Unsubscribe', 'woodiscuz'),
            'wpc_new_reply_email_subject' => __('New Reply', 'woodiscuz'),
            'wpc_new_reply_email_message' => __('New reply on the discussion section you\'ve been interested in', 'woodiscuz'),
        );
    }

    public function to_array() {
        $options = array(
            'wpc_comment_tab_priority' => $this->wpc_comment_tab_priority,
            'wpc_tab_show_hide' => $this->wpc_tab_show_hide,
            'wpc_voting_buttons_show_hide' => $this->wpc_voting_buttons_show_hide,
            'wpc_share_buttons_show_hide' => $this->wpc_share_buttons_show_hide,
            'wpc_captcha_show_hide' => $this->wpc_captcha_show_hide,
            'wpc_is_name_field_required' => $this->wpc_is_name_field_required,
            'wpc_is_email_field_required' => $this->wpc_is_email_field_required,
            'wpc_reply_button_guests_show_hide' => $this->wpc_reply_button_guests_show_hide,
            'wpc_reply_button_customers_show_hide' => $this->wpc_reply_button_customers_show_hide,
            'wpc_reply_button_only_author_show' => $this->wpc_reply_button_only_author_show,
            'wpc_author_titles_show_hide' => $this->wpc_author_titles_show_hide,
            'wpc_usergroups_for_support_title' => $this->wpc_usergroups_for_support_title,
            'woodiscuz_redirect_page' => $this->woodiscuz_redirect_page,
            'wpc_comment_editable_time' => $this->wpc_comment_editable_time,
            'wpc_is_guest_can_vote' => $this->wpc_is_guest_can_vote,
            'wpc_simple_comment_date' => $this->wpc_simple_comment_date,
            'wpc_request_for_comment' => $this->wpc_request_for_comment,
            'wpc_comment_text_size' => $this->wpc_comment_text_size,
            'wpc_form_bg_color' => $this->wpc_form_bg_color,
            'wpc_comment_bg_color' => $this->wpc_comment_bg_color,
            'wpc_reply_bg_color' => $this->wpc_reply_bg_color,
            'wpc_comment_text_color' => $this->wpc_comment_text_color,
            'wpc_is_use_po_mo' => $this->wpc_is_use_po_mo,
            'wpc_reply_subscription_on_off' => $this->wpc_reply_subscription_on_off,
            'wpc_show_plugin_powered_by' => $this->wpc_show_plugin_powered_by,
        );

        return $options;
    }

    public function update_options() {
        update_option($this->wpc_options_slug, serialize($this->to_array()));
    }

    public function add_options() {
        $options = array(
            'wpc_comment_tab_priority' => '1000',
            'wpc_tab_show_hide' => '0',
            'wpc_voting_buttons_show_hide' => '0',
            'wpc_share_buttons_show_hide' => '0',
            'wpc_captcha_show_hide' => '0',
            'wpc_is_name_field_required' => '1',
            'wpc_is_email_field_required' => '1',
            'wpc_reply_button_guests_show_hide' => '0',
            'wpc_reply_button_customers_show_hide' => '0',
            'wpc_reply_button_only_author_show' => '0',
            'wpc_author_titles_show_hide' => '0',
            'wpc_usergroups_for_support_title' => array('administrator', 'shop_manager'),
            'woodiscuz_redirect_page' => '0',
            'wpc_comment_editable_time' => '900',
            'wpc_is_guest_can_vote' => '0',
            'wpc_simple_comment_date' => '0',
            'wpc_request_for_comment' => '0',
            'wpc_comment_text_size' => '14px',
            'wpc_form_bg_color' => '#f9f9f9',
            'wpc_comment_bg_color' => '#fefefe',
            'wpc_reply_bg_color' => '#f8f8f8',
            'wpc_comment_text_color' => '#555',
            'wpc_is_use_po_mo' => '0',
            'wpc_reply_subscription_on_off' => '0',
            'wpc_show_plugin_powered_by' => '0',
        );
        add_option($this->wpc_options_slug, serialize($options));
    }

    public function init_phrases_on_load() {
        if (!$this->wpc_is_use_po_mo && $this->wpc_db_helper->is_phrase_exists('wpc_discuss_tab')) {
            $this->wpc_phrases = $this->wpc_db_helper->get_phrases();
        } else {
            $this->init_phrases();
        }
    }

}
