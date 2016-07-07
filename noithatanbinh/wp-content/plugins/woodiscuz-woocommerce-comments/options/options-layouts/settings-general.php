<div>
    <h2 style="padding:5px 10px 10px 10px; margin:0px;"><?php _e('General Settings', 'woodiscuz'); ?></h2>
    <table class="wp-list-table widefat plugins"  style="margin-top:10px; border:none;">
        <tbody>
            <tr valign="top">
                <th scope="row" style="width:55%;">
                    <?php _e('Set the Discussion Tab as the first opened Tab', 'woodiscuz'); ?>
                </th>
                <td colspan="2">
                    <label for="wpc_comment_tab_priority">
                        <input type="number" value="<?php echo isset($this->wpc_options_serialized->wpc_comment_tab_priority) ? $this->wpc_options_serialized->wpc_comment_tab_priority : 1000 ?>" name="wpc_comment_tab_priority" id="wpc_comment_tab_priority" />
                    </label>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row" style="width:55%;">
                    <?php _e('Is name field required?', 'woodiscuz'); ?>
                </th>
                <td colspan="2">                                
                    <label for="wpc_is_name_field_required">
                        <input type="checkbox" <?php checked($this->wpc_options_serialized->wpc_is_name_field_required == 1) ?> value="1" name="wpc_is_name_field_required" id="wpc_is_name_field_required" />
                    </label>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row" style="width:55%;">
                    <?php _e('Is email field required? ', 'woodiscuz'); ?>
                </th>
                <td colspan="2">                                
                    <label for="wpc_is_email_field_required">
                        <input type="checkbox" <?php checked($this->wpc_options_serialized->wpc_is_email_field_required == 1) ?> value="1" name="wpc_is_email_field_required" id="wpc_is_email_field_required" />
                    </label>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row" style="width:55%;">
                    <?php _e("Keep comment threads private for product author and thread starter. <br/> This option will not allow users reply in other users' threads, however those will be readable for all.", 'woodiscuz'); ?> 
                </th>
                <td colspan="2">                                
                    <label for="wpc_reply_button_only_author_show">
                        <input type="checkbox" <?php checked($this->wpc_options_serialized->wpc_reply_button_only_author_show == 1) ?> value="1" name="wpc_reply_button_only_author_show" id="wpc_reply_button_only_author_show" />
                    </label>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row" style="width:55%;">
                    <?php _e('Usergroups for User Title "Support"', 'woodiscuz'); ?> 
                </th>
                <td colspan="2">
                    <?php
                    foreach ($roles as $key => $role) {
                        if ($key != 'subscriber') {
                            ?>
                            <label for="<?php echo $key; ?>">
                                <input type="checkbox" <?php checked(in_array($key, $this->wpc_options_serialized->wpc_usergroups_for_support_title)); ?> value="<?php echo $key; ?>" name="wpc_usergroups_for_support_title[]" id="<?php echo $key; ?>" />
                                <span><?php echo $role; ?></span>
                            </label><br/>
                            <?php
                        }
                    }
                    ?>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <label for="wpc_comment_editable_time"><?php _e('Allow comment editing for', 'woodiscuz'); ?></label>
                </th>
                <td>
                    <select id="wpc_comment_editable_time" name="wpc_comment_editable_time">
                        <?php $wpc_comment_editable_time = isset($this->wpc_options_serialized->wpc_comment_editable_time) ? $this->wpc_options_serialized->wpc_comment_editable_time : 0; ?>
                        <option value="0" <?php selected($wpc_comment_editable_time, '0'); ?>><?php _e('Not Allow', 'woodiscuz'); ?></option>
                        <option value="900" <?php selected($wpc_comment_editable_time, '900'); ?>>15 <?php _e('Minutes', 'woodiscuz'); ?></option>
                        <option value="1800" <?php selected($wpc_comment_editable_time, '1800'); ?>>30 <?php _e('Minutes', 'woodiscuz'); ?></option>
                        <option value="3600" <?php selected($wpc_comment_editable_time, '3600'); ?>>1 <?php _e('Hour', 'woodiscuz'); ?></option>
                        <option value="10800" <?php selected($wpc_comment_editable_time, '10800'); ?>>3 <?php _e('Hours', 'woodiscuz'); ?></option>
                        <option value="86400" <?php selected($wpc_comment_editable_time, '86400'); ?>>24 <?php _e('Hours', 'woodiscuz'); ?></option>
                    </select>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <?php _e('Redirect first commenter to', 'woodiscuz'); ?>
                </th>
                <td>
                    <?php
                    wp_dropdown_pages(array(
                        'name' => 'woodiscuz_redirect_page',
                        'selected' => isset($this->wpc_options_serialized->woodiscuz_redirect_page) ? $this->wpc_options_serialized->woodiscuz_redirect_page : 0,
                        'show_option_none' => __('Do not redirect'),
                        'option_none_value' => 0
                    ));
                    ?>
                </td>
            </tr> 
            <tr valign="top">
                <th scope="row" style="width:55%;">
                    <?php _e('Requesting for comment on purchased product', 'woodiscuz'); ?> 
                </th>
                <td colspan="2">                                
                    <label for="wpc_request_for_comment">
                        <input type="checkbox" <?php checked($this->wpc_options_serialized->wpc_request_for_comment == 1) ?> value="1" name="wpc_request_for_comment" id="wpc_request_for_comment" />
                    </label>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <?php _e('Allow guests to vote on comments', 'woodiscuz'); ?>
                </th>
                <td>                                
                    <label for="wpc_is_guest_can_vote">
                        <input type="checkbox" <?php checked($this->wpc_options_serialized->wpc_is_guest_can_vote == 1) ?> value="1" name="wpc_is_guest_can_vote" id="wpc_is_guest_can_vote" />
                    </label>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row" style="width:55%;">
                    <?php _e('Use WordPress Date/Time format', 'woodiscuz'); ?> 
        <p style="font-size:13px; color:#999999; width:80%; padding-left:0px; margin-left:0px;"><?php _e('WooDiscuz shows Human Readable date format. If you check this option it\'ll show the date/time format set in WordPress General Settings.', 'woodiscuz'); ?></p>
        </th>
        <td colspan="2">
            <label for="wpc_simple_comment_date">
                <input type="checkbox" <?php checked($this->wpc_options_serialized->wpc_simple_comment_date == 1) ?> value="1" name="wpc_simple_comment_date" id="wpc_simple_comment_date" />
            </label><br/>
        </td>
        </tr>
        <tr valign="top">
            <th scope="row" >
                <?php _e('Use Plugin .PO/.MO files', 'woodiscuz'); ?>
        <p style="font-size:13px; color:#999999; width:80%; padding-left:0px; margin-left:0px;"><?php _e('WooDiscuz phrase system allows you to translate all front-end phrases. However if you have a multi-language website it\'ll not allow you to add more than one language translation. The only way to get it is the plugin translation files (.PO / .MO). If WooDiscuz has the languages you need you should check this option to disable phrase system and it\'ll automatically translate all phrases based on language files according to current language.', 'woodiscuz'); ?></p>
        </th>
        <td colspan="3">                                
            <label for="wpc_is_use_po_mo">
                <input type="checkbox" <?php checked($this->wpc_options_serialized->wpc_is_use_po_mo == 1) ?> value="1" name="wpc_is_use_po_mo" id="wpc_is_use_po_mo" />
            </label>
        </td>
        </tr>
        <tr valign="top">
            <th scope="row" >
                <label for="wpc_show_plugin_powered_by">
                    <?php _e('Help Woodiscuz to grow allowing people to recognize which comment plugin you use', 'woodiscuz'); ?>
                </label>
        <p style="font-size:13px; color:#999999; width:80%; padding-left:0px; margin-left:0px;"><?php _e('Please check this option on to help Woodiscuz get more popularity as your thank to the hard work we do for you totally free. This option adds a very small (16x16px) icon under the comment section which will allow your site visitors recognize the name of comment solution you use.', 'woodiscuz'); ?></p>
        </th>
        <td colspan="3">                                
            <label for="wpc_show_plugin_powered_by">
                <input type="checkbox" <?php checked($this->wpc_options_serialized->wpc_show_plugin_powered_by == 1) ?> value="1" name="wpc_show_plugin_powered_by" id="wpc_show_plugin_powered_by" />
                <span id="woodiscuz_thank_you" style="color:#006600; font-size:13px;"><?php _e('Thank you!', 'woodiscuz'); ?></span>
            </label>
        </td>
        </tr>
        </tbody>
    </table>
</div>