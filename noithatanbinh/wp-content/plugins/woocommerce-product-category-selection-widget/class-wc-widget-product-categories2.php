<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Product Categories Widget
 *
 * @author   WooThemes
 * @category Widgets
 * @package  WooCommerce/Widgets
 * @version  2.3.0
 * @extends  WC_Widget
 */
class WC_Widget_Product_Categories2 extends WC_Widget {

	/**
	 * Category ancestors
	 *
	 * @var array
	 */
	public $cat_ancestors;

	/**
	 * Current Category
	 *
	 * @var bool
	 */
	public $current_cat;

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->widget_cssclass    = 'center-footer container';
		$this->widget_description = __( 'A list or dropdown of product categories.', 'woocommerce' );
		$this->widget_id          = 'woocommerce_product_categories2';
		$this->widget_name        = __( 'Product Categories Selection', 'woocommerce' );
		$this->settings           = array(
			'title'  => array(
				'type'  => 'text',
				'std'   => __( 'Product Categories Selection', 'woocommerce' ),
				'label' => __( 'Title', 'woocommerce' )
			),
			'orderby' => array(
				'type'  => 'select',
				'std'   => 'name',
				'label' => __( 'Order by', 'woocommerce' ),
				'options' => array(
					'order' => __( 'Category Order', 'woocommerce' ),
					'name'  => __( 'Name', 'woocommerce' )
				)
			),
			'dropdown' => array(
				'type'  => 'checkbox',
				'std'   => 0,
				'label' => __( 'Show as dropdown', 'woocommerce' )
			),
			'count' => array(
				'type'  => 'checkbox',
				'std'   => 0,
				'label' => __( 'Show product counts', 'woocommerce' )
			),
			'hierarchical' => array(
				'type'  => 'checkbox',
				'std'   => 1,
				'label' => __( 'Show hierarchy', 'woocommerce' )
			),
			'show_children_only' => array(
				'type'  => 'checkbox',
				'std'   => 0,
				'label' => __( 'Only show children of the current category', 'woocommerce' )
			),

			'expand_collapse' => array(
				'type'  => 'checkbox',
				'std'   => 0,
				'label' => __( 'Show as Expand/Collapse', 'woocommerce' )
			),
		);

        add_action('wp_enqueue_scripts', array(&$this, 'wa_wcc_load_scripts'));

		parent::__construct();
	}

	/**
	 * widget function.
	 *
	 * @see WP_Widget
	 *
	 * @param array $args
	 * @param array $instance
	 *
	 * @return void
	 */
	public function widget( $args, $instance ) {
		global $wp_query, $post, $wpdb;

		$c             = isset( $instance['count'] ) ? $instance['count'] : $this->settings['count']['std'];
		$h             = isset( $instance['hierarchical'] ) ? $instance['hierarchical'] : $this->settings['hierarchical']['std'];
		$s             = isset( $instance['show_children_only'] ) ? $instance['show_children_only'] : $this->settings['show_children_only']['std'];
		$d             = isset( $instance['dropdown'] ) ? $instance['dropdown'] : $this->settings['dropdown']['std'];
		$o             = isset( $instance['orderby'] ) ? $instance['orderby'] : $this->settings['orderby']['std'];

		$e_c             = isset( $instance['expand_collapse'] ) ? $instance['expand_collapse'] : $this->settings['expand_collapse']['std'];

        $keysR = $arrr = array();
        //all categories
        $cats = array();
		$q = 'SELECT tt.term_id term_id
		FROM ' . $wpdb->term_taxonomy . ' tt
		WHERE tt.taxonomy = "product_cat"';
        $all_cats = $wpdb->get_results($q);

        if(count($all_cats) > 0) {

              foreach($all_cats as $ac) {
                   $cats[] = $ac->term_id;
              }
        }
		if(isset($instance['panels_info'])){
			$postid = get_the_ID();
		}else{
			$postid = '';
		}
	  	// 
	  	
	// echo "<pre>"; print_r($instance['panels_info']); echo "</pre>";
		//selected categories
		$query = 'SELECT option_value
		FROM ' . $wpdb->options . '
		WHERE option_name LIKE "taxonomy_' . str_replace(" ", "_", $instance['title']) .$postid. '"';

        $res = $wpdb->get_results($query);

        $n = array();
		if( $res[0]->option_value ) {

			$r = unserialize($res[0]->option_value);
			if($r && count($r) > 0) $keysR = array_keys($r);
		}

        if($cats && $keysR) $arrr = array_diff($cats,$keysR);
        $excl = implode(",",$arrr);

		$dropdown_args = array( 'hide_empty' => false,'exclude' => $excl );
		$list_args     = array( 'show_count' => $c, 'hierarchical' => $h, 'taxonomy' => 'product_cat', 'hide_empty' => false );

		// Menu Order
		$list_args['menu_order'] = false;
		if ( $o == 'order' ) {
			$list_args['menu_order'] = 'asc';
		} else {
			$list_args['orderby']    = 'title';
		}

		// Setup Current Category
		$this->current_cat   = false;
		$this->cat_ancestors = array();

		if ( is_tax( 'product_cat' ) ) {

			$this->current_cat   = $wp_query->queried_object;
			$this->cat_ancestors = get_ancestors( $this->current_cat->term_id, 'product_cat' );

		} elseif ( is_singular( 'product' ) ) {

			$product_category = wc_get_product_terms( $post->ID, 'product_cat', array( 'orderby' => 'parent' ) );

			if ( $product_category ) {
				$this->current_cat   = end( $product_category );
				$this->cat_ancestors = get_ancestors( $this->current_cat->term_id, 'product_cat' );
			}

		}

		// Show Siblings and Children Only
		if ( $s && $this->current_cat ) {

			// Top level is needed
			$top_level = get_terms(
				'product_cat',
				array(
					'fields'       => 'ids',
					'parent'       => 0,
					'hierarchical' => true,
					'hide_empty'   => false,
					'exclude'       => $excl
				)
			);

			// Direct children are wanted
			$direct_children = get_terms(
				'product_cat',
				array(
					'fields'       => 'ids',
					'parent'       => $this->current_cat->term_id,
					'hierarchical' => true,
					'hide_empty'   => false,
					'exclude'       => $excl
				)
			);

			// Gather siblings of ancestors
			$siblings  = array();
			if ( $this->cat_ancestors ) {
				foreach ( $this->cat_ancestors as $ancestor ) {
					$ancestor_siblings = get_terms(
						'product_cat',
						array(
							'fields'       => 'ids',
							'parent'       => $ancestor,
							'hierarchical' => false,
							'hide_empty'   => false
						)
					);
					$siblings = array_merge( $siblings, $ancestor_siblings );
				}
			}

			if ( $h ) {
				$include = array_merge( $top_level, $this->cat_ancestors, $siblings, $direct_children, array( $this->current_cat->term_id ) );
			} else {
				$include = array_merge( $direct_children );
			}

			$dropdown_args['include'] = implode( ',', $include );
			$list_args['include']     = implode( ',', $include );

			if ( empty( $include ) ) {
				return;
			}

		} elseif ( $s ) {
			$dropdown_args['depth']        = 1;
			$dropdown_args['child_of']     = 0;
			$dropdown_args['hierarchical'] = 1;
			$list_args['depth']            = 1;
			$list_args['child_of']         = 0;
			$list_args['hierarchical']     = 1;
		}

		$this->widget_start( $args, $instance );

		// Dropdown
		if ( $d ) {
			$dropdown_defaults = array(
				'show_counts'        => $c,
				'hierarchical'       => $h,
				'show_uncategorized' => 0,
				'orderby'            => $o,
				'selected'           => $this->current_cat ? $this->current_cat->slug : ''
			);
			$dropdown_args = wp_parse_args( $dropdown_args, $dropdown_defaults );

			// Stuck with this until a fix for http://core.trac.wordpress.org/ticket/13258
			wc_product_dropdown_categories( apply_filters( 'woocommerce_product_categories_widget_dropdown_args', $dropdown_args ) );

			wc_enqueue_js( "
				jQuery('.dropdown_product_cat').change(function(){
					if(jQuery(this).val() != '') {
						location.href = '" . home_url() . "/?product_cat=' + jQuery(this).val();
					}
				});
			" );

		// List
		} else {

			include_once( WC()->plugin_path() . '/includes/walkers/class-product-cat-list-walker.php' );
            if($e_c) {

				?>

				<script>

				jQuery(document).ready(function($) {

				$("li.current-cat-parent").addClass('current-cat');
				var mtree = $('ul.mtree');
				mtree.addClass('default');

				});

				</script>

			<?php

				$list_args['walker']                     = new WC_Product_Cat_List_Walker;
				$list_args['title_li']                   = '';
				$list_args['pad_counts']                 = 1;
				$list_args['show_option_none']           = __('No product categories exist.', 'woocommerce' );
				$list_args['current_category']           = ( $this->current_cat ) ? $this->current_cat->term_id : '';
				$list_args['current_category_ancestors'] = $this->cat_ancestors;
                $list_args['echo'] = false;

				$list_args['exclude'] = $excl;
				$list_args['heiararchical'] = true;

				echo '<div class="wcc_block">';
				echo '<ul class="mtree">';

				$wcc_categories = wp_list_categories( apply_filters( 'woocommerce_product_categories_widget_args', $list_args ) );

                $wcc_categories = preg_replace('/<\/a> <span class="count">\(([0-9]+)\)<\/span>/', ' (\\1)</a>', $wcc_categories);
                print $wcc_categories;

				echo '</ul>';
                echo '</div>';

				$this->wa_wcc_mtree_script();

			} else {

				$list_args['walker']                     = new WC_Product_Cat_List_Walker;
				$list_args['title_li']                   = '';
				$list_args['pad_counts']                 = 1;
				$list_args['show_option_none']           = __('No product categories exist.', 'woocommerce' );
				$list_args['current_category']           = ( $this->current_cat ) ? $this->current_cat->term_id : '';
				$list_args['current_category_ancestors'] = $this->cat_ancestors;
				$list_args['exclude'] = $excl;
				$list_args['heiararchical'] = true;
                $list_args['echo'] = false;

				echo '<div class="cate-footer">';
				echo '</ul class="row">';

				$tree = wp_list_categories( apply_filters( 'woocommerce_product_categories_widget_args', $list_args ) );

    			print($tree);

				echo '</ul>';
				echo '</div>';
				
			}
		}

		$this->widget_end( $args );
	}

	public function wa_wcc_mtree_script() {

		$args_mtree = apply_filters('mtree_options', array(
		'duration' =>   $this->options['settings']['duration'],
		'easing_type' =>  'easeOutQuart',
		));

		wp_register_script('wa_wcc_mtree',plugins_url('/assets/js/mtree.js', __FILE__),array('jquery'),'',($this->options['configuration']['loading_place'] === 'header' ? false : true));
    	wp_enqueue_script('wa_wcc_mtree');

    	wp_localize_script('wa_wcc_mtree','mtree_options',$args_mtree);

	}

	/* insert css files js files */
	public function wa_wcc_load_scripts($jquery_true) {

		wp_register_style('wa_wcc_mtree_css_file', plugins_url('/assets/css/mtree.css',__FILE__));
		wp_enqueue_style('wa_wcc_mtree_css_file');

	}


}
