<?php

class WPC_Comment_Template_Builder {

    public $wpc_helper;
    public $wpc_db_helper;
    public $wpc_options_serialized;

    function __construct($wpc_helper, $wpc_db_helper, $wpc_options_serialized) {
        $this->wpc_helper = $wpc_helper;
        $this->wpc_db_helper = $wpc_db_helper;
        $this->wpc_options_serialized = $wpc_options_serialized;
    }

    /**
     * @param type $comment the current comment object
     * @param type $args
     * @return single comment template
     */
    public function get_comment_template($comment, $args, $depth) {
        $comment_content = $comment->comment_content;

        $comment_content = wp_kses($comment_content, $this->wpc_helper->wpc_allowed_tags);

        $comment_content = $this->wpc_helper->make_clickable($comment_content);
        $comment_content = apply_filters('comment_text', $comment_content);

        $vote_cls = '';
        $vote_title_text = '';
        $user = get_user_by('id', $comment->user_id);
        $author_title = $this->get_author_title_by_user($user);

        $serial = $this->wpc_options_serialized;

        if ($this->wpc_options_serialized->wpc_simple_comment_date) {
            $date_format = get_option('date_format');
            $time_format = get_option('time_format');
            if (WPC_Helper::is_posted_today($comment)) {
                $posted_date = $this->wpc_options_serialized->wpc_phrases['wpc_posted_today_text'] . ' ' . mysql2date($time_format, $comment->comment_date);
            } else {
                $posted_date = get_comment_date($date_format, $comment->comment_ID);
            }
        } else {
            $posted_date = $this->wpc_helper->dateDiff(time(), strtotime($comment->comment_date_gmt), 2);
        }


        $wpc_reply_text = $this->wpc_options_serialized->wpc_phrases['wpc_reply_text'];
        $wpc_share_text = $this->wpc_options_serialized->wpc_phrases['wpc_share_text'];
        $wpc_comment_wrapper_class = ($comment->comment_parent) ? 'wpc-comment wpc-reply' : 'wpc-comment';
        $textarea_placeholder = $this->get_textarea_placeholder($comment);
        $wpc_author_name = $comment->comment_author;

        $wpc_comm_author_avatar = $this->wpc_helper->get_comment_author_avatar($comment);
        $wpc_profile_url = $this->get_profile_url($user);


        if ($wpc_profile_url) {
            $wpc_comm_author_avatar = "<a target='_blank' href='$wpc_profile_url'>" . $this->wpc_helper->get_comment_author_avatar($comment) . "</a>";
            $wpc_author_name = "<a target='_blank' href='$wpc_profile_url'>" . $wpc_author_name . "</a>";
        }

        $vote_count = ($comment->votes) ? $comment->votes : 0;
        $unique_id = $this->get_unique_id($comment);

        $child_comments = get_comments(array(
            'parent' => $comment->comment_ID,
            'status' => 'approve'
        ));

        if (!$this->wpc_options_serialized->wpc_is_guest_can_vote && !is_user_logged_in()) {
            $vote_cls = ' wpc_tooltipster';
            $vote_title_text = $this->wpc_options_serialized->wpc_phrases['wpc_login_to_vote'];
            $vote_up = $vote_title_text;
            $vote_down = $vote_title_text;
        } else {
            $vote_cls = ' wpc_vote wpc_tooltipster';
            $vote_up = $this->wpc_options_serialized->wpc_phrases['wpc_vote_up'];
            $vote_down = $this->wpc_options_serialized->wpc_phrases['wpc_vote_down'];
        }

        $parent_comment = (!$comment->comment_parent && count($child_comments)) ? ' parnet_comment' : '';

        $output = '<div id="wpc-comm-' . $unique_id . '" class="' . $wpc_comment_wrapper_class . ' ' . $parent_comment . ' wpc_comment_level-' . $depth . '">';
        $output .= '<div id="wpc-comment-' . $comment->comment_ID . '" class="wpc-comment-left">' . $wpc_comm_author_avatar;
        if (!$this->wpc_options_serialized->wpc_author_titles_show_hide) {
            $output .= '<div class="wpc-comment-label">' . $author_title . '</div>';
        }
        $output .= '</div>';
        $output .= '<div class="wpc-comment-right">';
        $output .= '<div class="wpc-comment-header"><div class="wpc-comment-author">' . $wpc_author_name . '</div><div class="wpc-comment-date">' . $posted_date . '</div><div style="clear:both"></div></div>';
        $output .= '<div class="wpc-comment-text">' . $comment_content . '</div>';
        $output .= '<div class="wpc-comment-footer">';
        if (!$this->wpc_options_serialized->wpc_voting_buttons_show_hide) {
            $output .= '<div id="vote-count-' . $unique_id . '" class="wpc-vote-result">' . $vote_count . '</div>';
            $output .= '<span id="wpc-up-' . $unique_id . '" class="wpc-vote-link wpc-up ' . $vote_cls . '" title="' . $vote_up . '">&and;</span> | <span id="wpc-down-' . $unique_id . '" class="wpc-vote-link wpc-down ' . $vote_cls . '" title="' . $vote_down . '">&or;</span> &nbsp;&nbsp;';
        }

        $wpc_post = get_post($comment->comment_post_ID);
        $wpc_poster = isset($_COOKIE['wpc_poster']) ? $_COOKIE['wpc_poster'] : '';
        $wpc_is_logged_in_poster = (get_current_user_id() == WPC_Helper::get_comment_root($comment->comment_ID)->user_id) ? 1 : 0;
        $wpc_is_poster_guest = ($wpc_poster == WPC_Helper::get_comment_root($comment->comment_ID)->comment_author_email) ? 1 : 0;
        $wpc_is_author = (get_current_user_id() == $wpc_post->post_author) ? 1 : 0;

        if ($this->wpc_options_serialized->wpc_reply_button_only_author_show && ($wpc_is_author || $wpc_is_logged_in_poster || $wpc_is_poster_guest)) {
            if ($this->is_guest_can_reply() && !get_current_user_id()) {
                $output .= '&nbsp;&nbsp;<span id="wpc-comm-reply-' . $unique_id . '" class="wpc-reply-link" title="' . $wpc_reply_text . '">' . $wpc_reply_text . '</span> &nbsp;&nbsp;';
            } elseif ($this->is_customer_can_reply()) {
                $output .= '&nbsp;&nbsp;<span id="wpc-comm-reply-' . $unique_id . '" class="wpc-reply-link" title="' . $wpc_reply_text . '">' . $wpc_reply_text . '</span> &nbsp;&nbsp;';
            }
        } else {
            if ($this->is_guest_can_reply() && !$this->wpc_options_serialized->wpc_reply_button_only_author_show && !get_current_user_id()) {
                $output .= '&nbsp;&nbsp;<span id="wpc-comm-reply-' . $unique_id . '" class="wpc-reply-link" title="' . $wpc_reply_text . '">' . $wpc_reply_text . '</span> &nbsp;&nbsp;';
            } elseif ($this->is_customer_can_reply() && !$this->wpc_options_serialized->wpc_reply_button_only_author_show) {
                $output .= '&nbsp;&nbsp;<span id="wpc-comm-reply-' . $unique_id . '" class="wpc-reply-link" title="' . $wpc_reply_text . '">' . $wpc_reply_text . '</span> &nbsp;&nbsp;';
            }
        }



        if (!$this->wpc_options_serialized->wpc_share_buttons_show_hide) {
            $output .= '-&nbsp;&nbsp; <span id="wpc-comm-share-' . $unique_id . '" class="wpc-share-link" title="' . $wpc_share_text . '">' . $wpc_share_text . '</span> &nbsp;&nbsp;';

            $twitt_content = strip_tags($comment_content) . ' ' . get_comment_link($comment);

            $wpc_post_permalink = get_permalink($comment->comment_post_ID);
            $output .= '<span id="share_buttons_box-' . $unique_id . '" class="share_buttons_box">';
            $output .= '<a target="_blank" href="http://www.facebook.com/sharer.php?u=' . $wpc_post_permalink . '" title="' . $this->wpc_options_serialized->wpc_phrases['wpc_share_facebook'] . '"><img src="' . plugins_url(WPC_Core::$PLUGIN_DIRECTORY . '/files/img/social-icons/fb-18x18.png') . '" onmouseover="this.src=\'' . plugins_url(WPC_Core::$PLUGIN_DIRECTORY . '/files/img/social-icons/fb-18x18-orig.png') . '\'" onmouseout="this.src=\'' . plugins_url(WPC_Core::$PLUGIN_DIRECTORY . '/files/img/social-icons/fb-18x18.png') . '\'"/></a>&nbsp;&nbsp;';
            $output .= '<a target="_blank" href="https://twitter.com/home?status=' . $twitt_content . '" title="' . $this->wpc_options_serialized->wpc_phrases['wpc_share_twitter'] . '"><img src="' . plugins_url(WPC_Core::$PLUGIN_DIRECTORY . '/files/img/social-icons/twitter-18x18.png') . '" onmouseover="this.src=\'' . plugins_url(WPC_Core::$PLUGIN_DIRECTORY . '/files/img/social-icons/twitter-18x18-orig.png') . '\'" onmouseout="this.src=\'' . plugins_url(WPC_Core::$PLUGIN_DIRECTORY . '/files/img/social-icons/twitter-18x18.png') . '\'"/></a>&nbsp;&nbsp;';
            $output .= '<a target="_blank" href="https://plus.google.com/share?url=' . $wpc_post_permalink . '" title="' . $this->wpc_options_serialized->wpc_phrases['wpc_share_google'] . '"><img src="' . plugins_url(WPC_Core::$PLUGIN_DIRECTORY . '/files/img/social-icons/google-18x18.png') . '" onmouseover="this.src=\'' . plugins_url(WPC_Core::$PLUGIN_DIRECTORY . '/files/img/social-icons/google-18x18-orig.png') . '\'" onmouseout="this.src=\'' . plugins_url(WPC_Core::$PLUGIN_DIRECTORY . '/files/img/social-icons/google-18x18.png') . '\'"/></a>&nbsp;&nbsp;';
            $output .= '<a target="_blank" href="http://vk.com/share.php?url=' . $wpc_post_permalink . '" title="' . $this->wpc_options_serialized->wpc_phrases['wpc_share_vk'] . '"><img src="' . plugins_url(WPC_Core::$PLUGIN_DIRECTORY . '/files/img/social-icons/vk-18x18.png') . '" onmouseover="this.src=\'' . plugins_url(WPC_Core::$PLUGIN_DIRECTORY . '/files/img/social-icons/vk-18x18-orig.png') . '\'" onmouseout="this.src=\'' . plugins_url(WPC_Core::$PLUGIN_DIRECTORY . '/files/img/social-icons/vk-18x18.png') . '\'"/></a>&nbsp;&nbsp;';
            $output .= '<a target="_blank" href="http://www.odnoklassniki.ru/dk?st.cmd=addShare&st.s=1&st._surl=' . $wpc_post_permalink . '" title="' . $this->wpc_options_serialized->wpc_phrases['wpc_share_ok'] . '"><img src="' . plugins_url(WPC_Core::$PLUGIN_DIRECTORY . '/files/img/social-icons/ok-18x18.png') . '" onmouseover="this.src=\'' . plugins_url(WPC_Core::$PLUGIN_DIRECTORY . '/files/img/social-icons/ok-18x18-orig.png') . '\'" onmouseout="this.src=\'' . plugins_url(WPC_Core::$PLUGIN_DIRECTORY . '/files/img/social-icons/ok-18x18.png') . '\'"/></a>&nbsp;&nbsp;';
            $output .= '</span>';
        }

        if (current_user_can('edit_comment', $comment->comment_ID)) {
            $output .= '-&nbsp;&nbsp; <a href="' . get_edit_comment_link($comment->comment_ID) . '">' . __('Edit', 'default') . '</a>';
        } else {
            global $current_user;
            get_currentuserinfo();
            if ($this->wpc_helper->is_comment_editable($comment) && $current_user->ID && $current_user->ID == $comment->user_id) {
                $output .= '<span id="wpc_editable_comment-' . $unique_id . '" class="wpc_editable_comment">-&nbsp;&nbsp;' . $this->wpc_options_serialized->wpc_phrases['wpc_edit_text'] . '</span>';
                $output .= '<span id="wpc_cancel_edit-' . $unique_id . '" class="wpc_cancel_edit">-&nbsp;&nbsp;' . $this->wpc_options_serialized->wpc_phrases['wpc_comment_edit_cancel_button'] . '</span>';
                $output .= '<span id="wpc_save_edited_comment-' . $unique_id . '" class="wpc_save_edited_comment" style="display:none;">&nbsp;&nbsp;-&nbsp;&nbsp;' . $this->wpc_options_serialized->wpc_phrases['wpc_comment_edit_save_button'] . '</span>';
            }
        }

        $visibility = 'none';
        if (!$comment->comment_parent && count($child_comments)) {
            $visibility = 'block';
            $output .= '<span id="wpc-toggle-' . $unique_id . '" class="wpc-toggle" style="display:' . $visibility . ';">' . $this->wpc_options_serialized->wpc_phrases['wpc_hide_replies_text'] . ' &and;</span>';
        }

        $output .= '</div>';
        $output .= '</div>';
        $output .= '<div style="clear:both"></div>';

        if ($this->is_form_visible()) {
            $output .= '<div class="wpc-form-wrapper wpc-secondary-forms-wrapper" id="wpc-secondary-forms-wrapper-' . $unique_id . '">';
            $output .= '<form action="" method="post" id="wpc_comm_form-' . $unique_id . '" class="wpc_comm_form">';
            $output .= '<div class="wpc-field-comment"><div style="width:60px; float:left; position:absolute;">' . $this->wpc_helper->get_comment_author_avatar() . '</div><div style="margin-left:65px;" class="woodiscuz-item"><textarea id="wpc_comment-' . $unique_id . '" class="wpc_comment" name="wpc_comment" required="required" placeholder="' . $textarea_placeholder . '"></textarea></div><div style="clear:both"></div></div>';

            $output .= '<div id="wpc-form-footer-' . $unique_id . '" class="wpc-form-footer">';

            if (!is_user_logged_in()) {
                $wpc_is_name_field_required = ($this->wpc_options_serialized->wpc_is_name_field_required) ? 'required="required"' : '';
                $wpc_is_email_field_required = ($this->wpc_options_serialized->wpc_is_email_field_required) ? 'required="required"' : '';

                $output .= '<div class="wpc-author-data"><div class="wpc-field-name woodiscuz-item"><input id="wpc_name-' . $unique_id . '" name="wpc_name" class="wpc_name" ' . $wpc_is_name_field_required . ' value="" type="text" placeholder="' . $this->wpc_options_serialized->wpc_phrases['wpc_name_text'] . '"/></div><div class="wpc-field-email woodiscuz-item"><input id="wpc_email-' . $unique_id . '" class="wpc_email email" name="wpc_email" ' . $wpc_is_email_field_required . ' value="" type="email" placeholder="' . $this->wpc_options_serialized->wpc_phrases['wpc_email_text'] . '"/></div><div style="clear:both"></div></div>';
            }

            $output .= '<div class="wpc-form-submit">';

			 if (!$this->wpc_options_serialized->wpc_captcha_show_hide) {
                if (!is_user_logged_in()) {
                    $output .= '<div class="wpc-field-captcha woodiscuz-item"><input id="wpc_captcha-' . $unique_id . '" name="wpc_captcha" required="required" value="" type="text" /><span class="wpc-label wpc-captcha-label"><img src="' . plugins_url(WPC_Core::$PLUGIN_DIRECTORY . '/captcha/captcha.php?comm_id=' . $comment->comment_post_ID . '-' . $comment->comment_ID) . '" id="wpc_captcha_img-' . $unique_id . '" /><img src="' . plugins_url(WPC_Core::$PLUGIN_DIRECTORY . '/files/img/refresh-16x16.png') . '" id="wpc_captcha_refresh_img-' . $unique_id . '" class="wpc_captcha_refresh_img" /></span><span class="captcha_msg">' . $this->wpc_options_serialized->wpc_phrases['wpc_captcha_text'] . '</span></div>';
                }
            }

            $output .= '<div class="wpc-field-submit">';
			
			if (!$this->wpc_options_serialized->wpc_reply_subscription_on_off) {

                $output .= '<div class="wpc_notification_checkboxes" style="display: block;">';
                $output .= '<input type="checkbox" id="wpc_notification_new_reply-' . $unique_id . '" class="wpc_notification_new_reply"  name="wpc_notification_new_reply-' . $unique_id . '" value="wpc_notification_new_reply"/>';
                $output .= '<label class="wpc-label-reply-notify" for="wpc_notification_new_reply-' . $unique_id . '">' . $this->wpc_options_serialized->wpc_phrases['wpc_notify_on_new_reply'] . '</label>';
                $output .= '</div>';
            }
			
			$output .= '<input type="button" name="submit" value="' . $this->wpc_options_serialized->wpc_phrases['wpc_submit_text'] . '" id="wpc_comm-' . $unique_id . '" class="wpc_comm_submit button alt"/>
							</div>';
            $output .= '<div style="clear:both"></div>';
            $output .= '</div>';
            
            $output .= '</div>';

            $output .= '<input type="hidden" name="wpc_home_url" value="' . plugins_url() . '" id="wpc_home_url-' . $unique_id . '" />';
            $output .= '<input type="hidden" name="wpc_comment_post_ID" value="' . $comment->comment_post_ID . '" id="wpc_comment_post_ID-' . $unique_id . '" />';
            $output .= '<input type="hidden" name="wpc_comment_parent" value="' . $comment->comment_ID . '" id="wpc_comment_parent-' . $unique_id . '" />';

            $output .= '</form>';
            $output .= '</div>';
        }
        return $output;
    }

    public function is_guest_can_reply() {
        $user_can_comment = true;
        if (!$this->wpc_options_serialized->wpc_user_must_be_registered) {
            if ($this->wpc_options_serialized->wpc_reply_button_guests_show_hide) {
                if (!is_user_logged_in()) {
                    $user_can_comment = false;
                }
            }
        } else {
            if (!is_user_logged_in()) {
                $user_can_comment = false;
            }
        }
        return $user_can_comment;
    }

    public function is_customer_can_reply() {
        $user_can_comment = true;
        if ($this->wpc_options_serialized->wpc_reply_button_customers_show_hide && is_user_logged_in()) {
            $user_can_comment = $this->is_user_can_reply_by_role('customer');
        }
        if (!is_user_logged_in()) {
            $user_can_comment = false;
        }
        return $user_can_comment;
    }

    /**
     * User can comment in product  by role
     */
    private function is_user_can_reply_by_role($role) {
        $user_can_comment = false;
        if (is_user_logged_in()) {
            $current_user = wp_get_current_user();
            $roles = $current_user->roles;
            if (!in_array($role, $roles)) {
                $user_can_comment = true;
            }
        }
        return $user_can_comment;
    }

    /**
     * Check if form visible or not
     */
    private function is_form_visible() {
        global $current_user;
        get_currentuserinfo();
        $is_from_visible = false;
        if ($current_user->ID) {
            $is_from_visible = $this->is_customer_can_reply();
        } else {
            $is_from_visible = $this->is_guest_can_reply();
        }
        return $is_from_visible;
    }

    /**
     * get comment author title
     */
    public function get_author_title_by_user($user) {
        if ($user) {
            $roles = $user->roles;

            foreach ($roles as $role) {
                if (in_array($role, $this->wpc_options_serialized->wpc_usergroups_for_support_title)) {
                    return $this->wpc_options_serialized->wpc_phrases['wpc_user_title_support_text'];
                }
            }

            if (in_array('customer', $roles)) {
                return $this->wpc_options_serialized->wpc_phrases['wpc_user_title_customer_text'];
            } else {
                return $this->wpc_options_serialized->wpc_phrases['wpc_user_title_member_text'];
            }
        } else {
            return $this->wpc_options_serialized->wpc_phrases['wpc_user_title_guest_text'];
        }
    }

    /**
     * 
     * get profile url 
     */
    private function get_profile_url($user) {
        $wpc_profile_url = '';
        if ($user) {
            if (class_exists('BuddyPress')) {
                $wpc_profile_url = bp_core_get_user_domain($user->ID);
            } else if (class_exists('XooUserUltra')) {
                global $xoouserultra;
                $wpc_profile_url = $xoouserultra->userpanel->get_user_profile_permalink($user->ID);
            } else {
                if (count_user_posts($user->ID)) {
                    $wpc_profile_url = get_author_posts_url($user->ID);
                }
            }
        }
        return $wpc_profile_url;
    }

    /**
     * returns placeholder for textarea from options page phrases
     */
    public function get_textarea_placeholder($comment) {
        if ($this->wpc_db_helper->get_comment_count($comment->comment_post_ID)) {
            $textarea_placeholder = $this->wpc_options_serialized->wpc_phrases['wpc_comment_join_text'];
        } else {
            $textarea_placeholder = $this->wpc_options_serialized->wpc_phrases['wpc_comment_start_text'];
        }
        return $textarea_placeholder;
    }

    /**
     * returns unique id based on comment and post ids
     */
    public function get_unique_id($comment) {
        $unique_id = $comment->comment_post_ID . '_' . $comment->comment_ID;
        return $unique_id;
    }

    /**
     * set wpc helper
     */
    public function set_wpc_helper($wpc_helper) {
        $this->wpc_helper = $wpc_helper;
    }

    /**
     * set db helper
     */
    public function set_wpc_db_helper($wpc_db_helper) {
        $this->wpc_db_helper = $wpc_db_helper;
    }

    /**
     * set wpc options
     */
    public function set_wpc_options($wpc_options) {
        $this->wpc_options = $wpc_options;
    }

}

?>