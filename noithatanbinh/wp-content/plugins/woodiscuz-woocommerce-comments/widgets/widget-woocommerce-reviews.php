<?php

class WooDiscuz_Reviews_Widget extends WP_Widget {

    public function __construct() {
        /**
         * the widget class name and description
         */
        $widget_ops = array(
            'classname' => 'woodiscuz_woocommerce_reviews_widget',
            'description' => __('This Widget displays woocommerce recent reviews', 'woodiscuz')
        );
        $control_ops = array();
        parent::__construct('woodiscuz_woocommerce_recent_reviews', __('Woodiscuz Recent Reviews', 'woodiscuz'), $widget_ops, $control_ops);
    }

    /**
     * Initialize The Widget
     */
    public function widget($args, $instance) {
        extract($args);
        $title = apply_filters('widget_title', $instance['title']);
        $before_widget = $args['before_widget'];
        $after_widget = $args['after_widget'];
        $before_title = $args['before_title'];
        $after_title = $args['after_title'];
        $number = (intval($instance['number'])) ? intval($instance['number']) : 10;
        $comments = get_comments(
                array('number' => $number,
                    'status' => 'approve',
                    'post_status' => 'publish',
                    'post_type' => 'product',
                    'type' => 'woodiscuz_review')
        );
        if ($comments) {
            // Widget 
            echo $before_widget;

            if ($title) {
                echo $before_title . strip_tags($title) . $after_title;
            }

            include('frontend-layout' . WOODISCUZDS . 'layout-woodiscuz-woocommerce-reviews.php');

            echo $after_widget;
            // end Widget
        }
    }

    /**
     * Update the widget options
     */
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['number'] = intval($new_instance['number']) ? intval($new_instance['number']) : 10;
        $instance['before_widget'] = $new_instance['before_widget'];
        $instance['after_widget'] = $new_instance['after_widget'];
        $instance['before_title'] = $new_instance['before_title'];
        $instance['after_title'] = $new_instance['after_title'];
        return $instance;
    }

    /**
     * Create a form for widget
     */
    function form($instance) {
        //Set up some default widget settings.
        $defaults = array('title' => __('Woodiscuz Recent Reviews', 'woodiscuz'), 'number' => 10);
        $instance = wp_parse_args((array) $instance, $defaults);
        include 'admin-form' . WOODISCUZDS . 'form-woodiscuz-woocommerce-reviews.php';
    }

}
