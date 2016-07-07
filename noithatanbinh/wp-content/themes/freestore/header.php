<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package FreeStore
 */
global $woocommerce;
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.6";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<div id="page" class="hfeed site <?php echo sanitize_html_class( get_theme_mod( 'freestore-slider-type' ) ); ?>" data-toggle="collapse" data-target="navbar-collapse">
<nav class="navbar navbar-fixed-top header-nav ">
					<div class='logo'>
                    <a href="<?php echo get_home_url(); ?>" >
						<img src="<?php echo get_stylesheet_directory_uri()?>/images/an-binh-logo.png" title="noi that an binh" alt="noi that an binh" class="img-responsive" />
					</a>
                </div>
                 <form class="search_menu" action= "<?php echo get_home_url(); ?>/">
 					 <input class="searchTerm" name="s" placeholder="Tìm Sản Phẩm..." />
					 <input type="hidden" name="post_type" value="product">
					 <input class="searchButton" type="submit" />
				</form>
				 <div class='cart'>
					<?php echo do_shortcode("[nc_ajax_cart]"); ?>	
				</div>

</nav>

	<div class="site-container <?php echo ( ! is_active_sidebar( 'sidebar-1' ) ) ? sanitize_html_class( 'content-no-sidebar' ) : sanitize_html_class( 'content-has-sidebar' ); ?>" style="margin-top:85px">

	
