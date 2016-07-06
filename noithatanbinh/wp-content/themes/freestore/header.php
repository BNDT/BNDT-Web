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

<div id="page" class="hfeed site <?php echo sanitize_html_class( get_theme_mod( 'freestore-slider-type' ) ); ?>">
	
<header class="header-top">
	<div class="container">
		<div class="row"> 
			 <div class='col-xs-3'>
			 	<div id="logo" >
                    <a href="<?php echo get_home_url(); ?>">
						<img src="<?php echo get_stylesheet_directory_uri()?>/images/an-binh-logo.png" title="noi that an binh" alt="noi that an binh" class="img-responsive" style="max-width: 300px">
					</a>
                  </div>
			 </div> 
			 <div class="col-xs-9">
			 	<?php  dynamic_sidebar('search_id');?>
			 </div>
			 <div class="col-xs-3">
			 	<?php  dynamic_sidebar('cart_id');?>
			 </div>
		</div>
	</div>
</header>
<?php masterslider(1); ?>
	<div class="site-container <?php echo ( ! is_active_sidebar( 'sidebar-1' ) ) ? sanitize_html_class( 'content-no-sidebar' ) : sanitize_html_class( 'content-has-sidebar' ); ?>">
	