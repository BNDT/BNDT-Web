<div>
    <h2 style="padding:5px 10px 10px 10px; margin:0px;"><?php _e('Notification Phrases', 'woodiscuz'); ?></h2>
    <table class="wp-list-table widefat plugins"  style="margin-top:10px; border:none;">
        <tbody>
            <tr valign="top">
                <th scope="row">
                    <?php _e('Error message for empty field', 'woodiscuz'); ?>
                </th>
                <td colspan="3">                                
                    <label for="wpc_error_empty_text">
                        <input type="text" value="<?php echo $this->wpc_options_serialized->wpc_phrases['wpc_error_empty_text']; ?>" name="wpc_error_empty_text" id="wpc_error_empty_text" />
                    </label>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <?php _e('Error message for invalid email field', 'woodiscuz'); ?>
                </th>
                <td colspan="3">                                
                    <label for="wpc_error_email_text">
                        <input type="text" value="<?php echo $this->wpc_options_serialized->wpc_phrases['wpc_error_email_text']; ?>" name="wpc_error_email_text" id="wpc_error_email_text" />
                    </label>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <?php _e('You must be', 'woodiscuz'); ?>
                </th>
                <td colspan="3">                                
                    <label for="wpc_you_must_be_text">
                        <input type="text" value="<?php echo $this->wpc_options_serialized->wpc_phrases['wpc_you_must_be_text']; ?>" name="wpc_you_must_be_text" id="wpc_you_must_be_text" />
                    </label>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <?php _e('Logged In', 'woodiscuz'); ?>
                </th>
                <td colspan="3">                                
                    <label for="wpc_logged_in_text">
                        <input type="text" value="<?php echo $this->wpc_options_serialized->wpc_phrases['wpc_logged_in_text']; ?>" name="wpc_logged_in_text" id="wpc_logged_in_text" />
                    </label>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <?php _e('To post a comment', 'woodiscuz'); ?>
                </th>
                <td colspan="3">                                
                    <label for="wpc_to_post_comment_text">
                        <input type="text" value="<?php echo $this->wpc_options_serialized->wpc_phrases['wpc_to_post_comment_text']; ?>" name="wpc_to_post_comment_text" id="wpc_to_post_comment_text" />
                    </label>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <?php _e('Vote Counted', 'woodiscuz'); ?>
                </th>
                <td colspan="3">                                
                    <label for="wpc_vote_counted">
                        <input type="text" value="<?php echo $this->wpc_options_serialized->wpc_phrases['wpc_vote_counted']; ?>" name="wpc_vote_counted" id="wpc_vote_counted" />
                    </label>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <?php _e('You can vote only 1 time', 'woodiscuz'); ?>
                </th>
                <td colspan="3">                                
                    <label for="wpc_vote_only_one_time">
                        <input type="text" value="<?php echo $this->wpc_options_serialized->wpc_phrases['wpc_vote_only_one_time']; ?>" name="wpc_vote_only_one_time" id="wpc_vote_only_one_time" />
                    </label>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <?php _e('Voting Error', 'woodiscuz'); ?>
                </th>
                <td colspan="3">                                
                    <label for="wpc_voting_error">
                        <input type="text" value="<?php echo $this->wpc_options_serialized->wpc_phrases['wpc_voting_error']; ?>" name="wpc_voting_error" id="wpc_voting_error" />
                    </label>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <?php _e('Login To Vote', 'woodiscuz'); ?>
                </th>
                <td colspan="3">                                
                    <label for="wpc_login_to_vote">
                        <input type="text" value="<?php echo $this->wpc_options_serialized->wpc_phrases['wpc_login_to_vote']; ?>" name="wpc_login_to_vote" id="wpc_login_to_vote" />
                    </label>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <?php _e('You Cannot Vote On Your Comment', 'woodiscuz'); ?>
                </th>
                <td colspan="3">                                
                    <label for="wpc_self_vote">
                        <input type="text" value="<?php echo $this->wpc_options_serialized->wpc_phrases['wpc_self_vote']; ?>" name="wpc_self_vote" id="wpc_self_vote" />
                    </label>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <?php _e('Invalid Captcha Code', 'woodiscuz'); ?>
                </th>
                <td colspan="3">                                
                    <label for="wpc_invalid_captcha">
                        <input type="text" value="<?php echo $this->wpc_options_serialized->wpc_phrases['wpc_invalid_captcha']; ?>" name="wpc_invalid_captcha" id="wpc_invalid_captcha" />
                    </label>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <?php _e('Some of field value is invalid', 'woodiscuz'); ?>
                </th>
                <td colspan="3">                                
                    <label for="wpc_invalid_field">
                        <input type="text" value="<?php echo $this->wpc_options_serialized->wpc_phrases['wpc_invalid_field']; ?>" name="wpc_invalid_field" id="wpc_invalid_field" />
                    </label>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <?php _e('Comment waiting moderation', 'woodiscuz'); ?>
                </th>
                <td colspan="3">                                
                    <label for="wpc_held_for_moderate">
                        <input type="text" value="<?php echo $this->wpc_options_serialized->wpc_phrases['wpc_held_for_moderate']; ?>" name="wpc_held_for_moderate" id="wpc_held_for_moderate" />
                    </label>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <?php _e('Message if comment was not updated', 'woodiscuz'); ?>
                </th>
                <td colspan="3">                                
                    <label for="wpc_comment_not_updated">
                        <input type="text" value="<?php echo isset($this->wpc_options_serialized->wpc_phrases['wpc_comment_not_updated']) ? $this->wpc_options_serialized->wpc_phrases['wpc_comment_not_updated'] : __('Sorry, the comment was not updated', 'wpdisucz'); ?>" name="wpc_comment_not_updated" id="wpc_comment_not_updated" />
                    </label>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <?php _e('Message if comment no longer possible to edit', 'woodiscuz'); ?>
                </th>
                <td colspan="3">                                
                    <label for="wpc_comment_edit_not_possible">
                        <input type="text" value="<?php echo isset($this->wpc_options_serialized->wpc_phrases['wpc_comment_edit_not_possible']) ? $this->wpc_options_serialized->wpc_phrases['wpc_comment_edit_not_possible'] : __('Sorry, this comment no longer possible to edit', 'wpdisucz'); ?>" name="wpc_comment_edit_not_possible" id="wpc_comment_edit_not_possible" />
                    </label>
                </td>
            </tr>

            <tr valign="top">
                <th scope="row">
                    <?php _e('Message if comment text not changed', 'woodiscuz'); ?>
                </th>
                <td colspan="3">                                
                    <label for="wpc_comment_not_edited">
                        <input type="text" value="<?php echo isset($this->wpc_options_serialized->wpc_phrases['wpc_comment_not_edited']) ? $this->wpc_options_serialized->wpc_phrases['wpc_comment_not_edited'] : __('TYou\'ve not made any changes', 'wpdisucz'); ?>" name="wpc_comment_not_edited" id="wpc_comment_not_edited" />
                    </label>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <?php _e('You\'ve successfully unsubscribed.', 'woodiscuz'); ?>
                </th>
                <td colspan="3">
                    <label for="wpc_unsubscribe_message">
                        <textarea name="wpc_unsubscribe_message" id="wpc_unsubscribe_message"><?php echo $this->wpc_options_serialized->wpc_phrases['wpc_unsubscribe_message']; ?></textarea>
                    </label>
                </td>
            </tr>
        </tbody>
    </table>
</div>