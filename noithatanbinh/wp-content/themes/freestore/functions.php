<?php
/**
 * FreeStore functions and definitions
 *
 * @package FreeStore
 */
define( 'FREESTORE_THEME_VERSION' , '1.0.8' );

// Load WP included scripts
require get_template_directory() . '/includes/inc/template-tags.php';
require get_template_directory() . '/includes/inc/extras.php';
require get_template_directory() . '/includes/inc/jetpack.php';
require get_template_directory() . '/includes/inc/customizer.php';

// Support page for taking donations
require get_template_directory() . '/support/support.php';

// Load Customizer Library scripts
require get_template_directory() . '/customizer/customizer-options.php';
require get_template_directory() . '/customizer/customizer-library/customizer-library.php';
require get_template_directory() . '/customizer/styles.php';
require get_template_directory() . '/customizer/mods.php';

// Load TGM plugin class
require_once get_template_directory() . '/includes/inc/class-tgm-plugin-activation.php';

if ( ! function_exists( 'freestore_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function freestore_setup() {
	
	/**
	 * Set the content width based on the theme's design and stylesheet.
	 */
	global $content_width;
	if ( ! isset( $content_width ) ) {
		$content_width = 900; /* pixels */
	}

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on freestore, use a find and replace
	 * to change 'freestore' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'freestore', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	add_image_size( 'freestore_blog_img_side', 500, 380, true );
    add_image_size( 'freestore_blog_img_top', 1200, 440, true );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu', 'freestore' ),
        'top-bar-menu' => __( 'Top Bar Menu', 'freestore' ),
        'footer-bar' => __( 'Footer Bar Menu', 'freestore' )
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
	) );
	
	// The custom logo is used for the logo
	add_theme_support( 'custom-logo', array(
		'height'      => 145,
		'width'       => 280,
		'flex-height' => true,
		'flex-width'  => false,
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'freestore_custom_background_args', array(
		'default-color' => 'F9F9F9',
		'default-image' => '',
	) ) );
	
	add_theme_support( 'woocommerce' );
}
endif; // freestore_setup
add_action( 'after_setup_theme', 'freestore_setup' );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function freestore_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'freestore' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	
	register_sidebar(array(
		'name' => __( 'Sidebar Menu', 'freestore' ),
		'id' => 'freestore-sidebar-menu',
        'description' => __( 'These widgets are placed in the slide out menu under the navigation.', 'freestore' )
	));
	
    register_sidebar(array(
		'name' => __( 'FreeStore Footer Centered', 'freestore' ),
		'id' => 'freestore-site-footer-centered',
        'description' => __( 'The footer will add widgets centered below each other.', 'freestore' )
	));
	
	register_sidebar(array(
		'name' => __( 'FreeStore Footer Standard', 'freestore' ),
		'id' => 'freestore-site-footer-standard',
        'description' => __( 'The footer will divide into however many widgets are placed here.', 'freestore' )
	));
}
add_action( 'widgets_init', 'freestore_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function freestore_scripts() {
	wp_enqueue_style( 'freestore-body-font-default', '//fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic', array(), FREESTORE_THEME_VERSION );
	wp_enqueue_style( 'freestore-heading-font-default', '//fonts.googleapis.com/css?family=Lato:400,300,300italic,400italic,700,700italic', array(), FREESTORE_THEME_VERSION );
	
	wp_enqueue_style( 'font-awesome', get_template_directory_uri().'/includes/font-awesome/css/font-awesome.css', array(), '4.3.0' );
	
	wp_enqueue_style( 'freestore-header-style-standard', get_template_directory_uri().'/templates/css/header-standard.css', array(), FREESTORE_THEME_VERSION );
	
	wp_enqueue_style( 'freestore-style', get_stylesheet_uri(), array(), FREESTORE_THEME_VERSION );
	
	if ( freestore_is_woocommerce_activated() ) :
		if ( get_theme_mod( 'freestore-woocommerce-layout' ) == 'freestore-woocommerce-layout-centered' ) :
			wp_enqueue_style( 'freestore-centered-woocommerce-style', get_template_directory_uri().'/templates/css/woocommerce-centered-style.css', array(), FREESTORE_THEME_VERSION );
		else :
			wp_enqueue_style( 'freestore-standard-woocommerce-style', get_template_directory_uri().'/templates/css/woocommerce-standard-style.css', array(), FREESTORE_THEME_VERSION );
		endif;
	endif;
	
	if ( get_theme_mod( 'freestore-footer-layout', false ) == 'freestore-footer-layout-centered' ) :
	    wp_enqueue_style( 'freestore-footer-centered-style', get_template_directory_uri().'/templates/css/footer-centered.css', array(), FREESTORE_THEME_VERSION );
	elseif ( get_theme_mod( 'freestore-footer-layout', false ) == 'freestore-footer-layout-standard' ) :
	    wp_enqueue_style( 'freestore-footer-standard-style', get_template_directory_uri().'/templates/css/footer-standard.css', array(), FREESTORE_THEME_VERSION );
	elseif ( get_theme_mod( 'freestore-footer-layout', false ) == 'freestore-footer-layout-none' ) :
	    wp_enqueue_style( 'freestore-no-footer-style', get_template_directory_uri().'/templates/css/footer-none.css', array(), FREESTORE_THEME_VERSION );
	else :
		wp_enqueue_style( 'freestore-footer-social-style', get_template_directory_uri().'/templates/css/footer-social.css', array(), FREESTORE_THEME_VERSION );
	endif;

	wp_enqueue_script( 'freestore-caroufredsel', get_template_directory_uri() . '/js/jquery.carouFredSel-6.2.1-packed.js', array('jquery'), FREESTORE_THEME_VERSION, true );
	
	wp_enqueue_script( 'freestore-customjs', get_template_directory_uri() . '/js/custom.js', array('jquery'), FREESTORE_THEME_VERSION, true );
	
	wp_enqueue_script( 'freestore-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), FREESTORE_THEME_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'freestore_scripts' );

/**
 * Add theme stying to the theme content editor
 */
function freestore_add_editor_styles() {
    add_editor_style( 'style-theme-editor.css' );
}
add_action( 'admin_init', 'freestore_add_editor_styles' );

/**
 * Enqueue admin styling.
 */
function freestore_load_admin_script() {
    wp_enqueue_style( 'freestore-admin-css', get_template_directory_uri() . '/support/css/admin-css.css' );
}
add_action( 'admin_enqueue_scripts', 'freestore_load_admin_script' );

/**
 * Enqueue freestore custom customizer styling.
 */
function freestore_load_customizer_script() {
    wp_enqueue_script( 'freestore-customizer-js', get_template_directory_uri() . '/customizer/customizer-library/js/customizer-custom.js', array('jquery'), FREESTORE_THEME_VERSION, true );
    $freestore_upgrade_button = array(
		'link' => esc_url( 'http://kaira.fetchapp.com/sell/a9380c28?amount=15' ),
		'text' => __( 'Donate to FreeStore Development', 'freestore' )
	);
	wp_localize_script( 'freestore-customizer-js', 'upgrade_button', $freestore_upgrade_button );
    wp_enqueue_style( 'freestore-customizer-css', get_template_directory_uri() . '/customizer/customizer-library/css/customizer.css' );
}
add_action( 'customize_controls_enqueue_scripts', 'freestore_load_customizer_script' );

/**
 * To maintain backwards compatibility with older versions of WordPress
 */
function freestore_the_custom_logo() {
	if ( function_exists( 'the_custom_logo' ) ) {
		the_custom_logo();
	}
}

/**
 * Check if WooCommerce exists.
 */
if ( ! function_exists( 'freestore_is_woocommerce_activated' ) ) :
	function freestore_is_woocommerce_activated() {
	    if ( class_exists( 'woocommerce' ) ) { return true; } else { return false; }
	}
endif; // freestore_is_woocommerce_activated

// If WooCommerce exists include ajax cart
if ( freestore_is_woocommerce_activated() ) {
	require get_template_directory() . '/includes/inc/woocommerce-header-inc.php';
}

/**
 * Add classed to the body tag from settings
 */
function freestore_add_body_class( $classes ) {
	if ( get_theme_mod( 'freestore-page-styling' ) ) {
		$page_style_class = sanitize_html_class( get_theme_mod( 'freestore-page-styling' ) );
	} else {
		$page_style_class = sanitize_html_class( 'freestore-page-styling-flat' );
	}
	$classes[] = $page_style_class;
	
	if ( get_theme_mod( 'freestore-woocommerce-shop-fullwidth' ) ) {
		$classes[] = sanitize_html_class( 'freestore-shop-full-width' );
	}
	
	return $classes;
}
add_filter( 'body_class', 'freestore_add_body_class' );

/**
 * Adjust is_home query if freestore-blog-cats is set
 */
function freestore_set_blog_queries( $query ) {
    $blog_query_set = '';
    if ( get_theme_mod( 'freestore-blog-cats', false ) ) {
        $blog_query_set = esc_attr( get_theme_mod( 'freestore-blog-cats' ) );
    }
    
    if ( $blog_query_set ) {
        // do not alter the query on wp-admin pages and only alter it if it's the main query
        if ( !is_admin() && $query->is_main_query() ){
            if ( is_home() ){
                $query->set( 'cat', $blog_query_set );
            }
        }
    }
}
add_action( 'pre_get_posts', 'freestore_set_blog_queries' );

/**
 * Display recommended plugins with the TGM class
 */
function freestore_register_required_plugins() {
	$plugins = array(
		// The recommended WordPress.org plugins.
		array(
			'name'      => 'Page Builder',
			'slug'      => 'siteorigin-panels',
			'required'  => false,
		),
		array(
			'name'      => 'woocommerce',
			'slug'      => 'woocommerce',
			'required'  => false,
		),
		array(
			'name'      => 'Widgets Bundle',
			'slug'      => 'siteorigin-panels',
			'required'  => false,
		),
		array(
			'name'      => 'Contact Form 7',
			'slug'      => 'contact-form-7',
			'required'  => false,
		),
		array(
			'name'      => 'Breadcrumb NavXT',
			'slug'      => 'breadcrumb-navxt',
			'required'  => false,
		),
		array(
			'name'      => 'Meta Slider',
			'slug'      => 'ml-slider',
			'required'  => false,
		)
	);
	$config = array(
		'id'           => 'freestore',
		'menu'         => 'tgmpa-install-plugins',
		'message'      => '',
	);

	tgmpa( $plugins, $config );
}
add_action( 'tgmpa_register', 'freestore_register_required_plugins' );

/**
@ Chèn CSS và Javascript vào theme
@ sử dụng hook wp_enqueue_scripts() để hiển thị nó ra ngoài front-end
**/
function thachpham_styles() {
  /*
   * Hàm get_stylesheet_uri() sẽ trả về giá trị dẫn đến file style.css của theme
   * Nếu sử dụng child theme, thì file style.css này vẫn load ra từ theme mẹ
   */
  wp_register_style( 'font-awesome', get_template_directory_uri() . '/font-awesome.min.css', 'all' );
  wp_register_style( 'bootstrap', get_template_directory_uri() . '/includes/bootstrap/css/bootstrap.css', 'all' );
  //wp_enqueue_style( 'font-awesome' );
  wp_enqueue_style( 'bootstrap' );
}
add_action( 'wp_enqueue_scripts', 'thachpham_styles' );
function Search_Widget(){
register_sidebar(array(
        'name'=> 'Search',
        'id'=>'search_id',
    ));
}
add_action('widgets_init','Search_Widget');
function Cart_Widget(){
register_sidebar(array(
        'name'=> 'cart widget',
        'id'=>'cart_id',
    ));
}
add_action('widgets_init','Cart_Widget');

/*Hiep -- sitebar-product*/

add_action('widgets_init','relative_product');
function Relative_Product(){
    register_widget('Relative_Product_Widget');
}

class Relative_Product_Widget extends WP_Widget
{
    
    
    function __construct()
    {
        # code...
        parent::__construct(
               'relativeproduct',
               'Sản Phẩm Liên Quan'
            );
    }
    function widget( $args, $instance ) {
 
        extract( $args );
		echo do_shortcode('[related_products per_page="3" columns="1"]');
    }
}
/*Hiệp -- footer widget*/

add_action('widgets_init','Footer_Form');
function Footer_Form(){
    register_widget('Footer_Form_Widget');
}

class Footer_Form_Widget extends WP_Widget
{
    function __construct()
    {
        # code...
        parent::__construct(
               'footerform',
               'Form Footer' ,
                array('description' => 'Forms Tạo Footer')
            );
    }
    function form($instance){
        parent::form($instance);
        $default = array(
                         'sdt'=> 'Hãy Nhập Số Điện Thoại',
						 );
        $instance=wp_parse_args((array)$instance,$default);
        $sdt=$instance['sdt'];
		 
         echo "<p><label>Số Hotline:</label>
         <input type='text' style='width:100%' class='widefat' name='".$this->get_field_name('sdt')."' value='".$sdt."' /></p>";
		 //<textarea class='widefat' rows='10' cols='20' name='".$this->get_field_name('value')."' id='".$this->get_field_id('value ')."'>".$value."</textarea></p>";
    }

    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        
        $instance['sdt']=$new_instance['sdt'];
		return $instance;
    }
    function widget( $args, $instance ) {
 
        extract( $args );
        $sdt = apply_filters( 'widget_sdt', $instance['sdt'] );
        $sdt = $instance['sdt'];
		//In widget
        // Nội dung trong widget
         echo " <div class='container'>
					<div class='row top-footer'>
						<div class='container'>
						<div class='logo-footer'>
					<a href='#'>
						<img  src ='".get_stylesheet_directory_uri()."/images/an-binh-logo.png' alt='Logo nội thất an bình'>
					</a>
			</div>	
			
	<div class='col-xs-4' style='margin-top:1.5%'>
		<span class='icon-hotline hot-line'>
			<a href='tel:+84".$sdt."'><em>Hotline : ".$sdt."</em></a>
		</span>
	</div>
	<div class='col-xs-4' style='float:right;margin-right:3.7%'>
		<div class='fb-page' data-href='https://www.facebook.com/sieuthinoithatanbinh/?fref=ts' data-tabs='' data-width='400' data-height='70' data-small-header='true' data-adapt-container-width='false' data-hide-cover='false' data-show-facepile='false' data-share='true'><blockquote class='fb-xfbml-parse-ignore'><a href='https://www.facebook.com/sieuthinoithatanbinh/?fref=ts'>Nội thất An Bình</a></blockquote>
		</div>
	</div>			
	</div>
	</div>
	</div>
	";
	echo '<div class="center-footer container">
		<div class="cate-footer">
              <ul class="row">';

  $taxonomy     = 'product_cat';
  $orderby      = 'name';  
  $show_count   = 0;      // 1 for yes, 0 for no
  $pad_counts   = 0;      // 1 for yes, 0 for no
  $hierarchical = 1;      // 1 for yes, 0 for no  
  $title        = '';  
  $empty        = 0;

  $args = array(
         'taxonomy'     => $taxonomy,
         'orderby'      => $orderby,
         'show_count'   => $show_count,
         'pad_counts'   => $pad_counts,
         'hierarchical' => $hierarchical,
         'title_li'     => $title,
         'hide_empty'   => $empty
  );
 $all_categories = get_categories( $args );
 foreach ($all_categories as $cat) {
    if($cat->category_parent == 0) {
        $category_id = $cat->term_id;       
        echo '<li class="cate-main col-xs-3"><a href="'. get_term_link($cat->slug, 'product_cat') .'">'. $cat->name .'</a>';

        $args2 = array(
                'taxonomy'     => $taxonomy,
                'child_of'     => 0,
                'parent'       => $category_id,
                'orderby'      => $orderby,
                'show_count'   => $show_count,
                'pad_counts'   => $pad_counts,
                'hierarchical' => $hierarchical,
                'title_li'     => $title,
                'hide_empty'   => $empty
        );
        $sub_cats = get_categories( $args2 );
		echo '<ul class="list-unstyled">';
        if($sub_cats) {
            foreach($sub_cats as $sub_category) {
                echo '<li><a class="sub-cate" href="'.get_term_link($sub_category->slug, 'product_cat') .'">'. $sub_category->name .'</a></li>' ;
            }   
        }
		echo '</ul></li>';
    }       
}
              echo'</ul>
			  </div></div>';
    }
	
}

add_action('widgets_init','Bottom_Footer');
function Bottom_Footer(){
    register_widget('Bottom_Footer_Widget');
}

class Bottom_Footer_Widget extends WP_Widget
{
    
    
    function __construct()
    {
        # code...
        parent::__construct(
               'bottomfooter',
               'Bottom Footer' ,
                array('description' => 'Forms Tạo Footer')
            );
    }
    function form($instance){
        parent::form($instance);
        $default = array('title'=> 'Hãy Nhập Tên Công Ty',
						 'diachi' => 'Nhập Địa Chỉ',
						 'chinhanh' => 'Nhập Chi Nhánh',
						 'truso' => 'Nhập Trụ sở',
						);
        $instance=wp_parse_args((array)$instance,$default);
        $title=$instance['title'];
		$diachi=$instance['diachi'];
		$chinhanh=$instance['chinhanh'];
		$truso=$instance['truso'];
		$hotline=$instance['hotline'];
         echo "<p><label>Tên Công Ty:</label>
         <input type='text' style='width:100%' class='widefat' name='".$this->get_field_name('title')."' value='".$title."' /></p>";
		 echo "<p><label>Địa Chỉ:</label>
         <input type='text' style='width:100%' class='widefat' name='".$this->get_field_name('diachi')."' value='".$diachi."' /></p>";
		 echo "<p><label>Chi Nhánh:</label>
         <input type='text' style='width:100%' class='widefat' name='".$this->get_field_name('chinhanh')."' value='".$chinhanh."' /></p>";
		 echo "<p><label>Trụ sở:</label>
         <input type='text' style='width:100%' class='widefat' name='".$this->get_field_name('truso')."' value='".$truso."' /></p>";
    }

    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title']=$new_instance['title'];
		$instance['diachi']=$new_instance['diachi'];
		$instance['chinhanh']=$new_instance['chinhanh'];
		$instance['truso']=$new_instance['truso'];
		
       return $instance;
    }
    function widget( $args, $instance ) {
 
        extract( $args );
        $title = apply_filters( 'widget_title', $instance['title'] );
        $title = $instance['title'];
		$diachi = $instance['diachi'];
		$chinhanh = $instance['chinhanh'];
		$truso = $instance['truso'];
		
        echo " 
	<div class='container'>
		<div class='bottom-footer row'>
			<p><strong>".$title."</strong><br/>
			ĐC GPKD : ".$diachi."<br/>
			Trụ sở : ".$truso."<br/>
			Chi nhánh : ".$chinhanh."<br/>
			</p>
		</div>
	</div>	
            ";
	}
}

//short-code Giảm giá

function woocommerce_sale_products( $atts ){
    global $woocommerce_loop;

    extract( shortcode_atts( array(
        'per_page'      => '12',
        'columns'       => '4',
        'orderby'       => 'title',
        'order'         => 'asc'
        ), $atts ) );

    $args = array(
        'post_type' => 'product',
        'post_status' => 'publish',
        'ignore_sticky_posts'   => 1,
        'orderby' => $orderby,
        'order' => $order,
        'posts_per_page' => $per_page,
        'meta_query' => array(
            array(
                'key' => '_visibility',
                'value' => array('catalog', 'visible'),
                'compare' => 'IN'
            ),
            array(
                'key' => '_sale_price',
                'value' => 0,
                'compare' => '>',
                'type' => 'NUMERIC'
            )
        )
    );

    ob_start();

    $products = new WP_Query( $args );

    $woocommerce_loop['columns'] = $columns;

    if ( $products->have_posts() ) : ?>

        <ul class="products">

            <?php while ( $products->have_posts() ) : $products->the_post(); ?>

                <?php woocommerce_get_template_part( 'content', 'product' ); ?>

            <?php endwhile; // end of the loop. ?>

        </ul>

    <?php endif;

    wp_reset_query();

    return ob_get_clean();
}

add_shortcode('sale_products', 'woocommerce_sale_products');
// add vào : [sale_products per_page="12" columns="4" orderby="date" order="desc" ]

include("myfunction/yoast_seo.php");

/**
 * Change text strings
 *
 * @link http://codex.wordpress.org/Plugin_API/Filter_Reference/gettext
 */
function my_text_strings( $translated_text, $text, $domain ) {
    switch ( $translated_text ) {
        case 'View Cart' :
            $translated_text = __( 'View Shopping Cart', 'woocommerce' );
            break;
    }
    return $translated_text;
}
add_filter( 'gettext', 'my_text_strings', 20, 3 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );


