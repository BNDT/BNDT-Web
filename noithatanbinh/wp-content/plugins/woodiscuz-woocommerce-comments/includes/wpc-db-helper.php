<?php

class WPC_DB_Helper {

    private $db;
    private $dbprefix;
    private $users_voted;
    private $phrases;
    private $email_notification;

    function __construct() {
        global $wpdb;
        $this->db = $wpdb;
        $this->dbprefix = $wpdb->prefix;
        $this->users_voted = $this->dbprefix . 'wpc_users_voted';
        $this->phrases = $this->dbprefix . 'wpc_phrases';
        $this->email_notification = $this->dbprefix. 'wpc_comments_subscription';
    }

    /**
     * create table in db on activation if not exists
     */
    public function create_tables() {
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        if ($this->db->get_var("SHOW TABLES LIKE '$this->users_voted'") != $this->users_voted) {
            $sql = "CREATE TABLE `" . $this->users_voted . "`(`id` INT(11) NOT NULL AUTO_INCREMENT,`user_id` VARCHAR(255) NOT NULL, `comment_id` INT(11) NOT NULL, `vote_type` INT(11) DEFAULT NULL, `is_guest` TINYINT(1) DEFAULT 0,`voting_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP, PRIMARY KEY (`id`), KEY `user_id` (`user_id`), KEY `comment_id` (`comment_id`),  KEY `vote_type` (`vote_type`), KEY `is_guest` (`is_guest`)) ENGINE=MyISAM DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci AUTO_INCREMENT=1;";
            dbDelta($sql);
        }
        if ($this->db->get_var("SHOW TABLES LIKE '$this->phrases'") != $this->phrases) {
            $sql = "CREATE TABLE `" . $this->phrases . "`(`id` INT(11) NOT NULL AUTO_INCREMENT, `phrase_key` VARCHAR(255) NOT NULL, `phrase_value` TEXT NOT NULL, PRIMARY KEY (`id`), KEY `phrase_key` (`phrase_key`)) ENGINE=MyISAM DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci AUTO_INCREMENT=1;";
            dbDelta($sql);
        }

        if ($this->db->get_var("SHOW TABLES LIKE '$this->email_notification'") != $this->email_notification) {
            $sql = "CREATE TABLE `" . $this->email_notification . "`(`id` INT(11) NOT NULL AUTO_INCREMENT, `email` VARCHAR(255) NOT NULL, `subscribtion_id` INT(11) NOT NULL, `post_id` INT(11) NOT NULL, `subscribtion_type` VARCHAR(255) NOT NULL, `activation_key` VARCHAR(255) NOT NULL, `confirm` TINYINT DEFAULT 0, `subscription_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP, PRIMARY KEY (`id`), KEY `subscribtion_id` (`subscribtion_id`), KEY `post_id` (`post_id`), KEY `confirm`(`confirm`)) ENGINE=MYISAM DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci AUTO_INCREMENT=1;";
            dbDelta($sql);
        }
    }

    /**
     * updates the comments to set comment type review if comment id is exists in comment meta table
     */
    public function update_comments_types() {
        $select_query = "SELECT `comment_id` FROM `" . $this->dbprefix . "commentmeta` WHERE `meta_key` LIKE 'rating';";
        $comments_ids = $this->db->get_results($select_query, ARRAY_A);

        if ($comments_ids) {
            $comment_ids_arr = array();
            foreach ($comments_ids as $comment_id) {
                $comment_ids_arr[] = $comment_id['comment_id'];
            }
            $comment_ids = implode(',', $comment_ids_arr);
            $update_query = "UPDATE `" . $this->dbprefix . "comments` SET `comment_type` = 'woodiscuz_review' WHERE `comment_ID` IN($comment_ids) AND `comment_type` LIKE '';";
            $this->db->query($update_query);
        }
    }

    /**
     * get woodiscuz comments count 
     */
    public function get_comment_count($product_id = null) {
        if ($product_id) {
            // get all comments count by product id
            $where = "WHERE c.`comment_type` LIKE 'woodiscuz' AND `c`.`comment_approved` = 1 AND `c`.`comment_post_ID` = %d;";
        } else {
            // get all comments count 
            $where = "WHERE c.`comment_type` LIKE 'woodiscuz' AND `c`.`comment_approved` = 1;";
        }
        $select_query = $this->db->prepare("SELECT COUNT(comment_ID) FROM `" . $this->dbprefix . "comments` AS c INNER JOIN `" . $this->dbprefix . "posts` AS p ON p.`ID` = c.`comment_post_ID` AND p.`post_status` LIKE 'publish' " . $where, $product_id);
        return $this->db->get_var($select_query);
    }

    /**
     * add vote type
     */
    public function add_vote_type($user_id, $comment_id, $vote_type) {
        $is_guest = is_user_logged_in() ? 0 : 1;
        $sql = $this->db->prepare("INSERT INTO `" . $this->users_voted . "`(`user_id`, `comment_id`, `vote_type`,`is_guest`) VALUES (%s, %d, %d, %d);", $user_id, $comment_id, $vote_type, $is_guest);
        return $this->db->query($sql);
    }

    /**
     * update vote type
     */
    public function update_vote_type($user_id, $comment_id, $vote_type) {
        $sql = $this->db->prepare("UPDATE `" . $this->users_voted . "` SET `vote_type` = %d WHERE `user_id` = %s AND `comment_id` = %d", $vote_type, $user_id, $comment_id);
        return $this->db->query($sql);
    }

    /**
     * returns reviews count
     */
    public function get_reviews_count($comment_type, $post_id) {
        $select_query = $this->db->prepare("SELECT count(*) FROM `" . $this->dbprefix . "comments` WHERE `comment_type` LIKE %s AND `comment_post_ID` = %d AND `comment_approved` = 1;", $comment_type, $post_id);
        $r_count = $this->db->get_var($select_query);
        return $r_count;
    }

    /**
     * check if the user is already voted on comment or not by user id and comment id
     */
    public function is_user_voted($user_id, $comment_id) {
        $sql = $this->db->prepare("SELECT `vote_type` FROM `" . $this->users_voted . "` WHERE `user_id` = %d AND `comment_id` = %d;", $user_id, $comment_id);
        return $this->db->get_var($sql);
    }

    /**
     * update phrases 
     */
    public function update_phrases($phrases) {
        if ($phrases) {
            foreach ($phrases as $phrase_key => $phrase_value) {

                if (is_array($phrase_value) && array_key_exists(WPC_Helper::$datetime, $phrase_value)) {
                    $phrase_value = $phrase_value[WPC_Helper::$datetime][0];
                }
                if ($this->is_phrase_exists($phrase_key)) {
                    $sql = $this->db->prepare("UPDATE `" . $this->phrases . "` SET `phrase_value` = %s WHERE `phrase_key` = %s;", str_replace('"', '&#34;', $phrase_value), $phrase_key);
                } else {
                    $sql = $this->db->prepare("INSERT INTO `" . $this->phrases . "`(`phrase_key`, `phrase_value`)VALUES(%s, %s);", $phrase_key, str_replace('"', '&#34;', $phrase_value));
                }
                $this->db->query($sql);
            }
        }
    }

    public function is_phrase_exists($phrase_key) {
        $sql = $this->db->prepare("SELECT `phrase_key` FROM `" . $this->phrases . "` WHERE `phrase_key` LIKE %s", $phrase_key);
        return $this->db->get_var($sql);
    }

    /**
     * get phrases from db
     */
    public function get_phrases() {
        $sql = "SELECT `phrase_key`, `phrase_value` FROM `" . $this->phrases . "`;";
        $phrases = $this->db->get_results($sql, ARRAY_A);
        $tmp_phrases = array();
        foreach ($phrases as $phrase) {
            $tmp_phrases[$phrase['phrase_key']] = WPC_Helper::init_phrase_key_value($phrase);
        }
        return $tmp_phrases;
    }

    /**
     * get product comments which types is null
     */
    public function get_empty_comment_types() {
        $result = $this->db->get_results("SELECT `comm`.`comment_ID` as `comment_id` FROM `" . $this->db->prefix . "comments` AS `comm`, `" . $this->db->prefix . "commentmeta` AS `meta` WHERE `comm`.`comment_ID` = `meta`.`comment_id` AND `comm`.`comment_type` LIKE '' AND `meta`.`meta_key` LIKE 'rating';", ARRAY_A);
        return $result;
    }

    public function wpc_alter_voting_phrases_tables() {
        $sql_alter = "ALTER TABLE `" . $this->users_voted . "` MODIFY `user_id` VARCHAR(255) NOT NULL, ADD COLUMN `is_guest` TINYINT(1) DEFAULT 0, ADD COLUMN `voting_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP, ADD INDEX `is_guest` (`is_guest`);";
        $this->db->query($sql_alter);
        $sql_alter = "ALTER TABLE `" . $this->phrases . "` MODIFY `phrase_value` TEXT NOT NULL;";
        $this->db->query($sql_alter);
    }

    public function wpc_has_comment_notification($post_id, $comment_id, $email) {
        $sql = $this->db->prepare("SELECT `id` FROM `" . $this->email_notification . "` WHERE  `subscribtion_id` = %d AND `email` = %s", $comment_id, $email);
        $result = $this->db->get_results($sql, ARRAY_N);
        return count($result);
    }

    public function wpc_add_email_notification($id, $post_id, $email) {
        $activation_key = md5($email . uniqid() . time());
        $sql = $this->db->prepare("INSERT INTO `" . $this->email_notification . "` (`email`, `subscribtion_id`, `post_id`, `subscribtion_type`, `activation_key`) VALUES(%s, %d, %d, %s, %s);", $email, $id, $post_id, 'reply', $activation_key);
        $this->db->query($sql);
        return $this->db->insert_id;
    }

    /**
     * generate confirm link
     */
    public function wpc_confirm_link($subscrib_id) {
        global $wp_rewrite;
        $sql_subscriber_data = $this->db->prepare("SELECT `id`, `post_id`, `activation_key` FROM `" . $this->email_notification . "` WHERE `id` = %d ", $subscrib_id);
        $wpc_confirm = $this->db->get_row($sql_subscriber_data, ARRAY_A);
        $post_id = $wpc_confirm['post_id'];
        $wpc_confirm_link = !$wp_rewrite->using_permalinks() ?  get_permalink($post_id) . "&" : get_permalink($post_id) . "?" ;
        $wpc_confirm_link .= "wooDiscuzConfirmID=" . $wpc_confirm['id'] . "&wooDiscuzConfirmKey=" . $wpc_confirm['activation_key'] . '&wooDiscuzConfirm=yes&#wpc_unsubscribe_message';
        return $wpc_confirm_link;
    }

    /**
     * Confirm  post or comment subscribtion
     */
    public function wpc_notification_confirm($subscribe_id, $key) {
        $sql_confirm = $this->db->prepare("UPDATE `" . $this->email_notification . "` SET `confirm` = 1 WHERE `id` = %d AND `activation_key` LIKE %s;", $subscribe_id, $key);
        return $this->db->query($sql_confirm);
    }

    /**
     * create unsubscribe link
     */
    public function wpc_unsubscribe_link($id, $email) {
        global $wp_rewrite;
        $sql_subscriber_data = $this->db->prepare("SELECT `id`, `post_id`, `activation_key` FROM `" . $this->email_notification . "` WHERE `subscribtion_type` = 'comment' AND `subscribtion_id` = %d  AND `email` LIKE %s",  $id, $email);
        $wpc_unsubscribe = $this->db->get_row($sql_subscriber_data, ARRAY_A);
        $post_id = $wpc_unsubscribe['post_id'];
        $wpc_unsubscribe_link = !$wp_rewrite->using_permalinks() ?  get_permalink($post_id) . "&" : get_permalink($post_id) . "?" ;
        $wpc_unsubscribe_link .= "wooDiscuzSubscribeID=" . $wpc_unsubscribe['id'] . "&key=" . $wpc_unsubscribe['activation_key'] . '&#wpc_unsubscribe_message';
        return $wpc_unsubscribe_link;
    }

    public function wpc_get_post_new_reply_notification($comment_id, $email) {
        $sql = $this->db->prepare("SELECT  `id`,`email`,`activation_key` FROM `" . $this->email_notification . "` WHERE `subscribtion_type` = 'reply' AND `confirm` = 1 AND `subscribtion_id` = %d  AND `email` != %s;", $comment_id, $email);
        return $this->db->get_results($sql, ARRAY_A);
    }
	
	/**
     * delete subscription
     */
    public function wpc_unsubscribe($id, $activation_key) {
        $sql_unsubscribe = $this->db->prepare("DELETE FROM `" . $this->email_notification . "` WHERE `id` = %d AND `activation_key` LIKE %s", $id, $activation_key);
        return $this->db->query($sql_unsubscribe);
    }

}

?>