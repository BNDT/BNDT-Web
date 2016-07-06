<?php
/**
 * Frontend class
 *
 * @author  Your Inspiration Themes
 * @package YITH WooCommerce Ajax Navigation
 * @version 1.3.2
 */

if ( ! defined( 'YITH_WCAN' ) ) {
    exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_WCAN_Frontend' ) ) {
    /**
     * Frontend class.
     * The class manage all the frontend behaviors.
     *
     * @since 1.0.0
     */
    class YITH_WCAN_Frontend {
        /**
         * Plugin version
         *
         * @var string
         * @since 1.0.0
         */
        public $version;

        /**
         * @var array deprecated array from WC_QUERY
         * @since version 3.0
         */
        public $filtered_product_ids_for_taxonomy   = array();
        public $layered_nav_product_ids             = array();
        public $unfiltered_product_ids              = array();
        public $filtered_product_ids                = array();
        public $layered_nav_post__in                = array();

        /**
         * Constructor
         *
         * @access public
         * @since  1.0.0
         */
        public function __construct( $version ) {
            $this->version = $version;
            $is_ajax_navigation_active = is_active_widget( false, false, 'yith-woo-ajax-navigation', true );

            //Actions
            //TODO: Remove woocommerce_layered_nav_init method
            //add_action( 'init', array( $this, 'woocommerce_layered_nav_init' ), 90 );

            if( $is_ajax_navigation_active ) {
                add_filter( 'woocommerce_is_layered_nav_active', '__return_true' );
            }

            add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles_scripts' ) );

            add_action( 'body_class', array( $this, 'body_class' ) );

            add_filter( 'the_posts', array( $this, 'the_posts' ), 15, 2 );

            add_filter( 'woocommerce_layered_nav_link', 'yit_plus_character_hack', 99 );

            // YITH WCAN Loaded
            do_action( 'yith_wcan_loaded' );
        }

        public function layered_navigation_array_for_wc_older_26(){
            if( YITH_WCAN()->is_wc_older_2_6 ){
                $this->filtered_product_ids_for_taxonomy   = WC()->query->filtered_product_ids_for_taxonomy;
                $this->layered_nav_product_ids             = WC()->query->layered_nav_product_ids;
                $this->unfiltered_product_ids              = WC()->query->unfiltered_product_ids;
                $this->filtered_product_ids                = WC()->query->filtered_product_ids;
                $this->layered_nav_post__in                = WC()->query->layered_nav_post__in;
            }
        }

        /**
         * Hook into the_posts to do the main product query if needed - relevanssi compatibility.
         *
         * @access public
         * @param array $posts
         * @param WP_Query|bool $query (default: false)
         * @return array
         */
        public function the_posts( $posts, $query = false ) {

            if( YITH_WCAN()->is_wc_older_2_6 ){
                add_action( 'wp', array( $this, 'layered_navigation_array_for_wc_older_26' ) );
            }

            else{

                $filtered_posts   = array();
                $queried_post_ids = array();
                $query_filtered_posts = $this->layered_nav_query();

                foreach ( $posts as $post ) {

                    if ( in_array( $post->ID, $query_filtered_posts ) ) {
                        $filtered_posts[]   = $post;
                        $queried_post_ids[] = $post->ID;
                    }
                }

                $query->posts       = $filtered_posts;
                $query->post_count  = count( $filtered_posts );

                // Get main query
                $current_wp_query = $query->query;

                // Get WP Query for current page (without 'paged')
                unset( $current_wp_query['paged'] );

                // Ensure filters are set
                $unfiltered_args = array_merge(
                    $current_wp_query,
                    array(
                        'post_type'              => 'product',
                        'numberposts'            => -1,
                        'post_status'            => 'publish',
                        'meta_query'             => $query->meta_query,
                        'fields'                 => 'ids',
                        'no_found_rows'          => true,
                        'update_post_meta_cache' => false,
                        'update_post_term_cache' => false,
                        'pagename'               => '',
                        'wc_query'               => 'get_products_in_view'
                    )
                );
                $this->unfiltered_product_ids = get_posts( $unfiltered_args );
                $this->filtered_product_ids   = $queried_post_ids;

                // Also store filtered posts ids...
                if ( sizeof( $queried_post_ids ) > 0 ) {
                    $this->filtered_product_ids = array_intersect( $this->unfiltered_product_ids, $queried_post_ids );
                } else {
                    $this->filtered_product_ids = $this->unfiltered_product_ids;
                }

                if ( sizeof( $this->layered_nav_post__in ) > 0 ) {
                    $this->layered_nav_product_ids = array_intersect( $this->unfiltered_product_ids, $this->layered_nav_post__in );
                } else {
                    $this->layered_nav_product_ids = $this->unfiltered_product_ids;
                }
            }
            
            return $posts;
        }

        /**
         * Enqueue frontend styles and scripts
         *
         * @access public
         * @return void
         * @since  1.0.0
         */
        public function enqueue_styles_scripts() {
            if ( yith_wcan_can_be_displayed() ) {
                $suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

                wp_enqueue_style( 'yith-wcan-frontend', YITH_WCAN_URL . 'assets/css/frontend.css', false, $this->version );
                wp_enqueue_script( 'yith-wcan-script', YITH_WCAN_URL . 'assets/js/yith-wcan-frontend' . $suffix . '.js', array( 'jquery' ), $this->version, true );

                $custom_style = yith_wcan_get_option( 'yith_wcan_custom_style', '' );

                ! empty( $custom_style ) && wp_add_inline_style( 'yith-wcan-frontend', sanitize_text_field( $custom_style ) );

                $args = apply_filters( 'yith_wcan_ajax_frontend_classes', array(
                        'container'             => yith_wcan_get_option('yith_wcan_ajax_shop_container', '.products'),
                        'pagination'            => yith_wcan_get_option('yith_wcan_ajax_shop_pagination', 'nav.woocommerce-pagination'),
                        'result_count'          => yith_wcan_get_option('yith_wcan_ajax_shop_result_container', '.woocommerce-result-count'),
                        'wc_price_slider'       => array(
                            'wrapper'   => '.price_slider',
                            'min_price' => '.price_slider_amount #min_price',
                            'max_price' => '.price_slider_amount #max_price',
                        ),
                        'is_mobile'             => wp_is_mobile(),
                        'scroll_top'            => yith_wcan_get_option('yith_wcan_ajax_scroll_top_class', '.yit-wcan-container'),
                        'change_browser_url'    => 'yes' == yith_wcan_get_option( 'yith_wcan_change_browser_url', 'yes' ) ? true : false,
                        /* === Avada Theme Support === */
                        'avada'                 => array(
                            'is_enabled' => class_exists( 'Avada' ),
                            'sort_count' => 'ul.sort-count.order-dropdown'
                        ),
                    )
                );

                wp_localize_script( 'yith-wcan-script', 'yith_wcan', apply_filters( 'yith-wcan-frontend-args', $args ) );
            }
        }


        /**
         * Layered Nav Init
         *
         * @package    WooCommerce/Widgets
         * @access     public
         * @return void
         */
        public function woocommerce_layered_nav_init() {
            $is_ajax_navigation_active = is_active_widget( false, false, 'yith-woo-ajax-navigation', true );

            var_dump( current_action() );

            if ( ! YITH_WCAN()->is_wc_older_2_6 && $is_ajax_navigation_active && ! is_admin() ) {

                $_chosen_attributes = YITH_WCAN()->get_layered_nav_chosen_attributes();

                /* FIX TO WOOCOMMERCE 2.1 */
                $attibute_taxonomies = function_exists( 'wc_get_attribute_taxonomies' ) ? $attribute_taxonomies = wc_get_attribute_taxonomies() :  $attribute_taxonomies = WC()->get_attribute_taxonomies();

                if ( $attribute_taxonomies ) {
                    foreach ( $attribute_taxonomies as $tax ) {

                        $attribute = wc_sanitize_taxonomy_name( $tax->attribute_name );

                        /* FIX TO WOOCOMMERCE 2.1 */
                        if ( function_exists( 'wc_attribute_taxonomy_name' ) ) {
                            $taxonomy = wc_attribute_taxonomy_name( $attribute );
                        }
                        else {
                            $taxonomy = WC()->attribute_taxonomy_name( $attribute );
                        }

                        $name            = 'filter_' . $attribute;
                        $query_type_name = 'query_type_' . $attribute;

                        if ( ! empty( $_GET[$name] ) && taxonomy_exists( $taxonomy ) ) {

                            $_chosen_attributes[ $taxonomy ]['terms'] = explode( ',', $_GET[ $name ] );

                            if ( empty( $_GET[ $query_type_name ] ) || ! in_array( strtolower( $_GET[ $query_type_name ] ), array( 'and', 'or' ) ) )
                                $_chosen_attributes[ $taxonomy ]['query_type'] = apply_filters( 'woocommerce_layered_nav_default_query_type', 'and' );
                            else
                                $_chosen_attributes[ $taxonomy ]['query_type'] = strtolower( $_GET[ $query_type_name ] );

                        }
                    }
                }

                if ( YITH_WCAN()->is_wc_older_2_1 ) {
                    add_filter( 'woocommerce_is_layered_nav_active', '__return_true' );
                    //add_filter( 'loop_shop_post_in', 'woocommerce_layered_nav_query' );
                }

                elseif ( YITH_WCAN()->is_wc_older_2_6 ) {
                    add_filter( 'woocommerce_is_layered_nav_active', '__return_true' );
                    //add_filter( 'loop_shop_post_in', array( WC()->query, 'layered_nav_query' ) );
                }
                //Nothing to do for WooCommerce 2.6
            }
        }
        /**
         * Layered Nav post filter.
         *
         * @param array $filtered_posts
         * @return array
         */
        public function layered_nav_query( $filtered_posts  = array()) {
            $_chosen_attributes = YITH_WCAN()->get_layered_nav_chosen_attributes();

            if ( sizeof( $_chosen_attributes ) > 0 ) {

                $matched_products   = array(
                    'and' => array(),
                    'or'  => array()
                );
                $filtered_attribute = array(
                    'and' => false,
                    'or'  => false
                );

                $is_product_taxonomy = false;
                if( is_product_taxonomy() ){
                    $is_product_taxonomy = array(
                        'taxonomy'  => get_queried_object()->taxonomy,
                        'terms'     =>  get_queried_object()->slug,
                        'field'     => YITH_WCAN()->filter_term_field
                    );
                }

                foreach ( $_chosen_attributes as $attribute => $data ) {
                    $matched_products_from_attribute = array();
                    $filtered = false;

                    if ( sizeof( $data['terms'] ) > 0 ) {
                        foreach ( $data['terms'] as $value ) {

                            $args = array(
                                'post_type' 	=> 'product',
                                'numberposts' 	=> -1,
                                'post_status' 	=> 'publish',
                                'fields' 		=> 'ids',
                                'no_found_rows' => true,
                                'tax_query' => array(
                                    array(
                                        'taxonomy' 	=> $attribute,
                                        'terms' 	=> $value,
                                        'field' 	=> YITH_WCAN()->filter_term_field
                                    )
                                )
                            );


                            if( $is_product_taxonomy ){
                                $args['tax_query'][] = $is_product_taxonomy;
                            }
                            
                            //TODO: Increase performance for get_posts()
                            $post_ids = apply_filters( 'woocommerce_layered_nav_query_post_ids', get_posts( $args ), $args, $attribute, $value );

                            if ( ! is_wp_error( $post_ids ) ) {

                                if ( sizeof( $matched_products_from_attribute ) > 0 || $filtered ) {
                                    $matched_products_from_attribute = $data['query_type'] == 'or' ? array_merge( $post_ids, $matched_products_from_attribute ) : array_intersect( $post_ids, $matched_products_from_attribute );
                                } else {
                                    $matched_products_from_attribute = $post_ids;
                                }

                                $filtered = true;
                            }
                        }
                    }

                    if ( sizeof( $matched_products[ $data['query_type'] ] ) > 0 || $filtered_attribute[ $data['query_type'] ] === true ) {
                        $matched_products[ $data['query_type'] ] = ( $data['query_type'] == 'or' ) ? array_merge( $matched_products_from_attribute, $matched_products[ $data['query_type'] ] ) : array_intersect( $matched_products_from_attribute, $matched_products[ $data['query_type'] ] );
                    } else {
                        $matched_products[ $data['query_type'] ] = $matched_products_from_attribute;
                    }

                    $filtered_attribute[ $data['query_type'] ] = true;

                    $this->filtered_product_ids_for_taxonomy[ $attribute ] = $matched_products_from_attribute;
                }

                // Combine our AND and OR result sets
                if ( $filtered_attribute['and'] && $filtered_attribute['or'] )
                    $results = array_intersect( $matched_products[ 'and' ], $matched_products[ 'or' ] );
                else
                    $results = array_merge( $matched_products[ 'and' ], $matched_products[ 'or' ] );

                if ( $filtered ) {

                    $this->layered_nav_post__in   = $results;
                    $this->layered_nav_post__in[] = 0;

                    if ( sizeof( $filtered_posts ) == 0 ) {
                        $filtered_posts   = $results;
                        $filtered_posts[] = 0;
                    } else {
                        $filtered_posts   = array_intersect( $filtered_posts, $results );
                        $filtered_posts[] = 0;
                    }

                }
            }
            return (array) $filtered_posts;
        }


        /**
         * Add a body class(es)
         *
         * @param $classes The classes array
         *
         * @author Andrea Grillo <andrea.grillo@yithemes.com>
         * @since  1.0
         * @return array
         */
        public function body_class( $classes ) {
            $classes[] = apply_filters( 'yith_wcan_body_class',  'yith-wcan-free' );
            return $classes;
        }
    }
}
