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
  js.src = "http://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.6";
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

	<div class="menu-main">
	<div class="container">
    <!-- <input id="CurrentNavPos" name="CurrentNavPos" type="hidden" value="3"> -->
	<div class="pro_megamenu dropdown row" id="promenu">
	<div class="hedding-menu dropdown-toggle" data-hover="dropdown" data-toggle="dropdown" aria-expanded="true">
        <div class="bgtitle">
			<span>Tất cả danh mục </span>
			<div class="icon icondown"></div>
		</div>
    </div>
    <div class="col-xs-12 detail-menu" role="menu" aria-labelledby="dropdownMenu1">
        <ul class="list-menu">
	<?php

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
 $num=0;
 $i=0;
 for ($i=0; $i< count($all_categories); $i++){
	$cat = $all_categories[$i];
    if($cat->category_parent == 0) {
		echo '<li class="topnaviitem topnaviitem'.$i.'" itempos="'.$i.'" itemid="'.$i.'">
				<a href='. get_term_link($cat->slug, 'product_cat') .'>'. $cat->name .'</a>
				<div class="dn topnaviitembanner topnaviitembanner'.$num.'" style="display: none;">
					<ul class="sub-menu scroll-menu mcustomscrollbar _mcs_'.($i+1).' mcs_no_scrollbar">
					
						<div id="mcsb_'.($i+1).'" class="mcustomscrollbox mcs-light mcsb_vertical mcsb_inside" tabindex="0">
							<div id="mcsb_'.($i+1).'_container" class="mcsb_container mcs_y_hidden mcs_no_scrollbar_y" style="position:relative; top:0; left:0;" dir="ltr">
								<li class="topnavisubitem">
									<a href="">'. $cat->name .'</a>
									<ul class="sub-sub-menu">';
		
		
        $category_id = $cat->term_id;
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
        if($sub_cats) {
            foreach($sub_cats as $sub_category) {
                
				echo '<li><a href="'. get_term_link($sub_category->slug, 'product_cat') .'">'. $sub_category->name .'</a></li>';
        
            }   
        }
			echo'</ul>
		</li>
	</div>
	';
						echo'<div id="mcsb_'.($i+1).'_scrollbar_vertical" class="mcsb_scrolltools mcsb_'.($i+1).'_scrollbar mcs-light mcsb_scrolltools_vertical" style="display: none;">
								<a href="#" class="mcsb_buttonup" oncontextmenu="return false;" style="display: block;"></a>
								<div class="mcsb_draggercontainer">
									<div id="mcsb_'.($i+1).'_dragger_vertical" class="mcsb_dragger" style="position: absolute; min-height: 27px; top: 0px; display: block; height: 273px; max-height: 302px;" oncontextmenu="return false;">
										<div class="mcsb_dragger_bar" style="line-height: 27px;"></div>
									</div>
									<div class="mcsb_draggerrail"></div>
								</div>
								<a href="#" class="mcsb_buttondown" oncontextmenu="return false;" style="display: block;">	</a>
							</div>
						</div>
					</ul>
					<div class="banner"><br></div>
				</div>
			</li>';
			$num++;
		}
    		
}
echo'</ul></div></div>';
	echo'
  </div>
</div>';
	
?>

<script>
	    function NaviNext() {
        var pos = parseInt($("#CurrentNavPos").val());
        $(".topNaviItem" + pos).removeClass("top-nav-item-selected");
        $(".top-nav-arrow" + pos).hide();
        $(".topNaviItemBanner" + $($(".topNaviItem" + pos)).attr("itemid")).togeeder();
        $(".topNaviSubPanel" + pos).hide();

        if (pos < 8-1){
            pos = pos + 1;
        } else {
                pos = 0;
        }
        $(".topNaviItem" + pos).addClass("top-nav-item-selected");
        $(".top-nav-arrow" + pos).show();
        $(".topNaviSubPanel" + pos).show();
        $(".topNaviItemBanner" + $($(".topNaviItem" + pos)).attr("itemid")).show();
        $("#CurrentNavPos").val(pos);
    }


    function NaviGoto(pos) {
        var cpos = parseInt($("#CurrentNavPos").val());
        $(".topNaviItem" + cpos).removeClass("top-nav-item-selected");
        $(".top-nav-arrow" + cpos).hide();
        $(".topNaviSubPanel" + cpos).hide();

        $(".topNaviItemBanner" + $($(".topNaviItem" + cpos)).attr("itemid")).hide();

        $(".topNaviItem" + pos).addClass("top-nav-item-selected");
        $(".top-nav-arrow" + pos).show();
        $(".topNaviSubPanel" + pos).show();
        $(".topNaviItemBanner" + $($(".topNaviItem" + pos)).attr("itemid")).show();
        $("#CurrentNavPos").val(pos);
    }

    var timer;

    function setIntervalWithCheck(){
        if (timer){
            clearInterval(timer);
        }
        timer = setInterval(function(){
            NaviNext();
        }, 5000)
    }
    function clearIntervalWithCheck(){
        if (timer){
            clearInterval(timer);
        }
    }
    $(function () {
        var pos = parseInt($("#CurrentNavPos").val());
        $(".topNaviItemBanner" + pos).show();
        $(".topNaviItem" + pos).addClass("top-nav-item-selected");
        $(".top-nav-arrow" + pos).show();
        $(".topNaviSubPanel" + pos).show();
        $(".topNaviSubPanel").hover(function () {
          //  clearIntervalWithCheck();
        }, function(){
          //  setIntervalWithCheck();
        });
        
        $(".topNaviItem").hover(function () {
         //   clearIntervalWithCheck();
            $(this).doTimeout("hover",0, function(){
                NaviGoto($(this).attr("itempos"));
                $(".topNaviItemBanner" + $(this).attr("itemid")).show();
                $(".top-nav-arrow" + $(this).attr("itemid")).show();
                $("#CurrentNavPos").val($(this).attr("itempos"));
            });
        }, function(){
         //   setIntervalWithCheck()
            $(this).doTimeout("hover",0, function(){

            });
        });


    });
	 
	//$(".dropdown-toggle").dropdownHover(options);
	</script>
	<script>
	//Init Scroll Bar
    if ($.fn.mCustomScrollbar) {
        $(".scroll-menu").mCustomScrollbar({
            scrollButtons: {
                enable: true
            },
        });
    };

    $(".menu-main").hover(function(){
    	$(".header__menu__overlayBG").addClass("view");
    	
    },function(){
    	$(".header__menu__overlayBG").removeClass("view");
    });
</script>
