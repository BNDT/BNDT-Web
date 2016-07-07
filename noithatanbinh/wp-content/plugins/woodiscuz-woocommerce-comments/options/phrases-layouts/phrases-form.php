<div>
    <h2 style="padding:5px 10px 10px 10px; margin:0px;"><?php _e('Form Template Phrases', 'woodiscuz'); ?></h2>
    <table class="wp-list-table widefat plugins"  style="margin-top:10px; border:none;">
        <tbody>
            <tr valign="top">
                <th scope="row">
                    <?php _e('Comment Field Start', 'woodiscuz'); ?>
                </th>
                <td colspan="3">                                
                    <label for="wpc_comment_start_text">
                        <input type="text" value="<?php echo $this->wpc_options_serialized->wpc_phrases['wpc_comment_start_text']; ?>" name="wpc_comment_start_text" id="wpc_comment_start_text" />
                    </label>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <?php _e('Comment Field Join', 'woodiscuz'); ?>
                </th>
                <td colspan="3">                                
                    <label for="wpc_comment_join_text">
                        <input type="text" value="<?php echo $this->wpc_options_serialized->wpc_phrases['wpc_comment_join_text']; ?>" name="wpc_comment_join_text" id="wpc_comment_join_text" />
                    </label>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <?php _e('Email Field', 'woodiscuz'); ?>
                </th>
                <td colspan="3">                                
                    <label for="wpc_email_text">
                        <input type="text" value="<?php echo $this->wpc_options_serialized->wpc_phrases['wpc_email_text']; ?>" name="wpc_email_text" id="wpc_email_text" />
                    </label>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <?php _e('Name Field', 'woodiscuz'); ?>
                </th>
                <td colspan="3">                                
                    <label for="wpc_name_text">
                        <input type="text" value="<?php echo $this->wpc_options_serialized->wpc_phrases['wpc_name_text']; ?>" name="wpc_name_text" id="wpc_email_text" />
                    </label>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <?php _e('CAPTCHA Field', 'woodiscuz'); ?>
                </th>
                <td colspan="3">                                
                    <label for="wpc_captcha_text">
                        <input type="text" value="<?php echo $this->wpc_options_serialized->wpc_phrases['wpc_captcha_text']; ?>" name="wpc_captcha_text" id="wpc_email_text" />
                    </label>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <?php _e('Submit Button', 'woodiscuz'); ?>
                </th>
                <td colspan="3">                                
                    <label for="wpc_submit_text">
                        <input type="text" value="<?php echo $this->wpc_options_serialized->wpc_phrases['wpc_submit_text']; ?>" name="wpc_submit_text" id="wpc_submit_text" />
                    </label>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <?php _e('Notify on new replies (checkbox)', 'woodiscuz'); ?>
                </th>
                <td colspan="3">
                    <label for="wpc_notify_on_new_reply">
                        <input type="text" value="<?php echo isset($this->wpc_options_serialized->wpc_phrases['wpc_notify_on_new_reply']) ? $this->wpc_options_serialized->wpc_phrases['wpc_notify_on_new_reply'] : __('Notify of new replies to this comment','woodiscuz'); ?>" name="wpc_notify_on_new_reply" id="wpc_notify_on_new_reply" />
                    </label>
                </td>
            </tr>
        </tbody>
    </table>
</div>