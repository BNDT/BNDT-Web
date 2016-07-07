<?php

class WPC_Helper
{

    public static $datetime = 'datetime';
    public static $year = 'wpc_year_text';
    public static $years = 'wpc_year_text_plural';
    public static $month = 'wpc_month_text';
    public static $months = 'wpc_month_text_plural';
    public static $day = 'wpc_day_text';
    public static $days = 'wpc_day_text_plural';
    public static $hour = 'wpc_hour_text';
    public static $hours = 'wpc_hour_text_plural';
    public static $minute = 'wpc_minute_text';
    public static $minutes = 'wpc_minute_text_plural';
    public static $second = 'wpc_second_text';
    public static $seconds = 'wpc_second_text_plural';
    private $wpc_options_serialized;
    public $wpc_allowed_tags = array(
        'br' => array(),
        'a' => array('href' => array(), 'title' => array(), 'target' => array(), 'rel' => array(), 'download' => array(), 'hreflang' => array(), 'media' => array(), 'type' => array()),
        'i' => array(),
        'b' => array(),
        'u' => array(),
        'strong' => array(),
        's' => array(),
        'p' => array(),
        'img' => array('src' => array(), 'width' => array(), 'height' => array(), 'alt' => array()),
        'blockquote' => array('cite' => array()),
        'ul' => array(),
        'li' => array(),
        'ol' => array(),
        'code' => array(),
        'em' => array(),
        'abbr' => array('title' => array()),
        'q' => array('cite' => array()),
        'acronym' => array('title' => array()),
        'cite' => array(),
        'strike' => array(),
        'del' => array('datetime' => array()),
    );

    function __construct($wpc_options_serialize)
    {
        $this->wpc_options_serialized = $wpc_options_serialize;
    }

// Set timezone
// Time format is UNIX timestamp or
// PHP strtotime compatible strings
    public function dateDiff($time1, $time2, $precision = 2)
    {
// If not numeric then convert texts to unix timestamps
        if (!is_int($time1)) {
            $time1 = strtotime($time1);
        }
        if (!is_int($time2)) {
            $time2 = strtotime($time2);
        }

// If time1 is bigger than time2
// Then swap time1 and time2
        if ($time1 > $time2) {
            $ttime = $time1;
            $time1 = $time2;
            $time2 = $ttime;
        }

// Set up intervals and diffs arrays
        $intervals = array(
            $this->wpc_options_serialized->wpc_phrases['wpc_year_text']['datetime'][1],
            $this->wpc_options_serialized->wpc_phrases['wpc_month_text']['datetime'][1],
            $this->wpc_options_serialized->wpc_phrases['wpc_day_text']['datetime'][1],
            $this->wpc_options_serialized->wpc_phrases['wpc_hour_text']['datetime'][1],
            $this->wpc_options_serialized->wpc_phrases['wpc_minute_text']['datetime'][1],
            $this->wpc_options_serialized->wpc_phrases['wpc_second_text']['datetime'][1]
        );
        $diffs = array();

// Loop thru all intervals
        foreach ($intervals as $interval) {
// Create temp time from time1 and interval
            $interval = $this->date_comparision_by_index($interval);
            $ttime = strtotime('+1 ' . $interval, $time1);
// Set initial values
            $add = 1;
            $looped = 0;
// Loop until temp time is smaller than time2
            while ($time2 >= $ttime) {
// Create new temp time from time1 and interval
                $add++;
                $ttime = strtotime("+" . $add . " " . $interval, $time1);
                $looped++;
            }

            $time1 = strtotime("+" . $looped . " " . $interval, $time1);
            $diffs[$interval] = $looped;
        }

        $count = 0;
        $times = array();
// Loop thru all diffs
        foreach ($diffs as $interval => $value) {
            $interval = $this->date_text_by_index($interval, $value);
// Break if we have needed precission
            if ($count >= $precision) {
                break;
            }
// Add value and interval 
// if value is bigger than 0
            if ($value > 0) {
// Add value and interval to times array
                $times[] = $value . " " . $interval;
                $count++;
            }
        }

// Return string with times        
        $ago = ($times) ? $this->wpc_options_serialized->wpc_phrases['wpc_ago_text'] : $this->wpc_options_serialized->wpc_phrases['wpc_right_now_text'];
        return implode(" ", $times) . ' ' . $ago;
    }

    /**
     * get comment author avatar if exists otherwise default avatar
     */
    public function get_comment_author_avatar($comment = null)
    {
        global $current_user;
        get_currentuserinfo();

        $comm_auth_user_email = $current_user->user_email;
        if ($comment) {
            $comm_auth_avatar = get_avatar($comment->comment_author_email, 48);
        } else {
            if ($comm_auth_user_email) {
                $comm_auth_avatar = get_avatar($comm_auth_user_email, 48);
            } else {
                $comm_auth_avatar = '<img width="48" height="48" class="avatar avatar-48 photo avatar-default" src="' . plugins_url(WPC_Core::$PLUGIN_DIRECTORY . '/files/img/avatar_default.png') . '" alt=""/>';
            }
        }
        return $comm_auth_avatar;
    }

    public static function init_phrase_key_value($phrase)
    {
        $phrase_value = stripslashes($phrase['phrase_value']);
        switch ($phrase['phrase_key']) {
            case WPC_Helper::$year:
                return array(WPC_Helper::$datetime => array($phrase_value, 1));
            case WPC_Helper::$years:
                return array(WPC_Helper::$datetime => array($phrase_value, 1));
            case WPC_Helper::$month:
                return array(WPC_Helper::$datetime => array($phrase_value, 2));
            case WPC_Helper::$months:
                return array(WPC_Helper::$datetime => array($phrase_value, 2));
            case WPC_Helper::$day:
                return array(WPC_Helper::$datetime => array($phrase_value, 3));
            case WPC_Helper::$days:
                return array(WPC_Helper::$datetime => array($phrase_value, 3));
            case WPC_Helper::$hour:
                return array(WPC_Helper::$datetime => array($phrase_value, 4));
            case WPC_Helper::$hours:
                return array(WPC_Helper::$datetime => array($phrase_value, 4));
            case WPC_Helper::$minute:
                return array(WPC_Helper::$datetime => array($phrase_value, 5));
            case WPC_Helper::$minutes:
                return array(WPC_Helper::$datetime => array($phrase_value, 5));
            case WPC_Helper::$second:
                return array(WPC_Helper::$datetime => array($phrase_value, 6));
            case WPC_Helper::$seconds:
                return array(WPC_Helper::$datetime => array($phrase_value, 6));
            default :
                return $phrase_value;
        }
    }

    private function date_comparision_by_index($index)
    {
        switch ($index) {
            case 1:
                return 'year';
            case 2:
                return 'month';
            case 3:
                return 'day';
            case 4:
                return 'hour';
            case 5:
                return 'minute';
            case 6:
                return 'second';
        }
    }

    private function date_text_by_index($index, $value)
    {
        switch ($index) {
            case 'year':
                return ($value > 1) ? $this->wpc_options_serialized->wpc_phrases['wpc_year_text_plural']['datetime'][0] : $this->wpc_options_serialized->wpc_phrases['wpc_year_text']['datetime'][0];
            case 'month':
                return ($value > 1) ? $this->wpc_options_serialized->wpc_phrases['wpc_month_text_plural']['datetime'][0] : $this->wpc_options_serialized->wpc_phrases['wpc_month_text']['datetime'][0];
            case 'day':
                return ($value > 1) ? $this->wpc_options_serialized->wpc_phrases['wpc_day_text_plural']['datetime'][0] : $this->wpc_options_serialized->wpc_phrases['wpc_day_text']['datetime'][0];
            case 'hour':
                return ($value > 1) ? $this->wpc_options_serialized->wpc_phrases['wpc_hour_text_plural']['datetime'][0] : $this->wpc_options_serialized->wpc_phrases['wpc_hour_text']['datetime'][0];
            case 'minute':
                return ($value > 1) ? $this->wpc_options_serialized->wpc_phrases['wpc_minute_text_plural']['datetime'][0] : $this->wpc_options_serialized->wpc_phrases['wpc_minute_text']['datetime'][0];
            case 'second':
                return ($value > 1) ? $this->wpc_options_serialized->wpc_phrases['wpc_second_text_plural']['datetime'][0] : $this->wpc_options_serialized->wpc_phrases['wpc_second_text']['datetime'][0];
        }
    }

    public static function get_comment_root($comment_id)
    {
        $comment = get_comment($comment_id);

        if (!$comment) {
            return -1;
        }

        if ($comment->comment_parent) {
            return WPC_Helper::get_comment_root($comment->comment_parent);
        } else {
            return $comment;
        }
    }

    public function make_url_clickable($matches)
    {
        $ret = '';
        $url = $matches[2];

        if (empty($url))
            return $matches[0];
        // removed trailing [.,;:] from URL
        if (in_array(substr($url, -1), array('.', ',', ';', ':')) === true) {
            $ret = substr($url, -1);
            $url = substr($url, 0, strlen($url) - 1);
        }
        return $matches[1] . "<a href=\"$url\" rel=\"nofollow\">$url</a>" . $ret;
    }

    public function make_web_ftp_clickable($matches)
    {
        $ret = '';
        $dest = $matches[2];
        $dest = 'http://' . $dest;

        if (empty($dest))
            return $matches[0];
        // removed trailing [,;:] from URL
        if (in_array(substr($dest, -1), array('.', ',', ';', ':')) === true) {
            $ret = substr($dest, -1);
            $dest = substr($dest, 0, strlen($dest) - 1);
        }
        return $matches[1] . "<a href=\"$dest\" rel=\"nofollow\">$dest</a>" . $ret;
    }

    public function make_email_clickable($matches)
    {
        $email = $matches[2] . '@' . $matches[3];
        return $matches[1] . "<a href=\"mailto:$email\">$email</a>";
    }

    public function make_clickable($ret)
    {
        $ret = ' ' . $ret;
        $ret = preg_replace('#[^\"|\'](https?:\/\/[^\s]+(\.jpe?g|\.png|\.gif|\.bmp))#i', '<a href="$1"><img src="$1" /></a>', $ret);
        // in testing, using arrays here was found to be faster
        $ret = preg_replace_callback('#([\s>])([\w]+?://[\w\\x80-\\xff\#$%&~/.\-;:=,?@\[\]+]*)#is', array(&$this, 'make_url_clickable'), $ret);
        $ret = preg_replace_callback('#([\s>])((www|ftp)\.[\w\\x80-\\xff\#$%&~/.\-;:=,?@\[\]+]*)#is', array(&$this, 'make_web_ftp_clickable'), $ret);
        $ret = preg_replace_callback('#([\s>])([.0-9a-z_+-]+)@(([0-9a-z-]+\.)+[0-9a-z]{2,})#i', array(&$this, 'make_email_clickable'), $ret);

        // this one is not in an array because we need it to run last, for cleanup of accidental links within links
        $ret = preg_replace("#(<a( [^>]+?>|>))<a [^>]+?>([^>]+?)</a></a>#i", "$1$3</a>", $ret);

        $ret = trim($ret);
        return $ret;
    }

    /**
     * check if comment is still editable or not
     * return boolean
     */
    public function is_comment_editable($comment)
    {
        if ($comment->comment_ID) {
            $wpc_editable_comment_time = isset($this->wpc_options_serialized->wpc_comment_editable_time) ? $this->wpc_options_serialized->wpc_comment_editable_time : 0;
            return $wpc_editable_comment_time && ((time() - strtotime($comment->comment_date_gmt)) < intval($wpc_editable_comment_time));
        } else {
            return false;
        }
    }

    /**
     * return client real ip
     */
    public static function get_real_ip_addr()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {   //check ip from share internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {   //to check ip is pass from proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    /**
     * check if comment has been posted today or not
     * return boolean
     */
    public static function is_posted_today($comment)
    {
        return date('Ymd', strtotime(current_time('Ymd'))) <= date('Ymd', strtotime($comment->comment_date));
    }


    public function wpc_set_priorities(&$tabs, $wpc_priority)
    {
        if ($wpc_priority == 1) {
            $priority = 1;
            foreach ($tabs as $key => $tab) {
                $tabs[$key]['priority'] += 2;
            }
        } else if (count($tabs) <= $wpc_priority) {
            $priority = 1001;
        } else {
            $tabs_priority = array();
            foreach ($tabs as $tab) {
                $tabs_priority[] = $tab['priority'];
            }
            array_multisort($tabs_priority, SORT_ASC, $tabs);
            $priority = $tabs_priority[$wpc_priority - 1];
            $i = 0;
            foreach ($tabs as $key => $tab) {
                if ($i >= $wpc_priority - 1) {
                    $tabs[$key]['priority'] += 2;
                }
                $i++;
            }
        }
        return $priority;
    }


}