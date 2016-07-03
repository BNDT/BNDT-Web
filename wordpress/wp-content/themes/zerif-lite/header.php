<?php
/**
 * The Header for our theme.
 * Displays all of the <head> section and everything up till <div id="content">
 */
?><!DOCTYPE html>

<html <?php language_attributes(); ?>>

<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<link rel="Stylesheet" href="/wp-content/themes/zerif-lite/css/002.css" type="text/css"/>

<!--[if lt IE 9]>
<script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/html5.js"></script>
<link rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() ); ?>/css/ie.css" type="text/css">
<![endif]-->

<?php

if ( ! function_exists( '_wp_render_title_tag' ) ) :
    function zerif_old_render_title() {
?>
<title><?php wp_title( '-', true, 'right' ); ?></title>
<?php
    }
    add_action( 'wp_head', 'zerif_old_render_title' );
endif;

wp_head(); ?>

</head>

<?php if(isset($_POST['scrollPosition'])): ?>

	<body <?php body_class(); ?> onLoad="window.scrollTo(0,<?php echo intval($_POST['scrollPosition']); ?>)">

<?php else: ?>

	<body <?php body_class(); ?> >

<?php endif; 

	global $wp_customize;
	
	/* Preloader */

	if(is_front_page() && !isset( $wp_customize ) && get_option( 'show_on_front' ) != 'page' ): 
 
		$zerif_disable_preloader = get_theme_mod('zerif_disable_preloader');
		
		if( isset($zerif_disable_preloader) && ($zerif_disable_preloader != 1)):
			echo '<div class="preloader">';
				echo '<div class="status">&nbsp;</div>';
			echo '</div>';
		endif;	

	endif; ?>


<div id="mobilebgfix">
	<div class="mobile-bg-fix-img-wrap">
		<div class="mobile-bg-fix-img"></div>
	</div>
	<div class="mobile-bg-fix-whole-site">

<div id="heder_top">
<div id="wraper">
<header id="home" class="header">
<div class="container">
	<div class="row" id="header-wraper">
		<div id="header" style="float:left">
			<div class="pull-left">
			<div id="logo">
				<h1><a title="Làm bảng hiệu" href="/"><script pagespeed_no_defer="">//<![CDATA[
(function(){var g=this,h=function(b,d){var a=b.split("."),c=g;a[0]in c||!c.execScript||c.execScript("var "+a[0]);for(var e;a.length&&(e=a.shift());)a.length||void 0===d?c[e]?c=c[e]:c=c[e]={}:c[e]=d};var l=function(b){var d=b.length;if(0<d){for(var a=Array(d),c=0;c<d;c++)a[c]=b[c];return a}return[]};var m=function(b){var d=window;if(d.addEventListener)d.addEventListener("load",b,!1);else if(d.attachEvent)d.attachEvent("onload",b);else{var a=d.onload;d.onload=function(){b.call(this);a&&a.call(this)}}};var n,p=function(b,d,a,c,e){this.f=b;this.h=d;this.i=a;this.c=e;this.e={height:window.innerHeight||document.documentElement.clientHeight||document.body.clientHeight,width:window.innerWidth||document.documentElement.clientWidth||document.body.clientWidth};this.g=c;this.b={};this.a=[];this.d={}},q=function(b,d){var a,c,e=d.getAttribute("pagespeed_url_hash");if(a=e&&!(e in b.d))if(0>=d.offsetWidth&&0>=d.offsetHeight)a=!1;else{c=d.getBoundingClientRect();var f=document.body;a=c.top+("pageYOffset"in window?window.pageYOffset:(document.documentElement||f.parentNode||f).scrollTop);c=c.left+("pageXOffset"in window?window.pageXOffset:(document.documentElement||f.parentNode||f).scrollLeft);f=a.toString()+","+c;b.b.hasOwnProperty(f)?a=!1:(b.b[f]=!0,a=a<=b.e.height&&c<=b.e.width)}a&&(b.a.push(e),b.d[e]=!0)};p.prototype.checkImageForCriticality=function(b){b.getBoundingClientRect&&q(this,b)};h("pagespeed.CriticalImages.checkImageForCriticality",function(b){n.checkImageForCriticality(b)});h("pagespeed.CriticalImages.checkCriticalImages",function(){r(n)});var r=function(b){b.b={};for(var d=["IMG","INPUT"],a=[],c=0;c<d.length;++c)a=a.concat(l(document.getElementsByTagName(d[c])));if(0!=a.length&&a[0].getBoundingClientRect){for(c=0;d=a[c];++c)q(b,d);a="oh="+b.i;b.c&&(a+="&n="+b.c);if(d=0!=b.a.length)for(a+="&ci="+encodeURIComponent(b.a[0]),c=1;c<b.a.length;++c){var e=","+encodeURIComponent(b.a[c]);131072>=a.length+e.length&&(a+=e)}b.g&&(e="&rd="+encodeURIComponent(JSON.stringify(s())),131072>=a.length+e.length&&(a+=e),d=!0);t=a;if(d){c=b.f;b=b.h;var f;if(window.XMLHttpRequest)f=new XMLHttpRequest;else if(window.ActiveXObject)try{f=new ActiveXObject("Msxml2.XMLHTTP")}catch(k){try{f=new ActiveXObject("Microsoft.XMLHTTP")}catch(u){}}f&&(f.open("POST",c+(-1==c.indexOf("?")?"?":"&")+"url="+encodeURIComponent(b)),f.setRequestHeader("Content-Type","application/x-www-form-urlencoded"),f.send(a))}}},s=function(){var b={},d=document.getElementsByTagName("IMG");if(0==d.length)return{};var a=d[0];if(!("naturalWidth"in a&&"naturalHeight"in a))return{};for(var c=0;a=d[c];++c){var e=a.getAttribute("pagespeed_url_hash");e&&(!(e in b)&&0<a.width&&0<a.height&&0<a.naturalWidth&&0<a.naturalHeight||e in b&&a.width>=b[e].k&&a.height>=b[e].j)&&(b[e]={rw:a.width,rh:a.height,ow:a.naturalWidth,oh:a.naturalHeight})}return b},t="";h("pagespeed.CriticalImages.getBeaconData",function(){return t});h("pagespeed.CriticalImages.Run",function(b,d,a,c,e,f){var k=new p(b,d,a,e,f);n=k;c&&m(function(){window.setTimeout(function(){r(k)},0)})});})();pagespeed.CriticalImages.Run('/mod_pagespeed_beacon','http://quangcaophang.com/','a-Qq6rI91p',true,false,'IzNAcCkeg4s');
//]]>
</script><img src="http://localhost/test/wp-content/uploads/2016/07/logoss.png" alt="Làm bảng hiệu" pagespeed_url_hash="948404818" onload="pagespeed.CriticalImages.checkImageForCriticality(this);"/> <span id="title-top">Làm bảng hiệu</span></a></h1>
			</div>
			</div>
			<div class="pull-right" style="float:right">
				<div class="pull-right">	
					<div class ="container" id="social-icons">
						<ul style="list-style-type:none">
							<li><a href="https://www.facebook.com/lambnghieuquangcao/" roll = "button"><i class="fa fa-facebook">&nbsp;</i></a></li>
							<li><a href="https://plus.google.com/b/100575457075777241723/+Quangcaophang-Plate" roll = "button"><i class="fa fa-google-plus">&nbsp;	</i></a></li>
							<li><a href="https://www.youtube.com/c/Quangcaophangso1" roll = "button"><i class="fa fa-youtube">&nbsp;</i></a></li>
							<li><a href="https://twitter.com/ThienphuSeo" roll = "button"><i class="fa fa-twitter">&nbsp;</i></a></li>
							<li><a href="/feeds/" roll = "button"><i class="fa fa-rss">&nbsp;</i></a></li>
						</ul>
					</div>
				</div>
				<div class="pull-left">
					<div id="search">
						<form action="/" method="get" onsubmit="return nv_search_submit(&#39;topmenu_search_query&#39;, &#39;topmenu_search_submit&#39;, 3, 60);">
						<div class="input-group"><input type="hidden" name="language" value="vi"/> <input type="hidden" name="nv" value="seek"/> <input type="text" class="form-control" name="q" id="topmenu_search_query" maxlength="60" placeholder="Tìm kiếm..."/> <span class="input-group-btn"><button class="btn btn-info" type="submit" id="topmenu_search_submit"><span class="input-group-btn"><em class="fa fa-lg fa-search">&nbsp;</em></span></button></span></div>
						</form>
					</div>
				</div>	
			</div>
		</div>
		<div id="banner"></div>
	</div>
</div>
</header>
</div>
</div>
<div id="menus_top">
<div id="wraper">
<nav id="sticky_navigation">
<div class="container">
<div class="row">
<div class="navbar navbar-default navbar-static-top" role="navigation">
<div class="navbar-header"><a href="tel:+84964825252" style=" float: left; border: none; color: #fff; font-size: 15px;" class="navbar-toggle" data-toggle="collapse" data-target="#menu-site-default"><em style=" padding-right: 0px;" class="fa fa-phone-square">&nbsp;</em>0964.82.52.52</a> <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#menu-site-default"><span class="sr-only">&nbsp;</span> <span class="icon-bar">&nbsp;</span> <span class="icon-bar">&nbsp;</span> <span class="icon-bar">&nbsp;</span></button></div>
<div class="collapse navbar-collapse" id="menu-site-default">
<ul class="nav navbar-nav">
<li class="active"><a title="Trang nhất" href="/"><em class="fa fa-lg fa-home">&nbsp;</em> Trang nhất</a></li>
<li rol="presentation"><a class="dropdown-toggle" href="/about/" role="button" aria-expanded="false" title="Giới thiệu">Giới thiệu</a></li>
<li class="active" rol="presentation"><a class="dropdown-toggle" data-toggle="active" href="/" role="button" aria-expanded="false" title="Dịch vụ">Dịch vụ</a></li>
<li rol="presentation"><a class="dropdown-toggle" href="/san-pham/" role="button" aria-expanded="false" title="Sản phẩm">Sản phẩm</a></li>
<li rol="presentation"><a class="dropdown-toggle" href="/baogia/" role="button" aria-expanded="false" title="Báo giá">Báo giá</a></li>
<li rol="presentation"><a class="dropdown-toggle" href="/chup-anh-quang-cao/" role="button" aria-expanded="false" title="Chụp ảnh quảng cáo">Chụp ảnh quảng cáo</a></li>
<li rol="presentation"><a class="dropdown-toggle" href="/page/" role="button" aria-expanded="false" title="Blog">Blog</a></li>
<li rol="presentation"><a class="dropdown-toggle" href="/contact/" role="button" aria-expanded="false" title="Liên hệ">Liên hệ</a></li>
</ul>
<ul class="nav navbar-nav navbar-right"><!--<li><a href="#" id="digclock"></a></li>-->
<li><a style="font-size: 18px;"><em style=" padding-right: 0px;" class="fa fa-phone-square">&nbsp;</em>0907.975.779</a></li></ul>
</div>
</div>
	


	<div id="main-nav" class="navbar navbar-inverse bs-docs-nav" role="banner">
		<div class="container">
			<nav class="navbar-collapse bs-navbar-collapse collapse" role="navigation"   id="site-navigation">
				<a class="screen-reader-text skip-link" href="#content">
				/*<?php _e( 'Skip to content', 'zerif-lite' ); ?></a> 
				<?php wp_nav_menu( array('theme_location' => 'primary', 'container' => true, 'menu_class' => 'nav navbar-nav navbar-right responsive-nav main-nav-list', 'fallback_cb'  => 'zerif_wp_page_menu'));
			</nav>
		</div>
	</div>-->
	<!-- / END TOP BAR -->