<div>
    <h2 style="padding:5px 10px 10px 10px; margin:0px;"><?php _e('Comment Template Phrases', 'woodiscuz'); ?></h2>
    <table class="wp-list-table widefat plugins"  style="margin-top:10px; border:none;">
        <tbody>
            <tr valign="top">
                <th scope="row">
                    <?php _e('Reply', 'woodiscuz'); ?>
                </th>
                <td colspan="3">                                
                    <label for="wpc_reply_text">
                        <input type="text" value="<?php echo $this->wpc_options_serialized->wpc_phrases['wpc_reply_text']; ?>" name="wpc_reply_text" id="wpc_submit_text" />
                    </label>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <?php _e('Share', 'woodiscuz'); ?>
                </th>
                <td colspan="3">                                
                    <label for="wpc_share_text">
                        <input type="text" value="<?php echo $this->wpc_options_serialized->wpc_phrases['wpc_share_text']; ?>" name="wpc_share_text" id="wpc_share_text" />
                    </label>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <?php _e('Edit', 'woodiscuz'); ?>
                </th>
                <td colspan="3">                                
                    <label for="wpc_edit_text">
                        <input type="text" value="<?php echo $this->wpc_options_serialized->wpc_phrases['wpc_edit_text']; ?>" name="wpc_edit_text" id="wpc_edit_text" />
                    </label>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <?php _e('Share On Facebook', 'woodiscuz'); ?>
                </th>
                <td colspan="3">                                
                    <label for="wpc_share_facebook">
                        <input type="text" value="<?php echo $this->wpc_options_serialized->wpc_phrases['wpc_share_facebook']; ?>" name="wpc_share_facebook" id="wpc_share_facebook" />
                    </label>
                </td>
            </tr>
            <tr valign="top" >
                <th scope="row">
                    <?php _e('Share On Twitter', 'woodiscuz'); ?>
                </th>
                <td colspan="3">                                
                    <label for="wpc_share_twitter">
                        <input type="text" value="<?php echo $this->wpc_options_serialized->wpc_phrases['wpc_share_twitter']; ?>" name="wpc_share_twitter" id="wpc_share_twitter" />
                    </label>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <?php _e('Share On Google', 'woodiscuz'); ?>
                </th>
                <td colspan="3">                                
                    <label for="wpc_share_google">
                        <input type="text" value="<?php echo $this->wpc_options_serialized->wpc_phrases['wpc_share_google']; ?>" name="wpc_share_google" id="wpc_share_google" />
                    </label>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <?php _e('Share On VKontakte', 'woodiscuz'); ?>
                </th>
                <td colspan="3">                                
                    <label for="wpc_share_vk">
                        <input type="text" value="<?php echo $this->wpc_options_serialized->wpc_phrases['wpc_share_vk']; ?>" name="wpc_share_vk" id="wpc_share_vk" />
                    </label>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <?php _e('Share On Odnoklassniki', 'woodiscuz'); ?>
                </th>
                <td colspan="3">                                
                    <label for="wpc_share_ok">
                        <input type="text" value="<?php echo $this->wpc_options_serialized->wpc_phrases['wpc_share_ok']; ?>" name="wpc_share_ok" id="wpc_share_ok" />
                    </label>
                </td>
            </tr>
            <tr valign="top" >
                <th scope="row">
                    <?php _e('Hide Replies', 'woodiscuz'); ?>
                </th>
                <td colspan="3">                                
                    <label for="wpc_hide_replies_text">
                        <input type="text" value="<?php echo $this->wpc_options_serialized->wpc_phrases['wpc_hide_replies_text']; ?>" name="wpc_hide_replies_text" id="wpc_hide_replies_text" />
                    </label>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <?php _e('Show Replies', 'woodiscuz'); ?>
                </th>
                <td colspan="3">                                
                    <label for="wpc_show_replies_text">
                        <input type="text" value="<?php echo $this->wpc_options_serialized->wpc_phrases['wpc_show_replies_text']; ?>" name="wpc_show_replies_text" id="wpc_show_replies_text" />
                    </label>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <?php _e('Title For Guests', 'woodiscuz'); ?>
                </th>
                <td colspan="3">                                
                    <label for="wpc_user_title_guest_text">
                        <input type="text" value="<?php echo $this->wpc_options_serialized->wpc_phrases['wpc_user_title_guest_text']; ?>" name="wpc_user_title_guest_text" id="wpc_user_title_guest_text" />
                    </label>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <?php _e('Title For Members', 'woodiscuz'); ?>
                </th>
                <td colspan="3">                                
                    <label for="wpc_user_title_member_text">
                        <input type="text" value="<?php echo $this->wpc_options_serialized->wpc_phrases['wpc_user_title_member_text']; ?>" name="wpc_user_title_member_text" id="wpc_user_title_member_text" />
                    </label>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <?php _e('Title For Customers', 'woodiscuz'); ?>
                </th>
                <td colspan="3">                                
                    <label for="wpc_user_title_customer_text">
                        <input type="text" value="<?php echo $this->wpc_options_serialized->wpc_phrases['wpc_user_title_customer_text']; ?>" name="wpc_user_title_customer_text" id="wpc_user_title_customer_text" />
                    </label>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <?php _e('Title For Support', 'woodiscuz'); ?>
                </th>
                <td colspan="3">                                
                    <label for="wpc_user_title_support_text">
                        <input type="text" value="<?php echo $this->wpc_options_serialized->wpc_phrases['wpc_user_title_support_text']; ?>" name="wpc_user_title_support_text" id="wpc_user_title_support_text" />
                    </label>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <?php _e('Vote Up', 'woodiscuz'); ?>
                </th>
                <td colspan="3">                                
                    <label for="wpc_vote_up">
                        <input type="text" value="<?php echo $this->wpc_options_serialized->wpc_phrases['wpc_vote_up']; ?>" name="wpc_vote_up" id="wpc_vote_up" />
                    </label>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <?php _e('Vote Down', 'woodiscuz'); ?>
                </th>
                <td colspan="3">                                
                    <label for="wpc_vote_down">
                        <input type="text" value="<?php echo $this->wpc_options_serialized->wpc_phrases['wpc_vote_down']; ?>" name="wpc_vote_down" id="wpc_vote_down" />
                    </label>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <?php _e('Save edited comment button text', 'woodiscuz'); ?>
                </th>
                <td colspan="3">                                
                    <label for="wpc_comment_edit_save_button">
                        <input type="text" value="<?php echo isset($this->wpc_options_serialized->wpc_phrases['wpc_comment_edit_save_button']) ? $this->wpc_options_serialized->wpc_phrases['wpc_comment_edit_save_button'] : __('Save', 'wpdisucz'); ?>" name="wpc_comment_edit_save_button" id="wpc_comment_edit_save_button" />
                    </label>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <?php _e('Cancel comment editing button text', 'woodiscuz'); ?>
                </th>
                <td colspan="3">                                
                    <label for="wpc_comment_edit_cancel_button">
                        <input type="text" value="<?php echo isset($this->wpc_options_serialized->wpc_phrases['wpc_comment_edit_cancel_button']) ? $this->wpc_options_serialized->wpc_phrases['wpc_comment_edit_cancel_button'] : __('Cancel', 'wpdisucz'); ?>" name="wpc_comment_edit_cancel_button" id="wpc_comment_edit_cancel_button" />
                    </label>
                </td>
            </tr>
        </tbody>
    </table>
</div>