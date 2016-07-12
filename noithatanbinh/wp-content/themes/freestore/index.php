<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package FreeStore
 */

get_header(); ?>

	
	<!-- Start Slider -->
	<div class='container' >
	<div class='menu-sanpham' style="">
	<h3>Danh Mục Sản Phẩm</h3>
	
	<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
	</div>
	<div class='slider-image' >
	
	<span >
	<?php masterslider(1); ?>
	</span>
	</div>
	<!-- End Slider -->
	<!-- Right -->
	<span class="my-menu-right">
      <div class="right__block">
        <div class="right__block__title">Mua sắm nhanh chóng</div>
        <div class="right__block__wrapper">
          <div class="right__block__item"><i class="fa fa-shopping-cart"></i>Tiện lợi và nhanh chóng</div>
          <div class="right__block__item"><i class="fa fa-check-square"></i>Hàng hóa được dảm bảo</div>
          <div class="right__block__item"><i class="fa fa-dollar"></i>Giá bán chính xác nhất</div>
          <div class="right__block__item"><i class="fa fa-thumbs-up"></i>Nhiều chương trình giảm giá</div>
          <div class="right__block__item"><i class="fa fa-truck"></i>Giao hàng cực nhanh <i class="fa fa-check-circle" style="border: none;font-size: 14px;color: rgb(79, 172, 31);"></i></div>
          <div class="right__block__item"><i class="fa fa-money"></i>Thanh toán khi nhận hàng</div>
          <div class="right__block__item"><i class="fa fa-history"></i>Đổi hàng trong 7 ngày</div>
          <div class="right__block__item"><i class="fa fa-smile-o"></i>Dịch vụ CSKH chu đáo nhất</div>
        </div>
      </div>
    </span>
    </div>
	<!-- End Right -->
	<?php if ( is_home() ) : ?>
	<div id="primary" class="content-area <?php echo ( get_theme_mod( 'freestore-blog-full-width', false ) ) ? sanitize_html_class( ' content-area-full' ) : ''; ?> col-xs-12" style="width:100%">
    <?php else : ?>
    <div id="primary" class="content-area" >
    <?php endif; ?>
		
	<!--<main id="main" class="container" role="main">-->
		<div class="row">
			<div class="box">
				<div class="title-bar col-xs-12">
					<span class="bar-header">Sản Phẩm Đang Giảm Giá</span>
					<ul class="bar bar-item">
						<li><a href="<?php echo home_url()?>/xem-nhieu">Xem nhiều</a></li>
						<li><a href="<?php echo home_url()?>/mua-nhieu">Mua nhiều nhất</a></li>
						<li><a href="<?php echo home_url()?>/moi-nhat">Mới nhất</a></li>
					</ul>
			
				</div>    
		
				<div class="con-product">
					<?php echo do_shortcode('[sale_products per_page="12" columns="4" orderby="date" order="desc" ]');?>
				</div> 
		
				<div class="title-bar col-xs-12">
					<span class="bar-header">Sản Phẩm Mới Nhất</span>
					<ul class="bar bar-item">
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
						foreach($all_categories as $cat){
							if($cat->category_parent == 0) {
								echo '<li><a href="'.get_term_link($cat->slug, 'product_cat').'/?filters=order-date">'.$cat->name.'</a></li>';
							}
						}
					?>
					</ul>
				</div>   
				<div class="con-product">
					<?php echo do_shortcode('[recent_products per_page="12" columns="4"]'); ?>
				</div>
			</div>
		</div>
	</div><!-- //#main -->
	<!-- //#primary -->
	
	<?php if ( is_home() ) : ?>
    
        <?php if ( get_theme_mod( 'freestore-blog-full-width', false ) ) : ?>
            <!-- No Sidebar -->
        <?php else : ?>
            <?php //get_sidebar(); ?>
        <?php endif; ?>
        
    <?php else : ?>
    <?php //get_sidebar(); ?>
    <?php endif; ?>
    
<?php get_footer(); ?>
    <div class="clearboth"></div>
