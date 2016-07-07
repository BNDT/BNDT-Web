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
	<div style="margin-top:5px; margin-bottom: 5px;">
	<span >
	<?php masterslider(1); ?>
	</span>
	<!-- End Slider -->
	<!-- Right -->
	<!-- <span class="menu-right">
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
	-->
	<!-- End Right -->
	</div>
	<?php if ( is_home() ) : ?>
	<div id="primary" class="content-area <?php echo ( get_theme_mod( 'freestore-blog-full-width', false ) ) ? sanitize_html_class( ' content-area-full' ) : ''; ?>">
    <?php else : ?>
    <div id="primary" class="content-area">
    <?php endif; ?>
		
		<main id="main" class="site-main" role="main">
			
		<?php get_template_part( '/templates/titlebar' ); ?>
		Giam gia
		<?php echo do_shortcode('[sale_products per_page="12" columns="4" orderby="date" order="desc" ]') ?>
		Moi
		<?php echo do_shortcode('[recent_products per_page="12" columns="4"]'); ?>
		</main><!-- #main -->
	</div><!-- #primary -->
	
	<?php if ( is_home() ) : ?>
    
        <?php if ( get_theme_mod( 'freestore-blog-full-width', false ) ) : ?>
            <!-- No Sidebar -->
        <?php else : ?>
            <?php //get_sidebar(); ?>
        <?php endif; ?>
        
    <?php else : ?>
    <?php //get_sidebar(); ?>
    <?php endif; ?>
    
    <div class="clearboth"></div>
<?php get_footer(); ?>
