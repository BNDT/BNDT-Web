<script type="text/javascript">
//    initialize the validator function
    woodiscuzValidator.message['invalid'] = '<?php echo $this->wpc_options_serialized->wpc_phrases['wpc_invalid_field']; ?>';
    woodiscuzValidator.message['empty'] = '<?php echo $this->wpc_options_serialized->wpc_phrases['wpc_error_empty_text']; ?>';
    woodiscuzValidator.message['email'] = '<?php echo $this->wpc_options_serialized->wpc_phrases['wpc_error_email_text']; ?>';

    jQuery(document).ready(function ($) {
        $(document).delegate('.wpc-toggle', 'click', function () {
            var toggleID = $(this).attr('id');
            var uniqueID = toggleID.substring(toggleID.lastIndexOf('-') + 1);
            $('#wpc-comm-' + uniqueID + ' .wpc-reply').slideToggle(500, function () {
                if ($(this).is(':hidden')) {
                    $('#' + toggleID).html('<?php echo $this->wpc_options_serialized->wpc_phrases['wpc_show_replies_text']; ?> &or;');
                } else {
                    $('#' + toggleID).html('<?php echo $this->wpc_options_serialized->wpc_phrases['wpc_hide_replies_text']; ?> &and;');
                }
            });
        });

        if ($.cookie('wpc_author_name') !== '' && $.cookie('wpc_author_email')) {
            $('#woopcomm .wpc_name').val($.cookie('wpc_author_name'));
            $('#woopcomm .wpc_email').val($.cookie('wpc_author_email'));
        }

        $('#wpc_unsubscribe_message').delay(7000).fadeOut(1500, function () {
            $(this).remove();
        });
    });
</script>
<?php
if (isset($_GET['wooDiscuzSubscribeID']) && isset($_GET['key'])) {
    $this->wpc_unsubscribe($_GET['wooDiscuzSubscribeID'], $_GET['key']);
    ?>
    <div id="wpc_unsubscribe_message">
        <span class="wpc_unsubscribe_message"><?php echo $this->wpc_options_serialized->wpc_phrases['wpc_unsubscribe_message']; ?></span>
    </div>
    <?php
}
?>

<?php
if (isset($_GET['wooDiscuzConfirmID']) && isset($_GET['wooDiscuzConfirmKey']) && isset($_GET['wooDiscuzConfirm'])) {
    $this->wpc_db_helper->wpc_notification_confirm($_GET['wooDiscuzConfirmID'], $_GET['wooDiscuzConfirmKey']);
    ?>
    <div id="wpc_unsubscribe_message">
        <span class="wpc_unsubscribe_message"><?php echo $this->wpc_options_serialized->wpc_phrases['wpc_confirm_success_message']; ?></span>
    </div>
    <?php
}
?>
<?php
global $post;
error_reporting(0);
$textarea_placeholder = '';
$wpc_form_has_comments = '';
if ($this->wpc_db_helper->get_comment_count($post->ID)) {
    $wpc_form_has_comments = ' wpc-has-comments';
    $textarea_placeholder = $this->wpc_options_serialized->wpc_phrases['wpc_comment_join_text'];
} else {
    $wpc_form_has_comments = ' wpc-no-comments';
    $textarea_placeholder = $this->wpc_options_serialized->wpc_phrases['wpc_comment_start_text'];
}

$unique_id = $post->ID . '_' . 0;
$wpc_is_name_field_required = ($this->wpc_options_serialized->wpc_is_name_field_required) ? 'required="required"' : '';
$wpc_is_email_field_required = ($this->wpc_options_serialized->wpc_is_email_field_required) ? 'required="required"' : '';
?>

<div id="woopcomm">
    <p class="wpc-comment-title"><?php echo $this->wpc_options_serialized->wpc_phrases['wpc_header_text']; ?></p>
    <div class="wpc-form-wrapper">
        <?php
        if ($this->is_guest_can_comment()) {
            ?>

            <form action="" method="post" id="wpc_comm_form-<?php echo $unique_id; ?>" class="wpc_comm_form wpc_main_form <?php echo $wpc_form_has_comments; ?>">
                <div class="wpc-field-comment">
                    <div style="width:60px; float:left; position:absolute;">
                        <?php echo $this->wpc_helper->get_comment_author_avatar(); ?>                        
                    </div>
                    <div style="margin-left:65px;" class="woodiscuz-item"><textarea id="wpc_comment-<?php echo $unique_id; ?>" class="wpc_comment" name="wpc_comment" required placeholder="<?php echo $textarea_placeholder; ?>"></textarea></div>
                    <div style="clear:both"></div>
                </div>
                <div id="wpc-form-footer-<?php echo $unique_id; ?>" class="wpc-form-footer">
                    <?php if (!is_user_logged_in()) { ?>
                        <div class="wpc-author-data">
                            <div class="wpc-field-name woodiscuz-item"><input id="wpc_name-<?php echo $unique_id; ?>" class="wpc_name" name="wpc_name" <?php echo $wpc_is_name_field_required; ?> value="" type="text" placeholder="<?php echo $this->wpc_options_serialized->wpc_phrases['wpc_name_text'] ?>"/></div>
                            <div class="wpc-field-email woodiscuz-item"><input id="wpc_email-<?php echo $unique_id; ?>" class="wpc_email email" name="wpc_email" <?php echo $wpc_is_email_field_required; ?> value="" type="email" placeholder="<?php echo $this->wpc_options_serialized->wpc_phrases['wpc_email_text']; ?>"/></div>
                            <div style="clear:both"></div>
                        </div>
                    <?php } ?>
                    <div class="wpc-form-submit">
                        <?php if (!$this->wpc_options_serialized->wpc_captcha_show_hide) { ?>
                            <?php if (!is_user_logged_in()) { ?>
                                <div class="wpc-field-captcha woodiscuz-item">
                                    <input id="wpc_captcha-<?php echo $unique_id; ?>" name="wpc_captcha" required="required" value="" type="text" />
                                    <span class="wpc-label wpc-captcha-label">
                                        <img src="<?php echo plugins_url(WPC_Core::$PLUGIN_DIRECTORY . '/captcha/captcha.php?comm_id=' . $post->ID . '-' . 0); ?>" id="wpc_captcha_img-<?php echo $unique_id; ?>" />
                                        <img src="<?php echo plugins_url(WPC_Core::$PLUGIN_DIRECTORY . '/files/img/refresh-16x16.png'); ?>" id="wpc_captcha_refresh_img-<?php echo $unique_id; ?>" class="wpc_captcha_refresh_img" />
                                    </span>
                                    <span class="captcha_msg"><?php echo $this->wpc_options_serialized->wpc_phrases['wpc_captcha_text']; ?></span>
                                </div>
                            <?php } ?>
                        <?php } ?>
                        <div class="wpc-field-submit">
							<?php if(!$this->wpc_options_serialized->wpc_reply_subscription_on_off){?>
                                <div class="wpc_notification_checkboxes" style="display: block;">
                                    <input type="checkbox" id="wpc_notification_new_reply-<?php echo $unique_id; ?>" class="wpc_notification_new_reply"  name="wpc_notification_new_reply-<?php echo $unique_id; ?>" value="wpc_notification_new_reply"/> 
                                    <label class="wpc-label-reply-notify" for="wpc_notification_new_reply-<?php echo $unique_id; ?>"><?php echo $this->wpc_options_serialized->wpc_phrases['wpc_notify_on_new_reply'];?></label>
                                </div>
                            <?php } ?>
                            <input type="button" name="submit" value="<?php echo $this->wpc_options_serialized->wpc_phrases['wpc_submit_text']; ?>" id="wpc_comm-<?php echo $unique_id; ?>" class="wpc_comm_submit button alt"/>
                        </div>
                        <div style="clear:both"></div>
                    </div>
                </div>                           
                <input type="hidden" name="wpc_comment_post_ID" value="<?php echo $post->ID; ?>" id="wpc_comment_post_ID-<?php echo $unique_id; ?>" />
                <input type="hidden" name="wpc_comment_parent"  value="0" id="wpc_comment_parent-<?php echo $unique_id; ?>" />
            </form>
        <?php } else { ?>
            <p class="wpc-must-login"><?php echo $this->wpc_options_serialized->wpc_phrases['wpc_you_must_be_text']; ?> <a href="<?php echo wp_login_url(); ?>"><?php echo $this->wpc_options_serialized->wpc_phrases['wpc_logged_in_text']; ?></a> <?php echo $this->wpc_options_serialized->wpc_phrases['wpc_to_post_comment_text']; ?></p>
        <?php } ?>
        <input type="hidden" name="wpc_home_url" value="<?php echo plugins_url(); ?>" id="wpc_home_url" />
        <input type="hidden" name="wpc_plugin_dir_url" value="<?php echo WPC_Core::$PLUGIN_DIRECTORY; ?>" id="wpc_plugin_dir_url" />
    </div>
    <hr/>

    <div class="wpc-thread-wrapper">
        <?php $wpc_parent_comments_count = $this->get_comments_by_type(1); ?>
    </div>

    <?php if ($wpc_parent_comments_count > $this->wpc_options_serialized->wpc_comment_count) { ?>
        <div class="wpc-load-more-submit-wrap">
            <input type="button" name="submit" value="<?php echo $this->wpc_options_serialized->wpc_phrases['wpc_load_more_submit_text']; ?>" id="wpc-load-more-submit-<?php echo $unique_id; ?>" class="wpc-load-more-submit button"/>
            <input type="hidden" name="wpc_comments_offset" id="wpc_comments_offset" value="1" />
            <input type="hidden" name="wpc_parent_per_page" id="wpc_parent_per_page" value="<?php echo $this->wpc_options_serialized->wpc_comment_count; ?>" />
            <input type="hidden" name="wpc_parent_comments_count" id="wpc_parent_comments_count" value="<?php echo $wpc_parent_comments_count; ?>" />
        </div>
    <?php } ?>

    <div style="clear:both"></div>
    <?php if ($this->wpc_options_serialized->wpc_show_plugin_powered_by) { ?>
    <div class="by-woodiscuz"><span id="awoodiscuz" onclick='javascript:document.getElementById("bywoodiscuz").style.display = "inline";
            document.getElementById("awoodiscuz").style.display = "none";'><img src="<?php echo plugins_url(WPC_Core::$PLUGIN_DIRECTORY . '/files/img/plugin-icon/icon_info.png'); ?>" align="absmiddle" class="woodimg"/></span>&nbsp;<a href="http://woodiscuz.com/" id="bywoodiscuz" title="WooDIscuz v<?php echo get_option($this->woodiscuz_version); ?>- Interactive Comment System for eCommerce Platforms">WooDiscuz</a>
    </div>
    <?php }?>
    <div id="wpc_openModalFormAction" class="modalDialog">
        <div id="wpc_response_info" class="wpc_modal">
            <div id="wpc_response_info_box">
                <a href="#close" title="Close" class="close">&nbsp;</a>
                <img width="64" height="64" src="<?php echo plugins_url(WPC_Core::$PLUGIN_DIRECTORY . '/files/img/loader/ajax-loader-200x200.gif'); ?>" />
            </div>
        </div>
    </div>
</div>